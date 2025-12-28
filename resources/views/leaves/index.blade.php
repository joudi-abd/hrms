@extends('layouts.app')

@section('title', __('Leave Requests'))

@section('content')
    <div class="container-fluid px-6 py-4">
        <x-flash-message />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 fw-bold">{{__('Leave Requests')}}</h1>
                            @can('create', App\Models\LeaveRequest::class)
                                <button class="btn btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#createEditModal"
                                data-action="{{ route('leave-requests.store') }}"
                                data-method="POST">
                                <i class="bi bi-plus me-1"></i>
                                {{__('New Leave Request')}}
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Tabs --}}
        
        <div class="card tab-content">
            <ul class="nav nav-tabs mb-4" id="leaveTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" style="border : 3px;" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                        <i class="fas fa-hourglass-half"></i>
                        {{ __('Pending Requests') }}
                        <span class="badge bg-danger text-dark">
                            {{ $pendingRequests->count() }}
                        </span>
                    </button>
                </li>
    
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" style="border : 3px;" data-bs-toggle="tab" data-bs-target="#history" type="button">
                        <i class="fas fa-history"></i>
                        {{ __('Request History') }}
                    </button>
                </li>
            </ul>

            <div class="tab-pane fade show active" id="pending">
                @if($pendingRequests->isEmpty())
                    <div class="alert alert-info text-center">
                        {{ __('No pending leave requests.') }}
                    </div>
                @else
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Employee') }}</th>
                                        <th>{{ __('Leave Type') }}</th>
                                        <th>{{ __('Period') }}</th>
                                        <th>{{ __('Days') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingRequests as $request)
                                        <tr class="table-warning">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $request->employee->name }}</td>
                                            <td>{{ $request->leaveType->name ?? '-' }}</td>
                                            <td>
                                                {{ $request->start_date }}
                                                →
                                                {{ $request->end_date }}
                                            </td>
                                            <td>{{ $request->total_days }}</td>
                                            <td class="d-flex gap-1 justify-content-center">

                                                @can('approve', $request)
                                                    <button class="action-btn approve" title="approve"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal"
                                                        data-action="{{ route('leave-requests.approve', $request) }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endcan

                                                @can('reject', $request)
                                                    <button class="action-btn reject" title="reject"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal"
                                                        data-action="{{ route('leave-requests.reject', $request) }}">
                                                        
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endcan

                                                @can('update', $request)
                                                    <button
                                                    class="action-btn edit" title="edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#createEditModal"
                                                    data-action="{{ route('leave-requests.update', $request) }}"
                                                    data-method="PUT"
                                                    data-start_date="{{ $request->start_date }}"
                                                    data-end_date="{{ $request->end_date }}"
                                                    data-leave_type="{{ $request->leave_type_id }}"
                                                    data-reason="{{ $request->reason }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endcan

                                                @can('delete', $request)
                                                    <button class="action-btn delete" title="delete"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        data-action="{{ route('leave-requests.destroy', $request) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="tab-pane fade" id="history">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Leave Type') }}</th>
                                    <th>{{ __('Period') }}</th>
                                    <th>{{ __('Days') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historyRequests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $request->employee->name }}</td>
                                        <td>{{ $request->leaveType->name ?? '-' }}</td>
                                        <td>
                                            {{ $request->start_date }}
                                            →
                                            {{ $request->end_date }}
                                        </td>
                                        <td>{{ $request->total_days }}</td>
                                        <td>
                                            @if($request->status === 'approved')
                                                <span class="badge bg-success">
                                                    {{ __('Approved') }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    {{ __('Rejected') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            @can('view', $request)
                                            <a href="{{ route('leave-requests.show', $request) }}" 
                                            class="action-btn view" title="view">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('No leave history found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $historyRequests->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('leaves.modals')
    @include('leaves.create_edit' , ['leaveTypes' => $leaveTypes ?? null])
@endsection

@push('scripts')
<script>
    function bindModal(modalId, formId) {
        const modal = document.getElementById(modalId);
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            modal.querySelector(formId).action = action;
        });
    }

    bindModal('deleteModal', '#deleteForm');
    bindModal('approveModal', '#approveForm');
    bindModal('rejectModal', '#rejectForm');
</script>
@endpush

@if($errors->any())
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('createEditModal'));
        modal.show();
    });

</script>
@endpush
@endif
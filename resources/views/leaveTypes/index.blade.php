@extends('layouts.app')
@section('title', 'Leave Types')
@section('content')
    <div class="container-fluid px-6 py-4">
        <x-flash-message />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 fw-bold">{{__('Leave Types')}}</h1>
                            @can('create' , App\Models\LeaveType::class)
                                <a class="btn btn-outline-primary"
                                    href="{{ route('leave_types.create') }}"><i class="bi bi-plus me-1"></i>{{__('Add New Leave Type')}}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-6">
            <!-- Hoverable rows -->
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="tab-content p-4" id="pills-tabContent-hoverable-rows">
                            <div class="tab-pane tab-example-design fade show active" id="pills-hoverable-rows-design"
                                role="tabpanel" aria-labelledby="pills-hoverable-rows-design-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Days Allowed')}}</th>
                                                <th>{{__('Description')}}</th>
                                                <th>{{__('Is Paid')}}</th>
                                                @canany(['update', 'delete'], App\Models\LeaveType::class)
                                                    <th>{{__('Actions')}}</th>
                                                @endcanany
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($leaveTypes as $type)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $type->name }}</td>
                                                    <td>{{ $type->max_days_per_year}}</td>
                                                    <td>{{ $type->description ?? '-' }}</td>
                                                    <td>
                                                        @if($type->is_paid)
                                                            <span class="badge bg-success">{{__('Paid')}}</span>
                                                        @else
                                                            <span class="badge bg-warning">{{__('Unpaid')}}</span>
                                                        @endif
                                                    </td>
                                                    @canany(['update', 'delete'], $type)
                                                        <td class="d-flex gap-1 justify-content-center">
                                                            @can('update', $type)
                                                                <a href="{{ route('leave_types.edit', $type->id) }}"
                                                                    class="action-btn edit" title="edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endcan
                                                            @can('delete', $type)
                                                                
                                                                <button type="button" class="action-btn delete" title="delete"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteModal" 
                                                                data-action="{{ route('leave_types.destroy', $type->id) }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                                
                                                            @endcan
                                                        </td>
                                                    @endcanany
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">{{__('No leave types found.')}}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $leaveTypes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{__('Confirm Delete')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{__('Are you sure you want to delete this leave type?')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = deleteModal.querySelector('#deleteForm');
            form.action = action;
        });
    </script>
@endpush
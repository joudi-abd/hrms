@extends('layouts.app')

@section('title', __('Leave Request Details'))

@section('content')
<div class="container-fluid px-6 py-4">
    <x-flash-message />

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-dark fw-bold">{{ __('Leave Request Details') }}</h3>
            <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>{{ __('Employee') }}:</strong> {{ $leaveRequest->employee->name }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('Leave Type') }}:</strong> {{ $leaveRequest->leaveType->name ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>{{ __('Start Date') }}:</strong> {{ $leaveRequest->start_date }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('End Date') }}:</strong> {{ $leaveRequest->end_date }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>{{ __('Total Days') }}:</strong> {{ $leaveRequest->total_days }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('Status') }}:</strong>
                    @if($leaveRequest->status === 'approved')
                        <span class="badge bg-success">{{ __('Approved') }}</span>
                    @elseif($leaveRequest->status === 'rejected')
                        <span class="badge bg-danger">{{ __('Rejected') }}</span>
                    @else
                        <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                    @endif
                </div>
            </div>

            @if($leaveRequest->reason)
            <div class="row mb-3">
                <div class="col-12">
                    <strong>{{ __('Reason') }}:</strong>
                    <p>{{ $leaveRequest->reason }}</p>
                </div>
            </div>
            @endif

            @if($leaveRequest->status !== 'pending' && $leaveRequest->approver)
            <div class="row mb-3">
                <div class="col-12">
                    <strong>{{ __('Approved/Rejected By') }}:</strong> {{ $leaveRequest->approver->name }}
                </div>
            </div>
            @endif

            {{-- Actions for pending requests --}}
            @if($leaveRequest->status === 'pending')
                <div class="d-flex gap-2 mt-3">
                    @can('approve', $leaveRequest)
                        <form action="{{ route('leave-requests.approve', $leaveRequest->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                        </form>
                    @endcan
                    @can('reject', $leaveRequest)
                        <form action="{{ route('leave-requests.reject', $leaveRequest->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">{{ __('Reject') }}</button>
                        </form>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
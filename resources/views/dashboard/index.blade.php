@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')

<div class="kpi-container">

    {{-- Pending Leaves KPI --}}
    @can('viewAny', App\Models\LeaveRequest::class)
    <div class="kpi-card pending">
        <div class="kpi-icon d-flex justify-content-between">
            <div class="kpi-label">{{ __('Leave Requests') }}</div>
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div class="kpi-value">{{ $pendingLeavesCount }}</div>
        <a href="{{ route('leave-requests.index') }}" class="kpi-action">
            {{ __('Reviewing requests') }}
        </a>
    </div>
    @endcan

    {{-- Active Departments --}}
    @can('viewAny', App\Models\Department::class)
    <div class="kpi-card success">
        <div class="kpi-icon d-flex justify-content-between">
            <div class="kpi-label">{{ __('Active Departments') }}</div>
            <i class="fas fa-building"></i>
        </div>
        <div class="kpi-value">{{ $activeDepartments }}</div>
        <a href="{{ route('departments.index') }}" class="kpi-action">
            {{ __('Show') }}
        </a>
    </div>
    @endcan

    {{-- Active Employees --}}
    @can('viewAny', App\Models\Employee::class)
    <div class="kpi-card">
        <div class="kpi-icon d-flex justify-content-between">
            <div class="kpi-label">{{ __('Active Employees') }}</div>
            <i class="fas fa-users"></i>
        </div>
        <div class="kpi-value">{{ $activeEmployees }}</div>
        <span style="font-size:12px;color:#10b981;">
            {{ __('New this month') }}: {{ $newEmployeesThisMonth }}
        </span>
    </div>
    @endcan

    {{-- Absent Today --}}
    @can('viewAny', App\Models\Attendance::class)
    <div class="kpi-card warning">
        <div class="kpi-icon d-flex justify-content-between">
            <div class="kpi-label">{{ __('Absent Today') }}</div>
            <i class="fas fa-user-slash"></i>
        </div>
        <div class="kpi-value">{{ $absentToday }}</div>
        <a href="{{ route('attendance.index') }}" class="kpi-action">
            {{ __('Show details') }}
        </a>
    </div>
    @endcan
</div>

{{-- Leave Balance --}}
@can('viewAny', App\Models\LeaveRequest::class)
<div class="card info p-4 rounded shadow-sm w-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">{{ __('Leave Balance') }}</h2>
        <i class="fas fa-calendar-check fa-2x text-primary"></i>
    </div>

    <div class="row g-3">
        @foreach($leaveBalances as $typeName => $balance)
        <div class="col-6 col-md-3">
            <div class="p-3 rounded shadow-sm text-center" style="background-color:#d9eaefff;">
                <h4>{{ $typeName }}</h4>
                <div class="fs-4 fw-bold">
                    <span class="text-success">{{ $balance['remaining'] }}</span> /
                    <span class="text-muted">{{ $balance['total'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('leave-requests.index') }}"
       class="d-block mt-3 text-center text-decoration-none fw-semibold text-primary">
        {{ __('View Requests') }}
    </a>
</div>
@endcan

@include('dashboard.partials.tables')
@include('dashboard.partials.charts')

@endsection

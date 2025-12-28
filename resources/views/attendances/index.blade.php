@extends('layouts.app')

@section('title', __('Attendances'))

@section('content')
<div class="container-fluid px-6 py-4">
    <x-flash-message />

    <div class="border-bottom pb-5">
        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
            <h1 class="mb-1 fw-bold">{{ __('Attendances') }}</h1>
            @can('attendance.create_daily')
                <form action="{{ route('attendance.create_daily') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary py-3" {{ $todayCreated ? 'disabled' : '' }}>
                        <h4 class="mb-0 text-white">
                            <i class="bi bi-plus me-1"></i>{{ __('Create Today Attendance Records') }}
                        </h4>
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">{{ __("Today's situation") }}</h6>
                        <h4 class="mb-0">
                            {{ $userAttendanceToday ? ($userAttendanceToday->check_out ? __('Checked Out') : __('Checked In')) : __('Not Checked In') }}
                        </h4>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success fs-5">
                            {{ __('Check In') }}: {{ $userAttendanceToday && $userAttendanceToday->check_in ? $userAttendanceToday->check_in : 'N/A' }}
                        </span>
                        <span class="badge bg-danger fs-5">
                            {{ __('Check Out') }}: {{ $userAttendanceToday && $userAttendanceToday->check_out ? $userAttendanceToday->check_out : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <hr><br>

            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('Actions') }}</h6>
                    <div class="d-flex gap-2">
                        @can('checkIn', App\Models\Attendance::class)
                            <button class="btn btn-success w-50 py-3" data-bs-toggle="modal" data-bs-target="#checkInModal"
                                @if(!$userAttendanceToday || ($userAttendanceToday && $userAttendanceToday->check_in) || ($userAttendanceToday->status ?? null) == 'leave') disabled @endif>
                                <h4 class="mb-0 text-white">
                                    <i class="fa fa-solid fa-right-to-bracket me-1"></i>
                                    {{ __('Check In') }}
                                </h4>
                            </button>
                            <button class="btn btn-danger w-50 py-3" data-bs-toggle="modal" data-bs-target="#checkOutModal"
                                @if(($userAttendanceToday && !$userAttendanceToday->check_in) || ($userAttendanceToday && $userAttendanceToday->check_out) || ($userAttendanceToday->status ?? null) == 'leave') disabled @endif>
                                <h4 class="mb-0 text-white">
                                    <i class="fa fa-solid fa-right-from-bracket me-1"></i>
                                    {{ __('Check Out') }}
                                </h4>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>

            <hr><br>

            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">{{ __('Attendance Records') }}</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                @can('view', $userAttendanceToday)
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Dep') }}</th>
                                @endcan
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Check In') }}</th>
                                <th>{{ __('Check Out') }}</th>
                                <th>{{ __('Work Hours') }}</th>
                                <th>{{ __('Status') }}</th>
                                @canany(['update', 'delete', 'viewAny'], App\Models\Attendance::class)
                                    <th>{{ __('Actions') }}</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @can('view', $userAttendanceToday)
                                        <td>{{ $attendance->employee->name }}</td>
                                        <td>{{ $attendance->employee->department->name ?? 'N/A' }}</td>
                                    @endcan
                                    <td>{{ $attendance->date }}</td>
                                    <td>{{ $attendance->check_in ?? 'N/A' }}</td>
                                    <td>{{ $attendance->check_out ?? 'N/A' }}</td>
                                    <td>{{ $attendance->work_hours ?? 'N/A' }}</td>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">{{ __('Present') }}</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger">{{ __('Absent') }}</span>
                                        @elseif($attendance->status == 'leave')
                                            <span class="badge bg-secondary text-dark">{{ __('On Leave') }}</span>
                                        @else
                                            <span class="badge bg-info text-dark">{{ __('Half day') }}</span>
                                        @endif
                                    </td>
                                    @canany(['update', 'delete', 'viewAny'], App\Models\Attendance::class)
                                        <td class="d-flex justify-content-center align-items-center">
                                            @can('view', $attendance)
                                                <a href="{{ route('attendance.show', $attendance) }}" class="action-btn view me-1"><i class="bi bi-eye"></i></a>
                                            @endcan
                                            @can('update', App\Models\Attendance::class)
                                                <a href="{{ route('attendance.edit', $attendance) }}" class="action-btn edit me-1"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('delete', App\Models\Attendance::class)
                                                <button type="button" class="action-btn reject" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('attendance.destroy', $attendance) }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endcan
                                        </td>
                                    @endcanany
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">{{ __('No attendance records found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>

    @include('attendances.modals') 
@endsection

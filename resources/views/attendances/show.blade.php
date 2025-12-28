@extends('layouts.app')

@section('title', __('Attendance Details'))

@section('content')
<div class="container-fluid px-6 py-4">

    <div class="mb-4">
        <h1 class="fw-bold">{{ __('Attendance Details') }}</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <td>{{ $attendance->employee->name }}</td>
                </tr>

                <tr>
                    <th>{{ __('Date') }}</th>
                    <td>{{ $attendance->date }}</td>
                </tr>

                <tr>
                    <th>{{ __('Check In') }}</th>
                    <td>{{ $attendance->check_in ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>{{ __('Check Out') }}</th>
                    <td>{{ $attendance->check_out ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>{{ __('Working Hours') }}</th>
                    <td>{{ $attendance->work_hours ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>{{ __('Status') }}</th>
                    @if ($attendance->status == 'present')
                        <td class="bg-success">{{ __('Present') }}</td>
                    @elseif ($attendance->status == 'absent')
                        <td class="bg-danger">{{ __('Absent') }}</td>
                    @elseif ($attendance->status == 'leave')
                        <td class="bg-secondary text-dark">{{ __('On Leave') }}</td>
                    @else
                        <td class="bg-info text-dark">{{ __('Half day') }}</td>
                    @endif
                </tr>
            </table>

            <a href="{{ route('attendance.index') }}" class="btn btn-secondary mt-3 w-100">
                {{ __('Back') }}
            </a>

        </div>
    </div>

</div>
@endsection
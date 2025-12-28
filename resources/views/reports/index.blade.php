@extends('layouts.app')

@section('title', 'Reports')

@section('content')
@php $active = request()->get('page', 'attendance'); @endphp
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-3">{{ ucfirst($active) }} Report</h1>

            <!-- زر PDF -->
            <form action="{{ route('reports.pdf') }}" method="GET" target="_blank">
                <input type="hidden" name="page" value="{{ $active }}">
                @foreach(request()->only(['from','to','status','employee_id']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf px-1"></i>Download PDF</button>
            </form>
        </div>
        {{-- pages --}}
        <ul class="nav nav-tabs mb-5">
            <li class="nav-item">
                <a href="?page=attendance"
                    class="fs-4 fw-bold text-dark nav-link {{ $active == 'attendance' ? 'active' : '' }}">Attendance</a>
            </li>
            <li class="nav-item">
                <a href="?page=payroll"
                    class="fs-4 fw-bold text-dark nav-link {{ $active == 'payroll' ? 'active' : '' }}">Payroll</a>
            </li>
            <li class="nav-item">
                <a href="?page=leaves"
                    class="fs-4 fw-bold text-dark nav-link {{ $active == 'leaves' ? 'active' : '' }}">Leaves</a>
            </li>
            <li class="nav-item">
                <a href="?page=tasks" class="fs-4 fw-bold text-dark nav-link {{ $active == 'tasks' ? 'active' : '' }}">Tasks</a>
            </li>
        </ul>

        <!-- Filter -->
        <form method="GET" class="row g-2 mb-4 align-items-end">

            <input type="hidden" name="page" value="{{ $active }}">

            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            

            <div class="col-md-3">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select">
                    <option value="">All</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach($Statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100">Apply</button>
                <a href="?page={{ $active }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>

        </form>

        {{-- KPIs --}}
        <div class="row mb-4">
            @foreach($kpis as $key => $value)
                @if(count($kpis) > 4)
                    <div class="col-md-2">
                @else
                        <div class="col-md-3">
                    @endif
                        <div class="card stats shadow-sm p-1 text-center"
                            style="background-color: {{ $colors[$active][$key] ?? '#ffffff' }};">
                            <div class="card-body p-1 d-flex flex-column justify-content-center align-items-center h-100">
                                <div class="d-flex justify-content-center align-items-center">
                                    <i class="{{ $icons[$active][$key] ?? 'bi bi-question-circle' }} text-white fs-4 me-2"></i>
                                    <strong class="text-white text-uppercase">{{ str_replace('_', ' ', $key) }}</strong>
                                </div>
                                <h4 class="fw-bold mt-2">
                                    {{ $value }}
                                </h4>
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>

            {{-- page content --}}
            <div class="card shadow-sm p-4">
                @includeIf(
                    'reports.partials.' . $active
                )
        </div>

        </div>
@endsection
    
    @push('styles')
            <style>
                .card .card-header {

           background-color: #ddedfdff;
                }
                .stats {
                       height: 120px;

        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                }
                .stats:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                }
            </style>
    @endpush
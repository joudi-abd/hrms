@extends('layouts.app')

@section('title', __('Employee Profile'))

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <div>
            <img src="{{ asset('assets/images/avatar/avatar1.jpg') }}"
                 class="rounded-circle shadow"
                 width="150" height="150"
                 style="object-fit: cover">
        </div>
        <div class="px-3">
            <h2 class="mb-1 fw-bold">{{ $employee->full_name }}</h2>
            <p class="mb-0 fw-medium text-secondary">
                {{ $employee->job_title ?? __('Employee') }}
                · {{ $employee->department?->name ?? __('No Department') }}
            </p>
            <span class="badge bg-success mt-2">
                {{ ucfirst($employee->status ?? 'active') }}
            </span>
        </div>
    </div>

    <div class="row g-4">

        {{-- Personal Information --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-person-fill me-2"></i>
                        {{ __('Personal Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Employee ID') }}:</strong> {{ $employee->employee_id }}</p>
                    <p><strong>{{ __('Full Name') }}:</strong> {{ $employee->full_name }}</p>
                    <p><strong>{{ __('Email') }}:</strong> {{ $employee->email }}</p>
                    <p><strong>{{ __('Phone') }}:</strong> {{ $employee->profile->phone ?? '-' }}</p>
                    <p><strong>{{ __('Gender') }}:</strong> {{ ucfirst($employee->profile->gender ?? '-') }}</p>
                    <p><strong>{{ __('Date of Birth') }}:</strong> {{ $employee->profile->birth_date ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Job Information --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-briefcase-fill me-2"></i>
                        {{ __('Job Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Department') }}:</strong> {{ $employee->department?->name ?? '-' }}</p>
                    <p><strong>{{ __('Job Title') }}:</strong> {{ $employee->job_title ?? '-' }}</p>
                    <p><strong>{{ __('Role') }}:</strong> {{ $employee->role?->name ?? '-' }}</p>
                    <p><strong>{{ __('Hire Date') }}:</strong> {{ $employee->hire_date ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Contact & Address --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        {{ __('Contact & Address') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Address') }}:</strong> {{ $employee->profile->address ?? '-' }}</p>
                    <p><strong>{{ __('City') }}:</strong> {{ $employee->profile->city ?? '-' }}</p>
                    <p><strong>{{ __('Country') }}:</strong> {{ $employee->profile->country ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- System Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        {{ __('System Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Account Status') }}:</strong> {{ ucfirst($employee->status ?? '-') }}</p>
                    <p><strong>{{ __('Created At') }}:</strong> {{ $employee->created_at->format('Y-m-d') }}</p>
                    <p><strong>{{ __('Last Updated') }}:</strong> {{ $employee->updated_at->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Actions --}}
    <div class="mt-4 d-flex gap-2">
        @can('update', $employee)
            <a href="{{ route('profile.edit')}}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>
                {{ __('Edit Profile') }}
            </a>
        @endcan

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            {{ __('Back') }}
        </a>
    </div>

</div>
@endsection

@push('styles')
<style>
    .card-header {
        background-color: #a8d2fcff;
    }
</style>
@endpush
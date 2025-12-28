@extends('layouts.app')

@section('title', __('Department Details'))

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0 fw-bold">{{ $department->name }}</h2>
        <span class="badge bg-primary ms-3">{{ ucfirst($department->status) }}</span>
    </div>

    <div class="row g-4">
        {{-- Department Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        {{ __('Department Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Department Name') }}:</strong> {{ $department->name }}</p>
                    <p><strong>{{ __('Description') }}:</strong> {{ $department->description ?? '-' }}</p>
                    <p><strong>{{ __('Status') }}:</strong> {{ ucfirst($department->status) }}</p>
                    <p><strong>{{ __('Head of Department') }}:</strong> {{ $department->head?->full_name ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Extra Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>
                        {{ __('Employees in Department') }}
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($department->employees as $emp)
                            <li class="list-group-item">
                                <a href="{{ route('employees.show', $emp->id) }}">
                                    {{ $emp->full_name }}
                                </a> - {{ $emp->job_title ?? __('Employee') }}
                            </li>
                        @empty
                            <li class="list-group-item">{{ __('No employees found.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-4 d-flex gap-2">
        @can('update', $department)
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>
                {{ __('Edit Department') }}
            </a>
        @endcan
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            {{ __('Back') }}
        </a>
    </div>

</div>
@endsection
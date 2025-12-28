@extends('layouts.app')
@section('title', 'Tasks')
@section('content')
<div class="container-fluid px-6 py-2">
    <x-flash-message />

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div>
                <div class="border-bottom pb-4">
                    <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                        <h1 class="fw-bold">{{ __('Tasks') }}</h1>
                        <div class="d-flex gap-2">
                            @can('viewAll' , App\Models\Task::class)
                            <a class="btn" style="background-color: slategrey; color: #fff;" href="{{ route('tasks.all') }}">
                                <i class="bi bi-eye me-1"></i> {{ __('View All Tasks') }}
                            </a>
                            @endcan
                            @can('create' , App\Models\Task::class)
                            <a class="btn" style="background-color: lightsteelblue; color: #fff;" href="{{ route('tasks.create') }}">
                                <i class="bi bi-plus me-1"></i> {{ __('Add Task') }}
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('In Progress Tasks') }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                @foreach ($tasks->where('status', 'in_progress') as $task)
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary mb-3 shadow-sm" style="background-color: lightsteelblue;">
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1 fw-bold">{{ $task->title }}</h5>
                                <p class="mb-1" style="font-size: 0.85rem;">
                                    {{ $task->assignedEmployee->name ?? __('Unassigned') }}
                                </p>
                                
                                <div class="me-3">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    <span style="font-size: 0.85rem;">
                                        {{ __('Due: ') . $task->due_date->format('Y-m-d') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge 
                                        @if($task->priority == 'high') bg-danger
                                        @elseif($task->priority == 'medium') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    <button class="action-btn approve me-3 mb-1" title="complete" 
                                    data-bs-target="#completeModal" 
                                    data-bs-toggle="modal" 
                                    data-action="{{ route('tasks.change_status', $task) }} "
                                    data-method="PATCH">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('Pending Tasks') }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                @foreach ($tasks->where('status', 'pending') as $task)
                    <div class="col-md-4 mb-3">
                        <div class="card border-warning mb-3 shadow-sm" style="background-color: lightpink">
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1 fw-bold">{{ $task->title }}</h5>
                                <p class="mb-1" style="font-size: 0.85rem;">
                                    {{ $task->assignedEmployee->name ?? __('Unassigned') }}
                                </p>
                                
                                <div class="me-3">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    <span style="font-size: 0.85rem;">
                                        {{ __('Due: ') . $task->due_date->format('Y-m-d') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge 
                                        @if($task->priority == 'high') bg-danger
                                        @elseif($task->priority == 'medium') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    <button class="action-btn reject me-3 mb-1" title="for processing" 
                                    data-bs-target="#forProcessingModal" 
                                    data-bs-toggle="modal" 
                                    data-action="{{ route('tasks.change_status', $task) }} "
                                    data-method="PATCH">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ __('Completed Tasks') }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                @foreach ($tasks->where('status', 'completed') as $task)
                    <div class="col-md-4 mb-3">
                        <div class="card border-success mb-3 shadow-sm" style="background-color: #cbeacb;">
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1 fw-bold">{{ $task->title }}</h5>
                                <p class="mb-1" style="font-size: 0.85rem;">
                                    {{ $task->assignedEmployee->name ?? __('Unassigned') }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    
                                    <span class="text-success me-3 mb-1">
                                        <i class="fas fa-check-circle"></i> {{ __('Completed') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>

    
</div>

@include('tasks.modals')
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
    const completeModal = document.getElementById('completeModal');
    completeModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        const form = completeModal.querySelector('#completeForm');
        form.action = action;
    });
    const forProcessingModal = document.getElementById('forProcessingModal');
    forProcessingModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        const form = forProcessingModal.querySelector('#forProcessingForm');
        form.action = action;
    });

    document.getElementById('resetBtn').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = "{{ route('tasks.index') }}";
    });
</script>
@endpush
@extends('layouts.app')
@section('title', 'Tasks')
@section('content')
    <div class="container-fluid px-6 py-4">
        <x-flash-message />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 fw-bold">{{__('Tasks')}}</h1>
                            <div class="d-flex gap-2">
                            <a class="btn btn-secondary" href="{{ route('tasks.index') }}">
                                <i class="bi bi-arrow-left me-1"></i>
                                {{__('Back')}}
                            </a>
                            @can('create' , App\Models\Task::class)
                            <a class="btn btn-primary" href="{{ route('tasks.create') }}">
                            <i class="bi bi-plus me-1"></i>
                            {{__('Add Task')}}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div id="hoverable-rows" class="mb-4">
                        <form action="{{ URL::current() }}" method="get" class="row g-3 align-items-end m-2 mt-3">
                            <div class="col-md-3">
                                <x-form.input name="title" placeholder="{{__('Enter title')}}" type="text" label="{{__('Title')}}"
                                    :value="request('title')" />
                            </div>
                            @can('viewAll' , App\Models\Department::class)
                            <div class="col-md-2">
                                <x-form.select name="department_id" label="{{__('Department')}}" id="department_id" for="department_id" placeholder="{{__('departments')}}" :options="$departments->pluck('name', 'id')->toArray()" :selected="request('department_id')" />
                            </div>
                            @endcan
                            <div class="col-md-2">
                                <x-form.select name="status" label="{{__('Status') }}" id="status" for="status" :options="['' => __('All') , 'pending' => __('Pending'), 'in_progress' => __('In Progress'), 'completed' => __('Completed')]" :selected="request('status')" />
                            </div>
                            <div class="col-md-2">
                                <x-form.select name="priority" label="{{__('Priority') }}" id="priority" for="priority" :options="['' => __('All') , 'high' => __('High'), 'medium' => __('Medium'), 'low' => __('Low')]" :selected="request('priority')" />
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary mx-2 d-flex"><i class="bi bi-filter me-1"></i>{{__('Filter')}}</button>
                                <button type="submit" class="btn btn-secondary d-flex" id="resetBtn"><i class="fa fa-arrow-rotate-left me-1"></i>{{__('Reset')}}</button>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('Title')}}</th>
                                        @can('viewAll' , App\Models\Department::class)
                                        <th>{{__('Department')}}</th>
                                        @endcan
                                        <!-- <th>{{__('Description')}}</th> -->
                                        <th>{{__('Priority')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            @can('viewAll' , App\Models\Department::class)
                                            <td>{{ $task->department->name ?? '-' }}</td>
                                            @endcan
                                            <!-- <td>{{ $task->description }}</td> -->
                                            @if ($task->priority == 'high')
                                            <td><span class="badge bg-danger">{{__('High')}}</span></td>
                                            @elseif ($task->priority == 'medium')
                                            <td><span class="badge bg-warning">{{__('Medium')}}</span></td>
                                            @else
                                            <td><span class="badge bg-secondary">{{__('Low')}}</span></td>
                                            @endif
                                            <td>
                                            @if ($task->status == 'pending')
                                            <span class="badge bg-secondary">{{__('Pending')}}</span>
                                            @elseif ($task->status == 'in_progress')
                                            <span class="badge bg-danger">{{__('In Progress')}}</span>
                                            @else
                                            <span class="badge bg-success">{{__('Completed')}}</span>
                                            @endif
                                            </td>
                                            <td class="d-flex justify-content-center gap-2">
                                                @can('view',$task)
                                                <a href="{{ route('tasks.show', $task->id) }}" class="action-btn view" title="view">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @endcan
                                                @can('update',$task)
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="action-btn edit" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('delete',$task)
                                                <button type="button" class="action-btn delete" title="delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('tasks.destroy', $task->id) }}">
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
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
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
    </script>
    <script>
        document.getElementById('resetBtn').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "{{ route('tasks.all') }}";
        });
    </script>
@endpush
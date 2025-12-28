@extends('layouts.app')
@section('title', __('Employees'))
@section('content')
<div class="container-fluid px-6 py-4">
    <x-flash-message />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4">
                <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0 fw-bold">{{ __('Employees') }}</h1>
                    @can('create', App\Models\Employee::class)
                        <a class="btn btn-outline-primary" href="{{ route('employees.create') }}">
                            <i class="bi bi-plus me-1"></i>{{ __('Add New Employee') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="row mb-6">
            <div class="col-xl-12">
                <div id="hoverable-rows" class="mb-4">
                    <form action="{{ URL::current() }}" method="get" class="row g-3 align-items-end m-2 mt-3">
                        <div class="col-md-3">
                            <x-form.input name="name" placeholder="{{ __('Enter name') }}" type="text" label="{{ __('Name') }}"
                                :value="request('name')" />
                        </div>
                        <div class="col-md-3">
                            <x-form.select name="status" label="{{ __('Status') }}" id="status" for="status" :options="['' => __('All') , 'active' => __('Active'), 'inactive' => __('Inactive')]" :selected="request('status')" />
                        </div>
                        <div class="col-md-3">
                            <x-form.select name="department_id" label="{{ __('Department') }}" id="department_id" for="department_id" placeholder="{{ __('Departments') }}" :options="$departments->pluck('name', 'id')->toArray()" :selected="request('department_id')" />
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary mx-2"><i class="bi bi-filter me-1"></i>{{ __('Filter') }}</button>
                            <button type="submit" class="btn btn-secondary" id="resetBtn"><i class="fa fa-arrow-rotate-left me-1"></i>{{ __('Reset') }}</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="tab-content p-4" id="pills-tabContent-hoverable-rows">
                        <div class="tab-pane fade show active" id="pills-hoverable-rows-design" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee Number') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th>{{ __('Job Title') }}</th>
                                            <th>{{ __('Salary') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <th>{{ $employee->employee_id }}</th>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->department->name ?? '-' }}</td>
                                            <td>{{ $employee->job_title }}</td>
                                            <td>{{ $employee->salary }}</td>
                                            <td>
                                                @if ($employee->status == 'active')
                                                    <span class="badge bg-success">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                            @canany(['update', 'delete'], $employee)
                                            <td class="d-flex">
                                                @can('view' , $employee )
                                                    <a href="{{ route('employees.show', $employee->id) }}"
                                                    class="action-btn view mx-1" title="{{__('show')}}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('update', $employee)
                                                    <a href="{{ route('employees.edit', $employee->id) }}" class="action-btn edit me-1" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete', $employee)
                                                    <button type="button" class="action-btn delete" title="{{ __('Delete') }}"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('employees.destroy', $employee->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                            @endcanany
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this employee?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.getElementById('resetBtn').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "{{ route('employees.index') }}";
        });
    </script>
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
@extends('layouts.app')
@section('title', 'Roles')
@section('content')
    <div class="container-fluid px-6 py-4">
        <x-flash-message />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 fw-bold">{{__('Roles')}}</h1>
                            <a class="btn btn-outline-primary" href="{{ route('roles.create') }}">
                            <i class="bi bi-plus me-1"></i>
                            {{__('Add Role')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-6">
            <!-- Hoverable rows -->
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td class="d-flex justify-content-center align-items-center gap-2">    
                                                @can('update',$role)
                                                <a href="{{ route('roles.edit', $role->id) }}" class="action-btn edit" title="edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('delete',$role)
                                                    <button type="button" class="action-btn reject" title="delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('roles.destroy', $role->id) }}">
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{__('Confirm Delete')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{__('Are you sure you want to delete this role?')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
@endpush
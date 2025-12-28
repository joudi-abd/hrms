@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
    <div class="container-fluid px-6 py-4">
        <x-flash-message />
        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger w-100">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="border-bottom pb-4 mb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 fw-bold">Edit Role</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <x-form.form :action="route('roles.update', $role->id)" method="PUT">
                    @include('roles._form')

                    <div class="d-flex gap-2 mt-4 justify-content-between">
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </x-form.form>
            </div>
        </div>
    </div>
@endsection
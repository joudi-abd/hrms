@extends('layouts.app')
@section('title', __('Edit Employee'))
@section('content')
<div class="container px-6 py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="border-bottom pb-4">
                <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">{{ __('Edit Employee') }}</h2>
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="row mb-6">
                @if ($errors->any())
                    <div class="alert alert-danger w-100">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <x-form.form method="PUT" action="{{ route('employees.update', $employee->id) }}">
                                @include('employees._form')
                                <div class="d-flex gap-2 mt-4 justify-content-between">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </x-form.form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
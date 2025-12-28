@extends('layouts.app')
@section('title', __('Edit Profile'))
@section('content')
    <div class="container px-6 py-4">
        <x-flash-message />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h2 class="mb-0 fw-bold">{{ __('Edit Profile') }}</h2>
                        </div>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <x-form.form method="PUT" action="{{ route('profile.update') }}">
                                    @include('profile._form')
                                    <div class="d-flex gap-2 mt-4 justify-content-between">
                                        <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
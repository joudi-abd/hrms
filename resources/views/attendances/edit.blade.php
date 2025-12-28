@extends('layouts.app')

@section('title', __('Edit Attendance'))

@section('content')
<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4">
                <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">{{ __('Edit Attendance') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
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
                    <x-form.form :action="route('attendance.update', $attendance->id)" method="PUT">
                        @include('attendances._form')
                        <div class="d-flex gap-2 mt-4 justify-content-between">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </x-form.form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
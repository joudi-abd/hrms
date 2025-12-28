@extends('layouts.guest')
@section('title', __('Reset Password'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Reset Password') }}</h3>
        </div>

        <div class="card-body p-6">
            <p class="fw-bold text-primary">
                {{ __('Enter your new password below.') }}
            </p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('New Password') }}</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Confirm New Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
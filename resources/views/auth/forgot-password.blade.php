@extends('layouts.guest')

@section('title', __('Forgot Password'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Forgot Password') }}</h3>
        </div>

        <div class="card-body p-6">
            <div class="mb-4">
                <p class="mb-6">
                    {{ __("Don't worry, we'll send you an email to reset your password.") }}
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email"
                           class="form-control"
                           name="email"
                           placeholder="{{ __('Enter Your Email') }}"
                           required>
                </div>

                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                </div>

                <span>
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
                </span>
            </form>
        </div>
    </div>
</div>
@endsection
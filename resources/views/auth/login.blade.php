@extends('layouts.guest')

@section('title', __('Sign In'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Sign In') }}</h3>
        </div>
        <div class="card-body p-6">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="{{ __('Enter Email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ __('Enter Password') }}" required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <label class="form-check-label">{{ __('Remember me') }}</label>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">{{ __('Sign In') }}</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            </div>

            <div class="mt-4 text-center">
                <span>
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                </span>
            </div>

        </div>
    </div>
</div>
@endsection
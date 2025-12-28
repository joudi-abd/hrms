@extends('layouts.guest')

@section('title', __('Two-Factor Authentication'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Two-Factor Authentication') }}</h3>
        </div>

        <div class="card-body">
            <p class="login-box-msg">
                {{ __('Enter your 2FA verification code or recovery code') }}
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('two-factor.login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('Authentication Code') }}</label>
                    <input type="text"
                           name="code"
                           class="form-control"
                           placeholder="{{ __('Enter 2FA code from app') }}"
                           required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Recovery Code (optional)') }}</label>
                    <input type="text"
                           name="recovery_code"
                           class="form-control"
                           placeholder="{{ __('Enter recovery code if you lost app access') }}">
                </div>

                <button class="btn btn-primary w-100">
                    {{ __('Verify') }}
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Login') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
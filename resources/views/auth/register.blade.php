@extends('layouts.guest')
@section('title', __('Sign Up'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Sign Up') }}</h3>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('User Name') }}</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="{{ __('User Name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="{{ __('Email address here') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="**************" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="**************" required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">{{ __('Create Account') }}</button>
                </div>

                <div class="d-md-flex justify-content-between mt-4">
                    <a href="{{ route('login') }}">{{ __('Already member? Login') }}</a>
                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
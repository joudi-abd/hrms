@extends('layouts.guest')

@section('title', __('Verify Email'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Verify Your Email Address') }}</h3>
        </div>

        <div class="card-body">
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <p class="mb-4">
                {{ __('Before proceeding, please check your email for a verification link. If you did not receive the email,') }}
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-secondary">
                        {{ __('Logout') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
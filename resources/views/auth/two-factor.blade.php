@extends('layouts.guest')

@section('title', __('Two-Factor Authentication'))

@section('content')
<div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
    <div class="card smooth-shadow-md">
        <div class="card-header text-center">
            <h3>{{ __('Two-Factor Authentication') }}</h3>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (!$employee->two_factor_secret)
                <p class="text-muted text-center">
                    {{ __('Two-factor authentication is currently disabled.') }}
                </p>

                <form action="{{ route('two-factor.enable') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary w-100">
                        {{ __('Enable Two-Factor Authentication') }}
                    </button>
                </form>

                @if (session('status') == 'two-factor-authentication-enabled')
                    <div class="alert alert-info mt-3 text-center">
                        {{ __('Please finish configuring two-factor authentication below.') }}
                    </div>
                @endif
            @else
                <div class="text-center mb-4">
                    <h5>{{ __('Scan this QR Code:') }}</h5>
                    <div class="border p-3 rounded bg-light d-inline-block">
                        {!! $employee->twoFactorQrCodeSvg() !!}
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h5>{{ __('Recovery Codes:') }}</h5>
                    @foreach ($employee->recoveryCodes() as $code)
                        <span class="badge bg-dark m-1">{{ $code }}</span>
                    @endforeach
                </div>

                <form action="{{ route('two-factor.disable') }}"
                      method="POST"
                      onsubmit="return confirm('{{ __('Are you sure you want to disable 2FA?') }}')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger w-100">
                        {{ __('Disable Two-Factor Authentication') }}
                    </button>
                </form>
            @endif

            <div class="mt-4 text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-home"></i> {{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Access Denied') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
        }

        .error-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .error-code {
            font-size: 110px;
            font-weight: 700;
            color: #6c757d;
        }

        .error-text {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 420px;
        }

        .btn-back {
            padding: 12px 32px;
            border-radius: 50px;
            background-color: #f65454ff;
            color: #fff;
            border: none;
            font-weight: 500;
        }

        .btn-back:hover {
            background-color : #d94343ff;
            color: #fff;
        }

        .error-illustration img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container error-wrapper">
    <div class="row align-items-center w-100">

        {{-- Left Content --}}
        <div class="col-md-6 text-start">

            <div class="error-code">403</div>

            <p class="error-text">
                {{ __('You do not have permission to access this page.') }}
            </p>

            <a href="{{ url()->previous() }}" class="btn btn-back">
                {{ __('Go Back') }}
            </a>
        </div>

        {{-- Right Illustration --}}
        <div class="col-md-6 text-center error-illustration d-none d-md-block">
            <img src="{{ asset('assets/images/error/403-illustration.svg') }}" alt="403 Error">
        </div>

    </div>
</div>

</body>
</html>
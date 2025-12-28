@extends('layouts.guest')
@section('title', 'Confirm Password')
@section('content')
    <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <!-- Card -->
        <div class="card smooth-shadow-md">

            <div class="card-header text-center">
                <h3>Confirm Password</h3>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
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

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control"
                                placeholder="Enter your password" required autocomplete="current-password" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block w-100">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
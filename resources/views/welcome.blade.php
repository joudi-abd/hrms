{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('HRLink') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f0f4f8, #d9e2ec);
            color: #333;
        }
        .navbar {
            background-color: #212529;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 2rem;
        }
        
        .nav-link {
            color: #fff !important;
        }
        .hero {
            text-align: center;
            padding: 90px 20px;
            background: url('https://source.unsplash.com/1600x600/?office,team') no-repeat center center;
            background-size: cover;
            color: #fff;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            top:0; left:0; right:0; bottom:0;
            background: rgba(44, 62, 80, 0.7);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #212529;
            border-color: #212529;
        }
        .btn-primary:hover {
            background-color: #f0f4f8;
            border-color: #212529;
            color: #212529;
        }

        footer {
            text-align: center;
            padding: 30px 0;
            background-color: #212529;
            color: #fff;
        }
        .language-select {
            margin-left: 15px;
        }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">{{ __('HRLink') }}</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{ __('Features') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">{{ __('Contact') }}</a>
                    </li>
                    <li class="nav-item">
                        <select class="form-select form-select-sm" onchange="window.location.href=this.value">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <option value="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                                    @selected($localeCode == App::currentLocale())>
                                    {{ $properties['native'] }}
                                </option>
                            @endforeach
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero">
        <div class="hero-content container">
            <h1>{{ __('Welcome to HRLink') }}</h1>
            <p>{{ __('Your ultimate HR management and smart attendance system.') }}</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">{{ __('Get Started') }}</a>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">{{ __('Key Features') }}</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <i class="bi bi-people-fill" style="font-size: 3rem; color: #212529;"></i>
                    <h4 class="mt-3">{{ __('Employee Management') }}</h4>
                    <p>{{ __('Manage all employees efficiently with smart tools.') }}</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-journal-check" style="font-size: 3rem; color: #212529;"></i>
                    <h4 class="mt-3">{{ __('Attendance Tracking') }}</h4>
                    <p>{{ __('Keep track of attendance, leaves, and working hours.') }}</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-currency-dollar" style="font-size: 3rem; color: #212529;"></i>
                    <h4 class="mt-3">{{ __('Payroll & Reports') }}</h4>
                    <p>{{ __('Generate payrolls and insightful reports with ease.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact / CTA Section --}}
    <section id="contact" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">{{ __('Get in Touch') }}</h2>
            <p>{{ __('Have questions? Reach out to us and we’ll get back to you promptly.') }}</p>
            <a href="joudi@gmail.com" class="btn btn-primary">{{ __('Contact Us') }}</a>
        </div>
    </section>

    {{-- Footer --}}
    <footer>
        &copy; {{ now()->year }} {{ __('HRLink') }}. {{ __('All rights reserved.') }}
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
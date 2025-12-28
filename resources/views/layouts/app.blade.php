<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @include('partials.head')
    @stack('styles')
    <title>{{ config('app.name') }} | @yield('title')</title>
</head>

<body class="d-flex flex-column">
    <!-- HEADER -->
    <header class="bg-white shadow-sm fixed-top w-100">
        @include('partials.header')
    </header>

    <!-- WRAPPER -->
    <div class="d-flex w-100">
        <!-- SIDEBAR -->
        <nav id="sidebar" class="sidebar bg-white">
            @include('partials.navbar-vertical')
        </nav>

        <!-- MAIN CONTENT -->
        <main id="main-content" class="content-wrapper flex-grow-1">
            <div class="pt-6 pb-16"
                 style="background-color:#f5f7fa;
                        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        color:#333;">
                <div class="container-fluid" style="padding-left:50px;padding-right:10px;">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
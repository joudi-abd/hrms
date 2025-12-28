<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <title>@yield('title')</title>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            @yield('content') <!-- هنا راح ينحط محتوى الصفحة -->
        </div>
    </div>

    @include('partials.scripts')
</body>
</html>
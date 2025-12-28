<nav class="navbar-vertical sidebar">
    <div class="sidebar-scroll mt-10">
        <!-- Brand logo -->
        <a class="navbar-brand border-bottom" href="{{ route('dashboard') }}" style="padding-bottom: 0px; margin-bottom: 10px;">
            <h1 class="text-center" style="color: #ffffffff;margin-bottom: 10px; font-size: xxx-large; font-family: 'Poppins', sans-serif;">
                {{ config('app.name', 'HRMS') }}
            </h1>
        </a>
        <!-- <hr class="m-0"> -->
        <!-- Navbar nav -->
        <div class="flex-grow-1">
            <ul class="navbar-nav flex-column" id="sideNavbar">
                @foreach ($items as $item)
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is($item['active']) ? 'active' : '' }}"
                            href="{{ $item['url'] }}">
                            <p style="font-size: 18px;margin-bottom: 0px;">
                                <i class="bi {{ $item['icon'] }} nav-icon icon-xs me-2" style="margin-left: 8px;"></i>
                                {{ __($item['title']) }}
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
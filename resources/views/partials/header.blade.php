<div class="header">
  <!-- navbar -->
  <nav class="navbar-classic navbar navbar-expand-lg d-flex justify-content-between">
    <div class="d-flex">
      <a id="nav-toggle" href="#" style="padding-top: 10px;padding-left: 10px;">
        <i data-feather="menu" class="nav-icon me-2 icon-xs"
          style="height: 30px;width: 30px;">
        </i>
      </a>
      <select class="form-select" style="width: 80px; margin-top: 10px; padding-top:2px" name="locale" id="localeSelect" onchange="window.location.href=this.value">
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <option value="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                @selected($localeCode == App::currentLocale())>
                {{ $properties['native'] }}
            </option>
        @endforeach
      </select>
    </div>
    <!-- <a class="navbar-brand" href="{{ route('dashboard') }}" style="padding-bottom: 0px;">
      <h3 style="color: #c5bfee;margin-bottom: 0px;">
        <img src="{{ asset('assets/images/brand/logo/logo.png') }}" alt="" style="width: 170px;height: 40px;">
      </h3>
    </a> -->
    <!-- Navbar nav -->
    <ul class="navbar-nav navbar-right-wrap d-flex nav-top-wrap">
      <li>
        <form class="search-bar" action="#" method="GET" style="margin:0px 5px;">
          <div class="position-relative">
            <input type="text" class="form-control" placeholder="{{ __('Search here')}}" style="border-radius: 2.375rem;background-color: #f5f7faf;color: #706666;">
            <span class="feather-search text-muted icon-sm position-absolute
              top-50 translate-middle-y ms-3"></span>
          </div>
        </form>        
      </li>
      <!-- Notifications -->
      <li class="dropdown stopevent">
        <a class="btn btn-light btn-icon rounded-circle indicator
          indicator-primary text-muted" style="background-color: #e2eaf8ff;margin:0px 5px;" href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="icon-xs" data-feather="bell" style="height: 25px;width: 25px; color: #706666;" ></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
          <div class="mb-0">
            <div class="border-bottom px-3 pt-2 pb-3 d-flex
              justify-content-between align-items-center">
              <p class="mb-0 text-dark fw-medium fs-4">{{__('Notifications')}}</p>
              <a href="#" class="text-muted">
                <span>
                  <i class="me-1 icon-xxs" data-feather="settings"></i>
                </span>
              </a>
            </div>
            <!-- List group -->
            <ul class="list-group list-group-flush notification-list-scroll">
              <li class="list-group-item bg-light">
                <a href="#" class="text-muted">
                  <h5 class="fw-bold mb-1">Rishi Chopra</h5>
                  <p class="mb-0">
                    Mauris blandit erat id nunc blandit, ac eleifend dolor pretium.
                  </p>
                </a>
              </li>
              <li class="list-group-item">
                <a href="#" class="text-muted">
                  <h5 class="fw-bold mb-1">Neha Kannned</h5>
                  <p class="mb-0">
                    Proin at elit vel est condimentum elementum id in ante. Maecenas et sapien metus.
                  </p>
                </a>
              </li>
              <li class="list-group-item">
                <a href="#" class="text-muted">
                  <h5 class="fw-bold mb-1">Nirmala Chauhan</h5>
                  <p class="mb-0">
                    Morbi maximus urna lobortis elit sollicitudin sollicitudieget elit vel pretium.
                  </p>
                </a>
              </li>
              <li class="list-group-item">
                <a href="#" class="text-muted">
                  <h5 class="fw-bold mb-1">Sina Ray</h5>
                  <p class="mb-0">
                    Sed aliquam augue sit amet mauris volutpat hendrerit sed nunc eu diam.
                  </p>
                </a>
              </li>
            </ul>
            <div class="border-top px-3 py-2 text-center">
              <a href="#" class="text-inherit fw-semi-bold">
                View all Notifications
              </a>
            </div>
          </div>
        </div>
      </li>

      <!-- User -->
      <li class="dropdown ms-2">
        <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-md avatar-indicators avatar-online">
            <img alt="avatar" src="{{ asset('assets/images/avatar/avatar1.jpg') }}" class="rounded-circle" />
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
          <div class="px-4 pb-0 pt-2">
            <div class="lh-1 text-center">
              <h4 class="mb-1">{{ auth()->user()->name ?? ''}}</h4>
            </div>
            <div class="dropdown-divider mt-3 mb-2"></div>
          </div>

          <ul class="list-unstyled">
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('two.factor.auth') }}">
                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="shield"></i>2FA
              </a>
            </li>
            <li>
              <form class="dropdown-item" method="post" action="{{ route('logout') }}">
                @csrf
                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Sign out</button>
              </form>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
</div>
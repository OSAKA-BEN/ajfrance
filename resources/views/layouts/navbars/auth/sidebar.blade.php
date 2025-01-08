<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="../assets/img/logos/logo.png" class="navbar-brand-img h-100" alt="...">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">ADMIN</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'users-management' ? 'active' : '' }}" href="{{ route('users-management') }}">
                        <i class="bi bi-people-fill"></i>
                        <span class="nav-link-text ms-1">Users Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'calendar-management' ? 'active' : '' }}" href="{{ route('calendar-management') }}">
                        <i class="bi bi-calendar-plus"></i>
                        <span class="nav-link-text ms-1">Calendar Management</span>
                    </a>
                </li>
            @endif
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Dashboard</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}"
                    href="{{ route('calendar') }}">
                    <i class="bi bi-calendar3"></i>
                    <span class="nav-link-text ms-1">Calendar</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Lessons</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="bi bi-plus-square-fill"></i>
                    <span class="nav-link-text ms-1">Take a lesson</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'tables' ? 'active' : '' }}"
                    href="{{ route('tables') }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span class="nav-link-text ms-1">List of Lessons</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 mt-3 pt-3">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpeg')">
            </div>
            <div class="card-body text-left p-3 w-100">
                <div class="docs-info">
                    <h6 class="text-white up mb-0">AJ France</h6>
                    <p class="text-xs font-weight-bold">Look at the lasts news.</p>
                    <a href="https://aj-france.com/" target="_blank"
                        class="btn btn-white btn-sm w-100 mb-0">Back to website</a>
                </div>
            </div>
        </div>
    </div>
</aside>

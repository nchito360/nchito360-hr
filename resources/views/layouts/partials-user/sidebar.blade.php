<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('employee.dashboard') }}" class="app-brand-link d-flex align-items-center">
            <img src="{{ asset('hr-app/assets/img/logos/nchito360-logo (4).png') }}" alt="Logo" style="height: 3rem;">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Nchito360°</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
            <a href="{{ route('employee.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>


        <!-- My Company -->
        <li class="menu-item {{ request()->is('employee/company/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-i18n="My Company">My Company</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('employee/company/overview') ? 'active' : '' }}">
                    <a href="/employee/company/overview" class="menu-link">
                        <div>Overview</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('employee/company/team') ? 'active' : '' }}">
                    <a href="/employee/company/team" class="menu-link">
                        <div>Team Members</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('employee/company/branches') ? 'active' : '' }}">
                    <a href="/employee/company/branches" class="menu-link">
                        <div>My Branch</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('employee/company/departments') ? 'active' : '' }}">
                    <a href="/employee/company/departments" class="menu-link">
                        <div>Department</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{ request()->routeIs('employee.profile.overview') ? 'active' : '' }}">
            <a href="{{ route('employee.profile.overview') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('employee.account.billing') ? 'active' : '' }}">
            <a href="{{ route('employee.account.billing') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div data-i18n="Billing & Payments">Billing & Payments</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('employee.support') ? 'active' : '' }}">
            <a href="{{ route('employee.support') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div data-i18n="Help & Support">Help & Support</div>
            </a>
        </li>


        <!-- Logout -->
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out-circle"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>
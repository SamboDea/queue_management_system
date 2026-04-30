<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/NTTI-logo.png') }}" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">NTTI-QMS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- Dashboard --}}
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        {{-- Users --}}
        @can('user.view')
            <li class="menu-item {{ request()->is('users*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>Users</div>
                </a>
                <ul class="menu-sub">
                    @can('user.create')
                        <li class="menu-item {{ request()->routeIs('users.create') ? 'active' : '' }}">
                            <a href="{{ route('users.create') }}" class="menu-link">
                                <div>Add User</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div>List User</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- Departments --}}
        @can('department.view')
            <li class="menu-item {{ request()->is('departments*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-buildings"></i>
                    <div>Departments</div>
                </a>
                <ul class="menu-sub">
                    @can('department.create')
                        <li class="menu-item {{ request()->routeIs('departments.create') ? 'active' : '' }}">
                            <a href="{{ route('departments.create') }}" class="menu-link">
                                <div>Add Department</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                        <a href="{{ route('departments.index') }}" class="menu-link">
                            <div>List Department</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- Counter --}}
        @can('counter.view')
            <li class="menu-item {{ request()->is('counters*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-discount"></i>
                    <div>Counter</div>
                </a>
                <ul class="menu-sub">
                    @can('counter.create')
                        <li class="menu-item {{ request()->routeIs('counters.create') ? 'active' : '' }}">
                            <a href="{{ route('counters.create') }}" class="menu-link">
                                <div>Add Counter</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->routeIs('counters.index') ? 'active' : '' }}">
                        <a href="{{ route('counters.index') }}" class="menu-link">
                            <div>List Counter</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- Display --}}
        @can('queue.view')
            <li class="menu-item {{ request()->is('queue*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-desktop"></i>
                    <div>Display</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('queue.index') ? 'active' : '' }}">
                        <a href="{{ route('queue.index') }}" class="menu-link">
                            <div>Queue Management</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('queue.display') ? 'active' : '' }}">
                        <a href="{{ route('queue.display') }}" target="_blank" class="menu-link">
                            <div>Display Screen</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- Setting --}}
        @can('role.view')
            <li class="menu-item {{ request()->is('roles*') ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-cog"></i>
                    <div>Setting</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="menu-link">
                            <div>List Role</div>
                        </a>
                    </li>
                    @can('role.create')
                        <li class="menu-item {{ request()->routeIs('roles.create') ? 'active' : '' }}">
                            <a href="{{ route('roles.create') }}" class="menu-link">
                                <div>Add Role</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

    </ul>
</aside>

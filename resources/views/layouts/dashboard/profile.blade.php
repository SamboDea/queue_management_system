<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>NTTI-QMS</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/NTTI-logo.png') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('style/css/index.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Battambang:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>
<style>
    @media (max-width: 884px) {
        .layout-navbar .navbar-nav {
            display: none;
        }
    }
</style>

<body>
    @include('components.alert')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.dashboard.sidebar')
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme mb-0"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item lh-1 me-3">
                            </li>

                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="d-flex">
                                        <div class="shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="../assets/img/avatars/1.png" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="grow">
                                            <span class="fw-semibold d-block">{{ Auth::user()->name ?? '' }}</span>
                                            <small class="text-muted">
                                                {{ Auth::user()->role->name }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/profile') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl grow container-p-y">
                        <div class="row">
                            <!-- LEFT: Profile Card -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">

                                        <!-- Avatar -->
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="rounded-circle mb-3"
                                            width="110" height="110" alt="User Avatar">

                                        <h5 class="mb-1"></h5>
                                        <span class="text-muted">{{ Auth::user()->email ?? '' }}</span>

                                        <div class="mt-3">
                                            <span class="badge bg-label-success">Active User</span>
                                        </div>

                                    </div>
                                </div>

                                <!-- Quick Info -->
                                <div class="card mt-3">
                                    <div class="card-body">

                                        <h6 class="mb-3">Account Details</h6>

                                        <div class="mb-2">
                                            <strong>Full Name:</strong>
                                            <span class="text-muted">{{ Auth::user()->name ?? '' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Role:</strong>
                                            <span
                                                class="badge bg-label-success">{{ Auth::user()->role->name ?? '' }}</span>
                                        </div>

                                        <div class="mb-2">
                                            <strong>Status:</strong>
                                            <span class="text-success">Active</span>
                                        </div>

                                        <div class="mb-2">
                                            <strong>Joined:</strong>
                                            <span class="text-muted">{{ Auth::user()->created_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- RIGHT: Profile Form -->
                            <div class="col-md-8">
                                <!-- Password Change -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3 form-password-toggle">
                                                <label class="form-label" for="current_password">Current
                                                    Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="current_password" class="form-control"
                                                        name="current_password"
                                                        placeholder="Enter current password" />
                                                    <span class="input-group-text cursor-pointer toggle-password">
                                                        <i class="bx bx-hide"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label class="form-label" for="new_password">New Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="new_password" class="form-control"
                                                        name="new_password" placeholder="Enter new password" />
                                                    <span class="input-group-text cursor-pointer toggle-password">
                                                        <i class="bx bx-hide"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label class="form-label" for="new_password_confirmation">Confirm
                                                    Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="new_password_confirmation"
                                                        class="form-control" name="new_password_confirmation"
                                                        placeholder="Confirm new password" />
                                                    <span class="input-group-text cursor-pointer toggle-password">
                                                        <i class="bx bx-hide"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn btn-success">Update Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
            <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
            <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
            <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

            <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
            <!-- endbuild -->

            <!-- Vendors JS -->
            <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

            <!-- Main JS -->
            <script src="{{ asset('assets/js/main.js') }}"></script>

            <!-- Page JS -->
            <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

            <!-- Place this tag in your head or just before your close body tag. -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>

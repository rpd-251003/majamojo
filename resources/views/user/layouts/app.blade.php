<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard') | Majamojo Game</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Majamojo Game Membership System" />
    <meta name="author" content="Majamojo" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('berry-template/dist/assets/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />
    <!-- [phosphor Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/phosphor/duotone/style.css') }}" />
    <!-- [Tabler Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/css/style-preset.css') }}" />

    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('user.dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('berry-template/dist/assets/images/logo-dark.svg') }}" alt="Majamojo" class="logo logo-lg" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Menu</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('user.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Browse</label>
                        <i class="ti ti-apps"></i>
                    </li>

                    <li class="pc-item {{ request()->routeIs('user.vouchers.*') ? 'active' : '' }}">
                        <a href="{{ route('user.vouchers.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-ticket"></i></span>
                            <span class="pc-mtext">Vouchers</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('user.events.*') ? 'active' : '' }}">
                        <a href="{{ route('user.events.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                            <span class="pc-mtext">Events</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('user.super-deals.*') ? 'active' : '' }}">
                        <a href="{{ route('user.super-deals.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-gift"></i></span>
                            <span class="pc-mtext">Super Deals</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Account</label>
                        <i class="ti ti-user"></i>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="pc-micon"><i class="ti ti-logout"></i></span>
                            <span class="pc-mtext">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">
                                    <span class="badge bg-light-{{ auth()->user()->role === 'membership' ? 'primary' : 'success' }}">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="ti ti-settings"></i>
                                <span>Profile Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti ti-logout"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header Topbar ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- jQuery (load first) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Required Js -->
    <script src="{{ asset('berry-template/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/feather.min.js') }}"></script>

    <!-- Berry Template JS -->
    <script src="{{ asset('berry-template/dist/assets/js/script.js') }}"></script>

    <script>
        // Setup AJAX CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global error handler
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (jqxhr.status === 401) {
                window.location.href = '/login';
            } else if (jqxhr.status === 403) {
                alert('You do not have permission to perform this action.');
            }
        });

        // Initialize Feather Icons
        $(document).ready(function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarHide = document.querySelector('#sidebar-hide');
            const mobileCollapse = document.querySelector('#mobile-collapse');
            const sidebar = document.querySelector('.pc-sidebar');

            if (sidebarHide) {
                sidebarHide.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (sidebar) {
                        sidebar.classList.toggle('mob-sidebar-active');
                    }
                });
            }

            if (mobileCollapse) {
                mobileCollapse.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (sidebar) {
                        sidebar.classList.toggle('mob-sidebar-active');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

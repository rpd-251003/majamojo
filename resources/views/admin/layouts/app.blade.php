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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
                <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('logo.png') }}" alt="Majamojo" class="logo" width="150" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Menu Utama</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Data Management</label>
                        <i class="ti ti-apps"></i>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.games.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
                            <span class="pc-mtext">Games</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.vouchers.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-ticket"></i></span>
                            <span class="pc-mtext">Vouchers</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.events.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                            <span class="pc-mtext">Events</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.super-deals.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.super-deals.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-gift"></i></span>
                            <span class="pc-mtext">Super Deals</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Akun</label>
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
                                <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
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

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                Swal.fire('Forbidden!', 'You do not have permission to perform this action.', 'error');
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

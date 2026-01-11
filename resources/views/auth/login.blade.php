<!doctype html>
<html lang="en">
<head>
    <title>Login | Majamojo Game</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Majamojo Game Membership System Login" />
    <meta name="author" content="Majamojo" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('berry-template/dist/assets/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />
    <!-- [Tabler Icons] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/css/style-preset.css') }}" />
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('logo.png') }}" alt="Majamojo" class="img-fluid mb-3" style="max-width: 150px;">
                            <h4 class="f-w-500 mb-1">Welcome Back!</h4>
                            <p class="text-muted mb-4">Sign in to your account to continue</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="ti ti-check me-2"></i>{{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email"
                                       required autofocus autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           placeholder="Enter your password"
                                           required autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="ti ti-eye" id="eyeIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-secondary">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-login me-2"></i>Sign In
                                </button>
                            </div>

                            <!-- Demo Accounts Info -->
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <strong><i class="ti ti-info-circle me-2"></i>Demo Accounts:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Admin:</strong> admin@majamojo.com / password</li>
                                        <li><strong>Membership:</strong> membership@majamojo.com / password</li>
                                        <li><strong>Reguler:</strong> reguler@majamojo.com / password</li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                        <!-- Register Link -->
                        {{-- @if (Route::has('register'))
                            <div class="d-flex justify-content-center align-items-end mt-4 pt-3 border-top">
                                <h6 class="f-w-400 mb-0 me-2">Don't have an account?</h6>
                                <a href="{{ route('register') }}" class="link-primary">Create Account</a>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="{{ asset('berry-template/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('berry-template/dist/assets/js/script.js') }}"></script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.remove('ti-eye');
                eyeIcon.classList.add('ti-eye-off');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('ti-eye-off');
                eyeIcon.classList.add('ti-eye');
            }
        });
    </script>
</body>
</html>

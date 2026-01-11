<!doctype html>
<html lang="en">
<head>
    <title>Register | Majamojo Game</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Majamojo Game Membership System Register" />
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
                            <img src="{{ asset('berry-template/dist/assets/images/logo-dark.svg') }}" alt="Majamojo" class="img-fluid mb-3" style="max-width: 150px;">
                            <h4 class="f-w-500 mb-1">Create Account</h4>
                            <p class="text-muted mb-4">Sign up to get started with Majamojo Game</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Enter your full name"
                                       required autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email"
                                       required autocomplete="username">
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
                                           placeholder="Create a password"
                                           required autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="ti ti-eye" id="eyeIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Confirm your password"
                                           required autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="ti ti-eye" id="eyeIconConfirm"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="link-primary">Terms and Conditions</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <div class="d-flex justify-content-center align-items-end mt-4 pt-3 border-top">
                            <h6 class="f-w-400 mb-0 me-2">Already have an account?</h6>
                            <a href="{{ route('login') }}" class="link-primary">Sign In</a>
                        </div>
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

        // Toggle password confirmation visibility
        document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
            const password = document.getElementById('password_confirmation');
            const eyeIcon = document.getElementById('eyeIconConfirm');

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

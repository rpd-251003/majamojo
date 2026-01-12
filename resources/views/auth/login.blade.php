<!doctype html>
<html lang="en">
<head>
    <title>Login | Majamojo Game</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/tabler-icons.min.css') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --neon-blue: #00f0ff;
            --neon-purple: #bf00ff;
            --neon-pink: #ff00bf;
            --dark-bg: #0a0a0f;
            --darker-bg: #050508;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--dark-bg);
            color: #fff;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Orbitron', sans-serif;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(125deg, #0a0a0f 0%, #1a0a2e 50%, #0a0a0f 100%);
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-blue) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridScroll 20s linear infinite;
            opacity: 0.1;
        }

        @keyframes gridScroll {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--neon-blue);
            border-radius: 50%;
            opacity: 0.6;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-100px) translateX(50px); }
            50% { transform: translateY(-50px) translateX(-50px); }
            75% { transform: translateY(-150px) translateX(100px); }
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: rgba(15, 15, 25, 0.9);
            border: 2px solid rgba(0, 240, 255, 0.3);
            border-radius: 20px;
            padding: 50px 40px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 240, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple), var(--neon-pink), var(--neon-blue));
            background-size: 200% auto;
            animation: gradient 3s linear infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* Logo */
        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo img {
            max-width: 150px;
            filter: drop-shadow(0 0 20px rgba(0, 240, 255, 0.5));
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            letter-spacing: 3px;
        }

        .login-subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0;
        }

        /* Form Elements */
        .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .form-control {
            background: rgba(0, 240, 255, 0.05);
            border: 2px solid rgba(0, 240, 255, 0.2);
            color: #fff;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(0, 240, 255, 0.1);
            border-color: var(--neon-blue);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .input-group .btn {
            background: rgba(0, 240, 255, 0.1);
            border: 2px solid rgba(0, 240, 255, 0.2);
            border-left: none;
            color: var(--neon-blue);
        }

        .input-group .btn:hover {
            background: rgba(0, 240, 255, 0.2);
            color: #fff;
        }

        /* Form Check */
        .form-check-input {
            background-color: rgba(0, 240, 255, 0.1);
            border: 2px solid rgba(0, 240, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: var(--neon-blue);
            border-color: var(--neon-blue);
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Links */
        a {
            color: var(--neon-blue);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--neon-purple);
            text-shadow: 0 0 10px var(--neon-purple);
        }

        /* Submit Button */
        .btn-gaming-submit {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            padding: 16px;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            border: none;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 16px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.3);
        }

        .btn-gaming-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-gaming-submit:hover::before {
            left: 100%;
        }

        .btn-gaming-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 240, 255, 0.5);
        }

        /* Alert */
        .alert {
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid rgba(0, 240, 255, 0.3);
            color: #fff;
            border-radius: 10px;
        }

        .alert-success {
            background: rgba(0, 255, 136, 0.1);
            border-color: rgba(0, 255, 136, 0.3);
        }

        .alert-info {
            background: rgba(0, 240, 255, 0.05);
            border-color: rgba(0, 240, 255, 0.2);
        }

        .alert ul {
            padding-left: 20px;
        }

        .alert strong {
            color: var(--neon-blue);
        }

        .invalid-feedback {
            color: #ff0062;
            font-weight: 600;
        }

        .is-invalid {
            border-color: #ff0062 !important;
        }

        /* Home Button */
        .btn-home {
            position: absolute;
            top: 30px;
            left: 30px;
            z-index: 1000;
            background: rgba(0, 240, 255, 0.1);
            border: 2px solid rgba(0, 240, 255, 0.3);
            color: var(--neon-blue);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background: rgba(0, 240, 255, 0.2);
            color: #fff;
            transform: translateX(-5px);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                padding: 40px 30px;
            }

            .login-title {
                font-size: 24px;
            }

            .btn-home {
                top: 20px;
                left: 20px;
                padding: 8px 16px;
                font-size: 12px;
            }
        }

        /* Loading Animation */
        .btn-gaming-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Home Button -->
    <a href="{{ route('landing') }}" class="btn-home">
        <i class="ti ti-arrow-left me-2"></i>Back to Home
    </a>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('logo.png') }}" alt="Majamojo">
                <h1 class="login-title">Access Portal</h1>
                <p class="login-subtitle">Enter your credentials to continue</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label" for="email">
                        <i class="ti ti-mail me-2"></i>Email Address
                    </label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="your@email.com"
                           required
                           autofocus
                           autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label" for="password">
                        <i class="ti ti-lock me-2"></i>Password
                    </label>
                    <div class="input-group">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Enter your password"
                               required
                               autocomplete="current-password">
                        <button class="btn" type="button" id="togglePassword">
                            <i class="ti ti-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-gaming-submit">
                        <i class="ti ti-login me-2"></i>Access System
                    </button>
                </div>

                <!-- Demo Accounts Info -->
                <div class="alert alert-info">
                    <strong><i class="ti ti-info-circle me-2"></i>Demo Accounts:</strong>
                    <ul class="mb-0 mt-2 small">
                        <li><strong>Admin:</strong> admin@majamojo.com / password</li>
                        <li><strong>Membership:</strong> membership@majamojo.com / password</li>
                        <li><strong>Reguler:</strong> reguler@majamojo.com / password</li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Footer Text -->
        <div class="text-center mt-4">
            <p style="color: rgba(255, 255, 255, 0.4); font-size: 14px;">
                &copy; {{ date('Y') }} Majamojo Game. Secured Portal.
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Create floating particles
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }

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

        // Form submit animation
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Accessing...';
        });
    </script>
</body>
</html>

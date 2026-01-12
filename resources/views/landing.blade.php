<!doctype html>
<html lang="en">
<head>
    <title>Majamojo Game - Ultimate Gaming Community</title>
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

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --neon-blue: #00f0ff;
            --neon-purple: #bf00ff;
            --neon-pink: #ff00bf;
            --neon-yellow: #ffd700;
            --dark-bg: #0a0a0f;
            --darker-bg: #050508;
            --card-bg: rgba(15, 15, 25, 0.9);
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
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Orbitron', sans-serif;
        }

        /* === NAVIGATION === */
        .main-navbar {
            background: rgba(10, 10, 15, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(0, 240, 255, 0.2);
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .main-navbar.scrolled {
            background: rgba(5, 5, 8, 0.98);
            box-shadow: 0 5px 30px rgba(0, 240, 255, 0.2);
        }

        .navbar-brand img {
            filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.5));
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            filter: drop-shadow(0 0 20px rgba(0, 240, 255, 0.8));
            transform: scale(1.05);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple));
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            width: 80%;
        }

        .nav-link:hover {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 10px var(--neon-blue);
        }

        .btn-nav-login {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            color: #fff !important;
            padding: 10px 30px !important;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(0, 240, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-nav-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.5);
        }

        /* === HERO SECTION === */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-top: 80px;
            padding: 80px 0;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: linear-gradient(135deg, #0a0a0f 0%, #1a0a2e 50%, #0a0a0f 100%);
        }

        .hero-bg::before {
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

        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            transition: transform 0.1s ease-out, opacity 0.3s ease-out;
            will-change: transform, opacity;
        }

        .hero-image {
            transition: transform 0.1s ease-out;
            will-change: transform;
        }

        .hero-bg {
            transition: transform 0.1s ease-out;
            will-change: transform, background;
        }

        .hero-particles div {
            transition: transform 0.1s ease-out;
            will-change: transform;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid var(--neon-blue);
            color: var(--neon-blue);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 10px rgba(0, 240, 255, 0.3); }
            50% { box-shadow: 0 0 25px rgba(0, 240, 255, 0.6); }
        }

        .hero-title {
            font-size: 72px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #fff 0%, var(--neon-blue) 50%, var(--neon-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-cta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-hero {
            font-family: 'Orbitron', sans-serif;
            padding: 18px 40px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            color: #fff;
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 240, 255, 0.5);
        }

        .btn-hero-outline {
            background: transparent;
            color: var(--neon-blue);
            border: 2px solid var(--neon-blue);
        }

        .btn-hero-outline:hover {
            background: var(--neon-blue);
            color: #000;
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.4);
        }

        .hero-image {
            position: relative;
        }

        .hero-image img {
            filter: drop-shadow(0 20px 60px rgba(0, 240, 255, 0.3));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        /* === SECTION TITLES === */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-label {
            display: inline-block;
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid var(--neon-blue);
            color: var(--neon-blue);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .section-heading {
            font-size: 48px;
            font-weight: 900;
            text-transform: uppercase;
            background: linear-gradient(135deg, #fff, var(--neon-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            transition: text-shadow 0.3s ease;
            position: relative;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--neon-blue), transparent);
            animation: lineGlow 2s ease-in-out infinite;
        }

        @keyframes lineGlow {
            0%, 100% { opacity: 0.3; width: 100px; }
            50% { opacity: 1; width: 150px; }
        }

        .section-description {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.6);
            max-width: 600px;
            margin: 0 auto;
        }

        /* === GAMES SECTION === */
        .games-section {
            padding: 100px 0;
            background: var(--darker-bg);
            position: relative;
        }

        .game-card {
            background: var(--card-bg);
            border: 2px solid rgba(0, 240, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            will-change: transform;
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 240, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .game-card:hover::before {
            left: 100%;
        }

        .game-card:hover {
            transform: translateY(-10px);
            border-color: var(--neon-blue);
            box-shadow: 0 20px 50px rgba(0, 240, 255, 0.3);
        }

        .game-card-image {
            height: 250px;
            background: linear-gradient(135deg, rgba(0, 240, 255, 0.1), rgba(191, 0, 255, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .game-card-image::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-blue) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.1;
            animation: gridScroll 15s linear infinite;
        }

        .game-card-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0, 240, 255, 0.3));
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .game-card:hover .game-card-image img {
            transform: scale(1.1);
        }

        .game-card-body {
            padding: 25px;
        }

        .game-card-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .game-card-description {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        /* === EVENTS SECTION === */
        .events-section {
            padding: 100px 0;
            background: var(--dark-bg);
        }

        .event-card {
            background: var(--card-bg);
            border: 2px solid rgba(0, 240, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            will-change: transform;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple), var(--neon-pink));
            background-size: 200% auto;
            animation: gradient 3s linear infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        .event-card:hover {
            transform: translateY(-10px);
            border-color: var(--neon-purple);
            box-shadow: 0 20px 50px rgba(191, 0, 255, 0.3);
        }

        .event-card-header {
            height: 200px;
            background: linear-gradient(135deg, rgba(191, 0, 255, 0.2), rgba(0, 240, 255, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .event-card-header::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-purple) 1px, transparent 1px);
            background-size: 25px 25px;
            opacity: 0.1;
        }

        .event-card-header img {
            max-width: 120px;
            max-height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(191, 0, 255, 0.4));
            position: relative;
            z-index: 1;
        }

        .event-card-body {
            padding: 25px;
        }

        .event-badge {
            display: inline-block;
            background: rgba(191, 0, 255, 0.1);
            border: 1px solid var(--neon-purple);
            color: var(--neon-purple);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .event-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
            line-height: 1.4;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .event-meta-item i {
            color: var(--neon-purple);
            font-size: 16px;
        }

        .event-description {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 240, 255, 0.1);
        }

        .event-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--neon-blue);
        }

        .event-status-dot {
            width: 8px;
            height: 8px;
            background: var(--neon-blue);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .btn-event-view {
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid var(--neon-blue);
            color: var(--neon-blue);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-event-view:hover {
            background: var(--neon-blue);
            color: #000;
        }

        /* === DEALS SECTION === */
        .deals-section {
            padding: 100px 0;
            background: var(--darker-bg);
            position: relative;
            overflow: hidden;
        }

        .deals-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(255, 0, 191, 0.05), transparent 50%),
                        radial-gradient(circle at 80% 50%, rgba(0, 240, 255, 0.05), transparent 50%);
            z-index: 0;
        }

        .deals-section .container {
            position: relative;
            z-index: 1;
        }

        .deal-card {
            background: var(--card-bg);
            border: 2px solid rgba(255, 0, 191, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            will-change: transform;
        }

        .deal-card::before {
            content: 'HOT DEAL';
            position: absolute;
            top: 20px;
            right: -35px;
            background: linear-gradient(135deg, var(--neon-pink), var(--neon-yellow));
            color: #000;
            padding: 5px 40px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
            transform: rotate(45deg);
            z-index: 10;
            box-shadow: 0 5px 15px rgba(255, 0, 191, 0.5);
        }

        .deal-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: var(--neon-pink);
            box-shadow: 0 20px 50px rgba(255, 0, 191, 0.4);
        }

        .deal-card-header {
            height: 220px;
            background: linear-gradient(135deg, rgba(255, 0, 191, 0.2), rgba(255, 215, 0, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .deal-card-header::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-pink) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
        }

        .deal-card-header img {
            max-width: 140px;
            max-height: 140px;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(255, 0, 191, 0.5));
            position: relative;
            z-index: 1;
        }

        .deal-card-body {
            padding: 25px;
        }

        .deal-badge {
            display: inline-block;
            background: rgba(255, 0, 191, 0.1);
            border: 1px solid var(--neon-pink);
            color: var(--neon-pink);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .deal-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
            line-height: 1.4;
        }

        .deal-price {
            display: flex;
            align-items: baseline;
            gap: 15px;
            margin-bottom: 15px;
        }

        .deal-price-current {
            font-size: 32px;
            font-weight: 900;
            color: var(--neon-yellow);
            font-family: 'Orbitron', sans-serif;
        }

        .deal-price-original {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: line-through;
        }

        .deal-discount {
            display: inline-block;
            background: linear-gradient(135deg, var(--neon-pink), var(--neon-yellow));
            color: #000;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 900;
            margin-left: 10px;
        }

        .deal-countdown {
            background: rgba(255, 0, 191, 0.1);
            border: 1px solid rgba(255, 0, 191, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .deal-countdown-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .deal-countdown-timer {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .deal-countdown-item {
            text-align: center;
        }

        .deal-countdown-value {
            font-size: 24px;
            font-weight: 900;
            color: var(--neon-pink);
            font-family: 'Orbitron', sans-serif;
            display: block;
        }

        .deal-countdown-unit {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-deal-claim {
            width: 100%;
            background: linear-gradient(135deg, var(--neon-pink), var(--neon-yellow));
            color: #000;
            padding: 15px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: none;
            transition: all 0.3s ease;
            font-family: 'Orbitron', sans-serif;
        }

        .btn-deal-claim:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 0, 191, 0.5);
        }

        /* === CTA SECTION === */
        .cta-section {
            padding: 100px 0;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 240, 255, 0.1) 0%, rgba(191, 0, 255, 0.1) 100%);
            z-index: 0;
        }

        .cta-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 56px;
            font-weight: 900;
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple), var(--neon-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .cta-description {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        /* === FOOTER === */
        .main-footer {
            background: var(--darker-bg);
            border-top: 2px solid rgba(0, 240, 255, 0.2);
            padding: 60px 0 30px;
        }

        .footer-brand {
            margin-bottom: 20px;
        }

        .footer-brand img {
            max-width: 150px;
            filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.3));
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .footer-social-link {
            width: 40px;
            height: 40px;
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid var(--neon-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neon-blue);
            transition: all 0.3s ease;
        }

        .footer-social-link:hover {
            background: var(--neon-blue);
            color: #000;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 240, 255, 0.3);
        }

        .footer-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--neon-blue);
            transform: translateX(5px);
        }

        .footer-bottom {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid rgba(0, 240, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-size: 14px;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 42px;
            }

            .section-heading {
                font-size: 32px;
            }

            .cta-title {
                font-size: 36px;
            }

            .hero-cta {
                justify-content: center;
            }

            .btn-hero {
                padding: 15px 30px;
                font-size: 14px;
            }

            .game-card-image {
                height: 200px;
            }

            .event-card-header {
                height: 180px;
            }

            .deal-card-header {
                height: 200px;
            }
        }

        /* === SCROLL TO TOP === */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(0, 240, 255, 0.3);
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.5);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('logo.png') }}" alt="Majamojo" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: var(--neon-blue);">
                <i class="ti ti-menu-2" style="color: var(--neon-blue); font-size: 24px;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#games">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#deals">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-nav-login" href="{{ route('login') }}">
                            <i class="ti ti-login me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-particles" id="hero-particles"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-right">
                    <span class="hero-badge">
                        <i class="ti ti-bolt me-2"></i>Ultimate Gaming Platform
                    </span>
                    <h1 class="hero-title">
                        Join The Epic <br>Gaming Community
                    </h1>
                    <p class="hero-subtitle">
                        Access exclusive vouchers, participate in tournaments, grab amazing deals, and connect with gamers worldwide. Your gaming journey starts here.
                    </p>
                    <div class="hero-cta">
                        <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">
                            <i class="ti ti-login me-2"></i>Get Started
                        </a>
                        <a href="#games" class="btn btn-hero btn-hero-outline">
                            <i class="ti ti-device-gamepad-2 me-2"></i>Explore Games
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    <img src="https://idmj-website.oss-ap-southeast-5.aliyuncs.com/resources/majamojo-web/202503171658-ete-kv-home-2.png" alt="Majamojo Gaming" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Games Section -->
    <section id="games" class="games-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="section-label">
                    <i class="ti ti-device-gamepad me-2"></i>Our Collection
                </span>
                <h2 class="section-heading">Featured Games</h2>
                <p class="section-description">
                    Discover our curated selection of the hottest games with exclusive rewards and tournaments
                </p>
            </div>

            <div class="row g-4">
                @forelse($games as $game)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="game-card">
                            <div class="game-card-image">
                                @if($game->logo)
                                    <img src="{{ asset('storage/' . $game->logo) }}" alt="{{ $game->name }}">
                                @else
                                    <i class="ti ti-device-gamepad-2" style="font-size: 80px; color: var(--neon-blue);"></i>
                                @endif
                            </div>
                            <div class="game-card-body">
                                <h3 class="game-card-title">{{ $game->name }}</h3>
                                <p class="game-card-description">
                                    {{ Str::limit($game->description ?? 'Join the action in ' . $game->name . ' and compete for amazing rewards!', 100) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p style="color: rgba(255, 255, 255, 0.6); font-size: 18px;">
                            <i class="ti ti-ghost me-2"></i>No games available at the moment
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="events-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="section-label">
                    <i class="ti ti-calendar-event me-2"></i>Upcoming
                </span>
                <h2 class="section-heading">Live Tournaments</h2>
                <p class="section-description">
                    Join exciting tournaments and compete against the best players for amazing prizes
                </p>
            </div>

            <div class="row g-4">
                @forelse($upcomingEvents as $event)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="event-card">
                            <div class="event-card-header">
                                @if($event->game && $event->game->logo)
                                    <img src="{{ asset('storage/' . $event->game->logo) }}" alt="{{ $event->game->name }}">
                                @else
                                    <i class="ti ti-trophy" style="font-size: 80px; color: var(--neon-purple);"></i>
                                @endif
                            </div>
                            <div class="event-card-body">
                                <span class="event-badge">
                                    <i class="ti ti-device-gamepad me-1"></i>{{ $event->game ? $event->game->name : 'Tournament' }}
                                </span>
                                <h3 class="event-title">{{ $event->name }}</h3>
                                <div class="event-meta">
                                    <div class="event-meta-item">
                                        <i class="ti ti-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="event-meta-item">
                                        <i class="ti ti-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('h:i A') }}</span>
                                    </div>
                                    @if($event->location)
                                        <div class="event-meta-item">
                                            <i class="ti ti-map-pin"></i>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="event-description">
                                    {{ Str::limit($event->description, 100) }}
                                </p>
                                <div class="event-footer">
                                    <div class="event-status">
                                        <span class="event-status-dot"></span>
                                        <span>Live Now</span>
                                    </div>
                                    <button class="btn-event-view">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p style="color: rgba(255, 255, 255, 0.6); font-size: 18px;">
                            <i class="ti ti-calendar-off me-2"></i>No upcoming events at the moment
                        </p>
                    </div>
                @endforelse
            </div>

            @if($upcomingEvents->count() > 0)
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">
                        <i class="ti ti-calendar-event me-2"></i>View All Events
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Super Deals Section -->
    <section id="deals" class="deals-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="section-label">
                    <i class="ti ti-bolt me-2"></i>Limited Time
                </span>
                <h2 class="section-heading">Hot Deals</h2>
                <p class="section-description">
                    Grab these exclusive deals before they're gone! Limited time offers on premium content
                </p>
            </div>

            <div class="row g-4">
                @forelse($hotDeals as $deal)
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="deal-card">
                            <div class="deal-card-header">
                                @if($deal->game && $deal->game->logo)
                                    <img src="{{ asset('storage/' . $deal->game->logo) }}" alt="{{ $deal->game->name }}">
                                @else
                                    <i class="ti ti-gift" style="font-size: 100px; color: var(--neon-pink);"></i>
                                @endif
                            </div>
                            <div class="deal-card-body">
                                <span class="deal-badge">
                                    <i class="ti ti-sparkles me-1"></i>{{ $deal->game ? $deal->game->name : 'Special Offer' }}
                                </span>
                                <h3 class="deal-title">{{ $deal->title }}</h3>

                                <div class="deal-price">
                                    <span class="deal-price-current">Rp {{ number_format($deal->price, 0, ',', '.') }}</span>
                                    @if($deal->original_price)
                                        <span class="deal-price-original">Rp {{ number_format($deal->original_price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                @if($deal->original_price && $deal->price < $deal->original_price)
                                    @php
                                        $discount = round((($deal->original_price - $deal->price) / $deal->original_price) * 100);
                                    @endphp
                                    <span class="deal-discount">-{{ $discount }}%</span>
                                @endif

                                <div class="deal-countdown">
                                    <div class="deal-countdown-label">
                                        <i class="ti ti-clock me-2"></i>Ends In
                                    </div>
                                    <div class="deal-countdown-timer" data-end-date="{{ $deal->end_date }}">
                                        <div class="deal-countdown-item">
                                            <span class="deal-countdown-value days">00</span>
                                            <span class="deal-countdown-unit">Days</span>
                                        </div>
                                        <div class="deal-countdown-item">
                                            <span class="deal-countdown-value hours">00</span>
                                            <span class="deal-countdown-unit">Hours</span>
                                        </div>
                                        <div class="deal-countdown-item">
                                            <span class="deal-countdown-value minutes">00</span>
                                            <span class="deal-countdown-unit">Mins</span>
                                        </div>
                                        <div class="deal-countdown-item">
                                            <span class="deal-countdown-value seconds">00</span>
                                            <span class="deal-countdown-unit">Secs</span>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn-deal-claim">
                                    <i class="ti ti-bolt me-2"></i>Claim Deal
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p style="color: rgba(255, 255, 255, 0.6); font-size: 18px;">
                            <i class="ti ti-discount-off me-2"></i>No hot deals available at the moment
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2 class="cta-title">Ready To Join The Action?</h2>
                <p class="cta-description">
                    Get instant access to exclusive vouchers, tournaments, and deals. Join thousands of gamers in the ultimate gaming community.
                </p>
                <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">
                    <i class="ti ti-login me-2"></i>Login Now
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <img src="{{ asset('logo.png') }}" alt="Majamojo">
                    </div>
                    <p class="footer-description">
                        Majamojo is the ultimate gaming community platform where players connect, compete, and win amazing rewards.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="footer-social-link">
                            <i class="ti ti-brand-facebook"></i>
                        </a>
                        <a href="#" class="footer-social-link">
                            <i class="ti ti-brand-twitter"></i>
                        </a>
                        <a href="#" class="footer-social-link">
                            <i class="ti ti-brand-discord"></i>
                        </a>
                        <a href="#" class="footer-social-link">
                            <i class="ti ti-brand-twitch"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#games">Games</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#deals">Deals</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Community</h4>
                    <ul class="footer-links">
                        <li><a href="#">Forums</a></li>
                        <li><a href="#">Tournaments</a></li>
                        <li><a href="#">Leaderboards</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Majamojo Game. All rights reserved. Powered by cutting-edge gaming technology.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="scroll-to-top" id="scrollToTop">
        <i class="ti ti-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS with more dynamic settings
        AOS.init({
            duration: 800,
            once: false,
            offset: 50,
            easing: 'ease-out-cubic'
        });

        // Create advanced animated particles with various movements
        const heroParticlesContainer = document.getElementById('hero-particles');
        const particleColors = ['var(--neon-blue)', 'var(--neon-purple)', 'var(--neon-pink)'];

        // Create 50 particles with different sizes and speeds
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            const size = Math.random() * 4 + 2; // 2-6px
            const speed = Math.random() * 3 + 2; // 2-5 seconds
            const color = particleColors[Math.floor(Math.random() * particleColors.length)];

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = color;
            particle.style.borderRadius = '50%';
            particle.style.opacity = Math.random() * 0.6 + 0.3; // 0.3-0.9
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.boxShadow = `0 0 ${size * 3}px ${color}`;

            // Different animation patterns
            const patterns = ['floatWave', 'floatZigzag', 'floatCircle', 'floatDiagonal'];
            const pattern = patterns[Math.floor(Math.random() * patterns.length)];

            particle.style.animation = `${pattern} ${speed}s ease-in-out infinite`;
            particle.style.animationDelay = Math.random() * 2 + 's';

            heroParticlesContainer.appendChild(particle);
        }

        // Add dynamic keyframe animations
        const styleSheet = document.createElement('style');
        styleSheet.textContent = `
            @keyframes floatWave {
                0%, 100% {
                    transform: translate(0, 0) scale(1);
                }
                25% {
                    transform: translate(30px, -50px) scale(1.2);
                }
                50% {
                    transform: translate(60px, -20px) scale(0.8);
                }
                75% {
                    transform: translate(30px, 20px) scale(1.1);
                }
            }

            @keyframes floatZigzag {
                0%, 100% {
                    transform: translate(0, 0) rotate(0deg);
                }
                20% {
                    transform: translate(40px, -60px) rotate(45deg);
                }
                40% {
                    transform: translate(-20px, -100px) rotate(-45deg);
                }
                60% {
                    transform: translate(50px, -140px) rotate(90deg);
                }
                80% {
                    transform: translate(-30px, -80px) rotate(-90deg);
                }
            }

            @keyframes floatCircle {
                0% {
                    transform: translate(0, 0) rotate(0deg);
                }
                25% {
                    transform: translate(50px, -50px) rotate(90deg);
                }
                50% {
                    transform: translate(0, -100px) rotate(180deg);
                }
                75% {
                    transform: translate(-50px, -50px) rotate(270deg);
                }
                100% {
                    transform: translate(0, 0) rotate(360deg);
                }
            }

            @keyframes floatDiagonal {
                0%, 100% {
                    transform: translate(0, 0) scale(1);
                    opacity: 0.3;
                }
                50% {
                    transform: translate(-80px, -120px) scale(1.5);
                    opacity: 0.9;
                }
            }
        `;
        document.head.appendChild(styleSheet);

        // Parallax effect on scroll
        let ticking = false;
        let lastScrollY = 0;

        function parallaxScroll() {
            const scrollY = window.pageYOffset;

            // Hero parallax
            const heroContent = document.querySelector('.hero-content');
            const heroImage = document.querySelector('.hero-image');
            const heroBg = document.querySelector('.hero-bg');

            if (heroContent && scrollY < window.innerHeight) {
                heroContent.style.transform = `translateY(${scrollY * 0.3}px)`;
                heroContent.style.opacity = 1 - (scrollY / window.innerHeight) * 0.8;
            }

            if (heroImage && scrollY < window.innerHeight) {
                heroImage.style.transform = `translateY(${scrollY * -0.2}px) scale(${1 + scrollY * 0.0002})`;
            }

            if (heroBg && scrollY < window.innerHeight) {
                heroBg.style.transform = `translateY(${scrollY * 0.5}px)`;
            }

            // Parallax for particles
            const particles = heroParticlesContainer.querySelectorAll('div');
            particles.forEach((particle, index) => {
                const speed = 0.1 + (index % 5) * 0.05;
                particle.style.transform = `translateY(${scrollY * speed}px)`;
            });

            // Section reveal effects
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                if (rect.top < windowHeight * 0.75) {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                } else {
                    section.style.opacity = '0.3';
                    section.style.transform = 'translateY(50px)';
                }
            });

            // Scale cards on scroll
            const cards = document.querySelectorAll('.game-card, .event-card, .deal-card');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const cardCenter = rect.top + rect.height / 2;
                const windowCenter = windowHeight / 2;
                const distance = Math.abs(cardCenter - windowCenter);
                const maxDistance = windowHeight / 2;
                const scale = 1 - (distance / maxDistance) * 0.1;

                if (rect.top < windowHeight && rect.bottom > 0) {
                    card.style.transform = `scale(${Math.max(scale, 0.9)})`;
                }
            });

            lastScrollY = scrollY;
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                window.requestAnimationFrame(parallaxScroll);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);

        // Initial call
        parallaxScroll();

        // Initialize section transitions
        const allSections = document.querySelectorAll('section');
        allSections.forEach(section => {
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        // Navbar scroll effect with enhanced transitions
        const navbar = document.querySelector('.main-navbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll to top button
        const scrollToTop = document.getElementById('scrollToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 500) {
                scrollToTop.classList.add('show');
            } else {
                scrollToTop.classList.remove('show');
            }
        });

        scrollToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Countdown timers for deals
        function updateCountdown(element) {
            const endDate = new Date(element.getAttribute('data-end-date')).getTime();

            function update() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    element.innerHTML = '<span style="color: var(--neon-pink);">Deal Expired</span>';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                element.querySelector('.days').textContent = String(days).padStart(2, '0');
                element.querySelector('.hours').textContent = String(hours).padStart(2, '0');
                element.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
                element.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
            }

            update();
            setInterval(update, 1000);
        }

        document.querySelectorAll('.deal-countdown-timer').forEach(updateCountdown);

        // Active nav link on scroll
        const navSections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', function() {
            let current = '';
            navSections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Add click handlers for deal buttons
        document.querySelectorAll('.btn-deal-claim').forEach(btn => {
            btn.addEventListener('click', function() {
                window.location.href = '{{ route("login") }}';
            });
        });

        document.querySelectorAll('.btn-event-view').forEach(btn => {
            btn.addEventListener('click', function() {
                window.location.href = '{{ route("login") }}';
            });
        });

        // Enhanced card interactions with magnetic effect
        const cards = document.querySelectorAll('.game-card, .event-card, .deal-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
            });

            card.addEventListener('mouseleave', function() {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
            });
        });

        // Animated gradient background on scroll
        let gradientOffset = 0;
        function animateGradient() {
            gradientOffset += 0.5;
            const heroBg = document.querySelector('.hero-bg');
            if (heroBg) {
                heroBg.style.background = `linear-gradient(${gradientOffset}deg, #0a0a0f 0%, #1a0a2e 50%, #0a0a0f 100%)`;
            }
            requestAnimationFrame(animateGradient);
        }
        animateGradient();

        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn-hero, .btn-nav-login, .btn-deal-claim, .btn-event-view');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple-effect');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple styles
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s ease-out;
                pointer-events: none;
            }

            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .btn-hero, .btn-nav-login, .btn-deal-claim, .btn-event-view {
                position: relative;
                overflow: hidden;
            }
        `;
        document.head.appendChild(rippleStyle);

        // Mouse trail effect
        const colors = ['rgba(0, 240, 255, 0.5)', 'rgba(191, 0, 255, 0.5)', 'rgba(255, 0, 191, 0.5)'];
        let colorIndex = 0;

        document.addEventListener('mousemove', function(e) {
            if (Math.random() > 0.9) { // Only create trail occasionally
                const trail = document.createElement('div');
                trail.style.position = 'fixed';
                trail.style.width = '6px';
                trail.style.height = '6px';
                trail.style.borderRadius = '50%';
                trail.style.background = colors[colorIndex % colors.length];
                trail.style.left = e.clientX + 'px';
                trail.style.top = e.clientY + 'px';
                trail.style.pointerEvents = 'none';
                trail.style.zIndex = '9999';
                trail.style.boxShadow = `0 0 10px ${colors[colorIndex % colors.length]}`;
                trail.style.animation = 'trail-fade 1s ease-out forwards';

                document.body.appendChild(trail);

                colorIndex++;

                setTimeout(() => {
                    trail.remove();
                }, 1000);
            }
        });

        // Trail fade animation
        const trailStyle = document.createElement('style');
        trailStyle.textContent = `
            @keyframes trail-fade {
                0% {
                    transform: scale(1);
                    opacity: 1;
                }
                100% {
                    transform: scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(trailStyle);

        // Section title glow effect on scroll
        const sectionHeadings = document.querySelectorAll('.section-heading');
        window.addEventListener('scroll', function() {
            sectionHeadings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.7 && rect.bottom > 0) {
                    heading.style.textShadow = '0 0 20px var(--neon-blue), 0 0 40px var(--neon-blue)';
                } else {
                    heading.style.textShadow = 'none';
                }
            });
        });
    </script>
</body>
</html>

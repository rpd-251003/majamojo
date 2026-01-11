@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- [ Hero Banner with Particles ] start -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card hero-banner-super position-relative overflow-hidden border-0" style="min-height: 350px;">
            <div class="particles-container" id="particles-js"></div>
            <div class="hero-gradient-overlay"></div>
            <div class="card-body position-relative" style="z-index: 10;">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="hero-content">
                            <div class="badge-animated mb-3">
                                @if(auth()->user()->role == 'membership')
                                    <span class="badge-glow badge-premium">
                                        <i class="ti ti-crown me-2"></i>PREMIUM MEMBER
                                    </span>
                                @else
                                    <span class="badge-glow badge-standard">
                                        <i class="ti ti-user me-2"></i>MEMBER
                                    </span>
                                @endif
                            </div>
                            <h1 class="hero-title text-white mb-3 display-4 fw-bold">
                                Welcome Back,<br>
                                <span class="text-gradient-animated">{{ auth()->user()->name }}!</span>
                            </h1>
                            <p class="hero-subtitle text-white text-opacity-90 mb-4 fs-5">
                                🎮 Your Gaming Hub for Exclusive Deals, Events & Vouchers
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="{{ route('user.vouchers') }}" class="btn btn-hero btn-light-hero btn-lg shadow-lg">
                                    <i class="ti ti-ticket me-2"></i>Explore Vouchers
                                    <span class="btn-shine"></span>
                                </a>
                                <a href="{{ route('user.super-deals') }}" class="btn btn-hero btn-outline-light-hero btn-lg">
                                    <i class="ti ti-flame me-2"></i>Hot Deals
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center d-none d-lg-block">
                        <div class="hero-illustration">
                            <div class="illustration-circle circle-1"></div>
                            <div class="illustration-circle circle-2"></div>
                            <div class="illustration-circle circle-3"></div>
                            <i class="ti ti-device-gamepad-2 hero-main-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Hero Banner ] end -->

<!-- [ Statistics Grid with Advanced Design ] start -->
<div class="row g-4 mb-4">
    <!-- Vouchers Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card stats-card-modern stats-success position-relative overflow-hidden">
            <div class="stats-pattern"></div>
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon bg-success-gradient">
                            <i class="ti ti-ticket"></i>
                        </div>
                    </div>
                    <div class="stats-trend">
                        <i class="ti ti-trending-up"></i>
                    </div>
                </div>
                <h2 class="stats-number mb-1 counter-value" data-target="{{ $stats['total_vouchers'] }}">0</h2>
                <p class="stats-label text-muted mb-0">Available Vouchers</p>
                <div class="stats-footer mt-3">
                    <a href="{{ route('user.vouchers') }}" class="stats-link">
                        View All <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="stats-glow stats-glow-success"></div>
        </div>
    </div>

    <!-- Events Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card stats-card-modern stats-warning position-relative overflow-hidden">
            <div class="stats-pattern"></div>
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon bg-warning-gradient">
                            <i class="ti ti-calendar-event"></i>
                        </div>
                    </div>
                    <div class="stats-trend">
                        <i class="ti ti-trending-up"></i>
                    </div>
                </div>
                <h2 class="stats-number mb-1 counter-value" data-target="{{ $stats['total_events'] }}">0</h2>
                <p class="stats-label text-muted mb-0">Active Events</p>
                <div class="stats-footer mt-3">
                    <a href="{{ route('user.events') }}" class="stats-link">
                        View All <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="stats-glow stats-glow-warning"></div>
        </div>
    </div>

    <!-- Super Deals Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card stats-card-modern stats-danger position-relative overflow-hidden">
            <div class="stats-pattern"></div>
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon bg-danger-gradient">
                            <i class="ti ti-flame"></i>
                        </div>
                    </div>
                    <div class="stats-trend stats-trend-hot">
                        <i class="ti ti-flame"></i>
                    </div>
                </div>
                <h2 class="stats-number mb-1 counter-value" data-target="{{ $stats['total_deals'] }}">0</h2>
                <p class="stats-label text-muted mb-0">Hot Deals</p>
                <div class="stats-footer mt-3">
                    <a href="{{ route('user.super-deals') }}" class="stats-link">
                        View All <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="stats-glow stats-glow-danger"></div>
        </div>
    </div>

    <!-- Games Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card stats-card-modern stats-primary position-relative overflow-hidden">
            <div class="stats-pattern"></div>
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon bg-primary-gradient">
                            <i class="ti ti-device-gamepad"></i>
                        </div>
                    </div>
                    <div class="stats-trend">
                        <i class="ti ti-trophy"></i>
                    </div>
                </div>
                <h2 class="stats-number mb-1 counter-value" data-target="{{ $stats['total_games'] }}">0</h2>
                <p class="stats-label text-muted mb-0">Total Games</p>
                <div class="stats-footer mt-3">
                    <span class="stats-link text-muted">
                        All Platforms
                    </span>
                </div>
            </div>
            <div class="stats-glow stats-glow-primary"></div>
        </div>
    </div>
</div>
<!-- [ Statistics Grid ] end -->

<!-- [ Featured Hot Deals Carousel ] start -->
@if($recentDeals->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card modern-card border-0 shadow-lg">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="featured-badge">
                                <i class="ti ti-flame"></i>
                            </div>
                            <h3 class="mb-0 ms-3">🔥 Hot Deals of the Day</h3>
                        </div>
                        <p class="text-muted mb-0">Limited time offers - Grab them before they're gone!</p>
                    </div>
                    <a href="{{ route('user.super-deals') }}" class="btn btn-danger btn-lg shadow">
                        View All Deals <i class="ti ti-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="card-body pt-4">
                <div id="hotDealsCarousel" class="carousel slide carousel-modern" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($recentDeals as $index => $deal)
                            <button type="button" data-bs-target="#hotDealsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded-3">
                        @foreach($recentDeals as $index => $deal)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="deal-showcase-card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-lg-6">
                                            <div class="deal-image-wrapper">
                                                @if($deal->banner_image)
                                                    <img src="{{ asset('storage/' . $deal->banner_image) }}"
                                                         class="deal-showcase-img"
                                                         alt="{{ $deal->game_name }}">
                                                @else
                                                    <div class="deal-placeholder bg-gradient-danger">
                                                        <i class="ti ti-gift"></i>
                                                    </div>
                                                @endif
                                                <div class="deal-overlay-badge">
                                                    <span class="badge-hot-deal">
                                                        <i class="ti ti-flame me-1"></i>HOT
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="deal-content-wrapper p-5">
                                                <div class="deal-game-info mb-4">
                                                    @if($deal->game->logo)
                                                        <img src="{{ asset('storage/' . $deal->game->logo) }}"
                                                             alt="{{ $deal->game->name }}"
                                                             class="deal-game-logo">
                                                    @endif
                                                    <span class="deal-game-name">{{ $deal->game->name }}</span>
                                                </div>
                                                <h2 class="deal-title mb-3">{{ $deal->game_name }}</h2>
                                                @if($deal->description)
                                                    <p class="deal-description text-muted mb-4">
                                                        {{ Str::limit($deal->description, 120) }}
                                                    </p>
                                                @endif
                                                <div class="deal-price-section mb-4">
                                                    <div class="row align-items-end">
                                                        <div class="col-auto">
                                                            <label class="deal-price-label">Special Price</label>
                                                            <h1 class="deal-price text-danger mb-0">
                                                                Rp {{ number_format($deal->price, 0, ',', '.') }}
                                                            </h1>
                                                        </div>
                                                        <div class="col-auto ms-auto">
                                                            <div class="deal-validity">
                                                                <i class="ti ti-clock-hour-4"></i>
                                                                <div>
                                                                    <small class="d-block text-muted">Valid Until</small>
                                                                    <strong>{{ $deal->end_date->format('d M Y') }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($deal->external_link)
                                                    <a href="{{ $deal->external_link }}" target="_blank" class="btn btn-danger btn-xl shadow-lg w-100">
                                                        <i class="ti ti-shopping-cart me-2"></i>Claim This Deal Now
                                                        <i class="ti ti-arrow-right ms-2"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-outline-danger btn-xl w-100" disabled>
                                                        <i class="ti ti-info-circle me-2"></i>Coming Soon
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($recentDeals->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#hotDealsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-custom">
                                <i class="ti ti-chevron-left"></i>
                            </span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#hotDealsCarousel" data-bs-slide="next">
                            <span class="carousel-control-custom">
                                <i class="ti ti-chevron-right"></i>
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- [ Featured Hot Deals Carousel ] end -->

<!-- [ Latest Updates Section ] start -->
<div class="row g-4">
    <!-- Latest Vouchers -->
    <div class="col-lg-6">
        <div class="card modern-card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="section-icon bg-success-light">
                            <i class="ti ti-ticket text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Latest Vouchers</h5>
                            <small class="text-muted">Grab your exclusive codes</small>
                        </div>
                    </div>
                    <a href="{{ route('user.vouchers') }}" class="btn btn-success btn-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="vouchers-list">
                    @forelse($recentVouchers as $voucher)
                        <div class="voucher-card-mini mb-3">
                            <div class="voucher-card-content">
                                <div class="d-flex align-items-center">
                                    <div class="voucher-game-icon">
                                        @if($voucher->game->logo)
                                            <img src="{{ asset('storage/' . $voucher->game->logo) }}"
                                                 alt="{{ $voucher->game->name }}">
                                        @else
                                            <div class="voucher-icon-placeholder bg-success-light">
                                                <i class="ti ti-device-gamepad text-success"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="voucher-code mb-1">{{ $voucher->promo_code }}</h6>
                                        <small class="text-muted">{{ $voucher->game->name }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($voucher->type == 'membership_only')
                                            <span class="badge badge-premium-mini">
                                                <i class="ti ti-crown"></i> VIP
                                            </span>
                                        @elseif($voucher->type == 'reguler_only')
                                            <span class="badge badge-regular-mini">
                                                <i class="ti ti-user"></i> Regular
                                            </span>
                                        @else
                                            <span class="badge badge-all-mini">
                                                <i class="ti ti-users"></i> All
                                            </span>
                                        @endif
                                        <div class="voucher-expiry mt-1">
                                            <i class="ti ti-clock"></i>
                                            <small>{{ $voucher->end_date->format('d M') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center py-5">
                            <div class="empty-icon mb-3">
                                <i class="ti ti-ticket"></i>
                            </div>
                            <h6 class="text-muted">No Vouchers Available</h6>
                            <p class="text-muted small mb-0">Check back later for new vouchers!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="col-lg-6">
        <div class="card modern-card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="section-icon bg-warning-light">
                            <i class="ti ti-calendar-event text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Upcoming Events</h5>
                            <small class="text-muted">Don't miss these exciting events</small>
                        </div>
                    </div>
                    <a href="{{ route('user.events') }}" class="btn btn-warning btn-sm">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="events-list">
                    @forelse($recentEvents as $event)
                        <div class="event-card-mini mb-3">
                            <div class="event-card-content">
                                <div class="d-flex align-items-start">
                                    <div class="event-date-badge-mini">
                                        <div class="event-day">{{ $event->start_date->format('d') }}</div>
                                        <div class="event-month">{{ $event->start_date->format('M') }}</div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="event-title mb-2">{{ $event->title }}</h6>
                                        <div class="d-flex align-items-center mb-2">
                                            @if($event->game->logo)
                                                <img src="{{ asset('storage/' . $event->game->logo) }}"
                                                     alt="{{ $event->game->name }}"
                                                     class="event-game-icon">
                                            @endif
                                            <small class="text-muted ms-2">{{ $event->game->name }}</small>
                                        </div>
                                        @php
                                            $daysLeft = now()->diffInDays($event->end_date, false);
                                        @endphp
                                        @if($daysLeft > 0)
                                            <div class="event-countdown">
                                                <i class="ti ti-clock-hour-4"></i>
                                                <small>{{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }} remaining</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="event-status">
                                        <span class="badge badge-active">
                                            <i class="ti ti-circle-check"></i> Active
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center py-5">
                            <div class="empty-icon mb-3">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <h6 class="text-muted">No Events Available</h6>
                            <p class="text-muted small mb-0">Check back later for exciting events!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Latest Updates Section ] end -->
@endsection

@push('styles')
<style>
/* ============================================
   HERO BANNER - SUPER ADVANCED
   ============================================ */
.hero-banner-super {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
}

.particles-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
}

.hero-gradient-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
    z-index: 2;
}

.badge-animated {
    animation: slideInDown 0.8s ease-out;
}

.badge-glow {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 1px;
    animation: glow-pulse 2s ease-in-out infinite;
}

.badge-premium {
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    color: #000;
    box-shadow: 0 4px 15px rgba(246, 211, 101, 0.5);
}

.badge-standard {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

@keyframes glow-pulse {
    0%, 100% {
        box-shadow: 0 4px 15px rgba(246, 211, 101, 0.5);
    }
    50% {
        box-shadow: 0 4px 25px rgba(246, 211, 101, 0.8);
    }
}

.hero-title {
    animation: fadeInUp 1s ease-out;
    line-height: 1.2;
}

.text-gradient-animated {
    background: linear-gradient(90deg, #fff, #ffd89b, #fff);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-shift 3s linear infinite;
}

@keyframes gradient-shift {
    0% { background-position: 0% center; }
    100% { background-position: 200% center; }
}

.hero-subtitle {
    animation: fadeInUp 1.2s ease-out;
}

.btn-hero {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    animation: fadeInUp 1.4s ease-out;
}

.btn-light-hero {
    background: rgba(255, 255, 255, 0.95);
    color: #667eea;
    border: none;
}

.btn-light-hero:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.4);
    background: #fff;
}

.btn-outline-light-hero {
    border: 2px solid rgba(255, 255, 255, 0.8);
    color: #fff;
    background: transparent;
}

.btn-outline-light-hero:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: #fff;
    transform: translateY(-3px);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { left: -100%; }
    20%, 100% { left: 100%; }
}

.hero-illustration {
    position: relative;
    animation: fadeIn 1.5s ease-out;
}

.illustration-circle {
    position: absolute;
    border-radius: 50%;
    animation: float-rotate 20s ease-in-out infinite;
}

.circle-1 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.circle-2 {
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: -5s;
}

.circle-3 {
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: -10s;
}

@keyframes float-rotate {
    0%, 100% {
        transform: translate(-50%, -50%) rotate(0deg) scale(1);
    }
    25% {
        transform: translate(-50%, -50%) rotate(90deg) scale(1.1);
    }
    50% {
        transform: translate(-50%, -50%) rotate(180deg) scale(1);
    }
    75% {
        transform: translate(-50%, -50%) rotate(270deg) scale(0.9);
    }
}

.hero-main-icon {
    font-size: 200px;
    color: rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 10;
    animation: icon-float 3s ease-in-out infinite;
}

@keyframes icon-float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(5deg);
    }
}

/* ============================================
   STATISTICS CARDS - MODERN DESIGN
   ============================================ */
.stats-card-modern {
    border: none;
    border-radius: 16px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
}

.stats-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stats-pattern {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0.03;
    background-image:
        repeating-linear-gradient(45deg, transparent, transparent 10px, currentColor 10px, currentColor 11px),
        repeating-linear-gradient(-45deg, transparent, transparent 10px, currentColor 10px, currentColor 11px);
}

.stats-icon-wrapper {
    position: relative;
}

.stats-icon {
    width: 65px;
    height: 65px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #fff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    animation: icon-bounce 2s ease-in-out infinite;
}

@keyframes icon-bounce {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.bg-success-gradient {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-warning-gradient {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-danger-gradient {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.bg-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-trend {
    width: 35px;
    height: 35px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #666;
}

.stats-trend-hot {
    animation: pulse-hot 1.5s ease-in-out infinite;
}

@keyframes pulse-hot {
    0%, 100% {
        transform: scale(1);
        color: #dc3545;
    }
    50% {
        transform: scale(1.2);
        color: #ff0000;
    }
}

.stats-number {
    font-weight: 800;
    font-size: 2.5rem;
    color: #2c3e50;
}

.stats-label {
    font-size: 14px;
    font-weight: 500;
}

.stats-footer {
    padding-top: 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.stats-link {
    color: #667eea;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.stats-link:hover {
    color: #764ba2;
    transform: translateX(5px);
}

.stats-glow {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 30px;
    border-radius: 50%;
    filter: blur(20px);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.stats-card-modern:hover .stats-glow {
    opacity: 0.6;
}

.stats-glow-success {
    background: #38ef7d;
}

.stats-glow-warning {
    background: #f5576c;
}

.stats-glow-danger {
    background: #fee140;
}

.stats-glow-primary {
    background: #764ba2;
}

/* ============================================
   HOT DEALS CAROUSEL
   ============================================ */
.modern-card {
    border-radius: 20px;
    overflow: hidden;
}

.featured-badge {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
    animation: pulse-badge 2s ease-in-out infinite;
}

@keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.carousel-modern {
    border-radius: 16px;
    overflow: hidden;
}

.carousel-indicators button {
    width: 40px;
    height: 4px;
    border-radius: 2px;
    background-color: rgba(0, 0, 0, 0.3);
    border: none;
}

.carousel-indicators button.active {
    background-color: #dc3545;
}

.deal-showcase-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
}

.deal-image-wrapper {
    position: relative;
    height: 450px;
    overflow: hidden;
}

.deal-showcase-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.carousel-item.active .deal-showcase-img {
    animation: zoomIn 0.8s ease-out;
}

@keyframes zoomIn {
    from {
        transform: scale(1.2);
    }
    to {
        transform: scale(1);
    }
}

.deal-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 120px;
    color: #fff;
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.deal-overlay-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 10;
}

.badge-hot-deal {
    background: rgba(220, 53, 69, 0.95);
    color: #fff;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    animation: pulse-hot 1.5s ease-in-out infinite;
}

.deal-content-wrapper {
    animation: slideInRight 0.8s ease-out;
}

.deal-game-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.deal-game-logo {
    width: 45px;
    height: 45px;
    object-fit: contain;
    border-radius: 8px;
}

.deal-game-name {
    font-size: 15px;
    color: #666;
    font-weight: 500;
}

.deal-title {
    font-size: 2rem;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1.2;
}

.deal-description {
    font-size: 15px;
    line-height: 1.6;
}

.deal-price-section {
    background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
    padding: 20px;
    border-radius: 12px;
}

.deal-price-label {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.deal-price {
    font-weight: 900;
    font-size: 2.5rem;
}

.deal-validity {
    display: flex;
    align-items: center;
    gap: 8px;
}

.deal-validity i {
    font-size: 24px;
    color: #dc3545;
}

.btn-xl {
    padding: 15px 30px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 12px;
}

.carousel-control-custom {
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    transition: all 0.3s ease;
}

.carousel-control-custom:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

/* ============================================
   VOUCHERS & EVENTS LISTS
   ============================================ */
.section-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.bg-success-light {
    background: rgba(17, 153, 142, 0.1);
}

.bg-warning-light {
    background: rgba(245, 87, 108, 0.1);
}

.voucher-card-mini {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.voucher-card-mini:hover {
    background: #fff;
    border-color: #11998e;
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.voucher-game-icon img {
    width: 55px;
    height: 55px;
    object-fit: contain;
    border-radius: 10px;
}

.voucher-icon-placeholder {
    width: 55px;
    height: 55px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.voucher-code {
    font-size: 16px;
    font-weight: 700;
    color: #2c3e50;
}

.badge-premium-mini {
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    color: #000;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}

.badge-regular-mini {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}

.badge-all-mini {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}

.voucher-expiry {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #666;
    font-size: 12px;
}

.event-card-mini {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.event-card-mini:hover {
    background: #fff;
    border-color: #f5576c;
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.event-date-badge-mini {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 12px 16px;
    border-radius: 10px;
    text-align: center;
    min-width: 65px;
}

.event-day {
    font-size: 28px;
    font-weight: 800;
    line-height: 1;
}

.event-month {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 2px;
}

.event-title {
    font-size: 15px;
    font-weight: 700;
    color: #2c3e50;
}

.event-game-icon {
    width: 22px;
    height: 22px;
    object-fit: contain;
}

.event-countdown {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #667eea;
    font-weight: 600;
}

.badge-active {
    background: rgba(17, 153, 142, 0.1);
    color: #11998e;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
}

.empty-state {
    padding: 60px 20px;
}

.empty-icon {
    font-size: 80px;
    color: #ddd;
}

/* ============================================
   ANIMATIONS
   ============================================ */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ============================================
   GAMING THEME OVERRIDES
   ============================================ */
body.gaming-theme .hero-banner-super {
    background: linear-gradient(135deg, #00d4ff 0%, #0099ff 50%, #667eea 100%) !important;
}

body.gaming-theme .stats-card-modern {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
}

body.gaming-theme .stats-number {
    color: var(--gaming-primary);
    text-shadow: 0 0 20px var(--gaming-glow);
}

body.gaming-theme .modern-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
}

body.gaming-theme .voucher-card-mini,
body.gaming-theme .event-card-mini {
    background: rgba(0, 212, 255, 0.05);
    border-color: var(--glass-border);
}

body.gaming-theme .voucher-card-mini:hover,
body.gaming-theme .event-card-mini:hover {
    background: rgba(0, 212, 255, 0.1);
    border-color: var(--gaming-primary);
}

body.gaming-theme .event-date-badge-mini {
    background: linear-gradient(135deg, var(--gaming-primary) 0%, var(--gaming-secondary) 100%);
}

body.gaming-theme .deal-showcase-card {
    background: var(--glass-bg);
}

body.gaming-theme .deal-price-section {
    background: rgba(0, 212, 255, 0.1);
}
</style>

<!-- Particles.js Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.css">
@endpush

@push('scripts')
<!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Particles.js
    if (typeof particlesJS !== 'undefined') {
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                shape: {
                    type: 'circle',
                },
                opacity: {
                    value: 0.5,
                    random: true,
                },
                size: {
                    value: 3,
                    random: true,
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'repulse'
                    },
                    resize: true
                },
            },
            retina_detect: true
        });
    }

    // Counter Animation with Easing
    $('.counter-value').each(function() {
        const $this = $(this);
        const countTo = parseInt($this.attr('data-target'));

        $({ countNum: 0 }).animate({
            countNum: countTo
        }, {
            duration: 2500,
            easing: 'easeOutCubic',
            step: function() {
                $this.text(Math.floor(this.countNum));
            },
            complete: function() {
                $this.text(countTo);
            }
        });
    });

    // Initialize Carousel with Auto-play
    @if($recentDeals->count() > 1)
    const dealsCarousel = new bootstrap.Carousel(document.getElementById('hotDealsCarousel'), {
        interval: 6000,
        ride: 'carousel',
        pause: 'hover'
    });
    @endif

    // Add smooth scroll to top on page load
    $('html, body').animate({ scrollTop: 0 }, 800);
});

// Custom easing function
$.easing.easeOutCubic = function (x, t, b, c, d) {
    return c*((t=t/d-1)*t*t + 1) + b;
};
</script>
@endpush

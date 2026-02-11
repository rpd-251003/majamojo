@extends('user.layouts.app')

@section('title', $event->title)

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.events') }}">Events</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ Str::limit($event->title, 40) }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Banner -->
        <div class="card overflow-hidden">
            @if($event->banner_image)
                <img src="{{ asset('storage/' . $event->banner_image) }}"
                     class="card-img-top event-banner"
                     alt="{{ $event->title }}">
            @else
                <div class="card-img-top bg-light-primary d-flex align-items-center justify-content-center event-banner">
                    <i class="ti ti-calendar-event" style="font-size: 80px; color: var(--bs-primary);"></i>
                </div>
            @endif

            <div class="card-body">
                <!-- Game badge & Status -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        @if($event->game->logo)
                            <img src="{{ asset('storage/' . $event->game->logo) }}" alt="{{ $event->game->name }}" style="width: 36px; height: 36px; object-fit: contain;" class="me-2">
                        @else
                            <div class="avtar avtar-s bg-light-primary me-2">
                                <i class="ti ti-device-gamepad"></i>
                            </div>
                        @endif
                        <div>
                            <span class="fw-semibold">{{ $event->game->name }}</span>
                        </div>
                    </div>
                    <span class="badge bg-success px-3 py-2">
                        <i class="ti ti-circle-check me-1"></i>Active
                    </span>
                </div>

                <!-- Title -->
                <h3 class="mb-4">{{ $event->title }}</h3>

                <!-- Description -->
                @if($event->description)
                    <div class="mb-4">
                        <h6 class="text-muted text-uppercase mb-3" style="letter-spacing: 1px; font-size: 12px;">
                            <i class="ti ti-file-description me-1"></i>Event Description
                        </h6>
                        <div class="event-description">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- External Link -->
                @if($event->external_link)
                    <div class="event-cta-box mt-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h6 class="mb-1"><i class="ti ti-link me-1"></i>Event Page</h6>
                                <small class="text-muted">Visit the official event page for more information</small>
                            </div>
                            <a href="{{ $event->external_link }}" target="_blank" class="btn btn-warning btn-lg">
                                <i class="ti ti-external-link me-2"></i>View Event Page
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Countdown -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white"><i class="ti ti-hourglass me-2"></i>Time Remaining</h5>
            </div>
            <div class="card-body">
                <div class="countdown-timer-detail" data-end-date="{{ $event->end_date->format('Y-m-d') }}T23:59:59">
                    <div class="row g-2 text-center">
                        <div class="col-3">
                            <div class="cd-box">
                                <span class="cd-val days">--</span>
                                <small class="cd-lbl">Days</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="cd-box">
                                <span class="cd-val hours">--</span>
                                <small class="cd-lbl">Hours</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="cd-box">
                                <span class="cd-val minutes">--</span>
                                <small class="cd-lbl">Min</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="cd-box">
                                <span class="cd-val seconds">--</span>
                                <small class="cd-lbl">Sec</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Event Info</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avtar avtar-s bg-light-success me-3 flex-shrink-0">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Start Date</small>
                                <strong>{{ $event->start_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avtar avtar-s bg-light-danger me-3 flex-shrink-0">
                                <i class="ti ti-calendar-x"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">End Date</small>
                                <strong>{{ $event->end_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avtar avtar-s bg-light-warning me-3 flex-shrink-0">
                                <i class="ti ti-clock"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Duration</small>
                                <strong>{{ $event->start_date->diffInDays($event->end_date) }} Days</strong>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avtar avtar-s bg-light-primary me-3 flex-shrink-0">
                                <i class="ti ti-device-gamepad"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Game</small>
                                <strong>{{ $event->game->name }}</strong>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ route('user.events') }}" class="btn btn-outline-primary w-100">
            <i class="ti ti-arrow-left me-2"></i>Back to Events
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
.event-banner {
    height: 320px;
    object-fit: cover;
}

.event-description {
    color: #555;
    font-size: 15px;
    line-height: 1.8;
    white-space: pre-line;
}

.event-cta-box {
    background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%);
    border: 1px solid rgba(255, 193, 7, 0.25);
    border-radius: 12px;
    padding: 20px 24px;
}

/* Countdown Detail */
.cd-box {
    background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
    border-radius: 12px;
    padding: 14px 8px;
    border: 1px solid rgba(var(--bs-primary-rgb), 0.1);
}

.cd-val {
    font-size: 28px;
    font-weight: 700;
    line-height: 1.2;
    display: block;
    color: var(--bs-primary);
    font-variant-numeric: tabular-nums;
}

.cd-lbl {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    display: block;
    margin-top: 2px;
}

.cd-expired .cd-box {
    background: linear-gradient(135deg, #fff0f0 0%, #ffe8e8 100%);
    border-color: rgba(220, 53, 69, 0.15);
}

.cd-expired .cd-val {
    color: var(--bs-danger);
}

@media (max-width: 768px) {
    .event-banner {
        height: 200px;
    }
}

/* ===== Gaming Theme Overrides ===== */
body.gaming-theme .event-description {
    color: #d0d0d0;
}

body.gaming-theme .event-cta-box {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.08) 0%, rgba(255, 152, 0, 0.06) 100%);
    border: 1px solid rgba(255, 193, 7, 0.25);
}

body.gaming-theme .event-cta-box h6 {
    color: #e0e0e0;
}

body.gaming-theme .event-cta-box small {
    color: rgba(224, 224, 224, 0.6) !important;
}

/* Countdown Detail Boxes */
body.gaming-theme .cd-box {
    background: linear-gradient(135deg, rgba(0, 212, 255, 0.08) 0%, rgba(0, 153, 255, 0.05) 100%);
    border: 1px solid rgba(0, 212, 255, 0.2);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(0, 212, 255, 0.1);
}

body.gaming-theme .cd-val {
    color: var(--gaming-primary) !important;
    text-shadow: 0 0 10px rgba(0, 212, 255, 0.4);
}

body.gaming-theme .cd-lbl {
    color: rgba(224, 224, 224, 0.5);
}

body.gaming-theme .cd-expired .cd-box {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.06) 100%);
    border-color: rgba(220, 53, 69, 0.3);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(220, 53, 69, 0.1);
}

body.gaming-theme .cd-expired .cd-val {
    color: #ff4757 !important;
    text-shadow: 0 0 10px rgba(255, 71, 87, 0.4);
}

/* List Group Items in Sidebar */
body.gaming-theme .list-group-item {
    background: transparent;
    border-color: rgba(0, 212, 255, 0.1);
    color: #e0e0e0;
}

body.gaming-theme .list-group-item strong {
    color: #e0e0e0;
}

body.gaming-theme .list-group-item .text-muted {
    color: rgba(224, 224, 224, 0.5) !important;
}

/* Card Header for Countdown */
body.gaming-theme .card-header.bg-primary {
    background: linear-gradient(135deg, rgba(0, 212, 255, 0.3) 0%, rgba(0, 153, 255, 0.2) 100%) !important;
    border-bottom: 1px solid rgba(0, 212, 255, 0.2);
}

/* Event Banner Placeholder */
body.gaming-theme .event-banner.bg-light-primary {
    background: rgba(0, 212, 255, 0.08) !important;
}

body.gaming-theme .event-banner.bg-light-primary i {
    color: var(--gaming-primary) !important;
}

/* Game badge text */
body.gaming-theme .card-body .fw-semibold {
    color: #e0e0e0;
}

/* Event title */
body.gaming-theme .card-body h3 {
    color: #f0f0f0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.countdown-timer-detail').forEach(function(el) {
        const endDate = new Date(el.dataset.endDate).getTime();

        function tick() {
            const now = Date.now();
            const diff = endDate - now;

            if (diff <= 0) {
                el.classList.add('cd-expired');
                el.querySelector('.days').textContent = '0';
                el.querySelector('.hours').textContent = '00';
                el.querySelector('.minutes').textContent = '00';
                el.querySelector('.seconds').textContent = '00';
                return;
            }

            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            el.querySelector('.days').textContent = d;
            el.querySelector('.hours').textContent = String(h).padStart(2, '0');
            el.querySelector('.minutes').textContent = String(m).padStart(2, '0');
            el.querySelector('.seconds').textContent = String(s).padStart(2, '0');

            requestAnimationFrame(tick);
        }

        tick();
    });
});
</script>
@endpush

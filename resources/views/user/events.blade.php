@extends('user.layouts.app')

@section('title', 'Events')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Events</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Active Events</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Filter Section ] start -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search events...">
                        </div>
                    </div>

                    <!-- Game Filter Buttons -->
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm game-filter active" data-game-id="">
                                <i class="ti ti-apps me-1"></i>All Games
                            </button>
                            @foreach($games as $game)
                                <button class="btn btn-outline-primary btn-sm game-filter" data-game-id="{{ $game->id }}">
                                    @if($game->logo)
                                        <img src="{{ asset('storage/' . $game->logo) }}" alt="{{ $game->name }}" style="width: 20px; height: 20px; object-fit: contain; margin-right: 5px;">
                                    @else
                                        <i class="ti ti-device-gamepad me-1"></i>
                                    @endif
                                    {{ $game->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Filter Section ] end -->

<!-- Loading Indicator -->
<div id="loadingIndicator" style="display: none;" class="text-center mb-3">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- [ Main Content ] start -->
<div class="row" id="eventsContainer">
    @forelse($events as $event)
        <div class="col-md-6 col-xl-4">
            <div class="card event-card">
                @if($event->banner_image)
                    <img src="{{ asset('storage/' . $event->banner_image) }}"
                         class="card-img-top"
                         alt="{{ $event->title }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="ti ti-calendar-event" style="font-size: 64px; color: var(--bs-primary);"></i>
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            @if($event->game->logo)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $event->game->logo) }}" alt="{{ $event->game->name }}" style="width: 30px; height: 30px; object-fit: contain;">
                                </div>
                            @else
                                <div class="avtar avtar-xs bg-light-primary flex-shrink-0">
                                    <i class="ti ti-device-gamepad"></i>
                                </div>
                            @endif
                            <span class="ms-2 text-muted small">{{ $event->game->name }}</span>
                        </div>
                        <span class="badge bg-light-success">
                            <i class="ti ti-circle-check me-1"></i>Active
                        </span>
                    </div>

                    <h5 class="card-title mb-2">{{ $event->title }}</h5>

                    @if($event->description)
                        <p class="text-muted small mb-3">{{ Str::limit($event->description, 100) }}</p>
                    @endif

                    <div class="bg-light-warning rounded p-2 mb-3">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <small class="text-muted d-block">Start Date</small>
                                <strong class="d-block">{{ $event->start_date->format('d M') }}</strong>
                                <small class="text-muted">{{ $event->start_date->format('Y') }}</small>
                            </div>
                            <div class="col-6 border-start">
                                <small class="text-muted d-block">End Date</small>
                                <strong class="d-block">{{ $event->end_date->format('d M') }}</strong>
                                <small class="text-muted">{{ $event->end_date->format('Y') }}</small>
                            </div>
                        </div>
                    </div>

                    {{-- Realtime Countdown --}}
                    <div class="countdown-timer mb-3" data-end-date="{{ $event->end_date->format('Y-m-d') }}T23:59:59">
                        <div class="d-flex justify-content-center gap-2 text-center">
                            <div class="countdown-box">
                                <span class="countdown-value days fw-bold">--</span>
                                <small class="countdown-label d-block text-muted">Days</small>
                            </div>
                            <div class="countdown-separator align-self-center fw-bold text-muted">:</div>
                            <div class="countdown-box">
                                <span class="countdown-value hours fw-bold">--</span>
                                <small class="countdown-label d-block text-muted">Hours</small>
                            </div>
                            <div class="countdown-separator align-self-center fw-bold text-muted">:</div>
                            <div class="countdown-box">
                                <span class="countdown-value minutes fw-bold">--</span>
                                <small class="countdown-label d-block text-muted">Min</small>
                            </div>
                            <div class="countdown-separator align-self-center fw-bold text-muted">:</div>
                            <div class="countdown-box">
                                <span class="countdown-value seconds fw-bold">--</span>
                                <small class="countdown-label d-block text-muted">Sec</small>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('user.events.show', $event->id) }}" class="btn btn-primary w-100">
                        <i class="ti ti-eye me-2"></i>Show Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-calendar-event" style="font-size: 64px; color: #ccc;"></i>
                    <h5 class="mt-3">No Events Available</h5>
                    <p class="text-muted">There are no active events at the moment. Check back later!</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div id="paginationContainer">
    @if($events->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
<!-- [ Main Content ] end -->
@endsection

@push('styles')
<style>
.event-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.event-card .card-img-top {
    transition: transform 0.3s ease;
}

.event-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Countdown */
.countdown-timer {
    background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
    border-radius: 10px;
    padding: 12px 8px;
    border: 1px solid rgba(var(--bs-primary-rgb), 0.12);
}

.countdown-box {
    min-width: 48px;
    background: #fff;
    border-radius: 8px;
    padding: 6px 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

.countdown-value {
    font-size: 20px;
    line-height: 1.2;
    display: block;
    color: var(--bs-primary);
    font-variant-numeric: tabular-nums;
}

.countdown-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.countdown-separator {
    font-size: 18px;
    margin-top: -8px;
}

.countdown-expired {
    background: linear-gradient(135deg, #fff0f0 0%, #ffe8e8 100%);
    border-color: rgba(220, 53, 69, 0.15);
}

.countdown-expired .countdown-value {
    color: var(--bs-danger);
}

/* ===== Gaming Theme Overrides ===== */
body.gaming-theme .event-card {
    border: 1px solid var(--glass-border);
}

body.gaming-theme .event-card:hover {
    box-shadow: 0 8px 32px rgba(0, 212, 255, 0.2), 0 0 15px rgba(0, 212, 255, 0.1);
    border-color: var(--gaming-primary);
}

body.gaming-theme .event-card .bg-light-warning {
    background: rgba(0, 212, 255, 0.08) !important;
    border: 1px solid rgba(0, 212, 255, 0.15);
    border-radius: 8px;
}

body.gaming-theme .event-card .bg-light-warning strong {
    color: #e0e0e0;
}

body.gaming-theme .event-card .bg-light-warning .border-start {
    border-color: rgba(0, 212, 255, 0.2) !important;
}

body.gaming-theme .countdown-timer {
    background: linear-gradient(135deg, rgba(0, 212, 255, 0.08) 0%, rgba(0, 153, 255, 0.06) 100%);
    border: 1px solid rgba(0, 212, 255, 0.2);
}

body.gaming-theme .countdown-box {
    background: rgba(10, 14, 39, 0.8);
    border: 1px solid rgba(0, 212, 255, 0.15);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(0, 212, 255, 0.1);
}

body.gaming-theme .countdown-value {
    color: var(--gaming-primary) !important;
    text-shadow: 0 0 8px rgba(0, 212, 255, 0.4);
}

body.gaming-theme .countdown-label {
    color: rgba(224, 224, 224, 0.6) !important;
}

body.gaming-theme .countdown-separator {
    color: var(--gaming-primary) !important;
    text-shadow: 0 0 6px rgba(0, 212, 255, 0.3);
}

body.gaming-theme .countdown-expired {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.06) 100%);
    border-color: rgba(220, 53, 69, 0.3);
}

body.gaming-theme .countdown-expired .countdown-value {
    color: #ff4757 !important;
    text-shadow: 0 0 8px rgba(255, 71, 87, 0.4);
}

body.gaming-theme .countdown-expired .countdown-box {
    border-color: rgba(220, 53, 69, 0.25);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(220, 53, 69, 0.1);
}

body.gaming-theme .event-card .bg-light-primary {
    background: rgba(0, 212, 255, 0.1) !important;
}

body.gaming-theme .event-card .bg-light-primary i {
    color: var(--gaming-primary) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // ============================
    // Realtime Countdown
    // ============================
    function initCountdowns() {
        document.querySelectorAll('.countdown-timer').forEach(function(el) {
            const endDate = new Date(el.dataset.endDate).getTime();

            function tick() {
                const now = Date.now();
                const diff = endDate - now;

                if (diff <= 0) {
                    el.classList.add('countdown-expired');
                    el.querySelector('.days').textContent = '0';
                    el.querySelector('.hours').textContent = '0';
                    el.querySelector('.minutes').textContent = '0';
                    el.querySelector('.seconds').textContent = '0';
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
    }

    initCountdowns();

    // ============================
    // AJAX Load Events
    // ============================
    function loadEvents(page = 1) {
        const gameId = $('.game-filter.active').data('game-id');
        const search = $('#searchInput').val();

        $('#loadingIndicator').show();
        $('#eventsContainer').css('opacity', '0.5');

        $.ajax({
            url: '{{ route("user.events") }}',
            type: 'GET',
            data: {
                game_id: gameId,
                search: search,
                page: page
            },
            success: function(response) {
                $('#eventsContainer').html(response);
                $('#eventsContainer').css('opacity', '1');
                $('#loadingIndicator').hide();
                // Re-init countdowns after AJAX load
                initCountdowns();
            },
            error: function() {
                $('#eventsContainer').css('opacity', '1');
                $('#loadingIndicator').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load events. Please try again.',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Game filter buttons
    $('.game-filter').click(function() {
        $('.game-filter').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary active');

        loadEvents(1);
    });

    // Search input with debounce
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadEvents(1);
        }, 500);
    });

    // Pagination click handler
    $(document).on('click', '#paginationContainer .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            const page = new URL(url).searchParams.get('page');
            loadEvents(page);

            // Scroll to top
            $('html, body').animate({scrollTop: 0}, 400);
        }
    });
});
</script>
@endpush

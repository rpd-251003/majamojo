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
                        <p class="text-muted small mb-3">
                            {{ Str::limit($event->description, 100) }}
                        </p>
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

                    @php
                        $daysLeft = now()->diffInDays($event->end_date, false);
                    @endphp

                    @if($daysLeft > 0)
                        <div class="alert alert-info py-2 mb-3">
                            <i class="ti ti-clock me-1"></i>
                            <strong>{{ $daysLeft }}</strong> day{{ $daysLeft > 1 ? 's' : '' }} remaining
                        </div>
                    @endif

                    @if($event->external_link)
                        <a href="{{ $event->external_link }}" target="_blank" class="btn btn-warning w-100">
                            <i class="ti ti-external-link me-2"></i>View Event Details
                        </a>
                    @else
                        <button class="btn btn-outline-warning w-100" disabled>
                            <i class="ti ti-info-circle me-2"></i>More Info Coming Soon
                        </button>
                    @endif
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Function to load events via AJAX
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

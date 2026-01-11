@extends('user.layouts.app')

@section('title', 'Super Deals')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Super Deals</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Super Deals</h2>
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
                            <input type="text" class="form-control" id="searchInput" placeholder="Search deals...">
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
<div class="row" id="dealsContainer">
    @forelse($deals as $deal)
        <div class="col-md-6 col-xl-4">
            <div class="card deal-card position-relative">
                <!-- Hot Deal Badge -->
                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                    <span class="badge bg-danger">
                        <i class="ti ti-flame me-1"></i>HOT DEAL
                    </span>
                </div>

                @if($deal->banner_image)
                    <img src="{{ asset('storage/' . $deal->banner_image) }}"
                         class="card-img-top"
                         alt="{{ $deal->game_name }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-gradient-danger d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="ti ti-gift" style="font-size: 64px; color: white;"></i>
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        @if($deal->game->logo)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $deal->game->logo) }}" alt="{{ $deal->game->name }}" style="width: 30px; height: 30px; object-fit: contain;">
                            </div>
                        @else
                            <div class="avtar avtar-xs bg-light-primary flex-shrink-0">
                                <i class="ti ti-device-gamepad"></i>
                            </div>
                        @endif
                        <span class="ms-2 text-muted small">{{ $deal->game->name }}</span>
                    </div>

                    <h5 class="card-title mb-2">{{ $deal->game_name }}</h5>

                    @if($deal->description)
                        <p class="text-muted small mb-3">
                            {{ Str::limit($deal->description, 80) }}
                        </p>
                    @endif

                    <!-- Price Section -->
                    <div class="bg-light-danger rounded p-3 mb-3 text-center">
                        <small class="text-muted d-block mb-1">Special Price</small>
                        <h3 class="text-danger mb-0">
                            <i class="ti ti-currency-dollar"></i>Rp {{ number_format($deal->price, 0, ',', '.') }}
                        </h3>
                    </div>

                    <!-- Validity Period -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded p-2 text-center">
                                <small class="text-muted d-block">Valid From</small>
                                <strong class="small">{{ $deal->start_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2 text-center">
                                <small class="text-muted d-block">Valid Until</small>
                                <strong class="small">{{ $deal->end_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    @php
                        $daysLeft = now()->diffInDays($deal->end_date, false);
                    @endphp

                    @if($daysLeft > 0 && $daysLeft <= 7)
                        <div class="alert alert-warning py-2 mb-3">
                            <i class="ti ti-alert-triangle me-1"></i>
                            <strong>Hurry!</strong> Only {{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }} left
                        </div>
                    @elseif($daysLeft > 7)
                        <div class="alert alert-success py-2 mb-3">
                            <i class="ti ti-check me-1"></i>
                            Valid for {{ $daysLeft }} more days
                        </div>
                    @endif

                    @if($deal->external_link)
                        <a href="{{ $deal->external_link }}" target="_blank" class="btn btn-danger w-100">
                            <i class="ti ti-shopping-cart me-2"></i>Get This Deal
                        </a>
                    @else
                        <button class="btn btn-outline-danger w-100" disabled>
                            <i class="ti ti-info-circle me-2"></i>Coming Soon
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-gift" style="font-size: 64px; color: #ccc;"></i>
                    <h5 class="mt-3">No Super Deals Available</h5>
                    <p class="text-muted">There are no active super deals at the moment. Check back soon for amazing offers!</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div id="paginationContainer">
    @if($deals->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $deals->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
<!-- [ Main Content ] end -->
@endsection

@push('styles')
<style>
.deal-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.deal-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(220, 38, 38, 0.2);
}

.deal-card .card-img-top {
    transition: transform 0.3s ease;
}

.deal-card:hover .card-img-top {
    transform: scale(1.1);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc2626 0%, #f87171 100%);
}

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Function to load deals via AJAX
    function loadDeals(page = 1) {
        const gameId = $('.game-filter.active').data('game-id');
        const search = $('#searchInput').val();

        $('#loadingIndicator').show();
        $('#dealsContainer').css('opacity', '0.5');

        $.ajax({
            url: '{{ route("user.super-deals") }}',
            type: 'GET',
            data: {
                game_id: gameId,
                search: search,
                page: page
            },
            success: function(response) {
                $('#dealsContainer').html(response);
                $('#dealsContainer').css('opacity', '1');
                $('#loadingIndicator').hide();
            },
            error: function() {
                $('#dealsContainer').css('opacity', '1');
                $('#loadingIndicator').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load deals. Please try again.',
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

        loadDeals(1);
    });

    // Search input with debounce
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadDeals(1);
        }, 500);
    });

    // Pagination click handler
    $(document).on('click', '#paginationContainer .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            const page = new URL(url).searchParams.get('page');
            loadDeals(page);

            // Scroll to top
            $('html, body').animate({scrollTop: 0}, 400);
        }
    });
});
</script>
@endpush

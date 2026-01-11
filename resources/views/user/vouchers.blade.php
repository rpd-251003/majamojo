@extends('user.layouts.app')

@section('title', 'Vouchers')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Vouchers</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Available Vouchers</h2>
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
                            <input type="text" class="form-control" id="searchInput" placeholder="Search vouchers...">
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
<div class="row" id="vouchersContainer">
    @forelse($vouchers as $voucher)
        <div class="col-md-6 col-xl-4">
            <div class="card voucher-card position-relative">
                <!-- Type Badge -->
                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                    @if($voucher->type == 'membership_only')
                        <span class="badge bg-primary">
                            <i class="ti ti-crown me-1"></i>Membership
                        </span>
                    @elseif($voucher->type == 'reguler_only')
                        <span class="badge bg-success">
                            <i class="ti ti-user me-1"></i>Reguler
                        </span>
                    @else
                        <span class="badge bg-info">
                            <i class="ti ti-users me-1"></i>All Users
                        </span>
                    @endif
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($voucher->game->logo)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $voucher->game->logo) }}" alt="{{ $voucher->game->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                            </div>
                        @else
                            <div class="avtar avtar-s bg-light-success flex-shrink-0">
                                <i class="ti ti-device-gamepad"></i>
                            </div>
                        @endif
                        <div class="ms-2">
                            <h6 class="mb-0">{{ $voucher->game->name }}</h6>
                            <small class="text-muted">Game Title</small>
                        </div>
                    </div>

                    <!-- Voucher Code Section -->
                    <div class="voucher-code-section bg-gradient-success rounded p-3 mb-3 text-center position-relative overflow-hidden copy-code-area" data-code="{{ $voucher->promo_code }}" style="cursor: pointer;" title="Click to copy">
                        <div class="voucher-pattern"></div>
                        <small class="text-white text-opacity-75 d-block mb-1">
                            <i class="ti ti-click me-1"></i>CLICK TO COPY PROMO CODE
                        </small>
                        <h3 class="text-white mb-0 fw-bold letter-spacing">
                            {{ $voucher->promo_code }}
                        </h3>
                        <div class="voucher-corner voucher-corner-left"></div>
                        <div class="voucher-corner voucher-corner-right"></div>
                    </div>

                    @if($voucher->description)
                        <p class="text-muted small mb-3">
                            <i class="ti ti-info-circle me-1"></i>{{ Str::limit($voucher->description, 100) }}
                        </p>
                    @endif

                    <!-- Validity Period -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded p-2 text-center">
                                <small class="text-muted d-block">Valid From</small>
                                <strong class="small">{{ $voucher->start_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2 text-center">
                                <small class="text-muted d-block">Valid Until</small>
                                <strong class="small">{{ $voucher->end_date->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    @php
                        $daysLeft = now()->diffInDays($voucher->end_date, false);
                    @endphp

                    @if($daysLeft > 0 && $daysLeft <= 3)
                        <div class="alert alert-danger py-2 mb-3">
                            <i class="ti ti-alert-circle me-1"></i>
                            <strong>Expires in {{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }}!</strong>
                        </div>
                    @elseif($daysLeft > 3 && $daysLeft <= 7)
                        <div class="alert alert-warning py-2 mb-3">
                            <i class="ti ti-clock me-1"></i>
                            {{ $daysLeft }} days remaining
                        </div>
                    @endif

                    @if($voucher->external_link)
                        <a href="{{ $voucher->external_link }}" target="_blank" class="btn btn-success w-100">
                            <i class="ti ti-external-link me-2"></i>Claim Voucher
                        </a>
                    @else
                        <button class="btn btn-success w-100 copy-voucher" data-code="{{ $voucher->promo_code }}">
                            <i class="ti ti-copy me-2"></i>Copy Voucher Code
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-ticket" style="font-size: 64px; color: #ccc;"></i>
                    <h5 class="mt-3">No Vouchers Available</h5>
                    <p class="text-muted">There are no active vouchers for you at the moment. Check back later!</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div id="paginationContainer">
    @if($vouchers->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
<!-- [ Main Content ] end -->
@endsection

@push('styles')
<style>
.voucher-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.voucher-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(34, 197, 94, 0.2);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    position: relative;
}

.voucher-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: repeating-linear-gradient(
        45deg,
        rgba(255, 255, 255, 0.05),
        rgba(255, 255, 255, 0.05) 10px,
        transparent 10px,
        transparent 20px
    );
}

.letter-spacing {
    letter-spacing: 3px;
}

.voucher-corner {
    position: absolute;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.voucher-corner-left {
    left: -10px;
}

.voucher-corner-right {
    right: -10px;
}

.copy-code-area {
    transition: all 0.3s ease;
    user-select: none;
}

.copy-code-area:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.copy-code-area:active {
    transform: scale(0.98);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%) !important;
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Function to copy text to clipboard with fallback
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        } else {
            return new Promise(function(resolve, reject) {
                const tempInput = document.createElement('textarea');
                tempInput.value = text;
                tempInput.style.position = 'fixed';
                tempInput.style.left = '-9999px';
                tempInput.style.top = '0';
                document.body.appendChild(tempInput);
                tempInput.focus();
                tempInput.select();

                try {
                    const successful = document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    if (successful) {
                        resolve();
                    } else {
                        reject(new Error('execCommand failed'));
                    }
                } catch (err) {
                    document.body.removeChild(tempInput);
                    reject(err);
                }
            });
        }
    }

    // Initialize copy functionality
    function initCopyFunctionality() {
        // Copy voucher code when clicking the code area
        $('.copy-code-area').off('click').on('click', function() {
            const code = $(this).data('code');
            const codeArea = $(this);

            copyToClipboard(code).then(function() {
                codeArea.addClass('bg-gradient-primary');
                codeArea.find('small').html('<i class="ti ti-check me-1"></i>CODE COPIED!');

                setTimeout(function() {
                    codeArea.removeClass('bg-gradient-primary');
                    codeArea.find('small').html('<i class="ti ti-click me-1"></i>CLICK TO COPY PROMO CODE');
                }, 2000);

                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Voucher code "' + code + '" copied to clipboard',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }).catch(function(err) {
                console.error('Copy failed:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Copy Failed',
                    text: 'Unable to copy automatically. Code: ' + code,
                    showConfirmButton: true
                });
            });
        });

        // Copy voucher code button
        $('.copy-voucher').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const code = $(this).data('code');
            const button = $(this);

            copyToClipboard(code).then(function() {
                const originalHtml = button.html();
                button.html('<i class="ti ti-check me-2"></i>Copied!');
                button.removeClass('btn-success').addClass('btn-primary');

                setTimeout(function() {
                    button.html(originalHtml);
                    button.removeClass('btn-primary').addClass('btn-success');
                }, 2000);

                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Voucher code "' + code + '" copied to clipboard',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }).catch(function(err) {
                console.error('Copy failed:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Copy Failed',
                    text: 'Unable to copy automatically. Code: ' + code,
                    showConfirmButton: true
                });
            });
        });
    }

    // Function to load vouchers via AJAX
    function loadVouchers(page = 1) {
        const gameId = $('.game-filter.active').data('game-id');
        const search = $('#searchInput').val();

        $('#loadingIndicator').show();
        $('#vouchersContainer').css('opacity', '0.5');

        $.ajax({
            url: '{{ route("user.vouchers") }}',
            type: 'GET',
            data: {
                game_id: gameId,
                search: search,
                page: page
            },
            success: function(response) {
                $('#vouchersContainer').html(response);
                $('#vouchersContainer').css('opacity', '1');
                $('#loadingIndicator').hide();

                // Re-initialize copy functionality
                initCopyFunctionality();
            },
            error: function() {
                $('#vouchersContainer').css('opacity', '1');
                $('#loadingIndicator').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load vouchers. Please try again.',
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

        loadVouchers(1);
    });

    // Search input with debounce
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadVouchers(1);
        }, 500);
    });

    // Pagination click handler
    $(document).on('click', '#paginationContainer .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            const page = new URL(url).searchParams.get('page');
            loadVouchers(page);

            // Scroll to top
            $('html, body').animate({scrollTop: 0}, 400);
        }
    });

    // Initial copy functionality
    initCopyFunctionality();
});
</script>
@endpush

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

<!-- Pagination -->
@if($vouchers->hasPages())
    <div class="col-12">
        <div class="d-flex justify-content-center mt-3">
            {{ $vouchers->links() }}
        </div>
    </div>
@endif

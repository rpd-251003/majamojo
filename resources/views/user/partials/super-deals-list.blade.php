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

<!-- Pagination -->
@if($deals->hasPages())
    <div class="col-12">
        <div class="d-flex justify-content-center mt-3">
            {{ $deals->links() }}
        </div>
    </div>
@endif

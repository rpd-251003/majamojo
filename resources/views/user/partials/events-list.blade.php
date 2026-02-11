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

<!-- Pagination -->
@if($events->hasPages())
    <div class="col-12">
        <div class="d-flex justify-content-center mt-3">
            {{ $events->links() }}
        </div>
    </div>
@endif

@extends('user.layouts.app')

@section('title', 'User Dashboard')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Welcome, {{ auth()->user()->name }}!</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <!-- Vouchers Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-ticket"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="text-white mb-1">{{ $stats['total_vouchers'] }}</h5>
                                <span class="text-white text-opacity-75">Available Vouchers</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-calendar-event"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="text-white mb-1">{{ $stats['total_events'] }}</h5>
                                <span class="text-white text-opacity-75">Active Events</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Super Deals Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-gift"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="text-white mb-1">{{ $stats['total_deals'] }}</h5>
                                <span class="text-white text-opacity-75">Super Deals</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Games Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-device-gamepad"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent border-0 p-0">
                                <h5 class="text-white mb-1">{{ $stats['total_games'] }}</h5>
                                <span class="text-white text-opacity-75">Available Games</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-bolt"></i> Quick Access</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('user.vouchers.index') }}" class="btn btn-success">
                        <i class="ti ti-ticket"></i> Browse Vouchers
                    </a>
                    <a href="{{ route('user.events.index') }}" class="btn btn-warning">
                        <i class="ti ti-calendar-event"></i> View Events
                    </a>
                    <a href="{{ route('user.super-deals.index') }}" class="btn btn-danger">
                        <i class="ti ti-gift"></i> Check Super Deals
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Vouchers -->
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Recent Vouchers</h5>
                <a href="{{ route('user.vouchers.index') }}" class="btn btn-sm btn-link-success">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Promo Code</th>
                                <th>Game</th>
                                <th>Valid Until</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVouchers as $voucher)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $voucher->promo_code }}</h6>
                                        @if($voucher->type == 'membership_only')
                                            <span class="badge bg-light-primary">Membership</span>
                                        @elseif($voucher->type == 'reguler_only')
                                            <span class="badge bg-light-success">Reguler</span>
                                        @else
                                            <span class="badge bg-light-info">All</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                                                <i class="ti ti-device-gamepad"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="mb-0">{{ $voucher->game->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $voucher->end_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No vouchers available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Recent Events</h5>
                <a href="{{ route('user.events.index') }}" class="btn btn-sm btn-link-warning">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Game</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEvents as $event)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $event->title }}</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                                                <i class="ti ti-device-gamepad"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="mb-0">{{ $event->game->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $event->end_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No events available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Super Deals -->
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Recent Super Deals</h5>
                <a href="{{ route('user.super-deals.index') }}" class="btn btn-sm btn-link-danger">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Deal</th>
                                <th>Game</th>
                                <th>Price</th>
                                <th>Valid Until</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDeals as $deal)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $deal->game_name }}</h6>
                                        @if($deal->description)
                                            <small class="text-muted">{{ Str::limit($deal->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                                                <i class="ti ti-device-gamepad"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="mb-0">{{ $deal->game->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp {{ number_format($deal->price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>{{ $deal->end_date->format('d M Y') }}</td>
                                    <td>
                                        @if($deal->external_link)
                                            <a href="{{ $deal->external_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link"></i> View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No deals available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection

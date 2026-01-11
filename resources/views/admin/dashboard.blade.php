@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
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
                                <span class="text-white text-opacity-75">Total Games</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-body progress mt-3" style="height: 8px">
                    <div class="progress-bar bg-white" style="width: {{ $stats['total_games'] > 0 ? ($stats['active_games'] / $stats['total_games']) * 100 : 0 }}%"></div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-white text-opacity-75 mb-0"><i class="ti ti-check"></i> {{ $stats['active_games'] }} Active</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-white text-opacity-75 mb-0">{{ $stats['total_games'] - $stats['active_games'] }} Inactive</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vouchers Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success dashnum-card text-white overflow-hidden">
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
                                <span class="text-white text-opacity-75">Total Vouchers</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-body progress mt-3" style="height: 8px">
                    <div class="progress-bar bg-white" style="width: {{ $stats['total_vouchers'] > 0 ? ($stats['active_vouchers'] / $stats['total_vouchers']) * 100 : 0 }}%"></div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-white text-opacity-75 mb-0"><i class="ti ti-check"></i> {{ $stats['active_vouchers'] }} Active</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-white text-opacity-75 mb-0">{{ $stats['total_vouchers'] - $stats['active_vouchers'] }} Inactive</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning dashnum-card text-white overflow-hidden">
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
                                <span class="text-white text-opacity-75">Total Events</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-body progress mt-3" style="height: 8px">
                    <div class="progress-bar bg-white" style="width: {{ $stats['total_events'] > 0 ? ($stats['active_events'] / $stats['total_events']) * 100 : 0 }}%"></div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-white text-opacity-75 mb-0"><i class="ti ti-check"></i> {{ $stats['active_events'] }} Active</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-white text-opacity-75 mb-0">{{ $stats['total_events'] - $stats['active_events'] }} Inactive</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Super Deals Card -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger dashnum-card text-white overflow-hidden">
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
                                <span class="text-white text-opacity-75">Total Deals</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-body progress mt-3" style="height: 8px">
                    <div class="progress-bar bg-white" style="width: {{ $stats['total_deals'] > 0 ? ($stats['active_deals'] / $stats['total_deals']) * 100 : 0 }}%"></div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-white text-opacity-75 mb-0"><i class="ti ti-check"></i> {{ $stats['active_deals'] }} Active</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-white text-opacity-75 mb-0">{{ $stats['total_deals'] - $stats['active_deals'] }} Inactive</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.games.index') }}" class="btn btn-primary">
                        <i class="ti ti-device-gamepad"></i> Manage Games
                    </a>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-success">
                        <i class="ti ti-ticket"></i> Manage Vouchers
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-warning">
                        <i class="ti ti-calendar-event"></i> Manage Events
                    </a>
                    <a href="{{ route('admin.super-deals.index') }}" class="btn btn-danger">
                        <i class="ti ti-gift"></i> Manage Super Deals
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Games -->
    <div class="col-md-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Recent Games</h5>
                <a href="{{ route('admin.games.index') }}" class="btn btn-sm btn-link-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Game Name</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGames as $game)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                                                <i class="ti ti-device-gamepad"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0">{{ $game->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($game->status)
                                            <span class="badge bg-light-success">Active</span>
                                        @else
                                            <span class="badge bg-light-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $game->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No games yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Vouchers -->
    <div class="col-md-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Recent Vouchers</h5>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-link-success">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Promo Code</th>
                                <th>Game</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVouchers as $voucher)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $voucher->promo_code }}</h6>
                                        <small class="text-muted">{{ $voucher->start_date->format('d M Y') }} - {{ $voucher->end_date->format('d M Y') }}</small>
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
                                    <td>
                                        @if($voucher->type == 'membership_only')
                                            <span class="badge bg-light-primary">Membership</span>
                                        @elseif($voucher->type == 'reguler_only')
                                            <span class="badge bg-light-success">Reguler</span>
                                        @else
                                            <span class="badge bg-light-info">All</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($voucher->status)
                                            <span class="badge bg-light-success">Active</span>
                                        @else
                                            <span class="badge bg-light-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No vouchers yet</td>
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

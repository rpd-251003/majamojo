<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Voucher;
use App\Models\Event;
use App\Models\SuperDeal;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_games' => Game::count(),
            'active_games' => Game::where('status', true)->count(),
            'total_vouchers' => Voucher::count(),
            'active_vouchers' => Voucher::active()->count(),
            'total_events' => Event::count(),
            'active_events' => Event::active()->count(),
            'total_deals' => SuperDeal::count(),
            'active_deals' => SuperDeal::active()->count(),
        ];

        $recentGames = Game::latest()->take(5)->get();
        $recentVouchers = Voucher::with('game')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentGames', 'recentVouchers'));
    }
}

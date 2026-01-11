<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Event;
use App\Models\SuperDeal;
use App\Models\Game;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userRole = auth()->user()->role;

        $stats = [
            'total_vouchers' => Voucher::active()->forRole($userRole)->count(),
            'total_events' => Event::active()->count(),
            'total_deals' => SuperDeal::active()->count(),
            'total_games' => Game::where('status', true)->count(),
        ];

        // Get recent data
        $recentVouchers = Voucher::with('game')
            ->active()
            ->forRole($userRole)
            ->latest()
            ->take(5)
            ->get();

        $recentEvents = Event::with('game')
            ->active()
            ->latest()
            ->take(5)
            ->get();

        $recentDeals = SuperDeal::with('game')
            ->active()
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentVouchers', 'recentEvents', 'recentDeals'));
    }
}

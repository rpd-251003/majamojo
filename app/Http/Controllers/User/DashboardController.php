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

    public function vouchers(Request $request)
    {
        $userRole = auth()->user()->role;
        $games = Game::where('status', true)->orderBy('name')->get();

        // If AJAX request, return filtered data
        if ($request->ajax()) {
            $query = Voucher::with('game')
                ->active()
                ->forRole($userRole);

            // Filter by game
            if ($request->filled('game_id')) {
                $query->where('game_id', $request->game_id);
            }

            // Search by keywords
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('promo_code', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('game', function($gameQuery) use ($search) {
                          $gameQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $vouchers = $query->latest()->paginate(12);

            return view('user.partials.vouchers-list', compact('vouchers'))->render();
        }

        $vouchers = Voucher::with('game')
            ->active()
            ->forRole($userRole)
            ->latest()
            ->paginate(12);

        return view('user.vouchers', compact('vouchers', 'games'));
    }

    public function events(Request $request)
    {
        $games = Game::where('status', true)->orderBy('name')->get();

        // If AJAX request, return filtered data
        if ($request->ajax()) {
            $query = Event::with('game')->active();

            // Filter by game
            if ($request->filled('game_id')) {
                $query->where('game_id', $request->game_id);
            }

            // Search by keywords
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('game', function($gameQuery) use ($search) {
                          $gameQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $events = $query->latest()->paginate(12);

            return view('user.partials.events-list', compact('events'))->render();
        }

        $events = Event::with('game')
            ->active()
            ->latest()
            ->paginate(12);

        return view('user.events', compact('events', 'games'));
    }

    public function superDeals(Request $request)
    {
        $games = Game::where('status', true)->orderBy('name')->get();

        // If AJAX request, return filtered data
        if ($request->ajax()) {
            $query = SuperDeal::with('game')->active();

            // Filter by game
            if ($request->filled('game_id')) {
                $query->where('game_id', $request->game_id);
            }

            // Search by keywords
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('game_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('game', function($gameQuery) use ($search) {
                          $gameQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $deals = $query->latest()->paginate(12);

            return view('user.partials.super-deals-list', compact('deals'))->render();
        }

        $deals = SuperDeal::with('game')
            ->active()
            ->latest()
            ->paginate(12);

        return view('user.super-deals', compact('deals', 'games'));
    }
}

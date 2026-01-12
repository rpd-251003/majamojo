<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SuperDeal;
use App\Models\Game;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get active games
        $games = Game::where('status', true)->get();

        // Get upcoming events (active and not expired)
        $upcomingEvents = Event::with('game')
            ->where('status', true)
            ->where('end_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        // Get hot deals (active and not expired)
        $hotDeals = SuperDeal::with('game')
            ->where('status', true)
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('landing', compact('games', 'upcomingEvents', 'hotDeals'));
    }
}

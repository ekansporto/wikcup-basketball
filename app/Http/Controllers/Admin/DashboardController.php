<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\MatchModel;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTeams     = Team::count();
        $totalPlayers   = Player::count();
        $totalMatches   = MatchModel::count();
        $totalGalleries = Gallery::count();

        // Get 5 recent matches (ordered by date desc, then time desc)
        $recentMatches = MatchModel::with(['teamA', 'teamB'])
            ->orderByDesc('tanggal')
            ->orderByDesc('jam')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTeams',
            'totalPlayers',
            'totalMatches',
            'totalGalleries',
            'recentMatches'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Statistic;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Pertandingan mendatang (belum ada skor, tanggal >= hari ini)
        $upcomingMatches = MatchModel::with(['teamA', 'teamB'])
            ->whereNull('skor_tim_a')
            ->whereNull('skor_tim_b')
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->take(2)
            ->get();

        // Hasil pertandingan terbaru (sudah ada skor)
        $recentResults = MatchModel::with(['teamA', 'teamB'])
            ->whereNotNull('skor_tim_a')
            ->whereNotNull('skor_tim_b')
            ->orderByDesc('tanggal')
            ->take(2)
            ->get();

        // Top Scorer
        $topScorer = Statistic::with(['player.team'])
            ->select('id_player',
                DB::raw('SUM(poin) as total_poin'),
                DB::raw('ROUND(AVG(poin), 1) as ppg'))
            ->groupBy('id_player')
            ->orderByDesc('total_poin')
            ->first();

        // Top Assist
        $topAssist = Statistic::with(['player.team'])
            ->select('id_player',
                DB::raw('SUM(assist) as total_assist'),
                DB::raw('ROUND(AVG(assist), 1) as apg'))
            ->groupBy('id_player')
            ->orderByDesc('total_assist')
            ->first();

        // Top Rebound
        $topRebound = Statistic::with(['player.team'])
            ->select('id_player',
                DB::raw('SUM(rebound) as total_rebound'),
                DB::raw('ROUND(AVG(rebound), 1) as rpg'))
            ->groupBy('id_player')
            ->orderByDesc('total_rebound')
            ->first();

        $totalTeams   = Team::count();
        $totalMatches = MatchModel::count();

        return view('home', compact(
            'upcomingMatches',
            'recentResults',
            'topScorer',
            'topAssist',
            'topRebound',
            'totalTeams',
            'totalMatches'
        ));
    }
}

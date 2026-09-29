<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchModelController extends Controller
{
    /**
     * Tampilan publik untuk jadwal & hasil pertandingan.
     */
    public function index(Request $request)
    {
        $tab   = $request->query('tab', 'semua');
        $fase  = $request->query('fase', 'all');

        $query = MatchModel::with(['teamA', 'teamB'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc');

        if ($tab === 'mendatang') {
            $query->whereNull('skor_tim_a');
        } elseif ($tab === 'hari-ini') {
            $query->whereDate('tanggal', now()->toDateString());
        }

        if ($fase !== 'all' && !empty($fase)) {
            $query->where('fase', $fase);
        }

        $matches = $query->get();
        $totalFound = $matches->count();

        // Distinct phases for dropdown
        $phases = MatchModel::select('fase')->distinct()->whereNotNull('fase')->pluck('fase');

        return view('matches.index', compact(
            'matches',
            'totalFound',
            'tab',
            'fase',
            'phases'
        ));
    }

    /**
     * Tampilan publik untuk hasil pertandingan selesai.
     */
    public function hasil(Request $request)
    {
        $tab  = $request->query('tab', 'semua');
        $fase = $request->query('fase', 'all');

        $query = MatchModel::with(['teamA', 'teamB'])
            ->whereNotNull('skor_tim_a')
            ->whereNotNull('skor_tim_b')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc');

        if ($tab === 'penyisihan') {
            $query->where('fase', 'like', '%Penyisihan%');
        } elseif ($tab === 'semifinal') {
            $query->where('fase', 'like', '%Semifinal%');
        } elseif ($tab === 'final') {
            $query->where('fase', 'like', '%Final%');
        }

        if ($fase !== 'all' && !empty($fase)) {
            $query->where('fase', $fase);
        }

        $matches = $query->get();
        $totalFound = $matches->count();
        $phases = MatchModel::select('fase')->distinct()->whereNotNull('fase')->pluck('fase');

        return view('matches.hasil', compact('matches', 'totalFound', 'tab', 'fase', 'phases'));
    }

    /**
     * Tampilan publik detail pertandingan beserta statistik box score.
     */
    public function show(MatchModel $match)
    {
        $match->load([
            'teamA.players',
            'teamB.players',
            'statistics.player.team',
        ]);

        $statsTeamA = $match->statistics->filter(function ($s) use ($match) {
            return $s->player && $s->player->id_team === $match->team_a_id;
        });

        $statsTeamB = $match->statistics->filter(function ($s) use ($match) {
            return $s->player && $s->player->id_team === $match->team_b_id;
        });

        return view('matches.show', compact('match', 'statsTeamA', 'statsTeamB'));
    }

    /**
     * Admin methods (placeholder, handles in Admin routes if needed)
     */
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(MatchModel $match) { abort(403); }
    public function update(Request $request, MatchModel $match) { abort(403); }
    public function destroy(MatchModel $match) { abort(403); }
}

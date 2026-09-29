<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of teams & players.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori', 'all');
        $search   = $request->query('search');
        $fase     = $request->query('fase', 'all');

        $query = Team::withCount('players')->orderBy('id_team', 'asc');

        if ($kategori === 'putra') {
            $query->where('kategori', 'Putra');
        } elseif ($kategori === 'putri') {
            $query->where('kategori', 'Putri');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tim', 'like', "%{$search}%")
                  ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $teams = $query->get();
        $totalTeams = $teams->count();
        $totalAll   = Team::count();

        return view('teams.index', compact('teams', 'totalTeams', 'totalAll', 'kategori', 'search', 'fase'));
    }

    /**
     * Display the specified team profile & roster.
     */
    public function show(Team $team)
    {
        $team->load([
            'players' => function ($q) {
                $q->orderBy('no_punggung', 'asc');
            },
            'matchesAsTeamA.teamB',
            'matchesAsTeamB.teamA'
        ]);

        return view('teams.show', compact('team'));
    }

    /**
     * Admin placeholders
     */
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(Team $team) { abort(403); }
    public function update(Request $request, Team $team) { abort(403); }
    public function destroy(Team $team) { abort(403); }
}

<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\Team;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /**
     * Display tournament statistics and rankings.
     */
    public function index(Request $request)
    {
        $kategori   = $request->query('kategori', 'all');
        $peringkat  = $request->query('peringkat', 'all');
        $statType   = $request->query('stat_type', 'poin');
        $searchTeam = $request->query('search_team');

        $query = Statistic::with(['player.team', 'match.teamA', 'match.teamB']);

        // Filter Divisi / Kategori (Putra / Putri)
        if ($kategori === 'putra') {
            $query->whereHas('player.team', function ($q) {
                $q->where('kategori', 'Putra');
            });
        } elseif ($kategori === 'putri') {
            $query->whereHas('player.team', function ($q) {
                $q->where('kategori', 'Putri');
            });
        }

        // Filter Search Team / School
        if (!empty($searchTeam)) {
            $query->whereHas('player.team', function ($q) use ($searchTeam) {
                $q->where('nama_tim', 'like', "%{$searchTeam}%")
                  ->orWhere('nickname', 'like', "%{$searchTeam}%");
            });
        }

        // Ordering by selected stat
        $validStats = ['poin', 'rebound', 'assist', 'steal', 'block', 'three_point_made', 'fgm'];
        $orderByCol = in_array($statType, $validStats) ? $statType : 'poin';

        $query->orderBy($orderByCol, 'desc')->orderBy('id_statistic', 'asc');

        // Apply Top N limit if specified
        if (is_numeric($peringkat) && intval($peringkat) > 0) {
            $query->take(intval($peringkat));
        }

        $totalCount = Statistic::count();
        $statistics = $query->paginate(8)->withQueryString();

        return view('statistics.index', compact(
            'statistics',
            'totalCount',
            'kategori',
            'peringkat',
            'statType',
            'searchTeam'
        ));
    }

    /**
     * Display the specified statistic.
     */
    public function show(Statistic $statistic)
    {
        $statistic->load(['player.team', 'match.teamA', 'match.teamB']);
        return view('statistics.show', compact('statistic'));
    }

    /**
     * Admin placeholders
     */
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(Statistic $statistic) { abort(403); }
    public function update(Request $request, Statistic $statistic) { abort(403); }
    public function destroy(Statistic $statistic) { abort(403); }
}

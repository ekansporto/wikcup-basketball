@extends('layouts.app')

@section('title', 'Statistik Turnamen — WikCup Basketball SMK Wikrama Bogor')
@section('meta_desc', 'Pusat rekapitulasi data statistik pertandingan dan papan peringkat individu pemain turnamen Wikrama Cup Basketball.')

@php
function ava_init($name){
    $w = preg_split('/\s+/', trim($name));
    if(count($w)>=2) return strtoupper(substr($w[0],0,1).substr($w[1],0,1));
    return strtoupper(substr($name,0,2));
}
@endphp

@section('content')

{{-- ========================================================
     1. HERO / BANNER SECTION
     ======================================================== --}}
<section class="jadwal-hero">
    <div class="container">
        <div class="jadwal-hero-content">
            {{-- Badge --}}
            <div class="jadwal-badge">
                <span class="jadwal-badge-dot"></span>
                Turnamen Basket Resmi SMK Wikrama Bogor
            </div>

            {{-- Title --}}
            <h1 class="jadwal-hero-title">
                Statistik <span class="c-orange">Turnamen</span>
            </h1>

            {{-- Subtitle --}}
            <p class="jadwal-hero-desc">
                Pusat rekapitulasi data statistik pertandingan dan papan peringkat individu pemain turnamen Wikrama Cup Basketball.
            </p>
        </div>
    </div>
</section>

{{-- ========================================================
     2. FILTER BOX & STATS TABLE SECTION
     ======================================================== --}}
<section class="jadwal-main-sec">
    <div class="container">

        {{-- Filter & Ranking Card --}}
        <div class="stat-filter-card">
            <div class="stat-filter-header">
                <div class="sf-title-row">
                    <span class="sf-bar"></span>
                    <h2 class="sf-title">Filter & Cari Ranking Pemain</h2>
                </div>
                <span class="sf-subtitle">Pilih kriteria untuk menampilkan peringkat statistik pemain</span>
            </div>

            <form action="{{ route('statistics.index') }}" method="GET" class="stat-filter-form">
                <div class="stat-form-grid">
                    
                    {{-- Divisi / Kategori --}}
                    <div class="stat-form-group">
                        <label class="stat-label">DIVISI / KATEGORI</label>
                        <div class="stat-select-wrap">
                            <select name="kategori" class="stat-select">
                                <option value="all" {{ $kategori === 'all' ? 'selected' : '' }}>🏀 Semua Divisi</option>
                                <option value="putra" {{ $kategori === 'putra' ? 'selected' : '' }}>🏀 Boys (Putra)</option>
                                <option value="putri" {{ $kategori === 'putri' ? 'selected' : '' }}>🏀 Girls (Putri)</option>
                            </select>
                            <svg class="stat-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Peringkat --}}
                    <div class="stat-form-group">
                        <label class="stat-label">PERINGKAT</label>
                        <div class="stat-select-wrap">
                            <select name="peringkat" class="stat-select">
                                <option value="all" {{ $peringkat === 'all' ? 'selected' : '' }}>Semua Pemain</option>
                                <option value="5" {{ $peringkat == '5' ? 'selected' : '' }}>Top 5 Pemain</option>
                                <option value="10" {{ $peringkat == '10' ? 'selected' : '' }}>Top 10 Pemain</option>
                                <option value="20" {{ $peringkat == '20' ? 'selected' : '' }}>Top 20 Pemain</option>
                            </select>
                            <svg class="stat-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Kategori Statistik --}}
                    <div class="stat-form-group">
                        <label class="stat-label">KATEGORI STATISTIK</label>
                        <div class="stat-select-wrap">
                            <select name="stat_type" class="stat-select">
                                <option value="poin" {{ $statType === 'poin' ? 'selected' : '' }}>Points (PTS)</option>
                                <option value="rebound" {{ $statType === 'rebound' ? 'selected' : '' }}>Rebounds (REB)</option>
                                <option value="assist" {{ $statType === 'assist' ? 'selected' : '' }}>Assists (AST)</option>
                                <option value="steal" {{ $statType === 'steal' ? 'selected' : '' }}>Steals (STL)</option>
                                <option value="block" {{ $statType === 'block' ? 'selected' : '' }}>Blocks (BLK)</option>
                                <option value="three_point_made" {{ $statType === 'three_point_made' ? 'selected' : '' }}>3-Points (3PM)</option>
                            </select>
                            <svg class="stat-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Nama Sekolah / Tim --}}
                    <div class="stat-form-group">
                        <label class="stat-label">NAMA SEKOLAH / TIM</label>
                        <input type="text" name="search_team" value="{{ $searchTeam }}" class="stat-input" placeholder="Contoh: SMK Wikrama">
                    </div>

                    {{-- Submit Button --}}
                    <div class="stat-form-group stat-btn-wrap">
                        <label class="stat-label">&nbsp;</label>
                        <button type="submit" class="btn-cari-ranking">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            Cari Ranking
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Statistics Table Card --}}
        <div class="stat-table-card">
            {{-- Dark Header --}}
            <div class="st-card-header">
                <div class="st-header-left">
                    <span class="st-bar"></span>
                    <div>
                        <h3 class="st-title">Riwayat Statistik Pertandingan</h3>
                        <p class="st-sub">Seluruh data rekaman statistik pemain per laga turnamen WIKCUP</p>
                    </div>
                </div>
                <div class="st-header-right">
                    <span class="st-total-badge">Total {{ $totalCount }} Data Pertandingan</span>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="stat-data-table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">PERTANDINGAN</th>
                            <th style="min-width: 220px;">PEMAIN</th>
                            <th class="text-center">MIN</th>
                            <th class="text-center th-pts">PTS</th>
                            <th class="text-center">REB</th>
                            <th class="text-center">AST</th>
                            <th class="text-center">STL</th>
                            <th class="text-center">BLK</th>
                            <th class="text-center">TO</th>
                            <th class="text-center">FGM</th>
                            <th class="text-center">FGA</th>
                            <th class="text-center">FG%</th>
                            <th class="text-center">3FGM</th>
                            <th class="text-center">3FGA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics as $s)
                            @php
                                $player = $s->player;
                                $team = $player->team ?? null;
                                $match = $s->match;
                                $init = ava_init($player->nama ?? 'P');
                                $isGirls = strtolower($team->kategori ?? '') === 'putri';
                                
                                $minFmt = substr($s->minutes ?? '00:00:00', 3, 5);
                                if(empty($minFmt) || $minFmt === '00') $minFmt = '30:00';
                                
                                $fgPct = ($s->fga > 0) ? round(($s->fgm / $s->fga) * 100, 1) . '%' : '0%';
                                
                                $matchLabel = ($match && $match->teamA && $match->teamB)
                                    ? ($match->teamA->nama_tim . ($match->teamA->nickname ? ' ' . $match->teamA->nickname : '') . ' vs ' . $match->teamB->nama_tim . ($match->teamB->nickname ? ' ' . $match->teamB->nickname : ''))
                                    : 'Match Turnamen WikCup';
                                
                                $matchDate = $match ? \Carbon\Carbon::parse($match->tanggal)->translatedFormat('d F Y') : '22 September 2026';
                            @endphp
                            <tr>
                                {{-- Match Info --}}
                                <td>
                                    <div class="st-match-cell">
                                        <div class="st-match-name">{{ $matchLabel }}</div>
                                        <div class="st-match-date">{{ $matchDate }}</div>
                                    </div>
                                </td>

                                {{-- Player Info --}}
                                <td>
                                    <div class="st-player-cell">
                                        <div class="st-player-ava">{{ $init }}</div>
                                        <div class="st-player-meta">
                                            <div class="st-player-name-row">
                                                <strong class="st-pname">{{ $player->nama ?? '-' }}</strong>
                                                <span class="st-pnum">#{{ $player->no_punggung ?? '-' }}</span>
                                            </div>
                                            <div class="st-player-sub-row">
                                                <span class="st-pteam">{{ $team ? ($team->nama_tim . ($team->nickname ? ' ' . $team->nickname : '')) : '-' }}</span>
                                                @if($isGirls)
                                                    <span class="st-tag-girls">&bull; Girls</span>
                                                @else
                                                    <span class="st-tag-boys">&bull; Boys</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Stats Columns --}}
                                <td class="text-center st-min">{{ $minFmt }}</td>
                                <td class="text-center st-pts">{{ $s->poin }}</td>
                                <td class="text-center st-bold">{{ $s->rebound }}</td>
                                <td class="text-center st-bold">{{ $s->assist }}</td>
                                <td class="text-center">{{ $s->steal }}</td>
                                <td class="text-center">{{ $s->block }}</td>
                                <td class="text-center">{{ $s->turnover }}</td>
                                <td class="text-center">{{ $s->fgm }}</td>
                                <td class="text-center">{{ $s->fga }}</td>
                                <td class="text-center st-fg">{{ $fgPct }}</td>
                                <td class="text-center">{{ $s->three_point_made }}</td>
                                <td class="text-center">{{ $s->three_point_attempted }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-5 text-muted">
                                    Tidak ada data statistik yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination Footer --}}
            <div class="st-pagination-wrap">
                {{-- Previous --}}
                @if ($statistics->onFirstPage())
                    <span class="btn-pag-nav disabled">&laquo; Previous</span>
                @else
                    <a href="{{ $statistics->previousPageUrl() }}" class="btn-pag-nav">&laquo; Previous</a>
                @endif

                {{-- Center Info & Pages --}}
                <div class="st-pag-center">
                    <span class="st-pag-info">
                        Showing <strong>{{ $statistics->firstItem() ?? 0 }}</strong> to <strong>{{ $statistics->lastItem() ?? 0 }}</strong> of <strong>{{ $statistics->total() }}</strong> results
                    </span>
                    <div class="st-page-numbers">
                        @foreach ($statistics->getUrlRange(1, $statistics->lastPage()) as $page => $url)
                            @if ($page == $statistics->currentPage())
                                <span class="pag-num active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pag-num">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Next --}}
                @if ($statistics->hasMorePages())
                    <a href="{{ $statistics->nextPageUrl() }}" class="btn-pag-nav">Next &raquo;</a>
                @else
                    <span class="btn-pag-nav disabled">Next &raquo;</span>
                @endif
            </div>

        </div>

    </div>
</section>

@endsection

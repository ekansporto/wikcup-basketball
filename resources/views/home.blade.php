@extends('layouts.app')

@section('title','Beranda — WikCup Basketball SMK Wikrama Bogor')
@section('meta_desc','Portal resmi WikCup 2026. Jadwal pertandingan, hasil skor, profil pemain, dan statistik turnamen basket SMK Wikrama Bogor.')

@php
/* Helper: warna avatar tim berdasarkan ID */
$ava_colors = [
    '#0B7A75','#0077B6','#6A0572','#9D0208','#1D6A96',
    '#3D5A80','#006D77','#023E8A','#7B2D8B','#4A4E69',
];
function ava_color($id, $arr){ return $arr[abs(intval($id)) % count($arr)]; }

/* Inisial 2 huruf dari nama tim */
function ava_init($name){
    $w = preg_split('/\s+/', trim($name));
    if(count($w)>=2) return strtoupper(substr($w[0],0,1).substr($w[1],0,1));
    return strtoupper(substr($name,0,2));
}
@endphp

@section('content')

{{-- ===================================================
     1. HERO
     =================================================== --}}
<section class="hero">
    <div class="hero-wrap">

        {{-- Kiri: Text Content --}}
        <div class="hero-left">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Turnamen Basket Resmi SMK Wikrama Bogor
            </div>

            <h1 class="hero-title">
                Wikrama Cup<br>
                <span class="grad-text">Basketball</span>
            </h1>

            <p class="hero-desc">
                Informasi pertandingan dan statistik Wikrama dalam satu website.
                Pantau jadwal tim, hasil skor langsung, profil pemain, serta performa
                statistik turnamen terlengkap.
            </p>

            <div class="hero-btns">
                <a href="{{ route('matches.index') }}" class="btn-primary" id="btn-lihat-jadwal">
                    Lihat Jadwal
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('statistics.index') }}" class="btn-secondary" id="btn-lihat-statistik">
                    Lihat Statistik
                </a>
            </div>

            <div class="hero-cats">
                <span class="hero-cat c-orange">MATCH</span>
                <span class="hero-cat-sep">—</span>
                <span class="hero-cat c-teal">PLAYER</span>
                <span class="hero-cat-sep">—</span>
                <span class="hero-cat c-navy">STATISTIC</span>
            </div>
        </div>

        {{-- Kanan: Dark Card --}}
        <div class="hero-card">
            <div class="hero-card-top">
                <span class="hc-live-badge">
                    <span class="hc-live-dot"></span>
                    Live Championship
                </span>
                <span class="hc-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2.1 13.4A10.1 10.1 0 0 0 13.4 2.1"/><path d="M5 4.9 19 19.1"/><path d="M21.9 10.6A10.1 10.1 0 0 0 10.6 21.9"/></svg>
                </span>
            </div>
            <div class="hc-divider"></div>

            <div class="hc-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="WikCup" style="height:52px;width:auto;object-fit:contain">
            </div>
            <div class="hc-team-name">SMK WIKRAMA</div>
            <div class="hc-team-sub">Bogor Basketball League</div>

            <div class="hc-stats">
                <div class="hc-stat">
                    <div class="hc-stat-val c-orange">{{ $totalTeams ?: '–' }}</div>
                    <div class="hc-stat-lbl">Tim</div>
                </div>
                <div class="hc-stat">
                    <div class="hc-stat-val c-teal">FIBA</div>
                    <div class="hc-stat-lbl">Rules</div>
                </div>
                <div class="hc-stat">
                    <div class="hc-stat-val">{{ $totalMatches ?: '–' }}</div>
                    <div class="hc-stat-lbl">Match</div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ===================================================
     2. PERTANDINGAN TERDEKAT
     =================================================== --}}
<section class="section" id="jadwal">
    <div class="sec-wrap">
        <div class="sec-hd">
            <div class="sec-hd-left">
                <h2 class="sec-title">Pertandingan Terdekat</h2>
                <p class="sec-sub">Jadwal pertandingan selanjutnya di arena SMK Wikrama.</p>
            </div>
            <a href="{{ route('matches.index') }}" class="sec-link">Seluruh Jadwal →</a>
        </div>

        <div class="grid-2">
            @forelse($upcomingMatches as $m)
                @php
                    $initA = ava_init($m->teamA->nama_tim ?? 'Team A');
                    $initB = ava_init($m->teamB->nama_tim ?? 'Team B');
                    $clrA  = ava_color($m->team_a_id, $ava_colors);
                    $clrB  = ava_color($m->team_b_id + 3, $ava_colors);
                @endphp
                <div class="match-card" id="match-{{ $m->id_match }}">
                    <div class="mc-top">
                        <span class="badge badge-green">● Mendatang</span>
                        <span class="mc-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-1px;margin-right:2px"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($m->tanggal)->translatedFormat('d M Y') }} &bull; {{ substr($m->jam,0,5) }} WIB
                        </span>
                    </div>
                    <div class="mc-teams">
                        <div class="mc-team">
                            <div class="team-ava" style="background:{{ $clrA }}">{{ $initA }}</div>
                            <span class="team-name-sm">{{ $m->teamA->nama_tim ?? '-' }}</span>
                        </div>
                        <span class="mc-vs">VS</span>
                        <div class="mc-team">
                            <div class="team-ava" style="background:{{ $clrB }}">{{ $initB }}</div>
                            <span class="team-name-sm">{{ $m->teamB->nama_tim ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mc-footer">
                        <span class="mc-loc">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-2px;margin-right:2px"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $m->lokasi }}
                        </span>
                        <a href="{{ route('matches.show', $m->id_match) }}" class="mc-detail-link">Detail Jadwal →</a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <p class="empty-txt">Belum ada pertandingan mendatang</p>
                    <p class="empty-sub">Jadwal akan muncul setelah diinput oleh admin.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===================================================
     3. HASIL PERTANDINGAN TERBARU
     =================================================== --}}
<section class="section-alt" id="hasil">
    <div class="sec-wrap">
        <div class="sec-hd">
            <div class="sec-hd-left">
                <h2 class="sec-title teal-bar">Hasil Pertandingan Terbaru</h2>
                <p class="sec-sub">Skor akhir laga yang baru saja selesai dimainkan.</p>
            </div>
            <a href="{{ route('matches.index') }}" class="sec-link teal">Semua Hasil →</a>
        </div>

        <div class="grid-2">
            @forelse($recentResults as $r)
                @php
                    $initA  = ava_init($r->teamA->nama_tim ?? 'Team A');
                    $initB  = ava_init($r->teamB->nama_tim ?? 'Team B');
                    $clrA   = ava_color($r->team_a_id, $ava_colors);
                    $clrB   = ava_color($r->team_b_id + 3, $ava_colors);
                    $winA   = ($r->skor_tim_a > $r->skor_tim_b);
                    $winB   = ($r->skor_tim_b > $r->skor_tim_a);
                @endphp
                <div class="result-card" id="result-{{ $r->id_match }}">
                    <div class="rc-top">
                        <span class="badge badge-blue">Final Score</span>
                        <span class="rc-meta">
                            {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                            &bull; {{ $r->lokasi }}
                        </span>
                    </div>
                    <div class="rc-scoreboard">
                        <div class="rc-team-row">
                            <div class="rc-team-info">
                                <div class="team-ava" style="background:{{ $clrA }};width:38px;height:38px;border-radius:10px;font-size:12px">{{ $initA }}</div>
                                <div>
                                    <div style="font-size:13px;font-weight:600;color:#101828">{{ $r->teamA->nama_tim ?? '-' }}</div>
                                    @if($winA)<span class="rc-winner">WINNER</span>@endif
                                </div>
                            </div>
                            <span class="rc-score {{ $winA ? 'win' : '' }}">{{ $r->skor_tim_a }}</span>
                        </div>
                        <div class="rc-team-row">
                            <div class="rc-team-info">
                                <div class="team-ava" style="background:{{ $clrB }};width:38px;height:38px;border-radius:10px;font-size:12px">{{ $initB }}</div>
                                <div>
                                    <div style="font-size:13px;font-weight:600;color:#101828">{{ $r->teamB->nama_tim ?? '-' }}</div>
                                    @if($winB)<span class="rc-winner">WINNER</span>@endif
                                </div>
                            </div>
                            <span class="rc-score {{ $winB ? 'win' : '' }}">{{ $r->skor_tim_b }}</span>
                        </div>
                    </div>
                    <a href="{{ route('matches.show', $r->id_match) }}" class="rc-link">
                        Lihat Statistik Pertandingan →
                    </a>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"/><path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"/></svg>
                    </div>
                    <p class="empty-txt">Belum ada hasil pertandingan</p>
                    <p class="empty-sub">Hasil akan tampil setelah pertandingan selesai.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===================================================
     4. STATISTIK TERATAS
     =================================================== --}}
<section class="section" id="statistik">
    <div class="sec-wrap">
        <div class="sec-hd">
            <div class="sec-hd-left">
                <h2 class="sec-title">Statistik Teratas</h2>
                <p class="sec-sub">Para pemimpin statistik individu turnamen WikCup.</p>
            </div>
            <a href="{{ route('statistics.index') }}" class="sec-link">Papan Peringkat Lengkap →</a>
        </div>

        <div class="grid-3">
            {{-- TOP SCORER --}}
            <div class="stat-card" id="card-top-scorer">
                <div class="sc-top">
                    <span class="sc-badge orange">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-1px;margin-right:2px"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 3z"/></svg>
                        Top Scorer
                    </span>
                    <span class="sc-val-lbl">Poin</span>
                </div>
                @if($topScorer && $topScorer->player)
                    <div class="sc-player">
                        <div class="sc-ava" style="background:#0B7A75">
                            {{ strtoupper(substr($topScorer->player->nama ?? 'P',0,2)) }}
                        </div>
                        <div>
                            <div class="sc-player-name">{{ $topScorer->player->nama }}</div>
                            <div class="sc-player-meta">{{ $topScorer->player->team->nama_tim ?? '-' }} #{{ $topScorer->player->no_punggung ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="sc-nums">
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topScorer->total_poin }}</span>
                            <span class="sc-num-lbl">Total PTS</span>
                        </div>
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topScorer->ppg }}</span>
                            <span class="sc-num-lbl">PPG</span>
                        </div>
                    </div>
                @else
                    <div class="empty-state" style="padding:28px 0">
                        <div class="empty-icon" style="font-size:24px">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                        </div>
                        <p class="empty-txt">Belum ada data</p>
                    </div>
                @endif
            </div>

            {{-- TOP ASSIST --}}
            <div class="stat-card" id="card-top-assist">
                <div class="sc-top">
                    <span class="sc-badge teal">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-1px;margin-right:2px"><circle cx="12" cy="12" r="10"/><path d="M2.1 13.4A10.1 10.1 0 0 0 13.4 2.1"/><path d="M5 4.9 19 19.1"/><path d="M21.9 10.6A10.1 10.1 0 0 0 10.6 21.9"/></svg>
                        Top Assist
                    </span>
                    <span class="sc-val-lbl">Assist</span>
                </div>
                @if($topAssist && $topAssist->player)
                    <div class="sc-player">
                        <div class="sc-ava" style="background:#006D77">
                            {{ strtoupper(substr($topAssist->player->nama ?? 'P',0,2)) }}
                        </div>
                        <div>
                            <div class="sc-player-name">{{ $topAssist->player->nama }}</div>
                            <div class="sc-player-meta">{{ $topAssist->player->team->nama_tim ?? '-' }} #{{ $topAssist->player->no_punggung ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="sc-nums">
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topAssist->total_assist }}</span>
                            <span class="sc-num-lbl">Total AST</span>
                        </div>
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topAssist->apg }}</span>
                            <span class="sc-num-lbl">APG</span>
                        </div>
                    </div>
                @else
                    <div class="empty-state" style="padding:28px 0">
                        <div class="empty-icon" style="font-size:24px">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                        </div>
                        <p class="empty-txt">Belum ada data</p>
                    </div>
                @endif
            </div>

            {{-- TOP REBOUND --}}
            <div class="stat-card" id="card-top-rebound">
                <div class="sc-top">
                    <span class="sc-badge green">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-1px;margin-right:2px"><polyline points="18 15 12 9 6 15"/></svg>
                        Top Rebound
                    </span>
                    <span class="sc-val-lbl">Rebound</span>
                </div>
                @if($topRebound && $topRebound->player)
                    <div class="sc-player">
                        <div class="sc-ava" style="background:#3D5A80">
                            {{ strtoupper(substr($topRebound->player->nama ?? 'P',0,2)) }}
                        </div>
                        <div>
                            <div class="sc-player-name">{{ $topRebound->player->nama }}</div>
                            <div class="sc-player-meta">{{ $topRebound->player->team->nama_tim ?? '-' }} #{{ $topRebound->player->no_punggung ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="sc-nums">
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topRebound->total_rebound }}</span>
                            <span class="sc-num-lbl">Total REB</span>
                        </div>
                        <div class="sc-num">
                            <span class="sc-num-val">{{ $topRebound->rpg }}</span>
                            <span class="sc-num-lbl">RPG</span>
                        </div>
                    </div>
                @else
                    <div class="empty-state" style="padding:28px 0">
                        <div class="empty-icon" style="font-size:24px">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                        </div>
                        <p class="empty-txt">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

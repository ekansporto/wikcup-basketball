@extends('layouts.app')

@section('title', ($match->teamA->nama_tim ?? 'Team A') . ' vs ' . ($match->teamB->nama_tim ?? 'Team B') . ' — WikCup Basketball')
@section('meta_desc', 'Detail dan statistik pertandingan ' . ($match->teamA->nama_tim ?? 'Team A') . ' melawan ' . ($match->teamB->nama_tim ?? 'Team B') . ' pada ajang WikCup SMK Wikrama Bogor.')

@php
function ava_init($name){
    $w = preg_split('/\s+/', trim($name));
    if(count($w)>=2) return strtoupper(substr($w[0],0,1).substr($w[1],0,1));
    return strtoupper(substr($name,0,2));
}

$isCompleted = !is_null($match->skor_tim_a) && !is_null($match->skor_tim_b);
$scoreA = intval($match->skor_tim_a);
$scoreB = intval($match->skor_tim_b);
$winA = $isCompleted && ($scoreA > $scoreB);
$winB = $isCompleted && ($scoreB > $scoreA);

$initA = $match->teamA->singkatan ?? ava_init($match->teamA->nama_tim ?? 'TA');
$initB = $match->teamB->singkatan ?? ava_init($match->teamB->nama_tim ?? 'TB');
$colorA = $match->teamA->warna ?? '#0F172A';
$colorB = $match->teamB->warna ?? '#0F172A';
$nameA = ($match->teamA->nama_tim ?? 'Team A') . ($match->teamA->nickname ? ' ' . $match->teamA->nickname : '');
$nameB = ($match->teamB->nama_tim ?? 'Team B') . ($match->teamB->nickname ? ' ' . $match->teamB->nickname : '');
@endphp

@section('content')

{{-- Top Back Nav --}}
<div class="page-top-nav">
    <div class="container">
        <a href="{{ $isCompleted ? route('matches.hasil') : route('matches.index') }}" class="btn-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke {{ $isCompleted ? 'Hasil Pertandingan' : 'Jadwal Pertandingan' }}
        </a>
    </div>
</div>

{{-- Match Scoreboard Banner --}}
<section class="match-detail-hero">
    <div class="container">
        <div class="match-detail-card">
            
            {{-- Header Meta --}}
            <div class="mdc-header">
                @if($isCompleted)
                    <span class="hc-finished-badge">FINISHED</span>
                @else
                    <span class="jc-status-badge">Mendatang</span>
                @endif

                <div class="mdc-meta-row">
                    <span class="mdc-meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($match->tanggal)->translatedFormat('d F Y') }}
                    </span>
                    <span class="mdc-sep">&bull;</span>
                    <span class="mdc-meta-item">{{ substr($match->jam, 0, 5) }} WIB</span>
                    <span class="mdc-sep">&bull;</span>
                    <span class="mdc-meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $match->lokasi ?? 'Lapangan Utama SMK Wikrama' }}
                    </span>
                </div>
            </div>

            {{-- Big Scoreboard Matchup --}}
            <div class="mdc-scoreboard">
                {{-- Team A --}}
                <div class="mdc-team {{ $winA ? 'winner' : '' }}">
                    <div class="mdc-team-badge" style="background-color: {{ $colorA }}">
                        {{ $initA }}
                    </div>
                    <div class="mdc-team-name">{{ $nameA }}</div>
                    @if($winA)
                        <span class="hc-win-badge">MENANG</span>
                    @endif
                </div>

                {{-- Center Score / VS --}}
                <div class="mdc-score-wrap">
                    @if($isCompleted)
                        <div class="mdc-score-digits">
                            <span class="{{ $winA ? 'c-orange' : 'c-dark' }}">{{ $scoreA }}</span>
                            <span class="mdc-dash">-</span>
                            <span class="{{ $winB ? 'c-orange' : 'c-dark' }}">{{ $scoreB }}</span>
                        </div>
                        <div class="mdc-score-lbl">FINAL SCORE</div>
                    @else
                        <div class="jc-vs-badge" style="width:40px;height:40px;font-size:13px">VS</div>
                        <div class="mdc-score-lbl">SCHEDULED</div>
                    @endif
                </div>

                {{-- Team B --}}
                <div class="mdc-team {{ $winB ? 'winner' : '' }}">
                    <div class="mdc-team-badge" style="background-color: {{ $colorB }}">
                        {{ $initB }}
                    </div>
                    <div class="mdc-team-name">{{ $nameB }}</div>
                    @if($winB)
                        <span class="hc-win-badge">MENANG</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Box Score or Upcoming Match Preview --}}
<section class="jadwal-main-sec">
    <div class="container">

        @if($isCompleted)
            <div class="sec-hd" style="margin-bottom: 24px;">
                <div class="sec-hd-left">
                    <h2 class="sec-title">Box Score & Statistik Pertandingan</h2>
                    <p class="sec-sub">Rincian performa individu per pemain dari kedua tim dalam pertandingan ini.</p>
                </div>
            </div>

            {{-- Team A Box Score Table --}}
            <div class="boxscore-card">
                <div class="boxscore-header">
                    <div class="team-ava-xs" style="background-color: {{ $colorA }}; color: #fff; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px;">
                        {{ $initA }}
                    </div>
                    <h3 class="boxscore-team-title">{{ $nameA }}</h3>
                </div>
                <div class="table-responsive">
                    <table class="wik-table">
                        <thead>
                            <tr>
                                <th>Pemain</th>
                                <th>Pos</th>
                                <th class="text-center">PTS</th>
                                <th class="text-center">REB</th>
                                <th class="text-center">AST</th>
                                <th class="text-center">STL</th>
                                <th class="text-center">BLK</th>
                                <th class="text-center">3PM</th>
                                <th class="text-center">TO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statsTeamA as $st)
                                <tr>
                                    <td>
                                        <div class="tbl-player-link">
                                            <strong>{{ $st->player->nama ?? '-' }}</strong>
                                            <span class="tbl-player-num">#{{ $st->player->no_punggung ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge-pos">{{ $st->player->posisi ?? '-' }}</span></td>
                                    <td class="text-center fw-bold c-orange">{{ $st->poin }}</td>
                                    <td class="text-center">{{ $st->rebound }}</td>
                                    <td class="text-center c-teal fw-bold">{{ $st->assist }}</td>
                                    <td class="text-center">{{ $st->steal }}</td>
                                    <td class="text-center">{{ $st->block }}</td>
                                    <td class="text-center">{{ $st->three_point_made }}</td>
                                    <td class="text-center">{{ $st->turnover }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada rincian data statistik pemain tercatat untuk tim ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Team B Box Score Table --}}
            <div class="boxscore-card" style="margin-top: 28px;">
                <div class="boxscore-header">
                    <div class="team-ava-xs" style="background-color: {{ $colorB }}; color: #fff; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px;">
                        {{ $initB }}
                    </div>
                    <h3 class="boxscore-team-title">{{ $nameB }}</h3>
                </div>
                <div class="table-responsive">
                    <table class="wik-table">
                        <thead>
                            <tr>
                                <th>Pemain</th>
                                <th>Pos</th>
                                <th class="text-center">PTS</th>
                                <th class="text-center">REB</th>
                                <th class="text-center">AST</th>
                                <th class="text-center">STL</th>
                                <th class="text-center">BLK</th>
                                <th class="text-center">3PM</th>
                                <th class="text-center">TO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statsTeamB as $st)
                                <tr>
                                    <td>
                                        <div class="tbl-player-link">
                                            <strong>{{ $st->player->nama ?? '-' }}</strong>
                                            <span class="tbl-player-num">#{{ $st->player->no_punggung ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge-pos">{{ $st->player->posisi ?? '-' }}</span></td>
                                    <td class="text-center fw-bold c-orange">{{ $st->poin }}</td>
                                    <td class="text-center">{{ $st->rebound }}</td>
                                    <td class="text-center c-teal fw-bold">{{ $st->assist }}</td>
                                    <td class="text-center">{{ $st->steal }}</td>
                                    <td class="text-center">{{ $st->block }}</td>
                                    <td class="text-center">{{ $st->three_point_made }}</td>
                                    <td class="text-center">{{ $st->turnover }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada rincian data statistik pemain tercatat untuk tim ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            {{-- Upcoming Match Information & Rosters --}}
            <div class="sec-hd" style="margin-bottom: 24px;">
                <div class="sec-hd-left">
                    <h2 class="sec-title">Informasi & Roster Pemain</h2>
                    <p class="sec-sub">Daftar pemain yang akan bertanding pada laga mendatang.</p>
                </div>
            </div>

            <div class="grid-2">
                {{-- Team A Roster --}}
                <div class="boxscore-card">
                    <div class="boxscore-header">
                        <div class="team-ava-xs" style="background-color: {{ $colorA }}; color: #fff; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px;">
                            {{ $initA }}
                        </div>
                        <div>
                            <h3 class="boxscore-team-title">{{ $nameA }}</h3>
                            <span style="font-size: 12px; color: #64748B;">Daftar Skuad Pemain</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="wik-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemain</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($match->teamA->players ?? [] as $pl)
                                    <tr>
                                        <td class="fw-bold c-orange">#{{ $pl->no_punggung }}</td>
                                        <td><strong>{{ $pl->nama }}</strong></td>
                                        <td><span class="badge-pos">{{ $pl->posisi }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada daftar pemain untuk tim ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Team B Roster --}}
                <div class="boxscore-card">
                    <div class="boxscore-header">
                        <div class="team-ava-xs" style="background-color: {{ $colorB }}; color: #fff; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px;">
                            {{ $initB }}
                        </div>
                        <div>
                            <h3 class="boxscore-team-title">{{ $nameB }}</h3>
                            <span style="font-size: 12px; color: #64748B;">Daftar Skuad Pemain</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="wik-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemain</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($match->teamB->players ?? [] as $pl)
                                    <tr>
                                        <td class="fw-bold c-orange">#{{ $pl->no_punggung }}</td>
                                        <td><strong>{{ $pl->nama }}</strong></td>
                                        <td><span class="badge-pos">{{ $pl->posisi }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada daftar pemain untuk tim ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

@endsection

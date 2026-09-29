@extends('layouts.app')

@section('title', ($team->nama_tim ?? 'Tim') . ' ' . ($team->nickname ?? '') . ' — WikCup Basketball')
@section('meta_desc', 'Profil lengkap dan daftar roster pemain tim ' . ($team->nama_tim ?? '') . ' pada turnamen basket WikCup SMK Wikrama Bogor.')

@php
function ava_init($name){
    $w = preg_split('/\s+/', trim($name));
    if(count($w)>=2) return strtoupper(substr($w[0],0,1).substr($w[1],0,1));
    return strtoupper(substr($name,0,2));
}

$fullName = trim(($team->nama_tim ?? 'Tim') . ($team->nickname ? ' ' . $team->nickname : ''));
$isSmp = str_contains(strtolower($team->nama_tim), 'smp');
$bgColor = $team->warna ?? ($isSmp ? '#F1F5F9' : '#0F172A');
$textColor = $isSmp ? '#334155' : '#FFFFFF';
$init = $team->singkatan ?? ava_init($team->nama_tim ?? 'TM');
@endphp

@section('content')

{{-- Top Back Nav --}}
<div class="page-top-nav">
    <div class="container">
        <a href="{{ route('teams.index') }}" class="btn-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke Daftar Tim & Pemain
        </a>
    </div>
</div>

{{-- Team Profile Hero --}}
<section class="match-detail-hero">
    <div class="container">
        <div class="match-detail-card">
            <div class="team-profile-header">
                <div class="tc-badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; width: 68px; height: 68px; font-size: 24px; border-radius: 18px;">
                    {{ $init }}
                </div>
                <div class="team-profile-meta">
                    <div class="team-profile-kategori">
                        <span class="tc-count-badge">
                            <span class="tc-count-dot"></span>
                            Kategori {{ $team->kategori ?? 'Putra' }}
                        </span>
                        <span class="tc-count-badge tc-count-empty">
                            {{ $team->players->count() }} Pemain Terdaftar
                        </span>
                    </div>
                    <h1 class="team-profile-title">{{ $fullName }}</h1>
                    <p class="team-profile-sub">Peserta Resmi Wikrama Cup Basketball Championship 2026</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Roster List --}}
<section class="jadwal-main-sec">
    <div class="container">

        <div class="sec-hd" style="margin-bottom: 24px;">
            <div class="sec-hd-left">
                <h2 class="sec-title">Daftar Roster & Pemain Tim</h2>
                <p class="sec-sub">Informasi skuad pemain resmi, nomor punggung, dan posisi bermain.</p>
            </div>
        </div>

        <div class="boxscore-card">
            <div class="table-responsive">
                <table class="wik-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Nama Pemain</th>
                            <th>Posisi</th>
                            <th>Tinggi</th>
                            <th>Berat</th>
                            <th>Kelas / Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($team->players as $p)
                            <tr>
                                <td class="fw-bold c-orange" style="font-size: 15px;">#{{ $p->no_punggung }}</td>
                                <td>
                                    <div class="tbl-player-link">
                                        <strong>{{ $p->nama }}</strong>
                                        @if($p->is_captain)
                                            <span class="badge-pos" style="background: #FEF3C7; color: #D97706; font-weight: 800;">C</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="badge-pos">{{ $p->posisi ?? '-' }}</span></td>
                                <td>{{ $p->tinggi_badan ? $p->tinggi_badan . ' cm' : '-' }}</td>
                                <td>{{ $p->berat_badan ? $p->berat_badan . ' kg' : '-' }}</td>
                                <td>{{ $p->kelas_program ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Belum ada data roster pemain untuk tim ini (Roster Baru).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection

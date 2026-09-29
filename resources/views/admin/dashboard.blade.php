@extends('layouts.admin')

@section('title', 'Dashboard Admin — WikCup Basketball')
@section('header_title', 'Ringkasan Turnamen')
@section('header_sub', 'Panel kontrol & pembaruan data real-time Wikrama Basketball Cup')

@push('admin-styles')
<style>
    /* Welcome Alert */
    .admin-alert-banner {
        background-color: #ECFDF5;
        border: 1px solid #A7F3D0;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .admin-alert-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background-color: #10B981;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .admin-alert-text {
        font-size: 13.5px;
        color: #065F46;
    }

    .admin-alert-text strong {
        font-weight: 700;
        color: #047857;
    }

    /* Stats Grid */
    .admin-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .admin-stat-card {
        background-color: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .admin-stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .admin-stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #94A3B8;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .admin-stat-icon-badge {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-blue   { background-color: #EFF6FF; color: #3B82F6; }
    .icon-amber  { background-color: #FEF3C7; color: #F59E0B; }
    .icon-orange { background-color: #FFEDD5; color: #EA580C; }
    .icon-slate  { background-color: #F1F5F9; color: #64748B; }

    .admin-stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
        margin: 10px 0 12px;
    }

    .admin-stat-link {
        font-size: 12px;
        font-weight: 700;
        color: #EA580C;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.2s;
    }

    .admin-stat-link:hover {
        color: #C2410C;
        gap: 6px;
    }

    .admin-stat-subtext {
        font-size: 12px;
        font-weight: 500;
        color: #94A3B8;
    }

    /* Recent Matches Table Card */
    .admin-table-card {
        background-color: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .admin-table-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .admin-table-title h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 2px;
    }

    .admin-table-title p {
        font-size: 12px;
        color: #64748B;
        margin: 0;
    }

    .btn-add-match {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        color: #FFFFFF;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 18px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(234, 88, 12, 0.25);
        transition: all 0.2s ease;
    }

    .btn-add-match:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
    }

    .admin-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .admin-custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-custom-table th {
        background-color: #FAFAFA;
        border-top: 1px solid #F1F5F9;
        border-bottom: 1px solid #E2E8F0;
        font-size: 11px;
        font-weight: 700;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 24px;
    }

    .admin-custom-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
        font-size: 13px;
    }

    .admin-custom-table tbody tr:hover {
        background-color: #F8FAFC;
    }

    .cell-date-main {
        font-weight: 700;
        color: #0F172A;
        font-size: 13px;
    }

    .cell-date-sub {
        font-size: 11px;
        color: #94A3B8;
        margin-top: 2px;
    }

    .cell-team-name {
        font-weight: 800;
        color: #0F172A;
        font-size: 13px;
    }

    .score-badge {
        display: inline-block;
        padding: 4px 14px;
        background-color: #0F172A;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 13px;
        border-radius: 9999px;
        min-width: 65px;
        text-align: center;
        letter-spacing: 0.05em;
    }

    .score-unplayed {
        font-style: italic;
        color: #94A3B8;
        font-size: 12px;
    }

    .cell-location {
        font-size: 12px;
        color: #64748B;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-mendatang {
        background-color: #FEF3C7;
        color: #D97706;
        border: 1px solid #FDE68A;
    }

    .status-selesai {
        background-color: #EFF6FF;
        color: #2563EB;
        border: 1px solid #BFDBFE;
    }

    .admin-table-footer {
        padding: 14px 24px;
        background-color: #FFFFFF;
        border-top: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
    }

    .footer-count {
        color: #64748B;
    }

    .footer-view-all {
        color: #EA580C;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-view-all:hover {
        color: #C2410C;
    }

    @media (max-width: 1024px) {
        .admin-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .admin-stats-grid {
            grid-template-columns: 1fr;
        }
        .admin-custom-table th, .admin-custom-table td {
            padding: 12px 16px;
        }
    }
</style>
@endpush

@section('content')
    {{-- 1. Alert Banner --}}
    <div class="admin-alert-banner">
        <div class="admin-alert-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="admin-alert-text">
            <strong>Selamat datang di Dashboard Admin WIKCUP!</strong> Kelola turnamen basket dengan mudah dan terstruktur.
        </div>
    </div>

    {{-- 2. Stats Grid --}}
    <div class="admin-stats-grid">
        {{-- Total Tim --}}
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <span class="admin-stat-label">TOTAL TIM</span>
                <div class="admin-stat-icon-badge icon-blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ $totalTeams }}</div>
            <a href="{{ route('teams.index') }}" class="admin-stat-link">
                Kelola Tim →
            </a>
        </div>

        {{-- Total Pemain --}}
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <span class="admin-stat-label">TOTAL PEMAIN</span>
                <div class="admin-stat-icon-badge icon-amber">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ $totalPlayers }}</div>
            <span class="admin-stat-subtext">Terdaftar di Turnamen</span>
        </div>

        {{-- Pertandingan --}}
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <span class="admin-stat-label">PERTANDINGAN</span>
                <div class="admin-stat-icon-badge icon-orange">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2.1 13.4A10.1 10.1 0 0 0 13.4 2.1"/>
                        <path d="M21.9 10.6A10.1 10.1 0 0 0 10.6 21.9"/>
                        <path d="M2 12h20"/>
                        <path d="M12 2v20"/>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ $totalMatches }}</div>
            <a href="{{ route('matches.index') }}" class="admin-stat-link">
                Kelola Jadwal →
            </a>
        </div>

        {{-- Foto Galeri --}}
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <span class="admin-stat-label">FOTO GALERI</span>
                <div class="admin-stat-icon-badge icon-slate">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                </div>
            </div>
            <div class="admin-stat-value">{{ $totalGalleries }}</div>
            <a href="{{ route('galleries.index') }}" class="admin-stat-link">
                Kelola Galeri →
            </a>
        </div>
    </div>

    {{-- 3. Pertandingan Terbaru Table Card --}}
    <div class="admin-table-card">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <h3>Pertandingan Terbaru</h3>
                <p>Daftar pertandingan terkini yang telah dicatat panitia</p>
            </div>
            <a href="{{ route('matches.index') }}" class="btn-add-match">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Pertandingan
            </a>
        </div>

        <div class="admin-table-responsive">
            <table class="admin-custom-table">
                <thead>
                    <tr>
                        <th>TANGGAL & WAKTU</th>
                        <th>TIM A</th>
                        <th style="text-align: center;">SKOR</th>
                        <th>TIM B</th>
                        <th>LOKASI</th>
                        <th style="text-align: center;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMatches as $match)
                        @php
                            $isPlayed = !is_null($match->skor_tim_a) && !is_null($match->skor_tim_b);
                            $dateObj  = \Carbon\Carbon::parse($match->tanggal)->locale('id');
                            $timeStr  = \Carbon\Carbon::parse($match->jam)->format('H:i') . ' WIB';
                            
                            $teamAName = $match->teamA ? ($match->teamA->nama_tim . ($match->teamA->nickname ? ' ' . $match->teamA->nickname : '')) : 'Tim A';
                            $teamBName = $match->teamB ? ($match->teamB->nama_tim . ($match->teamB->nickname ? ' ' . $match->teamB->nickname : '')) : 'Tim B';
                        @endphp
                        <tr>
                            <td>
                                <div class="cell-date-main">{{ $dateObj->translatedFormat('d F Y') }}</div>
                                <div class="cell-date-sub">{{ $timeStr }}</div>
                            </td>
                            <td>
                                <span class="cell-team-name">{{ $teamAName }}</span>
                            </td>
                            <td style="text-align: center;">
                                @if($isPlayed)
                                    <span class="score-badge">{{ $match->skor_tim_a }} – {{ $match->skor_tim_b }}</span>
                                @else
                                    <span class="score-unplayed">Belum Dimainkan</span>
                                @endif
                            </td>
                            <td>
                                <span class="cell-team-name">{{ $teamBName }}</span>
                            </td>
                            <td>
                                <span class="cell-location">{{ $match->lokasi ?? 'Lapangan Utama SMK Wikrama' }}</span>
                            </td>
                            <td style="text-align: center;">
                                @if($isPlayed)
                                    <span class="status-badge status-selesai">Selesai</span>
                                @else
                                    <span class="status-badge status-mendatang">Mendatang</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94A3B8; padding: 32px;">
                                Belum ada data pertandingan yang dicatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-table-footer">
            <span class="footer-count">Menampilkan {{ $recentMatches->count() }} pertandingan terkini</span>
            <a href="{{ route('matches.index') }}" class="footer-view-all">Lihat semua jadwal & hasil →</a>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Hasil Pertandingan — WikCup SMK Wikrama Bogor')
@section('meta_desc', 'Skor akhir dan rekap pertandingan resmi Wikrama Cup Basketball. Pantau hasil laga dan performa tim kesayanganmu.')

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
                Hasil <span class="c-orange">Pertandingan</span>
            </h1>

            {{-- Subtitle --}}
            <p class="jadwal-hero-desc">
                Skor akhir dan rekap pertandingan resmi Wikrama Cup Basketball. Pantau hasil laga dan performa tim kesayanganmu.
            </p>
        </div>
    </div>
</section>

{{-- ========================================================
     2. CONTROLS & RESULT CARDS SECTION
     ======================================================== --}}
<section class="jadwal-main-sec">
    <div class="container">

        {{-- Filter & Status Bar --}}
        <div class="jadwal-controls-bar">
            {{-- Left Tabs --}}
            <div class="jadwal-tabs" id="hasil-tabs">
                <button type="button" class="jtab-btn active" data-filter="all" onclick="setHasilTab('all', this)">
                    Semua Hasil
                </button>
                <button type="button" class="jtab-btn" data-filter="penyisihan" onclick="setHasilTab('penyisihan', this)">
                    Babak Penyisihan
                </button>
                <button type="button" class="jtab-btn" data-filter="semifinal" onclick="setHasilTab('semifinal', this)">
                    Semifinal
                </button>
                <button type="button" class="jtab-btn" data-filter="final" onclick="setHasilTab('final', this)">
                    Final
                </button>
            </div>

            {{-- Right Filter Dropdown --}}
            <div class="jadwal-controls-right">
                <span class="jadwal-count-info" style="color: #64748B;">
                    Filter Fase:
                </span>

                <div class="jadwal-dropdown-wrap">
                    <select class="jadwal-phase-select" id="hasil-phase-select" onchange="applyHasilFilters()">
                        <option value="all">Fase Grup & Penyisihan (September 2026)</option>
                        @foreach($phases as $p)
                            @if(trim($p) !== 'Fase Grup & Penyisihan')
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endif
                        @endforeach
                    </select>
                    <svg class="jadwal-dropdown-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Grid of Result Cards --}}
        <div class="jadwal-grid" id="hasil-grid">
            @forelse($matches as $m)
                @php
                    $initA = $m->teamA->singkatan ?? ava_init($m->teamA->nama_tim ?? 'SQ');
                    $initB = $m->teamB->singkatan ?? ava_init($m->teamB->nama_tim ?? 'SS');
                    $colorA = $m->teamA->warna ?? '#0F172A';
                    $colorB = $m->teamB->warna ?? '#0F172A';
                    $nameA = ($m->teamA->nama_tim ?? 'Tim A') . ($m->teamA->nickname ? ' ' . $m->teamA->nickname : '');
                    $nameB = ($m->teamB->nama_tim ?? 'Tim B') . ($m->teamB->nickname ? ' ' . $m->teamB->nickname : '');
                    
                    $scoreA = intval($m->skor_tim_a);
                    $scoreB = intval($m->skor_tim_b);
                    $winA = $scoreA > $scoreB;
                    $winB = $scoreB > $scoreA;
                @endphp
                <div class="hasil-card"
                     data-fase="{{ $m->fase ?? 'Fase Grup & Penyisihan' }}">
                    
                    {{-- Card Top Row --}}
                    <div class="hc-top">
                        <span class="hc-finished-badge">
                            FINISHED
                        </span>
                        <span class="jc-datetime">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($m->tanggal)->translatedFormat('d F Y') }} &bull; {{ $m->lokasi ?? 'Lapangan Utama SMK Wikrama' }}
                        </span>
                    </div>

                    {{-- Card Center Matchup & Score --}}
                    <div class="hc-matchup">
                        {{-- Team A --}}
                        <div class="hc-team hc-team-left">
                            <div class="jc-team-badge" style="background-color: {{ $colorA }}">
                                {{ $initA }}
                            </div>
                            <div class="hc-team-info">
                                <div class="hc-team-name {{ $winA ? 'winner' : '' }}">{{ $nameA }}</div>
                                @if($winA)
                                    <span class="hc-win-badge">MENANG</span>
                                @endif
                            </div>
                        </div>

                        {{-- Score Center --}}
                        <div class="hc-score-box">
                            <span class="hc-score {{ $winA ? 'c-orange' : 'c-dark' }}">{{ $scoreA }}</span>
                            <span class="hc-score-sep">-</span>
                            <span class="hc-score {{ $winB ? 'c-orange' : 'c-dark' }}">{{ $scoreB }}</span>
                        </div>

                        {{-- Team B --}}
                        <div class="hc-team hc-team-right">
                            <div class="hc-team-info text-right">
                                <div class="hc-team-name {{ $winB ? 'winner' : '' }}">{{ $nameB }}</div>
                                @if($winB)
                                    <span class="hc-win-badge">MENANG</span>
                                @endif
                            </div>
                            <div class="jc-team-badge" style="background-color: {{ $colorB }}">
                                {{ $initB }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="hc-footer">
                        <div class="hc-footer-left">
                            Box Score & Detail Pemain
                        </div>
                        <a href="{{ route('matches.show', $m->id_match) }}" class="btn-stat-dark">
                            Lihat Statistik Pertandingan <span class="hc-arrow">&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"/><path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"/>
                        </svg>
                    </div>
                    <p class="empty-txt">Belum ada hasil pertandingan</p>
                    <p class="empty-sub">Hasil skor akan ditampilkan secara real-time setelah laga berakhir.</p>
                </div>
            @endforelse
        </div>

        {{-- Load More Button --}}
        <div class="jadwal-load-more-wrap">
            <button type="button" class="btn-load-more" id="btn-load-more-hasil" onclick="handleLoadMoreHasil()">
                <span>Muat Lebih Banyak Hasil</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
let currentHasilTab = 'all';

function setHasilTab(type, btn) {
    document.querySelectorAll('#hasil-tabs .jtab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentHasilTab = type;
    applyHasilFilters();
}

function applyHasilFilters() {
    const phaseVal = document.getElementById('hasil-phase-select').value;
    const cards = document.querySelectorAll('.hasil-card');

    cards.forEach(card => {
        const fase = card.getAttribute('data-fase') || '';

        let matchTab = true;
        if (currentHasilTab === 'penyisihan') {
            matchTab = fase.toLowerCase().includes('penyisihan') || fase.toLowerCase().includes('grup');
        } else if (currentHasilTab === 'semifinal') {
            matchTab = fase.toLowerCase().includes('semifinal');
        } else if (currentHasilTab === 'final') {
            matchTab = fase.toLowerCase().includes('final');
        }

        let matchPhase = true;
        if (phaseVal !== 'all') {
            matchPhase = (fase === phaseVal);
        }

        if (matchTab && matchPhase) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function handleLoadMoreHasil() {
    const btn = document.getElementById('btn-load-more-hasil');
    btn.innerHTML = '<span>Semua Hasil Telah Ditampilkan</span>';
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';
}
</script>
@endpush

@extends('layouts.app')

@section('title', 'Jadwal Pertandingan — WikCup SMK Wikrama Bogor')
@section('meta_desc', 'Seluruh jadwal pertandingan turnamen basket SMK Wikrama Bogor. Pantau jadwal tim favorit, dukung jagoanmu, dan jangan lewatkan setiap laga serunya.')

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
                Jadwal <span class="c-orange">Pertandingan</span>
            </h1>

            {{-- Subtitle --}}
            <p class="jadwal-hero-desc">
                Seluruh jadwal pertandingan turnamen basket SMK Wikrama Bogor. Pantau jadwal tim favorit, dukung jagoanmu, dan jangan lewatkan setiap laga serunya.
            </p>
        </div>
    </div>
</section>

{{-- ========================================================
     2. CONTROLS & MATCH CARDS SECTION
     ======================================================== --}}
<section class="jadwal-main-sec">
    <div class="container">

        {{-- Filter & Status Bar --}}
        <div class="jadwal-controls-bar">
            {{-- Tabs --}}
            <div class="jadwal-tabs" id="jadwal-tabs">
                <button type="button" class="jtab-btn active" data-filter="all" onclick="setTabFilter('all', this)">
                    Semua
                </button>
                <button type="button" class="jtab-btn" data-filter="mendatang" onclick="setTabFilter('mendatang', this)">
                    Mendatang
                </button>
                <button type="button" class="jtab-btn" data-filter="hari-ini" onclick="setTabFilter('hari-ini', this)">
                    Hari Ini
                </button>
            </div>

            {{-- Right Meta & Dropdown --}}
            <div class="jadwal-controls-right">
                <span class="jadwal-count-info">
                    Menampilkan: <strong id="count-text">{{ $totalFound }} Jadwal Ditemukan</strong>
                </span>

                <div class="jadwal-dropdown-wrap">
                    <select class="jadwal-phase-select" id="phase-select" onchange="applyFilters()">
                        <option value="all">Fase Grup & Penyisihan</option>
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

        {{-- Grid of Match Cards --}}
        <div class="jadwal-grid" id="jadwal-grid">
            @forelse($matches as $m)
                @php
                    $initA = $m->teamA->singkatan ?? ava_init($m->teamA->nama_tim ?? 'SH');
                    $initB = $m->teamB->singkatan ?? ava_init($m->teamB->nama_tim ?? 'SW');
                    $colorA = $m->teamA->warna ?? '#0F172A';
                    $colorB = $m->teamB->warna ?? '#0F172A';
                    $subA = $m->teamA->nickname ?? 'Hawks';
                    $subB = $m->teamB->nickname ?? 'Warriors';
                    $isCompleted = $m->skor_tim_a !== null;
                    $isToday = \Carbon\Carbon::parse($m->tanggal)->isToday();
                @endphp
                <div class="jadwal-card"
                     data-status="{{ $isCompleted ? 'selesai' : 'mendatang' }}"
                     data-is-today="{{ $isToday ? '1' : '0' }}"
                     data-fase="{{ $m->fase ?? 'Fase Grup & Penyisihan' }}">
                    
                    {{-- Card Top Row --}}
                    <div class="jc-top">
                        <span class="jc-status-badge">
                            Mendatang
                        </span>
                        <span class="jc-datetime">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($m->tanggal)->translatedFormat('d F Y') }} &bull; {{ substr($m->jam, 0, 5) }} WIB
                        </span>
                    </div>

                    {{-- Card Center Matchup --}}
                    <div class="jc-matchup">
                        {{-- Team A --}}
                        <div class="jc-team">
                            <div class="jc-team-badge" style="background-color: {{ $colorA }}">
                                {{ $initA }}
                            </div>
                            <div class="jc-team-name">{{ $m->teamA->nama_tim ?? '-' }}</div>
                            <div class="jc-team-sub">{{ $subA }}</div>
                        </div>

                        {{-- VS Badge --}}
                        <div class="jc-vs-badge">
                            VS
                        </div>

                        {{-- Team B --}}
                        <div class="jc-team">
                            <div class="jc-team-badge" style="background-color: {{ $colorB }}">
                                {{ $initB }}
                            </div>
                            <div class="jc-team-name">{{ $m->teamB->nama_tim ?? '-' }}</div>
                            <div class="jc-team-sub">{{ $subB }}</div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="jc-footer">
                        <div class="jc-location">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>{{ $m->lokasi ?? 'Lapangan Utama SMK Wikrama' }}</span>
                        </div>
                        <a href="{{ route('matches.show', $m->id_match) }}" class="jc-detail-link">
                            Detail Pertandingan <span class="jc-arrow">&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <p class="empty-txt">Tidak ada jadwal pertandingan ditemukan</p>
                    <p class="empty-sub">Jadwal baru akan segera diumumkan oleh panitia turnamen.</p>
                </div>
            @endforelse
        </div>

        {{-- Load More Button --}}
        <div class="jadwal-load-more-wrap">
            <button type="button" class="btn-load-more" id="btn-load-more" onclick="handleLoadMore()">
                <span>Muat Lebih Banyak Jadwal</span>
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
let currentFilter = 'all';

function setTabFilter(type, btn) {
    document.querySelectorAll('#jadwal-tabs .jtab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentFilter = type;
    applyFilters();
}

function applyFilters() {
    const phaseVal = document.getElementById('phase-select').value;
    const cards = document.querySelectorAll('.jadwal-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const status = card.getAttribute('data-status');
        const isToday = card.getAttribute('data-is-today') === '1';
        const fase = card.getAttribute('data-fase');

        let matchTab = true;
        if (currentFilter === 'mendatang') {
            matchTab = (status === 'mendatang');
        } else if (currentFilter === 'hari-ini') {
            matchTab = isToday;
        }

        let matchPhase = true;
        if (phaseVal !== 'all') {
            matchPhase = (fase === phaseVal);
        }

        if (matchTab && matchPhase) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countText = document.getElementById('count-text');
    if (countText) {
        countText.textContent = `${visibleCount} Jadwal Ditemukan`;
    }
}

function handleLoadMore() {
    const btn = document.getElementById('btn-load-more');
    btn.innerHTML = '<span>Semua Jadwal Telah Dimuat</span>';
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';
}
</script>
@endpush

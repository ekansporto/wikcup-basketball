@extends('layouts.app')

@section('title', 'Tim & Pemain — WikCup Basketball SMK Wikrama Bogor')
@section('meta_desc', 'Daftar tim basket resmi yang bertanding di Wikrama Cup Basketball. Pantau roster lengkap, profil tim, dan statistik pemain resmi di setiap pertandingan.')

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
                Tim & <span class="c-orange">Pemain</span>
            </h1>

            {{-- Subtitle --}}
            <p class="jadwal-hero-desc">
                Daftar tim basket resmi yang bertanding di Wikrama Cup Basketball. Pantau roster lengkap, profil tim, dan statistik pemain resmi di setiap pertandingan.
            </p>
        </div>
    </div>
</section>

{{-- ========================================================
     2. CONTROLS & TEAMS GRID SECTION
     ======================================================== --}}
<section class="jadwal-main-sec">
    <div class="container">

        {{-- Filter & Search Bar --}}
        <div class="jadwal-controls-bar">
            {{-- Left Tabs --}}
            <div class="jadwal-tabs" id="team-tabs">
                <button type="button" class="jtab-btn active" data-filter="all" onclick="filterTeamCategory('all', this)">
                    Semua Tim ({{ $totalAll }})
                </button>
                <button type="button" class="jtab-btn" data-filter="putra" onclick="filterTeamCategory('putra', this)">
                    Kategori Putra
                </button>
                <button type="button" class="jtab-btn" data-filter="putri" onclick="filterTeamCategory('putri', this)">
                    Kategori Putri
                </button>
            </div>

            {{-- Right Search & Phase Dropdown --}}
            <div class="jadwal-controls-right">
                {{-- Search Input --}}
                <div class="team-search-wrap">
                    <svg class="team-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="team-search-inp" class="team-search-inp" placeholder="Cari nama tim atau sekolah..." oninput="filterTeamSearch(this.value)">
                </div>

                {{-- Phase Dropdown --}}
                <div class="jadwal-dropdown-wrap">
                    <select class="jadwal-phase-select" id="team-phase-select">
                        <option value="all">Fase: Penyisihan & Grup</option>
                        <option value="semifinal">Fase: Semifinal</option>
                        <option value="final">Fase: Final</option>
                    </select>
                    <svg class="jadwal-dropdown-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Grid of Team Cards (3 Columns) --}}
        <div class="team-grid" id="team-grid">
            @forelse($teams as $t)
                @php
                    $init = $t->singkatan ?? ava_init($t->nama_tim ?? 'TM');
                    $fullName = trim(($t->nama_tim ?? 'Tim') . ($t->nickname ? ' ' . $t->nickname : ''));
                    $isSmp = str_contains(strtolower($t->nama_tim), 'smp');
                    $bgColor = $t->warna ?? ($isSmp ? '#F1F5F9' : '#0F172A');
                    $textColor = $isSmp ? '#334155' : '#FFFFFF';
                    $playerCount = $t->players_count ?? $t->players->count();
                @endphp
                <div class="team-card" data-kategori="{{ strtolower($t->kategori ?? 'putra') }}" data-name="{{ strtolower($fullName) }}">
                    
                    {{-- Card Top Row --}}
                    <div class="tc-top">
                        {{-- Avatar Badge --}}
                        <div class="tc-badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            {{ $init }}
                        </div>

                        {{-- Name & Count --}}
                        <div class="tc-meta">
                            <h3 class="tc-name">{{ $fullName }}</h3>
                            @if($playerCount > 0)
                                <span class="tc-count-badge">
                                    <span class="tc-count-dot"></span>
                                    {{ $playerCount }} Pemain
                                </span>
                            @else
                                <span class="tc-count-badge tc-count-empty">
                                    <span class="tc-count-dot tc-dot-gray"></span>
                                    0 Pemain (Roster Baru)
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="tc-footer">
                        <span class="tc-footer-sub">Roster & Profil</span>
                        <a href="{{ route('teams.show', $t->id_team) }}" class="btn-team-dark">
                            Lihat Tim
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <p class="empty-txt">Tidak ada tim yang cocok dengan pencarian</p>
                    <p class="empty-sub">Silakan gunakan kata kunci pencarian lain atau pilih tab kategori lain.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
let currentCategory = 'all';

function filterTeamCategory(cat, btn) {
    document.querySelectorAll('#team-tabs .jtab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentCategory = cat;
    applyTeamFilters();
}

function filterTeamSearch(val) {
    applyTeamFilters();
}

function applyTeamFilters() {
    const searchVal = document.getElementById('team-search-inp').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.team-card');

    cards.forEach(card => {
        const cat = card.getAttribute('data-kategori') || 'putra';
        const name = card.getAttribute('data-name') || '';

        let matchCat = (currentCategory === 'all' || cat === currentCategory);
        let matchSearch = (searchVal === '' || name.includes(searchVal));

        if (matchCat && matchSearch) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush

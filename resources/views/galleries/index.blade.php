@extends('layouts.app')

@section('title', 'Galeri Pertandingan — WikCup Basketball SMK Wikrama Bogor')
@section('meta_desc', 'Momen aksi dan dokumentasi seru dari gelaran Wikrama Cup Basketball SMK Wikrama Bogor.')

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
                DOKUMENTASI RESMI TURNAMEN
            </div>

            {{-- Title --}}
            <h1 class="jadwal-hero-title">
                Galeri <span class="c-orange">Pertandingan</span>
            </h1>

            {{-- Subtitle --}}
            <p class="jadwal-hero-desc">
                Momen aksi dan dokumentasi seru dari gelaran Wikrama Cup Basketball
            </p>
        </div>
    </div>
</section>

{{-- ========================================================
     2. GALLERY CATEGORY TABS & GRID SECTION
     ======================================================== --}}
<section class="jadwal-main-sec">
    <div class="container">

        {{-- Filter Tabs Bar --}}
        <div class="gallery-controls-bar">
            <div class="gallery-tabs" id="gallery-tabs">
                <button type="button" class="gtab-btn active" data-filter="all" onclick="filterGalleryCategory('all', this)">
                    Semua Foto
                </button>
                <button type="button" class="gtab-btn" data-filter="Pertandingan" onclick="filterGalleryCategory('Pertandingan', this)">
                    Pertandingan
                </button>
                <button type="button" class="gtab-btn" data-filter="Selebrasi" onclick="filterGalleryCategory('Selebrasi', this)">
                    Selebrasi
                </button>
                <button type="button" class="gtab-btn" data-filter="Suporter & Pembukaan" onclick="filterGalleryCategory('Suporter & Pembukaan', this)">
                    Suporter & Pembukaan
                </button>
                <button type="button" class="gtab-btn" data-filter="Awarding" onclick="filterGalleryCategory('Awarding', this)">
                    Awarding
                </button>
            </div>
        </div>

        {{-- Grid of Gallery Cards (3 Columns) --}}
        <div class="gallery-grid" id="gallery-grid">
            @forelse($galleries as $g)
                @php
                    $isEvent = str_contains(strtolower($g->tag_text ?? ''), 'event');
                @endphp
                <div class="gallery-card" data-category="{{ $g->kategori }}">
                    
                    {{-- Image Container with Badge Overlay --}}
                    <div class="gc-img-wrap">
                        <img src="{{ $g->foto }}" alt="{{ $g->caption }}" class="gc-img" loading="lazy">
                        @if(!empty($g->badge_text))
                            <span class="gc-badge-overlay">{{ $g->badge_text }}</span>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="gc-body">
                        <h3 class="gc-caption">{{ $g->caption }}</h3>
                        
                        <div class="gc-footer">
                            <span class="gc-date">{{ \Carbon\Carbon::parse($g->tanggal)->translatedFormat('d F Y') }}</span>
                            @if(!empty($g->tag_text))
                                @if($isEvent)
                                    <span class="gc-tag-event">{{ $g->tag_text }}</span>
                                @else
                                    <span class="gc-tag-orange">
                                        <span class="gc-tag-dot"></span>
                                        {{ $g->tag_text }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1">
                    <div class="empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                    <p class="empty-txt">Belum ada foto dokumentasi untuk kategori ini</p>
                    <p class="empty-sub">Dokumentasi foto akan diperbarui secara berkala oleh panitia turnamen.</p>
                </div>
            @endforelse
        </div>

        {{-- Load More Button --}}
        <div class="jadwal-load-more-wrap">
            <button type="button" class="btn-load-more" id="btn-load-more-gallery" onclick="handleLoadMoreGallery()">
                <span>Muat Lebih Banyak Foto</span>
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
let currentGalleryFilter = 'all';

function filterGalleryCategory(cat, btn) {
    document.querySelectorAll('#gallery-tabs .gtab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentGalleryFilter = cat;
    applyGalleryFilter();
}

function applyGalleryFilter() {
    const cards = document.querySelectorAll('.gallery-card');

    cards.forEach(card => {
        const cat = card.getAttribute('data-category') || '';

        if (currentGalleryFilter === 'all' || cat === currentGalleryFilter) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function handleLoadMoreGallery() {
    const btn = document.getElementById('btn-load-more-gallery');
    btn.innerHTML = '<span>Semua Foto Telah Dimuat</span>';
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';
}
</script>
@endpush

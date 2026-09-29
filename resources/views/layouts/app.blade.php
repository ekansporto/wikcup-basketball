<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_desc', 'Portal resmi WikCup 2026 — Jadwal, hasil, statistik, dan profil pemain turnamen basket SMK Wikrama Bogor.')">
    <title>@yield('title', 'WikCup Basketball — SMK Wikrama Bogor')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="@yield('body_class','')">

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="nav-brand">
            <img src="{{ asset('images/logo.png') }}" alt="WikCup Logo" class="nav-brand-img">
            <div class="nav-brand-text">
                <span class="nav-brand-tag">OFFICIAL TOURNAMENT</span>
                <span class="nav-brand-sub">SMK WIKRAMA BOGOR</span>
            </div>
        </a>

        {{-- Nav links --}}
        <ul class="nav-links">
            <li><a href="{{ route('home') }}"             class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('matches.index') }}"    class="nav-link {{ request()->routeIs('matches.index') ? 'active' : '' }}">Jadwal</a></li>
            <li><a href="{{ route('matches.hasil') }}"    class="nav-link {{ request()->routeIs('matches.hasil') ? 'active' : '' }}">Hasil</a></li>
            <li><a href="{{ route('teams.index') }}"      class="nav-link {{ request()->routeIs('teams.*')||request()->routeIs('players.*') ? 'active' : '' }}">Tim & Pemain</a></li>
            <li><a href="{{ route('statistics.index') }}" class="nav-link {{ request()->routeIs('statistics.*') ? 'active' : '' }}">Statistik</a></li>
            <li><a href="{{ route('galleries.index') }}"  class="nav-link {{ request()->routeIs('galleries.*')  ? 'active' : '' }}">Galeri</a></li>
        </ul>

        {{-- Auth --}}
        <div class="nav-actions">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-profile" style="background: rgba(249, 115, 22, 0.15); color: #EA580C; border: 1px solid rgba(249, 115, 22, 0.3);">
                        <span class="dot-online" style="background: #EA580C;"></span>
                        Dashboard Admin
                    </a>
                @else
                    <a href="#" class="btn-profile">
                        <span class="dot-online"></span>
                        Profil Saya
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Login
                </a>
            @endauth
        </div>

    </div>
</nav>

{{-- Flash --}}
@if(session('success'))
    <div class="flash flash-ok" id="flash-msg">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-err" id="flash-msg">{{ session('error') }}</div>
@endif

<main>@yield('content')</main>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="ft-brand-row">
                <img src="{{ asset('images/logo.png') }}" alt="WikCup Logo" class="ft-logo-img">
            </div>
            <p class="ft-desc">Turnamen bola basket antarkelas dan jurusan SMK Wikrama Bogor. Menyajikan aksi kompetitif, jadwal akurat, serta analisis statistik pemain turnamen.</p>
            <div class="ft-tags">
                <a href="{{ route('matches.index') }}" class="c-orange">MATCH</a>
                <span class="ft-sep">•</span>
                <a href="{{ route('players.index') }}" class="c-teal">PLAYER</a>
                <span class="ft-sep">•</span>
                <a href="{{ route('statistics.index') }}" class="c-white">STATISTICS</a>
            </div>
        </div>
        <div class="ft-col">
            <h4>Menu Utama</h4>
            <div class="ft-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('matches.index') }}">Jadwal Pertandingan</a>
                <a href="{{ route('matches.index') }}">Hasil Pertandingan</a>
                <a href="{{ route('teams.index') }}">Tim & Pemain</a>
                <a href="{{ route('statistics.index') }}">Statistik Pemain</a>
                <a href="{{ route('galleries.index') }}">Galeri Foto</a>
            </div>
        </div>
        <div class="ft-col">
            <h4>Lokasi Turnamen</h4>
            <p class="ft-loc-name">Lapangan Basket Utama SMK Wikrama Bogor</p>
            <p class="ft-loc-addr">Jl. Raya Wangun No. 246, Sindangsari, Bogor Timur</p>
            <a href="#" class="ft-loc-link">Official Wikrama Basketball Championship</a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© 2026 WIKCUP — Wikrama Cup Basketball. Dibuat untuk Pengembangan PPLG SMK Wikrama.</span>
        <span>Fokus pada Sportivitas & Data Statistik</span>
    </div>
</footer>

<script>
const f = document.getElementById('flash-msg');
if(f) setTimeout(()=>{f.style.transition='opacity .4s';f.style.opacity='0';setTimeout(()=>f.remove(),400);}, 3500);
</script>
@stack('scripts')
</body>
</html>

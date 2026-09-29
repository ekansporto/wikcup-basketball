<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin WikCup 2026 — Panel Kontrol Turnamen Bola Basket SMK Wikrama Bogor.">
    <title>@yield('title', 'WikCup Admin — Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root {
            --admin-sidebar-bg: #0B1120;
            --admin-sidebar-border: #1E293B;
            --admin-body-bg: #F8FAFC;
            --admin-card-bg: #FFFFFF;
            --admin-orange: #F97316;
            --admin-orange-hover: #EA580C;
            --admin-text-main: #0F172A;
            --admin-text-muted: #64748B;
        }

        body.admin-body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--admin-body-bg);
            color: var(--admin-text-main);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Container */
        .admin-sidebar {
            width: 260px;
            background-color: var(--admin-sidebar-bg);
            color: #94A3B8;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            padding: 24px 16px;
            box-sizing: border-box;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        /* Brand / Logo */
        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            padding: 0 8px 24px;
        }

        .admin-brand-img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .admin-brand-text {
            display: flex;
            flex-direction: column;
        }

        .admin-brand-title {
            color: #FFFFFF;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.05em;
            line-height: 1.2;
        }

        .admin-brand-sub {
            color: #F97316;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Nav List */
        .admin-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-grow: 1;
        }

        .admin-nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: #94A3B8;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .admin-nav-item a:hover {
            color: #FFFFFF;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .admin-nav-item.active a {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            color: #FFFFFF;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
        }

        .admin-nav-item a svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            stroke-width: 2;
        }

        /* User Profile Box */
        .admin-profile-box {
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 12px;
            margin-top: 16px;
        }

        .admin-profile-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            color: #FFFFFF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
        }

        .admin-user-details {
            overflow: hidden;
        }

        .admin-user-name {
            color: #FFFFFF;
            font-weight: 700;
            font-size: 13px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            line-height: 1.2;
        }

        .admin-user-role {
            color: #64748B;
            font-size: 11px;
            font-weight: 500;
            margin-top: 2px;
        }

        .admin-profile-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 10px;
            font-size: 12px;
        }

        .admin-link-web {
            color: #94A3B8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s;
        }

        .admin-link-web:hover {
            color: #FFFFFF;
        }

        .admin-btn-logout {
            background: none;
            border: none;
            color: #F87171;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
        }

        .admin-btn-logout:hover {
            color: #EF4444;
            text-decoration: underline;
        }

        /* Main Content Container */
        .admin-main-wrapper {
            margin-left: 260px;
            flex-grow: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--admin-body-bg);
        }

        .admin-content-inner {
            padding: 32px 40px;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
            flex-grow: 1;
        }

        /* Top Header */
        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .admin-header-left h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--admin-text-main);
            margin: 0 0 4px;
            letter-spacing: -0.02em;
        }

        .admin-header-left p {
            font-size: 13px;
            color: var(--admin-text-muted);
            margin: 0;
        }

        .btn-visit-public {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }

        .btn-visit-public:hover {
            background-color: #F1F5F9;
            border-color: #CBD5E1;
            color: #0F172A;
        }

        /* Footer */
        .admin-footer {
            padding: 24px 40px;
            text-align: center;
            font-size: 12px;
            color: #94A3B8;
            border-top: 1px solid #E2E8F0;
            background-color: #FFFFFF;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .admin-main-wrapper {
                margin-left: 0;
            }
            .admin-content-inner {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('admin-styles')
</head>
<body class="admin-body">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div>
            {{-- Logo --}}
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo.png') }}" alt="WikCup Logo" class="admin-brand-img">
                <div class="admin-brand-text">
                    <span class="admin-brand-title">WIKCUP ADMIN</span>
                    <span class="admin-brand-sub">TURNAMEN BASKET</span>
                </div>
            </a>

            {{-- Navigation Menu --}}
            <ul class="admin-nav">
                <li class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Dashboard
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->routeIs('admin.teams.*') || request()->routeIs('teams.*') ? 'active' : '' }}">
                    <a href="{{ route('teams.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Tim
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->routeIs('admin.matches.*') || request()->routeIs('matches.*') ? 'active' : '' }}">
                    <a href="{{ route('matches.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Jadwal & Hasil
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->routeIs('admin.statistics.*') || request()->routeIs('statistics.*') ? 'active' : '' }}">
                    <a href="{{ route('statistics.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Statistik
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->routeIs('admin.galleries.*') || request()->routeIs('galleries.*') ? 'active' : '' }}">
                    <a href="{{ route('galleries.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Galeri
                    </a>
                </li>
            </ul>
        </div>

        {{-- User Profile Card --}}
        <div class="admin-profile-box">
            <div class="admin-profile-info">
                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="admin-user-details">
                    <div class="admin-user-name">{{ Auth::user()->name ?? 'Admin Panitia WikCup' }}</div>
                    <div class="admin-user-role">{{ Auth::user()->role === 'admin' ? 'Admin Panitia' : ucfirst(Auth::user()->role ?? 'Admin') }}</div>
                </div>
            </div>
            <div class="admin-profile-actions">
                <a href="{{ route('home') }}" class="admin-link-web">
                    Lihat Web
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="admin-btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="admin-main-wrapper">
        <main class="admin-content-inner">
            {{-- Top Header --}}
            <div class="admin-header">
                <div class="admin-header-left">
                    <h1>@yield('header_title', 'Ringkasan Turnamen')</h1>
                    <p>@yield('header_sub', 'Panel kontrol & pembaruan data real-time Wikrama Basketball Cup')</p>
                </div>
                <div class="admin-header-right">
                    <a href="{{ route('home') }}" class="btn-visit-public">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        Buka Website Publik
                    </a>
                </div>
            </div>

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="admin-footer">
            © 2026 Turnamen Basket WIKCUP • SMK Wikrama Bogor. Hak cipta dilindungi.
        </footer>
    </div>

    @stack('admin-scripts')
</body>
</html>

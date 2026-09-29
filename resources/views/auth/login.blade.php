@extends('layouts.app')

@section('title', 'Login — WikCup Basketball')
@section('body_class', 'auth-bg')

@section('content')
<div class="auth-page-wrap">
<div class="auth-grid">

    {{-- ===== LEFT: Info Panel ===== --}}
    <div class="auth-info-side">

        <div class="auth-lbl">
            <span class="auth-lbl-dot"></span>
            Portal Resmi Wikrama Cup 2026
        </div>

        <h1 class="auth-info-title">
            Akses & Kelola Portal<br>
            <span class="c-orange">Turnamen</span> <span class="c-teal">Basket</span>
        </h1>

        <p class="auth-info-desc">
            Pusat kendali operasional kejuaraan bola basket SMK Wikrama.
            Masuk untuk mengelola data roster pemain antarkelas, jadwal tanding,
            dan update statistik pertandingan real-time.
        </p>

        {{-- Mini cards --}}
        <div class="auth-mini-grid">
            <div class="auth-mini">
                <div class="auth-mini-ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--orange)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="auth-mini-ttl">Official Roster</div>
                <div class="auth-mini-sub">9+ Tim</div>
            </div>
            <div class="auth-mini">
                <div class="auth-mini-ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                </div>
                <div class="auth-mini-ttl">Live Statistics</div>
                <div class="auth-mini-sub">PTS, REB, AST, EFF</div>
            </div>
            <div class="auth-mini">
                <div class="auth-mini-ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"/><path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"/></svg>
                </div>
                <div class="auth-mini-ttl">Standings 2026</div>
                <div class="auth-mini-sub">Klasemen & Bracket</div>
            </div>
        </div>

        {{-- Note --}}
        <div class="auth-note">
            <span style="display:inline-flex;align-items:center;color:var(--orange)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <span>Terhubung langsung dengan server pencatatan statistik panitia resmi Wikrama Basketball Championship.</span>
        </div>

    </div>

    {{-- ===== RIGHT: Form Panel ===== --}}
    <div class="auth-form-side">
        <div class="form-card">

            <div class="fc-ico">
                <img src="{{ asset('images/logo.png') }}" alt="WikCup Logo" class="fc-logo-img">
            </div>
            <h2 class="fc-title">Login ke <span class="acc">WIKCUP</span></h2>
            <p class="fc-sub">Masuk untuk mengelola profil pemain atau dashboard turnamen</p>

            <form action="{{ route('login.post') }}" method="POST" id="form-login" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-grp">
                    <label for="login-email">Email</label>
                    <input
                        type="email"
                        id="login-email"
                        name="email"
                        class="form-inp {{ $errors->has('email') ? 'err' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="nama@wikcup.id"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <p class="err-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-grp">
                    <div class="lbl-row">
                        <label for="login-password">Password</label>
                        <a href="#" class="lbl-link">Lupa Password?</a>
                    </div>
                    <div class="inp-wrap">
                        <input
                            type="password"
                            id="login-password"
                            name="password"
                            class="form-inp {{ $errors->has('password') ? 'err' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="btn-eye" onclick="togglePw('login-password',this)" id="btn-toggle-pw" aria-label="Toggle Password">
                            <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide" style="display:none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="err-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + SSL --}}
                <div class="form-row-chk">
                    <label class="chk-lbl">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        Ingat Saya
                    </label>
                    <div class="ssl-badge">
                        <span class="ssl-dot"></span>
                        SSL Terenkripsi
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="btn-masuk">
                    Masuk Sekarang →
                </button>
            </form>

            <p class="form-bottom">
                Belum punya akun pemain?
                <a href="{{ route('register') }}" id="link-daftar">Daftar sebagai Pemain</a>
            </p>

        </div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
function togglePw(id, btn) {
    const f = document.getElementById(id);
    const showIco = btn.querySelector('.eye-show');
    const hideIco = btn.querySelector('.eye-hide');
    if (f.type === 'password') {
        f.type = 'text';
        if (showIco && hideIco) { showIco.style.display = 'none'; hideIco.style.display = 'inline-block'; }
    } else {
        f.type = 'password';
        if (showIco && hideIco) { showIco.style.display = 'inline-block'; hideIco.style.display = 'none'; }
    }
}
</script>
@endpush

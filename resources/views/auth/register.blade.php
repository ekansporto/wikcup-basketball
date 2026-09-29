@extends('layouts.app')

@section('title', 'Registrasi Pemain — WikCup Basketball')
@section('body_class', 'auth-bg')

@section('content')
<div class="auth-page-wrap">
<div class="auth-grid">

    {{-- ===== LEFT: Info Panel (sama seperti login) ===== --}}
    <div class="auth-info-side">

        <div class="auth-lbl">
            <span class="auth-lbl-dot"></span>
            Pendaftaran Resmi Pemain WikCup 2026
        </div>

        <h2 class="auth-info-title">
            Daftarkan Dirimu & Raih<br>
            Prestasi di <span class="c-orange">Wikrama Cup</span>
        </h2>

        <p class="auth-info-desc">
            Daftarkan akun pemain untuk mencatat profil atlet, rekap statistik
            pertandingan individu, dan pantau performa bersama tim terbaik
            SMK Wikrama Bogor.
        </p>

        {{-- Feature cards --}}
        <div class="auth-features">
            <div class="auth-feat">
                <div class="auth-feat-ico">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--orange)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <h5>Profil & Jersey Eksklusif</h5>
                    <p>Nomor punggung, posisi bermain, dan foto tim resmi turnamen.</p>
                </div>
            </div>
            <div class="auth-feat">
                <div class="auth-feat-ico">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                </div>
                <div>
                    <h5>Tracking Statistik Lengkap</h5>
                    <p>Data poin, assist, rebound, dan akurasi tembakan real-time.</p>
                </div>
            </div>
            <div class="auth-feat">
                <div class="auth-feat-ico">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <h5>Verifikasi Cepat & Aman</h5>
                    <p>Terdaftar resmi di bawah panitia Wikrama Basketball Championship.</p>
                </div>
            </div>
        </div>

        <div class="auth-verified">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>Data pemain diverifikasi untuk validitas pertandingan resmi.</span>
        </div>

    </div>

    {{-- ===== RIGHT: Form Panel ===== --}}
    <div class="auth-form-side">
        <div class="form-card">

            <div class="fc-ico">
                <img src="{{ asset('images/logo.png') }}" alt="WikCup Logo" class="fc-logo-img">
            </div>
            <h2 class="fc-title">Registrasi <span class="acc">Pemain</span></h2>
            <p class="fc-sub">Daftarkan akun untuk mencatat profil dan statistik turnamen</p>

            <form action="{{ route('register.post') }}" method="POST" id="form-register" novalidate>
                @csrf

                {{-- Nama Lengkap --}}
                <div class="form-grp">
                    <label for="reg-name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="reg-name"
                        name="name"
                        class="form-inp {{ $errors->has('name') ? 'err' : '' }}"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Rizky Pratama"
                        autocomplete="name"
                        required
                    >
                    @error('name')
                        <p class="err-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-grp">
                    <label for="reg-email">Email</label>
                    <input
                        type="email"
                        id="reg-email"
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
                    <label for="reg-password">Password</label>
                    <div class="inp-wrap">
                        <input
                            type="password"
                            id="reg-password"
                            name="password"
                            class="form-inp {{ $errors->has('password') ? 'err' : '' }}"
                            placeholder="Minimal 6 karakter"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="btn-eye" onclick="togglePw('reg-password',this)" aria-label="Toggle Password">
                            <svg class="eye-show" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide" style="display:none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="err-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-grp">
                    <label for="reg-password-confirm">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="reg-password-confirm"
                        name="password_confirmation"
                        class="form-inp"
                        placeholder="Ulangi password Anda"
                        autocomplete="new-password"
                        required
                    >
                </div>

                {{-- Info box --}}
                <div class="info-box-blue">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:2px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Akun yang didaftarkan otomatis berstatus sebagai <strong>Pemain</strong>.</span>
                </div>

                <button type="submit" class="btn-submit" id="btn-daftar">
                    Daftar Akun Pemain →
                </button>
            </form>

            <p class="form-bottom">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" id="link-login">Login Sekarang</a>
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

@extends('layouts.app')

@section('title', 'Daftar - BMKG WeatherLive')

@section('styles')
<style>
.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0d47a1 0%, #1565c0 50%, #1976d2 100%);
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.auth-page::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -15%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    border-radius: 50%;
}

.auth-page .cloud-icon {
    position: absolute;
    font-size: 120px;
    opacity: 0.04;
    animation: authCloud 25s linear infinite;
}

.auth-page .cloud-icon:nth-child(1) { top: 10%; left: -100px; }
.auth-page .cloud-icon:nth-child(2) { top: 60%; left: -80px; font-size: 80px; animation-duration: 30s; animation-delay: -10s; }

@keyframes authCloud {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(100vw + 200px)); }
}

.auth-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    position: relative;
    z-index: 1;
}

.dark .auth-card {
    background: rgba(15,23,42,0.95);
    border: 1px solid rgba(255,255,255,0.06);
}

.auth-card .auth-header { text-align: center; margin-bottom: 28px; }
.auth-card .auth-logo {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    margin: 0 auto 16px;
    box-shadow: 0 4px 16px rgba(26,115,232,0.3);
}

.auth-card .auth-header h1 { font-size: 22px; font-weight: 700; color: #1f2937; }
.dark .auth-card .auth-header h1 { color: #f1f5f9; }
.auth-card .auth-header p { font-size: 14px; color: #6b7280; margin-top: 4px; }

.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #374151; }
.dark .form-group label { color: #e5e7eb; }
.form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-size: 14px;
    background: #f9fafb;
    color: #1f2937;
    transition: all 0.3s;
    outline: none;
}

.dark .form-group input {
    background: #1e293b;
    border-color: #334155;
    color: #f1f5f9;
}

.form-group input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 4px rgba(26,115,232,0.1);
    background: white;
}

.btn-auth {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 4px;
}

.btn-auth:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,115,232,0.3); }
.btn-auth:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

.auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: #6b7280; }
.auth-footer a { color: #1a73e8; text-decoration: none; font-weight: 600; }
.auth-footer a:hover { text-decoration: underline; }

.msg-box {
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 16px;
}

.msg-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
.msg-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <span class="cloud-icon">☁️</span>
    <span class="cloud-icon">⛅</span>

    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo"><i class="fas fa-cloud-sun"></i></div>
            <h1>Daftar Akun Baru</h1>
            <p>Bergabung dengan WeatherLive BMKG</p>
        </div>

        <div id="register-app">
            <div v-if="registerError" class="msg-box msg-error">
                <i class="fas fa-exclamation-circle"></i> <span v-text="registerError"></span>
            </div>
            <div v-if="registerSuccess" class="msg-box msg-success">
                <i class="fas fa-check-circle"></i> <span v-text="registerSuccess"></span>
            </div>

            <form @submit.prevent="handleRegister">
                <div class="form-group">
                    <label><i class="fas fa-user" style="margin-right:6px;"></i>Nama Lengkap</label>
                    <input type="text" v-model="form.name" placeholder="Nama Anda" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope" style="margin-right:6px;"></i>Email</label>
                    <input type="email" v-model="form.email" placeholder="email@anda.com" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone" style="margin-right:6px;"></i>Nomor Telepon</label>
                    <input type="tel" v-model="form.phone" placeholder="081234567890">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock" style="margin-right:6px;"></i>Password</label>
                    <input type="password" v-model="form.password" placeholder="Minimal 8 karakter" minlength="8" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock" style="margin-right:6px;"></i>Konfirmasi Password</label>
                    <input type="password" v-model="form.password_confirmation" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="btn-auth" :disabled="loading">
                    <span v-if="loading" class="inline-block w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span v-else><i class="fas fa-user-plus"></i> Daftar</span>
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                <div style="margin-top:10px;font-size:13px;">
                    🏠 <a href="{{ route('dashboard') }}">Kembali ke Dashboard Publik</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const { createApp, ref } = Vue;

createApp({
    setup() {
        const form = ref({ name: '', email: '', phone: '', password: '', password_confirmation: '' });
        const registerError = ref('');
        const registerSuccess = ref('');
        const loading = ref(false);

        const handleRegister = async () => {
            registerError.value = '';
            registerSuccess.value = '';

            if (form.value.password !== form.value.password_confirmation) {
                registerError.value = 'Password dan konfirmasi tidak cocok.';
                return;
            }

            loading.value = true;

            try {
                const res = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(form.value)
                });

                const data = await res.json();

                if (data.success) {
                    registerSuccess.value = 'Registrasi berhasil! Mengalihkan...';
                    localStorage.setItem('access_token', data.token);
                    setTimeout(() => window.location.href = '/dashboard', 1500);
                } else {
                    registerError.value = Object.values(data).flat().join(', ') || 'Registrasi gagal';
                }
            } catch (e) {
                registerError.value = 'Terjadi kesalahan. Silakan coba lagi.';
            } finally {
                loading.value = false;
            }
        };

        return { form, registerError, registerSuccess, loading, handleRegister };
    }
}).mount('#register-app');
</script>
@endpush

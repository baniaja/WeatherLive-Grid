@extends('layouts.app')

@section('title', 'Masuk ke Sistem — BMKG WeatherLive')

@section('styles')
<style>
* { margin:0; padding:0; box-sizing:border-box; }
.auth-page {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 20px 60px;
    position: relative;
    overflow: hidden;
}

.auth-card {
    background: rgba(10, 20, 42, 0.88);
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    border: 1px solid rgba(56, 189, 248, 0.18);
    border-radius: 28px;
    padding: 36px;
    width: 100%;
    max-width: 460px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.55), 0 0 35px rgba(56,189,248,0.15);
    position: relative;
    z-index: 10;
    transition: all 0.35s ease;
}

.auth-card.admin-mode {
    border-color: rgba(0, 255, 231, 0.35);
    box-shadow: 0 25px 70px rgba(0,0,0,0.65), 0 0 45px rgba(0, 255, 231, 0.2);
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #0284c7, #38bdf8, #818cf8);
    border-radius: 28px 28px 0 0;
}

.auth-card.admin-mode::before {
    background: linear-gradient(90deg, #f59e0b, #00ffe7, #0284c7, #10b981);
}

.auth-header {
    text-align: center;
    margin-bottom: 24px;
}

.auth-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #0284c7, #2563eb);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: white;
    margin: 0 auto 14px;
    box-shadow: 0 8px 24px rgba(2, 132, 199, 0.45);
    transition: all 0.3s;
}

.auth-card.admin-mode .auth-logo {
    background: linear-gradient(135deg, #0f766e, #0284c7);
    box-shadow: 0 8px 24px rgba(0, 255, 231, 0.35);
}

.auth-header h1 {
    font-size: 22px;
    font-weight: 800;
    font-family: 'Space Grotesk', sans-serif;
    color: #f8fafc;
    letter-spacing: -0.02em;
}

.auth-header p {
    font-size: 13px;
    color: #94a3b8;
    margin-top: 4px;
}

/* Dual Role Switcher Tabs */
.role-tabs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 5px;
    margin-bottom: 24px;
    gap: 6px;
}

.role-tab {
    padding: 10px 14px;
    border-radius: 12px;
    border: none;
    background: transparent;
    color: #94a3b8;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.25s;
    font-family: inherit;
}

.role-tab.active {
    background: linear-gradient(135deg, rgba(2, 132, 199, 0.35), rgba(37, 99, 235, 0.25));
    color: #38bdf8;
    border: 1px solid rgba(56, 189, 248, 0.35);
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.25);
}

.role-tab.active.admin {
    background: linear-gradient(135deg, rgba(0, 255, 231, 0.25), rgba(2, 132, 199, 0.25));
    color: #00ffe7;
    border-color: rgba(0, 255, 231, 0.45);
    box-shadow: 0 4px 14px rgba(0, 255, 231, 0.2);
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    margin-bottom: 6px;
    color: #cbd5e1;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrap i.prefix-icon {
    position: absolute;
    left: 14px;
    color: #64748b;
    font-size: 14px;
}

.input-wrap input {
    width: 100%;
    padding: 12px 14px 12px 40px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.03);
    color: #f8fafc;
    transition: all 0.25s;
    outline: none;
    font-family: inherit;
}

.input-wrap input:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.18);
    background: rgba(255, 255, 255, 0.06);
}

.auth-card.admin-mode .input-wrap input:focus {
    border-color: #00ffe7;
    box-shadow: 0 0 0 3px rgba(0, 255, 231, 0.18);
}

.btn-auth {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #0284c7, #2563eb);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 6px 20px rgba(2, 132, 199, 0.35);
    font-family: inherit;
    margin-top: 8px;
}

.auth-card.admin-mode .btn-auth {
    background: linear-gradient(135deg, #0f766e, #0284c7);
    box-shadow: 0 6px 20px rgba(0, 255, 231, 0.25);
}

.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(2, 132, 199, 0.5);
}

.btn-auth:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.demo-box {
    margin-top: 18px;
    padding: 12px 14px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 12px;
    font-size: 12px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.demo-autofill-btn {
    background: rgba(56, 189, 248, 0.12);
    border: 1px solid rgba(56, 189, 248, 0.25);
    color: #38bdf8;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.demo-autofill-btn:hover {
    background: rgba(56, 189, 248, 0.25);
    color: #fff;
}

.error-msg {
    padding: 10px 14px;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.35);
    border-radius: 12px;
    font-size: 12.5px;
    color: #fca5a5;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #94a3b8;
}

.auth-footer a {
    color: #38bdf8;
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    text-decoration: underline;
}
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card" :class="{'admin-mode': selectedRole === 'admin'}" id="login-app" v-cloak>

        <!-- DUAL ROLE SWITCHER -->
        <div class="role-tabs">
            <button class="role-tab" :class="{active: selectedRole === 'user'}" @click="setRole('user')">
                <i class="fas fa-user"></i> Pengguna / Publik
            </button>
            <button class="role-tab admin" :class="{active: selectedRole === 'admin'}" @click="setRole('admin')">
                <i class="fas fa-shield-halved"></i> Administrator 2.0
            </button>
        </div>

        <div class="auth-header">
            <div class="auth-logo">
                <i :class="selectedRole === 'admin' ? 'fas fa-shield-halved' : 'fas fa-cloud-sun'"></i>
            </div>
            <h1 v-if="selectedRole === 'admin'">Login Administrator 2.0</h1>
            <h1 v-else>Login Akun Pengguna</h1>
            <p v-if="selectedRole === 'admin'">
                Akses Penuh Command Center 2.0 BMKG Jawa Barat
            </p>
            <p v-else>
                Sistem Informasi Cuaca & Personalisasi WeatherLive
            </p>
        </div>

        <div v-if="loginError" class="error-msg">
            <i class="fas fa-circle-exclamation"></i>
            <span v-text="loginError"></span>
        </div>

        <form @submit.prevent="handleLogin">
            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope prefix-icon"></i>
                    <input type="email" v-model="loginForm.email" :placeholder="selectedRole === 'admin' ? 'admin@weatherlive.id' : 'user@weatherlive.id'" required>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <div class="input-wrap">
                    <i class="fas fa-lock prefix-icon"></i>
                    <input :type="showPassword ? 'text' : 'password'" v-model="loginForm.password" placeholder="••••••••" required>
                    <button type="button" @click="showPassword = !showPassword" style="position:absolute;right:12px;background:none;border:none;color:#64748b;cursor:pointer;font-size:13px;">
                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-auth" :disabled="loginLoading">
                <span v-if="loginLoading"><i class="fas fa-spinner fa-spin"></i> Memproses Autentikasi...</span>
                <span v-else>
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    @{{ selectedRole === 'admin' ? 'Masuk ke Command Center 2.0' : 'Masuk ke WeatherLive' }}
                </span>
            </button>
        </form>

        <!-- DEMO AUTOFILL ASSISTANT -->
        <div class="demo-box" v-if="selectedRole === 'admin'">
            <div>
                <strong style="color:#00ffe7;">Akun Admin:</strong> admin@weatherlive.id / admin123
            </div>
            <button class="demo-autofill-btn" @click="fillAdminDemo">Isi Otomatis</button>
        </div>
        <div class="demo-box" v-else>
            <div>
                <strong style="color:#38bdf8;">Akun User:</strong> user@weatherlive.id / user1234
            </div>
            <button class="demo-autofill-btn" @click="fillUserDemo">Isi Otomatis</button>
        </div>

        <div class="auth-footer">
            <span v-if="selectedRole === 'user'">Belum punya akun? <a href="{{ route('register') }}">Daftar Baru</a></span>
            <span v-else>Portal internal Staf & Meteorolog Wilayah BMKG</span>
            <div style="margin-top:12px;font-size:12.5px;">
                <a href="{{ route('dashboard') }}"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard Publik</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const { createApp, ref, onMounted } = Vue;

createApp({
    setup() {
        const urlParams = new URLSearchParams(window.location.search);
        const initialRole = urlParams.get('role') === 'admin' || window.location.pathname.includes('admin') ? 'admin' : 'user';

        const selectedRole = ref(initialRole);
        const loginForm = ref({ email: '', password: '' });
        const loginError = ref('');
        const loginLoading = ref(false);
        const showPassword = ref(false);

        const setRole = (role) => {
            selectedRole.value = role;
            loginError.value = '';
            if (role === 'admin') {
                fillAdminDemo();
            } else {
                fillUserDemo();
            }
        };

        const fillAdminDemo = () => {
            loginForm.value.email = 'admin@weatherlive.id';
            loginForm.value.password = 'admin123';
        };

        const fillUserDemo = () => {
            loginForm.value.email = 'user@weatherlive.id';
            loginForm.value.password = 'user1234';
        };

        const handleLogin = async () => {
            loginError.value = '';
            loginLoading.value = true;

            try {
                const res = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(loginForm.value)
                });

                const data = await res.json();

                if (data.success && data.access_token) {
                    localStorage.setItem('access_token', data.access_token);
                    localStorage.setItem('user_name', data.user?.name || 'User');
                    localStorage.setItem('user_email', data.user?.email || '');
                    localStorage.setItem('user_role', data.user?.role?.name || (selectedRole.value === 'admin' ? 'Administrator' : 'Masyarakat'));

                    // Intelligent Redirection
                    if (selectedRole.value === 'admin' || data.user?.role?.name === 'Administrator') {
                        window.location.href = '/admin';
                    } else {
                        window.location.href = '/dashboard';
                    }
                } else {
                    loginError.value = data.message || 'Email atau kata sandi tidak valid.';
                }
            } catch (e) {
                loginError.value = 'Gagal menghubungi server. Silakan coba lagi.';
            } finally {
                loginLoading.value = false;
            }
        };

        onMounted(() => {
            if (selectedRole.value === 'admin') {
                fillAdminDemo();
            } else {
                fillUserDemo();
            }
        });

        return {
            selectedRole, loginForm, loginError, loginLoading, showPassword,
            setRole, fillAdminDemo, fillUserDemo, handleLogin
        };
    }
}).mount('#login-app');
</script>
@endpush

{{-- ============================================================
     WEATHERLIVE-GRID · PROFILE & IN-CONTEXT AUTH STUDIO 2.0
     Login & Profil Pengguna/Admin Langsung di Tempat (Tanpa Navigasi)
     Sesuai Permintaan: Login Admin & User di Profile Saja Tanpa Pindah Laman
     ============================================================ --}}
<div id="wl-profile-modal" class="wl-profile-overlay" style="display:none;" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="wl-profile-backdrop" onclick="window.closeProfileAuth()"></div>

  <div class="wl-profile-container">
    <div class="wl-profile-card">
      {{-- Card Glow Accent --}}
      <div class="wl-pcard-glow"></div>

      {{-- Close Button --}}
      <button class="wl-pcard-close" onclick="window.closeProfileAuth()" title="Tutup Modal (Esc)">
        <i class="fas fa-times"></i>
      </button>

      {{-- =================================================== --}}
      {{-- VIEW A: BELUM LOGIN (GUEST / ENTERPRISE LOGIN FORM)  --}}
      {{-- =================================================== --}}
      <div id="wl-view-guest" style="display:block;">
        <div class="wl-pcard-header">
          <div class="wl-pcard-brand-icon">
            <i class="fas fa-user-circle" id="wl-role-header-icon"></i>
          </div>
          <div>
            <h3 class="wl-pcard-title" id="wl-role-header-title">Masuk ke Akun WeatherLive</h3>
            <p class="wl-pcard-subtitle">Personalisasi cuaca, preferensi lokasi, dan notifikasi cerdas</p>
          </div>
        </div>

        {{-- Fast Autofill Demo Buttons (Discreet) --}}
        <div class="wl-autofill-strip" style="justify-content:space-between;">
          <span class="wl-autofill-label"><i class="fas fa-bolt"></i> Coba Akun:</span>
          <div style="display:flex;gap:6px;">
            <button type="button" class="wl-autofill-pill" onclick="window.wlFillDemo('user')">
              <i class="fas fa-user"></i> Demo Pengguna
            </button>
            <button type="button" class="wl-autofill-pill admin" onclick="window.wlFillDemo('admin')" title="Khusus Staf & Admin BMKG">
              <i class="fas fa-key"></i> Staf BMKG
            </button>
          </div>
        </div>

        {{-- Error Alert Banner --}}
        <div id="wl-login-error" class="wl-login-error-alert" style="display:none;">
          <i class="fas fa-circle-exclamation"></i>
          <span id="wl-login-error-text">Email atau password salah.</span>
        </div>

        {{-- Form Login --}}
        <form id="wl-login-form" onsubmit="window.wlSubmitLogin(event)">
          <div class="wl-form-group">
            <label class="wl-form-label"><i class="fas fa-envelope"></i> Email Akun</label>
            <div class="wl-input-wrap">
              <input
                type="email"
                id="wl-input-email"
                required
                class="wl-form-input"
                placeholder="nama@weatherlive.id"
                autocomplete="email"
              />
            </div>
          </div>

          <div class="wl-form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
              <label class="wl-form-label"><i class="fas fa-lock"></i> Kata Sandi</label>
              <button type="button" class="wl-toggle-pwd" onclick="window.wlTogglePasswordVisibility()">
                <i class="fas fa-eye" id="wl-eye-icon"></i> <span id="wl-eye-text">Lihat</span>
              </button>
            </div>
            <div class="wl-input-wrap">
              <input
                type="password"
                id="wl-input-password"
                required
                class="wl-form-input"
                placeholder="••••••••"
                autocomplete="current-password"
              />
            </div>
          </div>

          <div class="wl-form-actions">
            <button type="submit" id="wl-btn-login-submit" class="wl-btn-primary">
              <span id="wl-btn-login-spinner" style="display:none;"><i class="fas fa-circle-notch fa-spin"></i> </span>
              <span id="wl-btn-login-label"><i class="fas fa-arrow-right-to-bracket"></i> Masuk Sekarang</span>
            </button>
          </div>
        </form>

        <div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#64748b;">
          <span><i class="fas fa-shield-check"></i> Sesi terenkripsi JWT</span>
          <a href="javascript:void(0)" onclick="window.wlFillDemo('admin')" style="color:#64748b;text-decoration:none;font-weight:600;"><i class="fas fa-lock"></i> Portal Staf BMKG</a>
        </div>
      </div>

      {{-- =================================================== --}}
      {{-- VIEW B: SUDAH LOGIN (AUTHENTICATED PROFILE CARD)    --}}
      {{-- =================================================== --}}
      <div id="wl-view-auth" style="display:none;">
        <div class="wl-auth-badge-top">
          <span class="wl-auth-status-dot"></span> SESI AKTIF TERVERIFIKASI
        </div>

        <div class="wl-profile-user-card">
          <div class="wl-user-avatar-wrap">
            <div class="wl-user-avatar-initial" id="wl-auth-initial">AD</div>
            <span class="wl-user-avatar-badge" id="wl-auth-avatar-icon"><i class="fas fa-shield-halved"></i></span>
          </div>
          <div class="wl-user-meta">
            <h3 class="wl-user-name" id="wl-auth-name">Administrator BMKG</h3>
            <div class="wl-user-email" id="wl-auth-email">admin@weatherlive.id</div>
            <div class="wl-user-role-pill" id="wl-auth-role-pill">
              <i class="fas fa-shield-halved"></i> <span>Administrator 2.0</span>
            </div>
          </div>
        </div>

        {{-- Telemetry & Connection Status Bar --}}
        <div class="wl-auth-info-grid">
          <div class="wl-info-stat">
            <div class="wl-stat-label">STATUS DATA</div>
            <div class="wl-stat-val" style="color:#22c55e;"><i class="fas fa-circle-dot"></i> Live BMKG Grid</div>
          </div>
          <div class="wl-info-stat">
            <div class="wl-stat-label">HAK AKSES</div>
            <div class="wl-stat-val" id="wl-stat-access-val">Penuh (Full Access)</div>
          </div>
        </div>

        {{-- Quick Admin Shortcut (Visible if Admin) --}}
        <div id="wl-auth-admin-action" style="display:none;margin-top:16px;">
          <a href="{{ route('admin') }}" class="wl-btn-admin-command">
            <div class="wl-btn-admin-icon"><i class="fas fa-shield-halved"></i></div>
            <div>
              <div style="font-weight:800;font-size:13.5px;">Buka Admin Command Center 2.0</div>
              <div style="font-size:11px;color:rgba(255,255,255,0.7);">Rekapan Jawa Barat, Ekspor PDF/CSV, Kelola Stasiun & Sensor</div>
            </div>
            <i class="fas fa-arrow-right" style="margin-left:auto;"></i>
          </a>
        </div>

        {{-- Switch / Logout Actions --}}
        <div class="wl-auth-actions-row">
          <button type="button" class="wl-btn-secondary" onclick="window.wlSwitchAccount()">
            <i class="fas fa-arrow-right-arrow-left"></i> Ganti Akun
          </button>
          <button type="button" class="wl-btn-logout" onclick="window.wlLogout()">
            <i class="fas fa-arrow-right-from-bracket"></i> Keluar / Logout
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
/* =====================================================
   PROFILE MODAL & AUTH STUDIO STYLING (GLASSMORPHISM)
   ===================================================== */
.wl-profile-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 18px;
  animation: wlFadeIn 0.22s ease-out;
}
.wl-profile-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(3, 8, 20, 0.78);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
}
.wl-profile-container {
  position: relative;
  width: 100%;
  max-width: 440px;
  z-index: 10;
  animation: wlSlideUp 0.28s cubic-bezier(0.16, 1, 0.3, 1);
}

.wl-profile-card {
  position: relative;
  background: rgba(9, 20, 44, 0.94);
  border: 1px solid rgba(56, 189, 248, 0.28);
  border-radius: 26px;
  padding: 28px 24px 22px;
  box-shadow: 0 30px 80px rgba(0, 0, 0, 0.8), 0 0 50px rgba(56, 189, 248, 0.15);
  color: #f1f5f9;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  overflow: hidden;
}

.wl-pcard-glow {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #38bdf8, #2563eb, #00ffe7, #818cf8);
}

.wl-pcard-close {
  position: absolute;
  top: 16px;
  right: 16px;
  width: 32px;
  height: 32px;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #94a3b8;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 14px;
}
.wl-pcard-close:hover {
  background: rgba(239, 68, 68, 0.2);
  border-color: rgba(239, 68, 68, 0.4);
  color: #ef4444;
  transform: rotate(90deg);
}

.wl-pcard-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 20px;
}
.wl-pcard-brand-icon {
  width: 48px;
  height: 48px;
  border-radius: 15px;
  background: linear-gradient(135deg, #0284c7, #2563eb);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #fff;
  box-shadow: 0 8px 20px rgba(2, 132, 199, 0.4);
  flex-shrink: 0;
  transition: all 0.3s;
}
.wl-pcard-brand-icon.admin-mode {
  background: linear-gradient(135deg, #0f766e, #0284c7);
  box-shadow: 0 8px 20px rgba(0, 255, 231, 0.35);
  color: #00ffe7;
}
.wl-pcard-title {
  font-size: 18px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.01em;
  margin: 0;
}
.wl-pcard-subtitle {
  font-size: 11.5px;
  color: #94a3b8;
  margin: 3px 0 0;
}

/* Dual-Role Switcher Tabs */
.wl-role-tabs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px;
  padding: 4px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 14px;
  margin-bottom: 14px;
}
.wl-role-tab {
  padding: 8px 12px;
  border-radius: 10px;
  border: none;
  background: transparent;
  color: #94a3b8;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s;
  font-family: inherit;
}
.wl-role-tab.active {
  background: linear-gradient(135deg, #2563eb, #0284c7);
  color: #ffffff;
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.45);
}
.wl-role-tab#wl-tab-admin.active {
  background: linear-gradient(135deg, #0f766e, #0369a1);
  color: #00ffe7;
  box-shadow: 0 4px 14px rgba(0, 255, 231, 0.3);
}

/* Autofill Strip */
.wl-autofill-strip {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 16px;
  padding: 6px 10px;
  border-radius: 10px;
  background: rgba(56, 189, 248, 0.05);
  border: 1px dashed rgba(56, 189, 248, 0.2);
}
.wl-autofill-label {
  font-size: 11px;
  font-weight: 700;
  color: #38bdf8;
  display: flex;
  align-items: center;
  gap: 4px;
}
.wl-autofill-pill {
  padding: 3px 9px;
  border-radius: 7px;
  border: 1px solid rgba(56, 189, 248, 0.3);
  background: rgba(56, 189, 248, 0.1);
  color: #7dd3fc;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  font-family: inherit;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.wl-autofill-pill:hover {
  background: rgba(56, 189, 248, 0.25);
  color: #fff;
}
.wl-autofill-pill.admin {
  border-color: rgba(0, 255, 231, 0.3);
  background: rgba(0, 255, 231, 0.08);
  color: #00ffe7;
}
.wl-autofill-pill.admin:hover {
  background: rgba(0, 255, 231, 0.22);
}

/* Error Banner */
.wl-login-error-alert {
  padding: 10px 14px;
  border-radius: 12px;
  background: rgba(239, 68, 68, 0.12);
  border: 1px solid rgba(239, 68, 68, 0.35);
  color: #fca5a5;
  font-size: 12px;
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Form inputs */
.wl-form-group {
  margin-bottom: 14px;
}
.wl-form-label {
  display: block;
  font-size: 11.5px;
  font-weight: 700;
  color: #cbd5e1;
  margin-bottom: 6px;
}
.wl-input-wrap {
  position: relative;
}
.wl-form-input {
  width: 100%;
  padding: 11px 14px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.12);
  color: #fff;
  font-size: 13.5px;
  font-family: inherit;
  outline: none;
  transition: all 0.2s;
  box-sizing: border-box;
}
.wl-form-input:focus {
  border-color: #38bdf8;
  background: rgba(255, 255, 255, 0.08);
  box-shadow: 0 0 16px rgba(56, 189, 248, 0.25);
}
.wl-toggle-pwd {
  background: none;
  border: none;
  color: #7dd3fc;
  font-size: 11px;
  font-weight: 600;
  cursor: pointer;
  padding: 0;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

/* Action button */
.wl-form-actions {
  margin-top: 18px;
}
.wl-btn-primary {
  width: 100%;
  padding: 12px;
  border-radius: 12px;
  border: none;
  background: linear-gradient(135deg, #2563eb, #0284c7);
  color: #ffffff;
  font-size: 13.5px;
  font-weight: 800;
  cursor: pointer;
  transition: all 0.25s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-family: inherit;
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
}
.wl-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(37, 99, 235, 0.55);
}
.wl-btn-primary:active { transform: scale(0.98); }

.wl-pcard-footer-note {
  margin-top: 16px;
  text-align: center;
  font-size: 11px;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

/* =====================================================
   VIEW B: AUTHENTICATED PROFILE CARD
   ===================================================== */
.wl-auth-badge-top {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 10.5px;
  font-weight: 800;
  color: #22c55e;
  letter-spacing: 0.05em;
  padding: 4px 10px;
  border-radius: 999px;
  background: rgba(34, 197, 94, 0.1);
  border: 1px solid rgba(34, 197, 94, 0.25);
  margin-bottom: 16px;
}
.wl-auth-status-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 0 8px #22c55e;
  animation: pulse 1.8s infinite;
}

.wl-profile-user-card {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  margin-bottom: 14px;
}
.wl-user-avatar-wrap {
  position: relative;
  width: 52px;
  height: 52px;
  flex-shrink: 0;
}
.wl-user-avatar-initial {
  width: 100%;
  height: 100%;
  border-radius: 16px;
  background: linear-gradient(135deg, #0284c7, #2563eb);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: 900;
  color: #fff;
  box-shadow: 0 6px 18px rgba(2, 132, 199, 0.4);
}
.wl-user-avatar-badge {
  position: absolute;
  bottom: -4px;
  right: -4px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #0f766e;
  color: #00ffe7;
  border: 2px solid #09142c;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 9px;
}

.wl-user-meta {
  flex: 1;
  min-width: 0;
}
.wl-user-name {
  font-size: 16px;
  font-weight: 800;
  color: #fff;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.wl-user-email {
  font-size: 12px;
  color: #94a3b8;
  margin: 2px 0 6px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.wl-user-role-pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 6px;
  background: rgba(56, 189, 248, 0.15);
  color: #38bdf8;
  border: 1px solid rgba(56, 189, 248, 0.25);
}
.wl-user-role-pill.admin {
  background: rgba(0, 255, 231, 0.12);
  color: #00ffe7;
  border-color: rgba(0, 255, 231, 0.3);
}

.wl-auth-info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 14px;
}
.wl-info-stat {
  padding: 10px 12px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.06);
}
.wl-stat-label {
  font-size: 10px;
  color: #64748b;
  font-weight: 700;
  text-transform: uppercase;
  margin-bottom: 2px;
}
.wl-stat-val {
  font-size: 12px;
  font-weight: 700;
  color: #e2e8f0;
}

/* Admin Command Button */
.wl-btn-admin-command {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(15, 118, 110, 0.4), rgba(2, 132, 199, 0.3));
  border: 1.5px solid rgba(0, 255, 231, 0.4);
  color: #ffffff;
  text-decoration: none;
  transition: all 0.25s;
  box-shadow: 0 6px 20px rgba(0, 255, 231, 0.15);
}
.wl-btn-admin-command:hover {
  transform: translateY(-2px);
  border-color: #00ffe7;
  box-shadow: 0 10px 30px rgba(0, 255, 231, 0.3);
}
.wl-btn-admin-icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: rgba(0, 255, 231, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #00ffe7;
  font-size: 16px;
  flex-shrink: 0;
}

.wl-auth-actions-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-top: 14px;
}
.wl-btn-secondary {
  padding: 10px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.12);
  background: rgba(255, 255, 255, 0.05);
  color: #cbd5e1;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  font-family: inherit;
  transition: all 0.2s;
}
.wl-btn-secondary:hover {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
}
.wl-btn-logout {
  padding: 10px;
  border-radius: 12px;
  border: 1px solid rgba(239, 68, 68, 0.25);
  background: rgba(239, 68, 68, 0.1);
  color: #fca5a5;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  font-family: inherit;
  transition: all 0.2s;
}
.wl-btn-logout:hover {
  background: rgba(239, 68, 68, 0.25);
  color: #fff;
}

@keyframes wlFadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes wlSlideUp {
  from { opacity: 0; transform: translateY(20px) scale(0.96); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>

<script>
(function() {
  var currentLoginRole = 'user';

  // Open modal
  window.openProfileAuth = function(role) {
    var modal = document.getElementById('wl-profile-modal');
    if (!modal) return;
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');

    // Check if user is already logged in
    var token = localStorage.getItem('access_token');
    if (token) {
      renderAuthView();
    } else {
      renderGuestView(role || currentLoginRole);
    }
  };

  // Close modal
  window.closeProfileAuth = function() {
    var modal = document.getElementById('wl-profile-modal');
    if (!modal) return;
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
  };

  // Toggle role tab
  window.wlSetLoginRole = function(role) {
    currentLoginRole = role;
    var tabUser  = document.getElementById('wl-tab-user');
    var tabAdmin = document.getElementById('wl-tab-admin');
    var brandIco = document.getElementById('wl-role-header-icon');
    var brandWrap= document.querySelector('.wl-pcard-brand-icon');
    var title    = document.getElementById('wl-role-header-title');

    if (role === 'admin') {
      tabUser.classList.remove('active');
      tabAdmin.classList.add('active');
      if (brandIco) brandIco.className = 'fas fa-shield-halved';
      if (brandWrap) brandWrap.classList.add('admin-mode');
      if (title) title.innerText = 'Login Administrator 2.0';
      window.wlFillDemo('admin');
    } else {
      tabAdmin.classList.remove('active');
      tabUser.classList.add('active');
      if (brandIco) brandIco.className = 'fas fa-user';
      if (brandWrap) brandWrap.classList.remove('admin-mode');
      if (title) title.innerText = 'Login Pengguna / Publik';
      window.wlFillDemo('user');
    }
  };

  // Autofill demo credentials
  window.wlFillDemo = function(role) {
    var emailInput = document.getElementById('wl-input-email');
    var pwdInput   = document.getElementById('wl-input-password');
    if (!emailInput || !pwdInput) return;

    if (role === 'admin') {
      emailInput.value = 'admin@weatherlive.id';
      pwdInput.value   = 'admin123';
      currentLoginRole = 'admin';
      var tabUser  = document.getElementById('wl-tab-user');
      var tabAdmin = document.getElementById('wl-tab-admin');
      if (tabUser && tabAdmin) {
        tabUser.classList.remove('active');
        tabAdmin.classList.add('active');
      }
    } else {
      emailInput.value = 'user@weatherlive.id';
      pwdInput.value   = 'user1234';
      currentLoginRole = 'user';
      var tabUser  = document.getElementById('wl-tab-user');
      var tabAdmin = document.getElementById('wl-tab-admin');
      if (tabUser && tabAdmin) {
        tabAdmin.classList.remove('active');
        tabUser.classList.add('active');
      }
    }
  };

  // Toggle password eye
  window.wlTogglePasswordVisibility = function() {
    var pwdInput = document.getElementById('wl-input-password');
    var eyeIco   = document.getElementById('wl-eye-icon');
    var eyeTxt   = document.getElementById('wl-eye-text');
    if (!pwdInput) return;

    if (pwdInput.type === 'password') {
      pwdInput.type = 'text';
      if (eyeIco) eyeIco.className = 'fas fa-eye-slash';
      if (eyeTxt) eyeTxt.innerText = 'Tutup';
    } else {
      pwdInput.type = 'password';
      if (eyeIco) eyeIco.className = 'fas fa-eye';
      if (eyeTxt) eyeTxt.innerText = 'Lihat';
    }
  };

  // Submit Login
  window.wlSubmitLogin = function(e) {
    if (e) e.preventDefault();
    var emailInput = document.getElementById('wl-input-email');
    var pwdInput   = document.getElementById('wl-input-password');
    var errBox     = document.getElementById('wl-login-error');
    var errTxt     = document.getElementById('wl-login-error-text');
    var spinner    = document.getElementById('wl-btn-login-spinner');
    var btnSubmit  = document.getElementById('wl-btn-login-submit');

    if (!emailInput || !pwdInput) return;
    if (errBox) errBox.style.display = 'none';
    if (spinner) spinner.style.display = 'inline-block';
    if (btnSubmit) btnSubmit.disabled = true;

    fetch('/api/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        email: emailInput.value,
        password: pwdInput.value
      })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
      if (spinner) spinner.style.display = 'none';
      if (btnSubmit) btnSubmit.disabled = false;

      if (data.success && data.access_token) {
        // Save to localStorage
        localStorage.setItem('access_token', data.access_token);
        localStorage.setItem('user_name', data.user ? data.user.name : (currentLoginRole === 'admin' ? 'Administrator BMKG' : 'Pengguna Publik'));
        localStorage.setItem('user_email', data.user ? data.user.email : emailInput.value);
        localStorage.setItem('user_role', data.user && data.user.role ? data.user.role.name : (currentLoginRole === 'admin' ? 'Administrator' : 'Masyarakat'));

        if (window.showToast) {
          window.showToast('Login Berhasil ✓', 'Selamat datang, ' + (data.user ? data.user.name : 'User') + '!', 'success');
        }

        // Render Authenticated view
        renderAuthView();
        updateGlobalNavAvatar();
      } else {
        if (errBox && errTxt) {
          errTxt.innerText = data.message || 'Email atau kata sandi tidak valid.';
          errBox.style.display = 'flex';
        }
      }
    })
    .catch(function(err) {
      if (spinner) spinner.style.display = 'none';
      if (btnSubmit) btnSubmit.disabled = false;
      if (errBox && errTxt) {
        errTxt.innerText = 'Gagal menghubungi server autentikasi.';
        errBox.style.display = 'flex';
      }
    });
  };

  // Render Guest View
  function renderGuestView(role) {
    var vGuest = document.getElementById('wl-view-guest');
    var vAuth  = document.getElementById('wl-view-auth');
    if (vGuest) vGuest.style.display = 'block';
    if (vAuth)  vAuth.style.display = 'none';
    window.wlSetLoginRole(role || 'user');
  }

  // Render Authenticated View
  function renderAuthView() {
    var vGuest = document.getElementById('wl-view-guest');
    var vAuth  = document.getElementById('wl-view-auth');
    if (vGuest) vGuest.style.display = 'none';
    if (vAuth)  vAuth.style.display = 'block';

    var name  = localStorage.getItem('user_name') || 'Pengguna WeatherLive';
    var email = localStorage.getItem('user_email') || 'user@weatherlive.id';
    var role  = localStorage.getItem('user_role') || 'Pengguna';

    var nameEl    = document.getElementById('wl-auth-name');
    var emailEl   = document.getElementById('wl-auth-email');
    var initialEl = document.getElementById('wl-auth-initial');
    var rolePill  = document.getElementById('wl-auth-role-pill');
    var adminAct  = document.getElementById('wl-auth-admin-action');
    var accessVal = document.getElementById('wl-stat-access-val');

    if (nameEl) nameEl.innerText = name;
    if (emailEl) emailEl.innerText = email;
    if (initialEl) {
      var parts = name.trim().split(' ');
      var init = parts.length > 1 ? (parts[0][0] + parts[1][0]) : name.slice(0, 2);
      initialEl.innerText = init.toUpperCase();
    }

    var isAdmin = role.toLowerCase().includes('admin');
    if (rolePill) {
      rolePill.className = 'wl-user-role-pill ' + (isAdmin ? 'admin' : '');
      rolePill.innerHTML = '<i class="fas ' + (isAdmin ? 'fa-shield-halved' : 'fa-user-check') + '"></i> <span>' + (isAdmin ? 'Administrator 2.0' : role) + '</span>';
    }
    if (adminAct) {
      adminAct.style.display = isAdmin ? 'block' : 'none';
    }
    if (accessVal) {
      accessVal.innerText = isAdmin ? 'Penuh (Full Control)' : 'Standar (Publik)';
    }

    updateGlobalNavAvatar();
  }

  // Switch Account
  window.wlSwitchAccount = function() {
    renderGuestView(currentLoginRole === 'admin' ? 'user' : 'admin');
  };

  // Logout
  window.wlLogout = function() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('user_name');
    localStorage.removeItem('user_email');
    localStorage.removeItem('user_role');

    if (window.showToast) {
      window.showToast('Logout Berhasil', 'Anda telah keluar dari sesi.', 'info');
    }

    renderGuestView('user');
    updateGlobalNavAvatar();
  };

  // Sync Global Navbar Avatar across app
  function updateGlobalNavAvatar() {
    var token = localStorage.getItem('access_token');
    var role  = localStorage.getItem('user_role') || '';
    var name  = localStorage.getItem('user_name') || 'User';
    var isAdmin = role.toLowerCase().includes('admin');

    // Update triggers on navbar
    document.querySelectorAll('.db-topbar-avatar, #wlProfileAvatar').forEach(function(el) {
      if (token) {
        var parts = name.trim().split(' ');
        var init = parts.length > 1 ? (parts[0][0] + parts[1][0]) : name.slice(0, 2);
        el.innerHTML = '<span style="font-weight:900;font-size:12px;color:#fff;">' + init.toUpperCase() + '</span>';
        el.style.background = isAdmin ? 'linear-gradient(135deg, #0f766e, #0284c7)' : 'linear-gradient(135deg, #2563eb, #38bdf8)';
        el.style.border = isAdmin ? '1.5px solid #00ffe7' : '1.5px solid #38bdf8';
      } else {
        el.innerHTML = '<i class="fas fa-user-circle" style="font-size:18px;"></i>';
        el.style.background = '';
        el.style.border = '';
      }
    });

    var dot = document.getElementById('wlProfileDot');
    if (dot) {
      dot.style.display = token ? 'block' : 'none';
    }
  }

  // Auto-init on page load
  document.addEventListener('DOMContentLoaded', function() {
    updateGlobalNavAvatar();

    // Check URL parameters for instant popup trigger
    var params = new URLSearchParams(window.location.search);
    if (params.get('open_profile') === '1' || params.get('open_login') === '1') {
      setTimeout(function() {
        window.openProfileAuth(params.get('role') || 'user');
        try {
          var cleanUrl = window.location.pathname;
          window.history.replaceState({}, document.title, cleanUrl);
        } catch(e) {}
      }, 300);
    }

    // Escape key listener
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        window.closeProfileAuth();
      }
    });

    // Global click listener for profile trigger links
    document.addEventListener('click', function(e) {
      var trigger = e.target.closest('[data-open-profile], .open-profile-trigger, .db-topbar-avatar');
      if (trigger) {
        e.preventDefault();
        window.openProfileAuth();
      }
    });
  });

  // Expose immediately
  window.updateGlobalNavAvatar = updateGlobalNavAvatar;
})();
</script>

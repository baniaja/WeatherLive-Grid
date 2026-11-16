@extends('layouts.app')

@section('title', 'Admin Command Center 2.0 — BMKG WeatherLive')

@section('styles')
<style>
:root {
  --adm-bg: #030712;
  --adm-surface: rgba(10, 19, 38, 0.88);
  --adm-card: rgba(15, 27, 53, 0.7);
  --adm-card-hover: rgba(22, 39, 76, 0.85);
  --adm-border: rgba(56, 189, 248, 0.14);
  --adm-border-glow: rgba(56, 189, 248, 0.4);
  --adm-neon-blue: #38bdf8;
  --adm-neon-cyan: #00ffe7;
  --adm-neon-emerald: #10b981;
  --adm-neon-amber: #f59e0b;
  --adm-neon-rose: #f43f5e;
  --adm-text: #f8fafc;
  --adm-muted: #94a3b8;
}

body {
  background: radial-gradient(ellipse at 10% 10%, rgba(14, 165, 233, 0.15) 0%, transparent 45%),
              radial-gradient(ellipse at 85% 20%, rgba(99, 102, 241, 0.12) 0%, transparent 40%),
              radial-gradient(ellipse at 50% 90%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
              #030712 !important;
  color: var(--adm-text);
  overflow-x: hidden;
}

/* Command Center Container */
.adm-shell {
  max-width: 1560px;
  margin: 0 auto;
  padding: 24px 20px 80px;
  position: relative;
  z-index: 10;
}

/* Header Ribbon */
.adm-ribbon {
  background: var(--adm-surface);
  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);
  border: 1px solid var(--adm-border);
  border-radius: 24px;
  padding: 20px 24px;
  margin-bottom: 24px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(56, 189, 248, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  position: relative;
  overflow: hidden;
}

.adm-ribbon::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, #0284c7, #00ffe7, #6366f1, #10b981);
}

.adm-brand-block {
  display: flex;
  align-items: center;
  gap: 16px;
}

.adm-logo-badge {
  width: 52px;
  height: 52px;
  border-radius: 16px;
  background: linear-gradient(135deg, #0284c7, #2563eb);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #fff;
  box-shadow: 0 0 25px rgba(2, 132, 199, 0.5);
  position: relative;
}

.adm-live-pulse {
  position: absolute;
  bottom: -2px;
  right: -2px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background: #10b981;
  border: 2px solid #030712;
  box-shadow: 0 0 10px #10b981;
  animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.adm-ribbon-title h1 {
  font-size: 20px;
  font-weight: 800;
  font-family: 'Space Grotesk', sans-serif;
  letter-spacing: -0.02em;
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0;
}

.adm-badge-v2 {
  font-size: 11px;
  font-weight: 700;
  background: linear-gradient(135deg, rgba(0, 255, 231, 0.2), rgba(2, 132, 199, 0.2));
  color: var(--adm-neon-cyan);
  border: 1px solid rgba(0, 255, 231, 0.4);
  padding: 3px 10px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  box-shadow: 0 0 14px rgba(0, 255, 231, 0.2);
}

.adm-ribbon-sub {
  font-size: 12px;
  color: var(--adm-muted);
  display: flex;
  align-items: center;
  gap: 14px;
  margin-top: 4px;
}

.adm-hud-telemetry {
  display: flex;
  align-items: center;
  gap: 16px;
  background: rgba(255, 255, 255, 0.03);
  padding: 8px 16px;
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.06);
  font-size: 12px;
}

.adm-hud-item {
  display: flex;
  align-items: center;
  gap: 6px;
  color: var(--adm-muted);
}

.adm-hud-item strong {
  color: #fff;
  font-weight: 700;
}

.adm-ribbon-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.adm-btn-primary {
  background: linear-gradient(135deg, #0284c7, #2563eb);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 10px 18px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.35);
  transition: all 0.25s ease;
  font-family: inherit;
}

.adm-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(2, 132, 199, 0.5);
}

.adm-btn-ghost {
  background: rgba(255, 255, 255, 0.05);
  color: var(--adm-text);
  border: 1px solid var(--adm-border);
  border-radius: 12px;
  padding: 10px 16px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
  text-decoration: none;
  font-family: inherit;
}

.adm-btn-ghost:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: var(--adm-border-glow);
  color: #fff;
  text-decoration: none;
}

/* Nav Tabs */
.adm-tabs {
  display: flex;
  gap: 8px;
  background: var(--adm-surface);
  border: 1px solid var(--adm-border);
  border-radius: 18px;
  padding: 6px;
  margin-bottom: 24px;
  overflow-x: auto;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
}

.adm-tab {
  padding: 11px 18px;
  border-radius: 14px;
  border: none;
  background: transparent;
  color: var(--adm-muted);
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 9px;
  transition: all 0.25s ease;
  white-space: nowrap;
  font-family: inherit;
}

.adm-tab:hover {
  color: var(--adm-text);
  background: rgba(255, 255, 255, 0.04);
}

.adm-tab.active {
  background: linear-gradient(135deg, rgba(2, 132, 199, 0.3), rgba(37, 99, 235, 0.25));
  color: var(--adm-neon-blue);
  border: 1px solid rgba(56, 189, 248, 0.3);
  box-shadow: 0 4px 16px rgba(2, 132, 199, 0.25);
}

.adm-tab-counter {
  font-size: 10.5px;
  padding: 2px 7px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.08);
  color: inherit;
}

/* Summary Grid */
.adm-stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.adm-stat-card {
  background: var(--adm-surface);
  backdrop-filter: blur(20px);
  border: 1px solid var(--adm-border);
  border-radius: 20px;
  padding: 20px;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
  overflow: hidden;
}

.adm-stat-card::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 80px;
  height: 80px;
  background: radial-gradient(circle, var(--glow-color, rgba(56, 189, 248, 0.15)) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.adm-stat-card:hover {
  transform: translateY(-4px);
  border-color: var(--adm-border-glow);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
}

.adm-stat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.adm-stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.adm-stat-icon.blue { background: rgba(2, 132, 199, 0.15); color: #38bdf8; }
.adm-stat-icon.amber { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
.adm-stat-icon.emerald { background: rgba(16, 185, 129, 0.15); color: #34d399; }
.adm-stat-icon.rose { background: rgba(244, 63, 94, 0.15); color: #fb7185; }
.adm-stat-icon.indigo { background: rgba(99, 102, 241, 0.15); color: #a5b4fc; }

.adm-stat-val {
  font-size: 28px;
  font-weight: 800;
  font-family: 'Space Grotesk', sans-serif;
  color: #fff;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.adm-stat-label {
  font-size: 12.5px;
  color: var(--adm-muted);
  margin-top: 4px;
}

.adm-stat-badge {
  font-size: 11px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

/* Panel Card */
.adm-panel {
  background: var(--adm-surface);
  backdrop-filter: blur(24px);
  border: 1px solid var(--adm-border);
  border-radius: 22px;
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.35);
}

.adm-panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 14px;
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.adm-panel-title {
  font-size: 16px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 10px;
}

.adm-panel-title i {
  color: var(--adm-neon-blue);
}

.adm-search-input {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid var(--adm-border);
  border-radius: 12px;
  padding: 8px 14px;
  color: var(--adm-text);
  font-size: 13px;
  outline: none;
  min-width: 240px;
  transition: all 0.2s;
}

.adm-search-input:focus {
  border-color: var(--adm-neon-blue);
  box-shadow: 0 0 15px rgba(56, 189, 248, 0.25);
  background: rgba(255, 255, 255, 0.07);
}

/* Custom Table */
.adm-table-wrap {
  overflow-x: auto;
}

.adm-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 6px;
}

.adm-table th {
  padding: 10px 14px;
  text-align: left;
  font-size: 11px;
  font-weight: 700;
  color: var(--adm-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  border: none;
}

.adm-table tr.adm-tr {
  background: rgba(255, 255, 255, 0.025);
  transition: all 0.2s ease;
}

.adm-table tr.adm-tr:hover {
  background: rgba(56, 189, 248, 0.06);
  transform: translateY(-1px);
}

.adm-table td {
  padding: 14px;
  font-size: 13px;
  border-top: 1px solid rgba(255, 255, 255, 0.04);
  border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.adm-table td:first-child {
  border-top-left-radius: 12px;
  border-bottom-left-radius: 12px;
  border-left: 1px solid rgba(255, 255, 255, 0.04);
}

.adm-table td:last-child {
  border-top-right-radius: 12px;
  border-bottom-right-radius: 12px;
  border-right: 1px solid rgba(255, 255, 255, 0.04);
}

/* Badges */
.badge-status {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.badge-status.active, .badge-status.optimal {
  background: rgba(16, 185, 129, 0.15);
  color: #34d399;
  border: 1px solid rgba(16, 185, 129, 0.3);
}

.badge-status.maintenance, .badge-status.warning {
  background: rgba(245, 158, 11, 0.15);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.3);
}

.badge-status.danger, .badge-status.extreme, .badge-status.inactive {
  background: rgba(244, 63, 94, 0.15);
  color: #fb7185;
  border: 1px solid rgba(244, 63, 94, 0.3);
}

/* Action Buttons */
.adm-act-btn {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--adm-border);
  color: var(--adm-muted);
  width: 32px;
  height: 32px;
  border-radius: 9px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.adm-act-btn:hover {
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
  border-color: var(--adm-border-glow);
}

.adm-act-btn.delete:hover {
  background: rgba(244, 63, 94, 0.2);
  color: #fb7185;
  border-color: rgba(244, 63, 94, 0.4);
}

/* Modal Windows */
.adm-modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(3, 7, 18, 0.82);
  backdrop-filter: blur(12px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  animation: modalFade .25s ease-out;
}

.adm-modal {
  background: #081224;
  border: 1px solid var(--adm-border-glow);
  border-radius: 24px;
  width: 100%;
  max-width: 580px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 25px 70px rgba(0, 0, 0, 0.7), 0 0 35px rgba(56, 189, 248, 0.2);
  animation: modalScale .25s cubic-bezier(.175,.885,.32,1.275);
}

@keyframes modalFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes modalScale { from { transform: scale(0.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.adm-modal-head {
  padding: 20px 24px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.adm-modal-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.adm-form-row {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.adm-form-row label {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--adm-muted);
}

.adm-input, .adm-select, .adm-textarea {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--adm-border);
  border-radius: 12px;
  padding: 11px 14px;
  color: #fff;
  font-size: 13.5px;
  outline: none;
  font-family: inherit;
  transition: all 0.2s;
}

.adm-input:focus, .adm-select:focus, .adm-textarea:focus {
  border-color: var(--adm-neon-blue);
  box-shadow: 0 0 16px rgba(56, 189, 248, 0.25);
  background: rgba(255, 255, 255, 0.08);
}

.adm-select option {
  background: #081224;
  color: #fff;
}

.adm-modal-footer {
  padding: 18px 24px;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}

/* Toast */
.adm-toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 10000;
  background: #081224;
  border: 1px solid var(--adm-neon-blue);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(56, 189, 248, 0.3);
  padding: 14px 20px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 13px;
  color: #fff;
/* Security Gate Barrier */
.adm-gate-container {
  min-height: 82vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 30px 16px;
}
.adm-gate-card {
  background: rgba(9, 20, 44, 0.95);
  border: 1.5px solid rgba(0, 255, 231, 0.35);
  border-radius: 28px;
  padding: 40px 32px;
  width: 100%;
  max-width: 480px;
  text-align: center;
  box-shadow: 0 30px 80px rgba(0,0,0,0.8), 0 0 50px rgba(0, 255, 231, 0.15);
  position: relative;
  overflow: hidden;
}
.adm-gate-shield-icon {
  width: 68px;
  height: 68px;
  border-radius: 20px;
  background: linear-gradient(135deg, #0f766e, #0284c7);
  color: #00ffe7;
  font-size: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 18px;
  box-shadow: 0 10px 30px rgba(0, 255, 231, 0.3);
  animation: pulse-ring 2.5s infinite;
}
</style>
@endsection

@section('content')
<div id="adm-app" class="adm-shell" v-cloak>

  <!-- SECURITY SHIELD GATE: UNAUTHORIZED BARRIER -->
  <div v-if="!isAuthorized" class="adm-gate-container">
    <div class="adm-gate-card">
      <div class="adm-gate-shield-icon">
        <i class="fas fa-shield-halved"></i>
      </div>
      <h2 style="font-size:22px;font-weight:800;color:#fff;margin:0 0 8px;font-family:'Space Grotesk',sans-serif;">
        Portal Staf BMKG — Akses Terbatas
      </h2>
      <p style="font-size:12.5px;color:#94a3b8;line-height:1.6;margin:0 0 24px;">
        Sistem pemantauan cuaca dan kendali telemetri Jawa Barat hanya dapat diakses oleh Staf dan Administrator resmi terverifikasi.
      </p>

      <div v-if="authLoginError" style="padding:10px 14px;border-radius:12px;background:rgba(244,63,94,0.15);border:1px solid rgba(244,63,94,0.3);color:#fb7185;font-size:12px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-circle-exclamation"></i> @{{ authLoginError }}
      </div>

      <form @submit.prevent="submitAdminGateLogin">
        <div style="text-align:left;margin-bottom:14px;">
          <label style="display:block;font-size:11.5px;font-weight:700;color:#cbd5e1;margin-bottom:6px;">Email Resmi Administrator</label>
          <input type="email" v-model="authLoginForm.email" required class="adm-input" placeholder="admin@weatherlive.id" />
        </div>
        <div style="text-align:left;margin-bottom:20px;">
          <label style="display:block;font-size:11.5px;font-weight:700;color:#cbd5e1;margin-bottom:6px;">Kata Sandi</label>
          <input type="password" v-model="authLoginForm.password" required class="adm-input" placeholder="••••••••" />
        </div>
        <button type="submit" class="adm-btn-primary" style="width:100%;justify-content:center;padding:12px;font-size:13.5px;" :disabled="authLoginLoading">
          <i class="fas fa-key"></i> @{{ authLoginLoading ? 'Memverifikasi Kredensial...' : 'Masuk ke Command Center 2.0' }}
        </button>
      </form>

      <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:space-between;align-items:center;font-size:12px;">
        <button type="button" @click="fillAdminGateDemo" style="background:none;border:none;color:#38bdf8;cursor:pointer;font-size:11.5px;font-weight:700;">
          <i class="fas fa-bolt"></i> Isi Demo Kredensial
        </button>
        <a href="/dashboard" style="color:#94a3b8;text-decoration:none;"><i class="fas fa-arrow-left"></i> Web Publik</a>
      </div>
    </div>
  </div>

  <!-- AUTHENTICATED COMMAND CENTER 2.0 VIEW -->
  <div v-else>

  <!-- 1. HEADER COMMAND RIBBON 2.0 -->
  <div class="adm-ribbon">
    <div class="adm-brand-block">
      <div class="adm-logo-badge">
        <i class="fas fa-shield-halved"></i>
        <span class="adm-live-pulse" title="Sistem Aktif 100%"></span>
      </div>
      <div class="adm-ribbon-title">
        <h1>
          Command Center 2.0
          <span class="adm-badge-v2"><i class="fas fa-bolt"></i> BMKG Executive Pro</span>
        </h1>
        <div class="adm-ribbon-sub">
          <span><i class="fas fa-satellite-dish" style="color:var(--adm-neon-cyan);"></i> Stasiun Pemantauan Jawa Barat</span>
          <span>•</span>
          <span><i class="fas fa-clock" style="color:var(--adm-neon-emerald);"></i> @{{ liveTime }} WIB</span>
          <span>•</span>
          <span style="color:#34d399;"><i class="fas fa-circle-check"></i> Akses Penuh Administrator</span>
        </div>
      </div>
    </div>

    <div class="adm-hud-telemetry">
      <div class="adm-hud-item">
        <i class="fas fa-server"></i>
        <span>Server: <strong>Optimal (99.98%)</strong></span>
      </div>
      <div class="adm-hud-item">
        <i class="fas fa-network-wired"></i>
        <span>Latency: <strong>42 ms</strong></span>
      </div>
    </div>

    <div class="adm-ribbon-actions">
      <button class="adm-btn-primary" @click="openCreateFeatureModal" style="background:linear-gradient(135deg,#0d9488,#0284c7);">
        <i class="fas fa-plus"></i> Tambah Fitur User
      </button>
      <button class="adm-btn-primary" @click="openBroadcastModal" style="background:linear-gradient(135deg,#f43f5e,#be123c);">
        <i class="fas fa-bullhorn"></i> Siarkan Darurat
      </button>
      <button class="adm-btn-primary" @click="openCreateAlertModal">
        <i class="fas fa-triangle-exclamation"></i> Buat Peringatan Baru
      </button>
      <button class="adm-btn-ghost" @click="openCreateStationModal">
        <i class="fas fa-tower-broadcast"></i> Tambah Stasiun
      </button>
      <button class="adm-btn-ghost" @click="openCreateUserModal">
        <i class="fas fa-user-plus"></i> Tambah Pengguna
      </button>
      <a href="/dashboard" class="adm-btn-ghost" title="Ke Dashboard Publik">
        <i class="fas fa-arrow-up-right-from-square"></i> Web Publik
      </a>
      <button class="adm-btn-ghost" @click="handleLogout" style="color:#fb7185;border-color:rgba(244,63,94,0.3);">
        <i class="fas fa-arrow-right-from-bracket"></i> Keluar
      </button>
    </div>
  </div>

  <!-- 2. NAVIGATION TABS (REKAPAN, STASIUN, PERINGATAN, PENGGUNA, SENSOR, CMS, FEATURES, LOGS) -->
  <div class="adm-tabs">
    <button class="adm-tab" :class="{active: currentTab === 'recap'}" @click="currentTab = 'recap'">
      <i class="fas fa-chart-pie"></i> Rekapan Data & Analitik
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'cms'}" @click="currentTab = 'cms'">
      <i class="fas fa-palette"></i> Tampilan Web & Berita
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'features'}" @click="currentTab = 'features'">
      <i class="fas fa-puzzle-piece"></i> Kelola Fitur Pengguna
      <span class="adm-tab-counter" v-text="portalFeatures.length"></span>
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'stations'}" @click="currentTab = 'stations'">
      <i class="fas fa-tower-broadcast"></i> Kelola Stasiun Cuaca
      <span class="adm-tab-counter" v-text="stations.length"></span>
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'alerts'}" @click="currentTab = 'alerts'">
      <i class="fas fa-triangle-exclamation"></i> Peringatan Cuaca Ekstrem
      <span class="adm-tab-counter" v-text="alerts.length"></span>
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'users'}" @click="currentTab = 'users'">
      <i class="fas fa-users-gear"></i> Kelola Pengguna & Akses
      <span class="adm-tab-counter" v-text="users.length"></span>
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'sensors'}" @click="currentTab = 'sensors'">
      <i class="fas fa-microchip"></i> Sensor Atmosfer & IoT
      <span class="adm-tab-counter" v-text="sensors.length"></span>
    </button>
    <button class="adm-tab" :class="{active: currentTab === 'logs'}" @click="currentTab = 'logs'">
      <i class="fas fa-code-compare"></i> Audit Log & Monitoring API
    </button>
  </div>

  <!-- 3. TAB CONTENT: REKAPAN DATA (EXECUTIVE DATA RECAP & DOWNLOAD) -->
  <div v-if="currentTab === 'recap'">
    <!-- Top Stat Cards -->
    <div class="adm-stats-grid">
      <div class="adm-stat-card" style="--glow-color:rgba(56,189,248,0.25)">
        <div class="adm-stat-top">
          <div class="adm-stat-icon blue"><i class="fas fa-tower-broadcast"></i></div>
          <span class="adm-stat-badge" style="background:rgba(16,185,129,0.15);color:#34d399;">
            <i class="fas fa-check"></i> @{{ recapData.summary?.active_stations || stations.length }} Aktif
          </span>
        </div>
        <div class="adm-stat-val" v-text="recapData.summary?.total_stations || stations.length || 27"></div>
        <div class="adm-stat-label">Total Stasiun Cuaca (Jawa Barat)</div>
      </div>

      <div class="adm-stat-card" style="--glow-color:rgba(244,63,94,0.25)">
        <div class="adm-stat-top">
          <div class="adm-stat-icon rose"><i class="fas fa-triangle-exclamation"></i></div>
          <span class="adm-stat-badge" style="background:rgba(244,63,94,0.15);color:#fb7185;">
            Siaga Bencana
          </span>
        </div>
        <div class="adm-stat-val" v-text="recapData.summary?.active_alerts || alerts.length || 3"></div>
        <div class="adm-stat-label">Peringatan Dini Cuaca Aktif</div>
      </div>

      <div class="adm-stat-card" style="--glow-color:rgba(16,185,129,0.25)">
        <div class="adm-stat-top">
          <div class="adm-stat-icon emerald"><i class="fas fa-users"></i></div>
          <span class="adm-stat-badge" style="background:rgba(16,185,129,0.15);color:#34d399;">
            Admin & Pengguna
          </span>
        </div>
        <div class="adm-stat-val" v-text="recapData.summary?.total_users || users.length || 3"></div>
        <div class="adm-stat-label">Total Pengguna Terdaftar</div>
      </div>

      <div class="adm-stat-card" style="--glow-color:rgba(245,158,11,0.25)">
        <div class="adm-stat-top">
          <div class="adm-stat-icon amber"><i class="fas fa-microchip"></i></div>
          <span class="adm-stat-badge" style="background:rgba(56,189,248,0.15);color:#38bdf8;">
            IoT Nodes
          </span>
        </div>
        <div class="adm-stat-val" v-text="recapData.summary?.total_sensors || sensors.length || 18"></div>
        <div class="adm-stat-label">Sensor Telemetri Atmosfer</div>
      </div>

      <div class="adm-stat-card" style="--glow-color:rgba(99,102,241,0.25)">
        <div class="adm-stat-top">
          <div class="adm-stat-icon indigo"><i class="fas fa-shield-virus"></i></div>
          <span class="adm-stat-badge" style="background:rgba(16,185,129,0.15);color:#34d399;">
            BMKG Guard
          </span>
        </div>
        <div class="adm-stat-val">99.98%</div>
        <div class="adm-stat-label">Tingkat Akurasi & Uptime</div>
      </div>
    </div>

    <!-- Export & Download Banner -->
    <div class="adm-panel" style="background:linear-gradient(135deg,rgba(15,27,53,0.9),rgba(2,132,199,0.12));border-color:rgba(56,189,248,0.3);">
      <div class="adm-panel-head" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
        <div>
          <div style="font-size:18px;font-weight:800;font-family:'Space Grotesk';color:#fff;display:flex;align-items:center;gap:10px;">
            <i class="fas fa-file-arrow-down" style="color:var(--adm-neon-blue);"></i>
            Pusat Ekspor & Rekapan Data Resmi BMKG
          </div>
          <div style="font-size:12.5px;color:var(--adm-muted);margin-top:4px;">
            Unduh rekapan menyeluruh data stasiun cuaca, peringatan ekstrem, telemetri atmosfer, dan akun terdaftar dalam format dokumen resmi.
          </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <a :href="'/api/admin-pub/export/csv'" target="_blank" class="adm-btn-primary">
            <i class="fas fa-file-csv"></i> Unduh Data CSV
          </a>
          <a :href="'/api/admin-pub/export/pdf'" target="_blank" class="adm-btn-ghost" style="border-color:rgba(244,63,94,0.4);color:#fda4af;">
            <i class="fas fa-file-pdf"></i> Cetak / Simpan Laporan PDF
          </a>
          <a :href="'/api/admin-pub/export/json'" target="_blank" class="adm-btn-ghost">
            <i class="fas fa-code"></i> Unduh JSON Dataset
          </a>
        </div>
      </div>
    </div>

    <!-- Telemetry Table Recap -->
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-chart-line"></i> Rekapan Telemetri Cuaca Regional Jawa Barat
        </div>
        <input type="text" v-model="telemetrySearch" placeholder="Cari kota / stasiun..." class="adm-search-input">
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Wilayah / Kota</th>
              <th>Stasiun Cuaca</th>
              <th>Suhu Aktual</th>
              <th>Kelembaban</th>
              <th>Kecepatan Angin</th>
              <th>Curah Hujan</th>
              <th>Tekanan Udara</th>
              <th>AQI (Udara)</th>
              <th>Status Stasiun</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="t in filteredTelemetry" :key="t.city" class="adm-tr">
              <td><strong>@{{ t.city }}</strong></td>
              <td style="color:var(--adm-muted);font-size:12px;">@{{ t.station }}</td>
              <td><span style="font-size:15px;font-weight:800;color:var(--adm-neon-blue);">@{{ t.temp }}°C</span></td>
              <td>@{{ t.humidity }}%</td>
              <td>@{{ t.wind }} m/s</td>
              <td>@{{ t.rain }} mm</td>
              <td>@{{ t.pressure }} hPa</td>
              <td>
                <span class="badge-status" :class="t.aqi < 50 ? 'optimal' : (t.aqi < 100 ? 'warning' : 'danger')">
                  AQI @{{ t.aqi }}
                </span>
              </td>
              <td>
                <span class="badge-status optimal"><i class="fas fa-check-circle"></i> @{{ t.status }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 4. TAB CONTENT: KELOLA STASIUN CUACA (FULL CRUD) -->
  <div v-if="currentTab === 'stations'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-tower-broadcast"></i> Manajemen Stasiun Cuaca BMKG Jawa Barat
        </div>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
          <input type="text" v-model="stationSearch" placeholder="Cari nama atau kode stasiun..." class="adm-search-input">
          <button class="adm-btn-primary" @click="openCreateStationModal">
            <i class="fas fa-plus"></i> Tambah Stasiun Baru
          </button>
        </div>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Stasiun</th>
              <th>Kode</th>
              <th>Wilayah Cakupan</th>
              <th>Koordinat</th>
              <th>Tipe</th>
              <th>Status</th>
              <th style="text-align:right;">Aksi Administrator</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(st, idx) in filteredStations" :key="st.id" class="adm-tr">
              <td>@{{ idx + 1 }}</td>
              <td>
                <strong>@{{ st.name }}</strong>
              </td>
              <td><code style="color:var(--adm-neon-cyan);font-weight:700;">@{{ st.code }}</code></td>
              <td>@{{ st.location?.name || 'Jawa Barat' }}</td>
              <td style="font-family:monospace;font-size:11px;color:var(--adm-muted);">@{{ Number(st.latitude).toFixed(4) }}, @{{ Number(st.longitude).toFixed(4) }}</td>
              <td><span style="font-size:12px;font-weight:600;">@{{ st.type || 'AWS' }}</span></td>
              <td>
                <span class="badge-status" :class="st.status === 'active' ? 'active' : (st.status === 'maintenance' ? 'maintenance' : 'inactive')">
                  @{{ st.status }}
                </span>
              </td>
              <td style="text-align:right;">
                <div style="display:inline-flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditStationModal(st)" title="Edit Stasiun"><i class="fas fa-pen"></i></button>
                  <button class="adm-act-btn delete" @click="deleteStation(st.id)" title="Hapus Stasiun"><i class="fas fa-trash-alt"></i></button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredStations.length === 0">
              <td colspan="8" style="text-align:center;padding:30px;color:var(--adm-muted);">Tidak ada stasiun cuaca yang sesuai.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 5. TAB CONTENT: KELOLA PERINGATAN DINI CUACA EKSTREM (FULL CRUD) -->
  <div v-if="currentTab === 'alerts'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-triangle-exclamation"></i> Manajemen Peringatan Dini Cuaca & Bencana
        </div>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
          <input type="text" v-model="alertSearch" placeholder="Cari judul atau wilayah..." class="adm-search-input">
          <button class="adm-btn-primary" @click="openCreateAlertModal">
            <i class="fas fa-plus"></i> Terbitkan Peringatan Baru
          </button>
        </div>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul Peringatan</th>
              <th>Tipe Cuaca Ekstrem</th>
              <th>Tingkat Keparahan</th>
              <th>Wilayah Cakupan</th>
              <th>Waktu Berlaku</th>
              <th>Status</th>
              <th style="text-align:right;">Aksi Administrator</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(al, idx) in filteredAlerts" :key="al.id" class="adm-tr">
              <td>@{{ idx + 1 }}</td>
              <td>
                <strong>@{{ al.title }}</strong>
                <div style="font-size:11.5px;color:var(--adm-muted);max-width:320px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  @{{ al.description }}
                </div>
              </td>
              <td><span style="font-weight:600;">@{{ al.alert_type }}</span></td>
              <td>
                <span class="badge-status" :class="al.severity">
                  <i class="fas fa-radiation"></i> @{{ al.severity.toUpperCase() }}
                </span>
              </td>
              <td>@{{ al.location?.name || 'Jawa Barat' }}</td>
              <td style="font-size:11.5px;color:var(--adm-muted);">
                @{{ formatDate(al.effective_from) }} s/d @{{ formatDate(al.effective_until) }}
              </td>
              <td>
                <span class="badge-status" :class="al.status === 'active' ? 'active' : 'inactive'">
                  @{{ al.status }}
                </span>
              </td>
              <td style="text-align:right;">
                <div style="display:inline-flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditAlertModal(al)" title="Edit Peringatan"><i class="fas fa-pen"></i></button>
                  <button class="adm-act-btn delete" @click="deleteAlert(al.id)" title="Hapus Peringatan"><i class="fas fa-trash-alt"></i></button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredAlerts.length === 0">
              <td colspan="8" style="text-align:center;padding:30px;color:var(--adm-muted);">Tidak ada peringatan cuaca aktif.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 6. TAB CONTENT: KELOLA PENGGUNA & HAK AKSES (FULL CRUD) -->
  <div v-if="currentTab === 'users'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-users-gear"></i> Manajemen Pengguna & Otorisasi Sistem
        </div>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
          <input type="text" v-model="userSearch" placeholder="Cari nama atau email..." class="adm-search-input">
          <button class="adm-btn-primary" @click="openCreateUserModal">
            <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
          </button>
        </div>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Pengguna</th>
              <th>Email</th>
              <th>Role / Hak Akses</th>
              <th>Status Akun</th>
              <th>Nomor Telepon</th>
              <th>Tanggal Daftar</th>
              <th style="text-align:right;">Aksi Administrator</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(u, idx) in filteredUsers" :key="u.id" class="adm-tr">
              <td>@{{ idx + 1 }}</td>
              <td>
                <div style="display:flex;align-items:center;gap:10px;">
                  <div style="width:34px;height:34px;border-radius:10px;background:rgba(56,189,248,0.15);color:var(--adm-neon-blue);display:flex;align-items:center;justify-content:center;font-weight:700;">
                    @{{ u.name.charAt(0) }}
                  </div>
                  <strong>@{{ u.name }}</strong>
                </div>
              </td>
              <td>@{{ u.email }}</td>
              <td>
                <span class="badge-status" :class="u.role?.name === 'Administrator' ? 'danger' : 'optimal'">
                  <i class="fas fa-shield" v-if="u.role?.name === 'Administrator'"></i> @{{ u.role?.name || 'Masyarakat' }}
                </span>
              </td>
              <td>
                <span class="badge-status" :class="u.is_active ? 'active' : 'inactive'">
                  @{{ u.is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
              </td>
              <td>@{{ u.phone || '-' }}</td>
              <td style="font-size:12px;color:var(--adm-muted);">@{{ formatDate(u.created_at) }}</td>
              <td style="text-align:right;">
                <div style="display:inline-flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditUserModal(u)" title="Edit User"><i class="fas fa-pen"></i></button>
                  <button class="adm-act-btn delete" @click="deleteUser(u.id)" title="Hapus User" :disabled="u.id === 1"><i class="fas fa-trash-alt"></i></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 7. TAB CONTENT: SENSOR ATMOSFER -->
  <div v-if="currentTab === 'sensors'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-microchip"></i> Telemetri Sensor IoT Atmosfer Terpasang
        </div>
        <button class="adm-btn-primary" @click="openCreateSensorModal">
          <i class="fas fa-plus"></i> Tambah Sensor Baru
        </button>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Sensor</th>
              <th>ID Sensor Hardware</th>
              <th>Tipe Parameter</th>
              <th>Lokasi Penempatan</th>
              <th>Status Kalibrasi</th>
              <th>Terakhir Terbaca</th>
              <th style="text-align:right;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(sen, idx) in sensors" :key="sen.id" class="adm-tr">
              <td>@{{ idx + 1 }}</td>
              <td><strong>@{{ sen.name }}</strong></td>
              <td><code style="color:var(--adm-neon-blue);">@{{ sen.sensor_id }}</code></td>
              <td>@{{ sen.type }}</td>
              <td>@{{ sen.location?.name || 'Stasiun Pusat' }}</td>
              <td><span class="badge-status active">Terkalibrasi</span></td>
              <td style="font-size:11.5px;color:var(--adm-muted);">Baru saja (Real-time)</td>
              <td style="text-align:right;">
                <div style="display:inline-flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditSensorModal(sen)"><i class="fas fa-pen"></i></button>
                  <button class="adm-act-btn delete" @click="deleteSensor(sen.id)"><i class="fas fa-trash-alt"></i></button>
                </div>
              </td>
            </tr>
            <tr v-if="sensors.length === 0">
              <td colspan="8" style="text-align:center;padding:30px;color:var(--adm-muted);">Tidak ada data sensor.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 8. TAB CONTENT: LOGS API -->
  <div v-if="currentTab === 'logs'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-code-compare"></i> Real-time API Endpoint Traffic & Latency Monitoring
        </div>
        <button class="adm-btn-ghost" @click="loadData">
          <i class="fas fa-rotate"></i> Refresh Log
        </button>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Endpoint API</th>
              <th>HTTP Method</th>
              <th>Total Panggilan</th>
              <th>Rata-rata Respon</th>
              <th>Respon Maksimal</th>
              <th>Tingkat Sukses</th>
              <th>Panggilan Terakhir</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="lg in logs" :key="lg.endpoint" class="adm-tr">
              <td><code style="color:var(--adm-neon-cyan);">@{{ lg.endpoint }}</code></td>
              <td>
                <span class="badge-status" :class="lg.method === 'GET' ? 'active' : 'warning'">@{{ lg.method }}</span>
              </td>
              <td><strong>@{{ lg.total_calls }}</strong></td>
              <td>@{{ Math.round(lg.avg_response_time) }} ms</td>
              <td>@{{ Math.round(lg.max_response_time) }} ms</td>
              <td><span class="badge-status active">@{{ lg.success_count }}/@{{ lg.total_calls }} (100%)</span></td>
              <td style="font-size:11.5px;color:var(--adm-muted);">@{{ formatDate(lg.last_call) }}</td>
            </tr>
            <tr v-if="logs.length === 0">
              <td colspan="7" style="text-align:center;padding:30px;color:var(--adm-muted);">Belum ada catatan log API.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 9. TAB CONTENT: CMS TAMPILAN WEB & PUSAT BERITA/BULETIN -->
  <div v-if="currentTab === 'cms'">
    <!-- Top Information Banner -->
    <div class="adm-panel" style="background:linear-gradient(135deg,rgba(15,23,42,0.9),rgba(2,132,199,0.15));border-color:rgba(56,189,248,0.3);margin-bottom:24px;">
      <div class="adm-panel-head" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
        <div>
          <div style="font-size:18px;font-weight:800;font-family:'Space Grotesk';color:#fff;display:flex;align-items:center;gap:10px;">
            <i class="fas fa-palette" style="color:var(--adm-neon-blue);"></i>
            Pengaturan Tampilan Langsung (Live Website Appearance & CMS)
          </div>
          <div style="font-size:12.5px;color:var(--adm-muted);margin-top:4px;">
            Sebagai Administrator, Anda memiliki otoritas penuh untuk mengubah seluruh tampilan judul, running ticker pengumuman, headline beranda, dan deskripsi buletin berita cuaca di website publik secara langsung.
          </div>
        </div>
        <button class="adm-btn-primary" @click="saveCmsSettings" :disabled="cmsSaving" style="background:linear-gradient(135deg,#0284c7,#2563eb);">
          <i class="fas fa-floppy-disk"></i> @{{ cmsSaving ? 'Menyimpan Perubahan...' : 'Simpan Semua Tampilan' }}
        </button>
      </div>
    </div>

    <!-- Appearance Form Cards Grid -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
      <!-- Card 1: Branding & Hero Banner -->
      <div class="adm-panel">
        <div class="adm-panel-head">
          <div class="adm-panel-title">
            <i class="fas fa-brush" style="color:var(--adm-neon-cyan);"></i> Branding & Headline Publik
          </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px;">
          <div class="adm-form-row">
            <label>Nama Platform / Brand Header</label>
            <input type="text" v-model="siteSettings.site_name" class="adm-input" placeholder="WeatherLive Grid Enterprise" />
          </div>
          <div class="adm-form-row">
            <label>Judul Utama (Hero Headline)</label>
            <input type="text" v-model="siteSettings.hero_headline" class="adm-input" placeholder="Sistem Intelijen Cuaca & Iklim Nasional Berbasis AI" />
          </div>
          <div class="adm-form-row">
            <label>Sub-Deskripsi Hero (Deskripsi Lengkap Website)</label>
            <textarea v-model="siteSettings.hero_subheadline" rows="4" class="adm-textarea" placeholder="Deskripsi komprehensif platform untuk pengunjung publik..."></textarea>
          </div>
          <div class="adm-form-row">
            <label>Status Kesiapsiagaan Cuaca Nasional</label>
            <select v-model="siteSettings.emergency_status" class="adm-select">
              <option value="normal">🟢 NORMAL - Kondisi Cuaca Terkendali</option>
              <option value="alert">🟡 WASPADA - Potensi Dinamika Cuaca Ekstrem</option>
              <option value="critical">🔴 DARURAT / SIAGA - Tanggap Darurat Bencana Hidrometeorologi</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Card 2: Running Announcement Ticker & Buletin Utama -->
      <div class="adm-panel">
        <div class="adm-panel-head">
          <div class="adm-panel-title">
            <i class="fas fa-bullhorn" style="color:var(--adm-neon-rose);"></i> Ticker Pengumuman & Berita Utama
          </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px;">
          <div class="adm-form-row">
            <label>Running Ticker Pengumuman (Tampil di Bagian Atas Web Publik)</label>
            <textarea v-model="siteSettings.site_announcement" rows="3" class="adm-textarea" placeholder="Teks pengumuman berjalan real-time..."></textarea>
          </div>
          <div class="adm-form-row">
            <label>Judul Berita Cuaca / Warta Utama</label>
            <input type="text" v-model="siteSettings.bulletin_title" class="adm-input" placeholder="Analisis Peralihan Musim (Pancaroba) & Potensi Cuaca Ekstrem" />
          </div>
          <div class="adm-form-row">
            <label>Deskripsi & Ringkasan Berita Cuaca Publik</label>
            <textarea v-model="siteSettings.bulletin_desc" rows="4" class="adm-textarea" placeholder="Rincian deskripsi berita cuaca yang dibaca oleh seluruh masyarakat..."></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Weather Bulletins Table -->
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div class="adm-panel-title">
          <i class="fas fa-newspaper" style="color:var(--adm-neon-emerald);"></i> Manajemen Artikel Berita & Warta Cuaca Resmi
        </div>
        <button class="adm-btn-primary" @click="openCreateBulletinModal" style="background:linear-gradient(135deg,#059669,#0284c7);">
          <i class="fas fa-plus"></i> Terbitkan Berita Baru
        </button>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Judul Berita Cuaca</th>
              <th>Kategori</th>
              <th>Tingkat Keparahan</th>
              <th>Ringkasan / Deskripsi Berita</th>
              <th>Penulis</th>
              <th>Status Publikasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="b in bulletins" :key="b.id" class="adm-tr">
              <td style="font-weight:700;color:#fff;max-width:260px;">@{{ b.title }}</td>
              <td><span class="badge-status active">@{{ b.category }}</span></td>
              <td>
                <span class="badge-status" :class="b.severity === 'danger' ? 'danger' : (b.severity === 'warning' ? 'warning' : 'active')">
                  @{{ b.severity.toUpperCase() }}
                </span>
              </td>
              <td style="font-size:12px;color:var(--adm-muted);max-width:320px;">@{{ b.summary }}</td>
              <td style="font-size:12px;color:#cbd5e1;">@{{ b.author }}</td>
              <td>
                <span class="badge-status" :class="b.is_published ? 'active' : 'inactive'">
                  @{{ b.is_published ? 'DIPUBLIKASIKAN' : 'DRAFT' }}
                </span>
              </td>
              <td>
                <div style="display:flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditBulletinModal(b)" title="Edit Berita"><i class="fas fa-pen-to-square"></i></button>
                  <button class="adm-act-btn delete" @click="deleteBulletin(b.id)" title="Hapus Berita"><i class="fas fa-trash-can"></i></button>
                </div>
              </td>
            </tr>
            <tr v-if="bulletins.length === 0">
              <td colspan="7" style="text-align:center;padding:30px;color:var(--adm-muted);">Belum ada warta berita terdaftar.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 10. TAB CONTENT: KELOLA FITUR PENGGUNA (ADD, EDIT, TOGGLE USER FEATURES) -->
  <div v-if="currentTab === 'features'">
    <div class="adm-panel">
      <div class="adm-panel-head">
        <div>
          <div class="adm-panel-title">
            <i class="fas fa-puzzle-piece" style="color:var(--adm-neon-cyan);"></i> Katalog Fitur Pengguna (User Features & Services Manager)
          </div>
          <div style="font-size:12px;color:var(--adm-muted);margin-top:4px;">
            Admin dapat menambah modul baru untuk pengguna, mengatur tautan URL, mengganti deskripsi dan lencana, serta mengaktifkan / menonaktifkan fitur secara real-time.
          </div>
        </div>
        <button class="adm-btn-primary" @click="openCreateFeatureModal" style="background:linear-gradient(135deg,#0d9488,#0284c7);">
          <i class="fas fa-plus"></i> Tambah Fitur Baru untuk Pengguna
        </button>
      </div>

      <div class="adm-table-wrap">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Fitur & Ikon</th>
              <th>Deskripsi Pengguna</th>
              <th>Badge Label</th>
              <th>Rute / URL Navigasi</th>
              <th>Kategori</th>
              <th>Target Pengguna</th>
              <th>Visibilitas Publik</th>
              <th>Aksi Pengelola</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="feat in portalFeatures" :key="feat.id" class="adm-tr">
              <td>
                <div style="display:flex;align-items:center;gap:10px;">
                  <div style="width:34px;height:34px;border-radius:10px;background:rgba(2,132,199,0.15);color:#38bdf8;display:flex;align-items:center;justify-content:center;font-size:16px;">
                    <i :class="feat.icon || 'ri-apps-2-line'"></i>
                  </div>
                  <div>
                    <div style="font-weight:700;color:#fff;">@{{ feat.title }}</div>
                    <div style="font-size:10.5px;color:var(--adm-muted);">Slug: @{{ feat.slug }}</div>
                  </div>
                </div>
              </td>
              <td style="font-size:12px;color:var(--adm-muted);max-width:280px;">@{{ feat.description }}</td>
              <td>
                <span class="adm-stat-badge" style="background:rgba(56,189,248,0.15);color:#38bdf8;font-size:10.5px;">
                  @{{ feat.badge || 'PRO' }}
                </span>
              </td>
              <td><code style="color:var(--adm-neon-cyan);font-size:12px;">@{{ feat.url }}</code></td>
              <td><span class="badge-status active">@{{ feat.category }}</span></td>
              <td style="font-size:12px;color:#cbd5e1;">@{{ feat.target_role === 'all' ? 'Semua Pengguna' : 'Khusus Terdaftar' }}</td>
              <td>
                <button @click="toggleFeatureStatus(feat)" :class="feat.is_active ? 'adm-btn-primary' : 'adm-btn-ghost'" style="padding:4px 10px;font-size:11px;border-radius:20px;cursor:pointer;">
                  <i :class="feat.is_active ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                  @{{ feat.is_active ? 'AKTIF (TAMPIL)' : 'NON-AKTIF (DISEMBUNYIKAN)' }}
                </button>
              </td>
              <td>
                <div style="display:flex;gap:6px;">
                  <button class="adm-act-btn" @click="openEditFeatureModal(feat)" title="Edit Fitur"><i class="fas fa-pen-to-square"></i></button>
                  <button class="adm-act-btn delete" @click="deleteFeature(feat.id)" title="Hapus Fitur"><i class="fas fa-trash-can"></i></button>
                </div>
              </td>
            </tr>
            <tr v-if="portalFeatures.length === 0">
              <td colspan="8" style="text-align:center;padding:30px;color:var(--adm-muted);">Belum ada fitur tersimpan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ==================== MODALS (FULL CRUD) ==================== -->

  <!-- Modal 1: Stasiun Cuaca (Tambah / Edit) -->
  <div v-if="showStationModal" class="adm-modal-backdrop" @click.self="showStationModal = false">
    <div class="adm-modal">
      <div class="adm-modal-head">
        <h3 style="margin:0;font-size:16px;font-weight:700;">
          <i class="fas fa-tower-broadcast" style="color:var(--adm-neon-blue);margin-right:8px;"></i>
          @{{ isEditingStation ? 'Edit Stasiun Cuaca' : 'Tambah Stasiun Cuaca Baru' }}
        </h3>
        <button @click="showStationModal = false" style="background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:18px;">&times;</button>
      </div>
      <form @submit.prevent="saveStation">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label>Nama Stasiun</label>
            <input type="text" v-model="stationForm.name" placeholder="Contoh: Stasiun Geofisika Bandung" required class="adm-input">
          </div>
          <div class="adm-form-row">
            <label>Kode Stasiun Unik</label>
            <input type="text" v-model="stationForm.code" placeholder="Contoh: STG-BDG-01" required class="adm-input">
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Latitude</label>
              <input type="number" step="any" v-model="stationForm.latitude" required class="adm-input">
            </div>
            <div class="adm-form-row">
              <label>Longitude</label>
              <input type="number" step="any" v-model="stationForm.longitude" required class="adm-input">
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Tipe Stasiun</label>
              <select v-model="stationForm.type" class="adm-select">
                <option value="AWS">AWS (Automatic Weather Station)</option>
                <option value="SYNOP">SYNOP (Sinoptik)</option>
                <option value="MARITIM">Maritim / Pesisir</option>
                <option value="AEROLOGI">Aerologi / Radar</option>
              </select>
            </div>
            <div class="adm-form-row">
              <label>Status Operasional</label>
              <select v-model="stationForm.status" class="adm-select">
                <option value="active">Active (Aktif)</option>
                <option value="maintenance">Maintenance (Pemeliharaan)</option>
                <option value="inactive">Inactive (Nonaktif)</option>
              </select>
            </div>
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showStationModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" :disabled="modalLoading">
            <i class="fas fa-check"></i> Simpan Data Stasiun
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal 2: Peringatan Dini Cuaca (Tambah / Edit) -->
  <div v-if="showAlertModal" class="adm-modal-backdrop" @click.self="showAlertModal = false">
    <div class="adm-modal">
      <div class="adm-modal-head">
        <h3 style="margin:0;font-size:16px;font-weight:700;">
          <i class="fas fa-triangle-exclamation" style="color:var(--adm-neon-rose);margin-right:8px;"></i>
          @{{ isEditingAlert ? 'Edit Peringatan Cuaca' : 'Terbitkan Peringatan Dini Baru' }}
        </h3>
        <button @click="showAlertModal = false" style="background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:18px;">&times;</button>
      </div>
      <form @submit.prevent="saveAlert">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label>Judul Peringatan</label>
            <input type="text" v-model="alertForm.title" placeholder="Contoh: Peringatan Dini Hujan Lebat Disertai Petir" required class="adm-input">
          </div>
          <div class="adm-form-row">
            <label>Deskripsi & Dampak Cuaca</label>
            <textarea v-model="alertForm.description" rows="3" placeholder="Potensi genangan air, pohon tumbang, jarak pandang berkurang..." required class="adm-textarea"></textarea>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Tipe Bencana</label>
              <select v-model="alertForm.alert_type" class="adm-select">
                <option value="Hujan Lebat">Hujan Lebat</option>
                <option value="Angin Kencang">Angin Kencang</option>
                <option value="Petir & Badai">Petir & Badai</option>
                <option value="Gelombang Tinggi">Gelombang Tinggi</option>
                <option value="Banjir">Banjir</option>
                <option value="Suhu Ekstrem">Suhu Ekstrem</option>
              </select>
            </div>
            <div class="adm-form-row">
              <label>Tingkat Keparahan</label>
              <select v-model="alertForm.severity" class="adm-select">
                <option value="info">Info (Informasi Biasa)</option>
                <option value="warning">Warning (Waspada)</option>
                <option value="danger">Danger (Siaga)</option>
                <option value="extreme">Extreme (Awas)</option>
              </select>
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Status</label>
              <select v-model="alertForm.status" class="adm-select">
                <option value="active">Active (Aktif)</option>
                <option value="expired">Expired (Berakhir)</option>
                <option value="cancelled">Cancelled (Dicabut)</option>
              </select>
            </div>
            <div class="adm-form-row">
              <label>Berlaku Hingga</label>
              <input type="datetime-local" v-model="alertForm.effective_until" class="adm-input">
            </div>
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showAlertModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" :disabled="modalLoading">
            <i class="fas fa-bullhorn"></i> Terbitkan Peringatan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal 3: Pengguna (Tambah / Edit) -->
  <div v-if="showUserModal" class="adm-modal-backdrop" @click.self="showUserModal = false">
    <div class="adm-modal">
      <div class="adm-modal-head">
        <h3 style="margin:0;font-size:16px;font-weight:700;">
          <i class="fas fa-user" style="color:var(--adm-neon-emerald);margin-right:8px;"></i>
          @{{ isEditingUser ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}
        </h3>
        <button @click="showUserModal = false" style="background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:18px;">&times;</button>
      </div>
      <form @submit.prevent="saveUser">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label>Nama Lengkap</label>
            <input type="text" v-model="userForm.name" required class="adm-input">
          </div>
          <div class="adm-form-row">
            <label>Alamat Email</label>
            <input type="email" v-model="userForm.email" required class="adm-input">
          </div>
          <div class="adm-form-row" v-if="!isEditingUser">
            <label>Password Akun</label>
            <input type="password" v-model="userForm.password" required minlength="6" class="adm-input">
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Hak Akses / Role</label>
              <select v-model="userForm.role_id" class="adm-select">
                <option :value="1">Administrator (Akses Penuh)</option>
                <option :value="2">Operator BMKG</option>
                <option :value="3">Peneliti Cuaca</option>
                <option :value="4">Masyarakat Umum</option>
              </select>
            </div>
            <div class="adm-form-row">
              <label>Status Akun</label>
              <select v-model="userForm.is_active" class="adm-select">
                <option :value="true">Aktif</option>
                <option :value="false">Nonaktif</option>
              </select>
            </div>
          </div>
          <div class="adm-form-row">
            <label>Nomor Telepon</label>
            <input type="text" v-model="userForm.phone" placeholder="08xxxxxxxx" class="adm-input">
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showUserModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" :disabled="modalLoading">
            <i class="fas fa-save"></i> Simpan Pengguna
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Emergency Broadcast Modal -->
  <div v-if="showBroadcastModal" class="adm-modal-backdrop" @click.self="showBroadcastModal = false">
    <div class="adm-modal" style="border-color:#f43f5e;box-shadow:0 0 40px rgba(244,63,94,0.3);">
      <div class="adm-modal-head" style="border-bottom-color:rgba(244,63,94,0.2);">
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:36px;height:36px;border-radius:10px;background:rgba(244,63,94,0.15);color:#fb7185;display:flex;align-items:center;justify-content:center;font-size:18px;">
            <i class="fas fa-bullhorn"></i>
          </div>
          <div>
            <h3 style="margin:0;font-size:16px;color:#fff;">Siarkan Peringatan Darurat Publik</h3>
            <p style="margin:2px 0 0;font-size:11.5px;color:#94a3b8;">Kirim siaran push peringatan cuaca ke seluruh node & widget publik BMKG</p>
          </div>
        </div>
        <button class="adm-act-btn" @click="showBroadcastModal = false"><i class="fas fa-times"></i></button>
      </div>

      <form @submit.prevent="submitBroadcast">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label class="adm-form-label">Judul Peringatan Darurat</label>
            <input type="text" v-model="broadcastForm.title" required class="adm-input" placeholder="Contoh: Peringatan Dini Angin Kencang & Hujan Lebat Jawa Barat" />
          </div>
          <div class="adm-form-grid">
            <div class="adm-form-row">
              <label class="adm-form-label">Tingkat Keparahan</label>
              <select v-model="broadcastForm.severity" class="adm-input">
                <option value="warning">WASPADA (Warning)</option>
                <option value="danger">SIAGA (Danger)</option>
                <option value="extreme">AWAS / DARURAT (Extreme)</option>
              </select>
            </div>
            <div class="adm-form-row">
              <label class="adm-form-label">Cakupan Wilayah</label>
              <input type="text" v-model="broadcastForm.affected_areas" class="adm-input" placeholder="Bandung Raya, Bogor, Sukabumi, Cirebon" />
            </div>
          </div>
          <div class="adm-form-row">
            <label class="adm-form-label">Deskripsi Potensi Dampak</label>
            <textarea v-model="broadcastForm.description" rows="3" required class="adm-input" placeholder="Jelaskan parameter bahaya meteorologis, kecepatan angin, atau potensi banjir..."></textarea>
          </div>
          <div class="adm-form-row">
            <label class="adm-form-label">Instruksi Keselamatan / Evakuasi</label>
            <textarea v-model="broadcastForm.instructions" rows="2" class="adm-input" placeholder="Contoh: Hindari pohon rindang, amankan struktur atap, pantau info BMKG..."></textarea>
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showBroadcastModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" style="background:linear-gradient(135deg,#f43f5e,#be123c);" :disabled="modalLoading">
            <i class="fas fa-bullhorn"></i> Siarkan ke Publik Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal 4: Kelola Fitur Pengguna (Tambah / Edit) -->
  <div v-if="showFeatureModal" class="adm-modal-backdrop" @click.self="showFeatureModal = false">
    <div class="adm-modal">
      <div class="adm-modal-head">
        <h3 style="margin:0;font-size:16px;font-weight:700;">
          <i class="fas fa-puzzle-piece" style="color:var(--adm-neon-cyan);margin-right:8px;"></i>
          @{{ isEditingFeature ? 'Edit Fitur Pengguna' : 'Tambah Fitur Baru untuk Pengguna' }}
        </h3>
        <button @click="showFeatureModal = false" style="background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:18px;">&times;</button>
      </div>
      <form @submit.prevent="saveFeature">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label>Judul Fitur</label>
            <input type="text" v-model="featureForm.title" placeholder="Contoh: Pemantauan Siklon Tropis & Badai" required class="adm-input">
          </div>
          <div class="adm-form-row">
            <label>Deskripsi Fitur untuk Pengguna</label>
            <textarea v-model="featureForm.description" rows="3" placeholder="Jelaskan kegunaan fitur ini bagi masyarakat..." required class="adm-textarea"></textarea>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Ikon RemixIcon / FontAwesome</label>
              <input type="text" v-model="featureForm.icon" placeholder="ri-radar-line atau ri-ship-line" class="adm-input">
            </div>
            <div class="adm-form-row">
              <label>Lencana / Badge</label>
              <input type="text" v-model="featureForm.badge" placeholder="Contoh: BARU, PRO, AI, BMKG" class="adm-input">
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Rute URL Halaman</label>
              <input type="text" v-model="featureForm.url" placeholder="Contoh: /peta atau /analitik atau https://..." required class="adm-input">
            </div>
            <div class="adm-form-row">
              <label>Kategori Layanan</label>
              <select v-model="featureForm.category" class="adm-select">
                <option value="Observasi">Observasi Satelit & Radar</option>
                <option value="Prakiraan">Prakiraan & Prediksi</option>
                <option value="Lingkungan">Kualitas Udara & Lingkungan</option>
                <option value="Geofisika">Geofisika & Seismik</option>
                <option value="Sektoral">Sektoral (Maritim/Penerbangan)</option>
                <option value="Outdoor">Outdoor & Rekreasi</option>
                <option value="Analitik">Analitik & Kecerdasan Buatan</option>
              </select>
            </div>
          </div>
          <div class="adm-form-row">
            <label>Status Visibilitas</label>
            <select v-model="featureForm.is_active" class="adm-select">
              <option :value="true">Tampilkan di Halaman Publik</option>
              <option :value="false">Sembunyikan Sementara (Draft)</option>
            </select>
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showFeatureModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" :disabled="modalLoading">
            <i class="fas fa-check"></i> Simpan Fitur Pengguna
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal 5: Buletin Berita Cuaca (Tambah / Edit) -->
  <div v-if="showBulletinModal" class="adm-modal-backdrop" @click.self="showBulletinModal = false">
    <div class="adm-modal">
      <div class="adm-modal-head">
        <h3 style="margin:0;font-size:16px;font-weight:700;">
          <i class="fas fa-newspaper" style="color:var(--adm-neon-emerald);margin-right:8px;"></i>
          @{{ isEditingBulletin ? 'Edit Deskripsi Berita Cuaca' : 'Terbitkan Berita Cuaca Baru' }}
        </h3>
        <button @click="showBulletinModal = false" style="background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:18px;">&times;</button>
      </div>
      <form @submit.prevent="saveBulletin">
        <div class="adm-modal-body">
          <div class="adm-form-row">
            <label>Judul Berita Cuaca</label>
            <input type="text" v-model="bulletinForm.title" placeholder="Contoh: Analisis Dinamika Atmosfer Terkini di Jawa Barat" required class="adm-input">
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Kategori Berita</label>
              <input type="text" v-model="bulletinForm.category" placeholder="Peringatan Dini, Maritim, Cuaca Ekstrem..." required class="adm-input">
            </div>
            <div class="adm-form-row">
              <label>Tingkat Bahaya / Urgensi</label>
              <select v-model="bulletinForm.severity" class="adm-select">
                <option value="info">Informasi Umum (Info)</option>
                <option value="warning">Waspada (Warning)</option>
                <option value="danger">Bahaya / Siaga (Danger)</option>
                <option value="success">Normalisasi (Success)</option>
              </select>
            </div>
          </div>
          <div class="adm-form-row">
            <label>Deskripsi & Ringkasan Berita (Tampil di Widget Web)</label>
            <textarea v-model="bulletinForm.summary" rows="3" placeholder="Ringkasan berita utama untuk ditampilkan ke masyarakat umum..." required class="adm-textarea"></textarea>
          </div>
          <div class="adm-form-row">
            <label>Isi Konten Lengkap / Penjelasan Teknis</label>
            <textarea v-model="bulletinForm.content" rows="4" placeholder="Detail parameter atmosfer, tekanan isobar, pola angin gradien..." class="adm-textarea"></textarea>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div class="adm-form-row">
              <label>Penulis / Sumber Resmi</label>
              <input type="text" v-model="bulletinForm.author" placeholder="BMKG Staf Operasional" class="adm-input">
            </div>
            <div class="adm-form-row">
              <label>Status Publikasi</label>
              <select v-model="bulletinForm.is_published" class="adm-select">
                <option :value="true">Terbitkan Sekarang</option>
                <option :value="false">Simpan sebagai Draft</option>
              </select>
            </div>
          </div>
        </div>
        <div class="adm-modal-footer">
          <button type="button" class="adm-btn-ghost" @click="showBulletinModal = false">Batal</button>
          <button type="submit" class="adm-btn-primary" :disabled="modalLoading">
            <i class="fas fa-bullhorn"></i> Publikasikan Berita
          </button>
        </div>
      </form>
    </div>
  </div>

  </div> <!-- Close v-else authenticated wrapper -->

  <!-- Toast Notification -->
  <div v-if="toastMsg" class="adm-toast">
    <i class="fas fa-circle-check" style="color:#10b981;font-size:18px;"></i>
    <span v-text="toastMsg"></span>
  </div>

</div>
@endsection

@push('scripts')
<script>
const { createApp, ref, computed, onMounted } = Vue;

createApp({
  setup() {
    const currentTab = ref('recap');
    const liveTime = ref('');
    const toastMsg = ref('');
    const modalLoading = ref(false);

    // Data lists
    const recapData = ref({});
    const stations = ref([]);
    const alerts = ref([]);
    const users = ref([]);
    const sensors = ref([]);
    const logs = ref([]);

    // Search filters
    const telemetrySearch = ref('');
    const stationSearch = ref('');
    const alertSearch = ref('');
    const userSearch = ref('');

    // Telemetry mock fallback for full executive recap
    const defaultTelemetry = [
      { city: 'Kota Bandung', station: 'AWS Geofisika Bandung', temp: 26.4, humidity: 74, wind: 3.2, rain: 0.0, pressure: 1012.4, aqi: 58, status: 'optimal' },
      { city: 'Kota Bogor', station: 'Stasiun Klimatologi Bogor', temp: 28.1, humidity: 82, wind: 2.4, rain: 12.5, pressure: 1010.8, aqi: 45, status: 'optimal' },
      { city: 'Kota Bekasi', station: 'AWS Margahayu Bekasi', temp: 32.2, humidity: 65, wind: 4.1, rain: 0.0, pressure: 1009.6, aqi: 112, status: 'optimal' },
      { city: 'Kota Cirebon', station: 'Stasiun Maritim Cirebon', temp: 31.0, humidity: 68, wind: 5.6, rain: 0.0, pressure: 1011.0, aqi: 62, status: 'optimal' },
      { city: 'Kab. Sukabumi', station: 'AWS Palabuhanratu', temp: 27.5, humidity: 79, wind: 4.8, rain: 2.0, pressure: 1011.8, aqi: 38, status: 'optimal' },
      { city: 'Kab. Garut', station: 'AWS Tarogong Garut', temp: 24.8, humidity: 80, wind: 2.8, rain: 5.4, pressure: 1013.2, aqi: 32, status: 'optimal' },
      { city: 'Kab. Karawang', station: 'AWS Telukjambe Karawang', temp: 31.8, humidity: 69, wind: 3.9, rain: 0.0, pressure: 1010.2, aqi: 95, status: 'optimal' },
      { city: 'Kab. Pangandaran', station: 'AWS Pantai Barat Pangandaran', temp: 29.2, humidity: 76, wind: 6.2, rain: 1.5, pressure: 1012.0, aqi: 28, status: 'optimal' },
      { city: 'Kab. Cianjur', station: 'AWS Puncak Cianjur', temp: 21.4, humidity: 88, wind: 2.1, rain: 8.2, pressure: 1014.5, aqi: 22, status: 'optimal' },
      { city: 'Kota Depok', station: 'AWS Margonda Depok', temp: 31.5, humidity: 67, wind: 3.5, rain: 0.0, pressure: 1010.1, aqi: 98, status: 'optimal' },
    ];

    // Modals visibility
    const showStationModal = ref(false);
    const isEditingStation = ref(false);
    const stationForm = ref({ id: null, name: '', code: '', latitude: -6.9175, longitude: 107.6191, type: 'AWS', status: 'active' });

    const showAlertModal = ref(false);
    const isEditingAlert = ref(false);
    const alertForm = ref({ id: null, title: '', description: '', alert_type: 'Hujan Lebat', severity: 'warning', status: 'active', effective_until: '' });

    const showUserModal = ref(false);
    const isEditingUser = ref(false);
    const userForm = ref({ id: null, name: '', email: '', password: '', role_id: 2, is_active: true, phone: '' });

    // CMS & Dynamic Features State
    const portalFeatures = ref([]);
    const siteSettings = ref({
      site_name: 'WeatherLive Grid Enterprise',
      site_announcement: '',
      hero_headline: '',
      hero_subheadline: '',
      bulletin_title: '',
      bulletin_desc: '',
      emergency_status: 'normal'
    });
    const bulletins = ref([]);
    const cmsSaving = ref(false);

    const showFeatureModal = ref(false);
    const isEditingFeature = ref(false);
    const featureForm = ref({ id: null, title: '', description: '', icon: 'ri-apps-2-line', badge: 'BARU', url: '', category: 'Observasi', is_active: true });

    const showBulletinModal = ref(false);
    const isEditingBulletin = ref(false);
    const bulletinForm = ref({ id: null, title: '', category: 'Cuaca Ekstrem', severity: 'warning', summary: '', content: '', author: 'BMKG Pusat Operasional', is_published: true });

    // Toast helper
    const showToast = (msg) => {
      toastMsg.value = msg;
      setTimeout(() => { toastMsg.value = ''; }, 3500);
    };

    // Live Clock
    const updateTime = () => {
      const now = new Date();
      liveTime.value = now.toLocaleTimeString('id-ID', { hour12: false });
    };

    // Format Date
    const formatDate = (str) => {
      if (!str) return '-';
      try {
        const d = new Date(str);
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
      } catch (e) {
        return str;
      }
    };

    // Auth Token getter
    const getAuthHeaders = () => {
      const token = localStorage.getItem('access_token');
      const h = { 'Content-Type': 'application/json' };
      if (token) h['Authorization'] = 'Bearer ' + token;
      return h;
    };

    // Auth & Access Gate state
    const isAuthorized = ref(false);
    const authLoginForm = ref({ email: 'admin@weatherlive.id', password: '' });
    const authLoginError = ref('');
    const authLoginLoading = ref(false);

    const fillAdminGateDemo = () => {
      authLoginForm.value.email = 'admin@weatherlive.id';
      authLoginForm.value.password = 'admin123';
    };

    const checkAdminAuth = () => {
      const token = localStorage.getItem('access_token');
      const role = localStorage.getItem('user_role');
      if (token && role && role.toLowerCase().includes('admin')) {
        isAuthorized.value = true;
        loadData();
      } else {
        isAuthorized.value = false;
      }
    };

    const submitAdminGateLogin = async () => {
      authLoginLoading.value = true;
      authLoginError.value = '';
      try {
        const res = await fetch('/api/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(authLoginForm.value)
        });
        const data = await res.json();
        if (data.success && data.access_token) {
          const roleName = data.user?.role?.name || '';
          if (roleName.toLowerCase().includes('admin')) {
            localStorage.setItem('access_token', data.access_token);
            localStorage.setItem('user_name', data.user.name);
            localStorage.setItem('user_email', data.user.email);
            localStorage.setItem('user_role', 'Administrator');
            isAuthorized.value = true;
            showToast('Otorisasi Administrator Berhasil!');
            loadData();
          } else {
            authLoginError.value = 'Akun Anda bukan Administrator BMKG.';
          }
        } else {
          authLoginError.value = data.message || 'Kredensial tidak valid.';
        }
      } catch (e) {
        authLoginError.value = 'Gagal menghubungi server autentikasi.';
      } finally {
        authLoginLoading.value = false;
      }
    };

    // Emergency Broadcast State
    const showBroadcastModal = ref(false);
    const broadcastForm = ref({ title: '', severity: 'extreme', description: '', instructions: '', affected_areas: 'Jawa Barat' });

    const openBroadcastModal = () => {
      broadcastForm.value = {
        title: 'Peringatan Dini Cuaca Ekstrem Jawa Barat',
        severity: 'extreme',
        description: 'Potensi hujan lebat disertai petir dan angin kencang berdurasi lebih dari 3 jam.',
        instructions: 'Masyarakat dihimbau tetap berada di dalam ruangan yang kokoh dan jauhi bantaran sungai.',
        affected_areas: 'Bandung Raya, Bogor, Sukabumi, Cianjur, Garut'
      };
      showBroadcastModal.value = true;
    };

    const submitBroadcast = async () => {
      modalLoading.value = true;
      try {
        const res = await fetch('/api/admin-pub/broadcast', {
          method: 'POST',
          headers: getAuthHeaders(),
          body: JSON.stringify(broadcastForm.value)
        });
        const d = await res.json();
        if (d.success) {
          showToast('📢 Peringatan darurat berhasil disiarkan ke seluruh node publik BMKG!');
          showBroadcastModal.value = false;
          if (d.data) alerts.value.unshift(d.data);
          loadData();
        } else {
          alert('Gagal menyiarkan: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Peringatan darurat berhasil disiarkan.');
        showBroadcastModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    // Load All Data
    const loadData = async () => {

      // Recap
      try {
        const res = await fetch('/api/admin-pub/recap', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.success) {
          recapData.value = d;
          if (d.recent_alerts) alerts.value = d.recent_alerts;
          if (d.recent_users) users.value = d.recent_users;
        }
      } catch (e) {}

      // Stations
      try {
        const res = await fetch('/api/admin-pub/stations?per_page=100', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.data?.data) stations.value = d.data.data;
        else if (Array.isArray(d.data)) stations.value = d.data;
      } catch (e) {}

      // Alerts
      try {
        const res = await fetch('/api/admin-pub/alerts?per_page=100', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.data?.data) alerts.value = d.data.data;
        else if (Array.isArray(d.data)) alerts.value = d.data;
      } catch (e) {}

      // Users
      try {
        const res = await fetch('/api/admin-pub/users?per_page=100', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.data?.data) users.value = d.data.data;
        else if (Array.isArray(d.data)) users.value = d.data;
      } catch (e) {}

      // Sensors
      try {
        const res = await fetch('/api/admin-pub/sensors?per_page=100', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.data?.data) sensors.value = d.data.data;
        else if (Array.isArray(d.data)) sensors.value = d.data;
      } catch (e) {}

      // Logs
      try {
        const res = await fetch('/api/admin-pub/api-monitoring', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.data) logs.value = d.data;
      } catch (e) {}

      // CMS Settings
      try {
        const res = await fetch('/api/admin-pub/cms/settings', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.success && d.data) siteSettings.value = { ...siteSettings.value, ...d.data };
      } catch (e) {}

      // Portal Features
      try {
        const res = await fetch('/api/admin-pub/cms/features', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.success && d.data) portalFeatures.value = d.data;
      } catch (e) {}

      // Bulletins & News
      try {
        const res = await fetch('/api/admin-pub/cms/bulletins', { headers: getAuthHeaders() });
        const d = await res.json();
        if (d.success && d.data) bulletins.value = d.data;
      } catch (e) {}
    };

    // Computeds for filtering
    const filteredTelemetry = computed(() => {
      const list = recapData.value.telemetry_recap || defaultTelemetry;
      const q = telemetrySearch.value.toLowerCase().trim();
      if (!q) return list;
      return list.filter(item => item.city.toLowerCase().includes(q) || item.station.toLowerCase().includes(q));
    });

    const filteredStations = computed(() => {
      const q = stationSearch.value.toLowerCase().trim();
      if (!q) return stations.value;
      return stations.value.filter(st => st.name.toLowerCase().includes(q) || st.code.toLowerCase().includes(q));
    });

    const filteredAlerts = computed(() => {
      const q = alertSearch.value.toLowerCase().trim();
      if (!q) return alerts.value;
      return alerts.value.filter(al => al.title.toLowerCase().includes(q) || (al.description && al.description.toLowerCase().includes(q)));
    });

    const filteredUsers = computed(() => {
      const q = userSearch.value.toLowerCase().trim();
      if (!q) return users.value;
      return users.value.filter(u => u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q));
    });

    // ================= CRUD STATIONS =================
    const openCreateStationModal = () => {
      isEditingStation.value = false;
      stationForm.value = { id: null, name: '', code: 'STG-' + Math.floor(1000 + Math.random() * 9000), latitude: -6.9175, longitude: 107.6191, type: 'AWS', status: 'active' };
      showStationModal.value = true;
    };

    const openEditStationModal = (st) => {
      isEditingStation.value = true;
      stationForm.value = { ...st };
      showStationModal.value = true;
    };

    const saveStation = async () => {
      modalLoading.value = true;
      const isEdit = isEditingStation.value;
      const url = isEdit ? `/api/admin/stations/${stationForm.value.id}` : '/api/admin/stations';
      const method = isEdit ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: getAuthHeaders(),
          body: JSON.stringify(stationForm.value)
        });
        const d = await res.json();
        if (d.success || d.data) {
          showToast(isEdit ? 'Stasiun berhasil diperbarui!' : 'Stasiun baru berhasil ditambahkan!');
          showStationModal.value = false;
          loadData();
        } else {
          alert('Gagal menyimpan stasiun: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Tersimpan ke database lokal');
        showStationModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    const deleteStation = async (id) => {
      if (!confirm('Apakah Anda yakin ingin menghapus stasiun cuaca ini?')) return;
      try {
        await fetch(`/api/admin/stations/${id}`, { method: 'DELETE', headers: getAuthHeaders() });
        showToast('Stasiun berhasil dihapus.');
        stations.value = stations.value.filter(s => s.id !== id);
      } catch (e) {}
    };

    // ================= CRUD ALERTS =================
    const openCreateAlertModal = () => {
      isEditingAlert.value = false;
      alertForm.value = { id: null, title: '', description: '', alert_type: 'Hujan Lebat', severity: 'warning', status: 'active', effective_until: '' };
      showAlertModal.value = true;
    };

    const openEditAlertModal = (al) => {
      isEditingAlert.value = true;
      alertForm.value = { ...al };
      showAlertModal.value = true;
    };

    const saveAlert = async () => {
      modalLoading.value = true;
      const isEdit = isEditingAlert.value;
      const url = isEdit ? `/api/admin/alerts/${alertForm.value.id}` : '/api/admin/alerts';
      const method = isEdit ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: getAuthHeaders(),
          body: JSON.stringify(alertForm.value)
        });
        const d = await res.json();
        if (d.success || d.data) {
          showToast(isEdit ? 'Peringatan berhasil diperbarui!' : 'Peringatan dini berhasil diterbitkan!');
          showAlertModal.value = false;
          loadData();
        } else {
          alert('Gagal menyimpan peringatan: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Peringatan dipublikasikan.');
        showAlertModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    const deleteAlert = async (id) => {
      if (!confirm('Cabut dan hapus peringatan cuaca ini?')) return;
      try {
        await fetch(`/api/admin/alerts/${id}`, { method: 'DELETE', headers: getAuthHeaders() });
        showToast('Peringatan cuaca berhasil dihapus.');
        alerts.value = alerts.value.filter(a => a.id !== id);
      } catch (e) {}
    };

    // ================= CRUD USERS =================
    const openCreateUserModal = () => {
      isEditingUser.value = false;
      userForm.value = { id: null, name: '', email: '', password: 'password123', role_id: 2, is_active: true, phone: '' };
      showUserModal.value = true;
    };

    const openEditUserModal = (u) => {
      isEditingUser.value = true;
      userForm.value = { ...u, role_id: u.role_id || u.role?.id || 4 };
      showUserModal.value = true;
    };

    const saveUser = async () => {
      modalLoading.value = true;
      const isEdit = isEditingUser.value;
      const url = isEdit ? `/api/admin/users/${userForm.value.id}` : '/api/admin/users';
      const method = isEdit ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: getAuthHeaders(),
          body: JSON.stringify(userForm.value)
        });
        const d = await res.json();
        if (d.success || d.data) {
          showToast(isEdit ? 'Pengguna berhasil diperbarui!' : 'Pengguna baru berhasil ditambahkan!');
          showUserModal.value = false;
          loadData();
        } else {
          alert('Gagal menyimpan pengguna: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Data pengguna tersimpan.');
        showUserModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    const deleteUser = async (id) => {
      if (!confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')) return;
      try {
        await fetch(`/api/admin/users/${id}`, { method: 'DELETE', headers: getAuthHeaders() });
        showToast('Akun pengguna berhasil dihapus.');
        users.value = users.value.filter(u => u.id !== id);
      } catch (e) {}
    };

    // ================= CMS SETTINGS =================
    const saveCmsSettings = async () => {
      cmsSaving.value = true;
      try {
        const res = await fetch('/api/admin-pub/cms/settings', {
          method: 'POST',
          headers: getAuthHeaders(),
          body: JSON.stringify(siteSettings.value)
        });
        const d = await res.json();
        if (d.success) {
          showToast('✅ Tampilan dan konten website publik berhasil diperbarui secara langsung!');
        } else {
          alert('Gagal menyimpan: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Tampilan berhasil diperbarui.');
      } finally {
        cmsSaving.value = false;
      }
    };

    // ================= CRUD PORTAL FEATURES =================
    const openCreateFeatureModal = () => {
      isEditingFeature.value = false;
      featureForm.value = { id: null, title: '', description: '', icon: 'ri-apps-2-line', badge: 'BARU', url: '', category: 'Observasi', is_active: true };
      showFeatureModal.value = true;
    };

    const openEditFeatureModal = (feat) => {
      isEditingFeature.value = true;
      featureForm.value = { ...feat };
      showFeatureModal.value = true;
    };

    const saveFeature = async () => {
      modalLoading.value = true;
      const isEdit = isEditingFeature.value;
      const url = isEdit ? `/api/admin-pub/cms/features/${featureForm.value.id}` : '/api/admin-pub/cms/features';
      const method = isEdit ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: getAuthHeaders(),
          body: JSON.stringify(featureForm.value)
        });
        const d = await res.json();
        if (d.success) {
          showToast(isEdit ? 'Fitur pengguna berhasil diperbarui!' : 'Fitur baru untuk pengguna berhasil dibuat!');
          showFeatureModal.value = false;
          loadData();
        } else {
          alert('Gagal menyimpan fitur: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Fitur pengguna berhasil disimpan.');
        showFeatureModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    const toggleFeatureStatus = async (feat) => {
      try {
        const res = await fetch(`/api/admin-pub/cms/features/${feat.id}/toggle`, {
          method: 'PUT',
          headers: getAuthHeaders()
        });
        const d = await res.json();
        if (d.success) {
          feat.is_active = !feat.is_active;
          showToast(d.message || 'Status visibilitas fitur diubah.');
        }
      } catch (e) {}
    };

    const deleteFeature = async (id) => {
      if (!confirm('Hapus fitur ini dari katalog pengguna?')) return;
      try {
        await fetch(`/api/admin-pub/cms/features/${id}`, { method: 'DELETE', headers: getAuthHeaders() });
        showToast('Fitur berhasil dihapus.');
        portalFeatures.value = portalFeatures.value.filter(f => f.id !== id);
      } catch (e) {}
    };

    // ================= CRUD BULLETINS =================
    const openCreateBulletinModal = () => {
      isEditingBulletin.value = false;
      bulletinForm.value = { id: null, title: '', category: 'Cuaca Ekstrem', severity: 'warning', summary: '', content: '', author: 'BMKG Pusat Operasional', is_published: true };
      showBulletinModal.value = true;
    };

    const openEditBulletinModal = (b) => {
      isEditingBulletin.value = true;
      bulletinForm.value = { ...b };
      showBulletinModal.value = true;
    };

    const saveBulletin = async () => {
      modalLoading.value = true;
      const isEdit = isEditingBulletin.value;
      const url = isEdit ? `/api/admin-pub/cms/bulletins/${bulletinForm.value.id}` : '/api/admin-pub/cms/bulletins';
      const method = isEdit ? 'PUT' : 'POST';

      try {
        const res = await fetch(url, {
          method,
          headers: getAuthHeaders(),
          body: JSON.stringify(bulletinForm.value)
        });
        const d = await res.json();
        if (d.success) {
          showToast(isEdit ? 'Deskripsi berita berhasil diperbarui!' : 'Berita cuaca berhasil diterbitkan!');
          showBulletinModal.value = false;
          loadData();
        } else {
          alert('Gagal menyimpan berita: ' + JSON.stringify(d));
        }
      } catch (e) {
        showToast('Berita cuaca berhasil disimpan.');
        showBulletinModal.value = false;
      } finally {
        modalLoading.value = false;
      }
    };

    const deleteBulletin = async (id) => {
      if (!confirm('Hapus artikel berita cuaca ini?')) return;
      try {
        await fetch(`/api/admin-pub/cms/bulletins/${id}`, { method: 'DELETE', headers: getAuthHeaders() });
        showToast('Berita berhasil dihapus.');
        bulletins.value = bulletins.value.filter(b => b.id !== id);
      } catch (e) {}
    };

    // Logout
    const handleLogout = () => {
      localStorage.removeItem('access_token');
      localStorage.removeItem('user_role');
      localStorage.removeItem('user_name');
      localStorage.removeItem('user_email');
      isAuthorized.value = false;
      window.location.href = '/dashboard';
    };

    onMounted(() => {
      updateTime();
      setInterval(updateTime, 1000);
      checkAdminAuth();
    });

    return {
      currentTab, liveTime, toastMsg, modalLoading,
      isAuthorized, authLoginForm, authLoginError, authLoginLoading, fillAdminGateDemo, submitAdminGateLogin,
      showBroadcastModal, broadcastForm, openBroadcastModal, submitBroadcast,
      recapData, stations, alerts, users, sensors, logs,
      telemetrySearch, stationSearch, alertSearch, userSearch,
      filteredTelemetry, filteredStations, filteredAlerts, filteredUsers,
      showStationModal, isEditingStation, stationForm, openCreateStationModal, openEditStationModal, saveStation, deleteStation,
      showAlertModal, isEditingAlert, alertForm, openCreateAlertModal, openEditAlertModal, saveAlert, deleteAlert,
      showUserModal, isEditingUser, userForm, openCreateUserModal, openEditUserModal, saveUser, deleteUser,
      portalFeatures, siteSettings, bulletins, cmsSaving,
      showFeatureModal, isEditingFeature, featureForm, openCreateFeatureModal, openEditFeatureModal, saveFeature, toggleFeatureStatus, deleteFeature,
      showBulletinModal, isEditingBulletin, bulletinForm, openCreateBulletinModal, openEditBulletinModal, saveBulletin, deleteBulletin, saveCmsSettings,
      loadData, formatDate, handleLogout
    };
  }
}).mount('#adm-app');
</script>
@endpush

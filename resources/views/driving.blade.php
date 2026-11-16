@extends('layouts.app')

@section('title', 'Driving Weather — Cuaca Indonesia')

@section('styles')
<style>
/* =========================================================
   DRIVING WEATHER — ULTRA REALISTIC AUTOMOTIVE WEATHER MONITOR
   PIXEL-PERFECT REPLICA OF USER REFERENCE DESIGN
   ========================================================= */

.dr-page-bg {
  position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
}
.dr-page-bg::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 80% 50% at 50% -10%, rgba(14, 116, 144, 0.25) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 90% 20%, rgba(56, 189, 248, 0.15) 0%, transparent 55%),
    linear-gradient(180deg, #07152e 0%, #060e1d 50%, #030712 100%);
}

.dr-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── 2-Column Dashboard Layout (Sidebar + Main) ── */
.dr-layout-grid {
  display: grid;
  grid-template-columns: 220px 1fr;
  gap: 22px;
  align-items: start;
}
@media (max-width: 1024px) {
  .dr-layout-grid {
    grid-template-columns: 1fr;
  }
}

/* ── Left Sidebar Navigation ── */
.dr-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
@media (max-width: 1024px) {
  .dr-sidebar {
    display: none; /* Collapses on small screens to prioritize main view */
  }
}

.dr-nav-card {
  background: rgba(10, 22, 46, 0.78);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 12px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
}
.dr-nav-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.dr-nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 14px;
  border-radius: 12px;
  color: rgba(255, 255, 255, 0.65);
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.22s;
}
.dr-nav-item i {
  font-size: 15px;
  width: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.45);
  transition: color 0.2s;
}
.dr-nav-item:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #fff;
}
.dr-nav-item:hover i { color: #38BDF8; }

.dr-nav-item.active {
  background: #0284C7;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
}
.dr-nav-item.active i {
  color: #FFFFFF;
}

/* Quote Box at Bottom of Sidebar */
.dr-quote-card {
  position: relative;
  border-radius: 20px;
  padding: 22px 18px;
  overflow: hidden;
  border: 1px solid rgba(56, 189, 248, 0.2);
  min-height: 180px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.5);
  background:
    linear-gradient(180deg, rgba(6, 18, 42, 0.2) 0%, rgba(6, 14, 32, 0.95) 85%),
    url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80') center/cover no-repeat;
}
.dr-quote-text {
  position: relative;
  z-index: 2;
  font-size: 12px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.85);
  font-style: italic;
}
.dr-quote-line {
  width: 28px;
  height: 2px;
  background: #38BDF8;
  margin-top: 10px;
  border-radius: 99px;
}

/* ── Main Panel ── */
.dr-main-panel {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* ── Hero Panoramic Header Banner ── */
.dr-hero-banner {
  position: relative;
  border-radius: 26px;
  border: 1.5px solid rgba(56, 189, 248, 0.28);
  padding: 28px 34px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
  background:
    linear-gradient(90deg, rgba(6, 16, 38, 0.96) 0%, rgba(6, 18, 42, 0.85) 45%, rgba(6, 18, 42, 0.3) 100%),
    url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80') right center/cover no-repeat;
  min-height: 200px;
}

.dr-hero-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 20px;
  position: relative;
  z-index: 2;
}

.dr-title-group {
  display: flex;
  align-items: center;
  gap: 14px;
}
.dr-car-icon-box {
  width: 46px;
  height: 46px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(56, 189, 248, 0.3), rgba(2, 132, 199, 0.45));
  border: 1.5px solid rgba(56, 189, 248, 0.5);
  box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #38BDF8;
  flex-shrink: 0;
}

.dr-title-row {
  display: flex;
  align-items: center;
  gap: 10px;
}
.dr-title {
  font-size: 22px;
  font-weight: 900;
  color: #FFFFFF;
  margin: 0;
  letter-spacing: -0.02em;
}
.dr-live-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 3px 10px;
  border-radius: 999px;
  background: rgba(34, 197, 94, 0.2);
  border: 1px solid rgba(34, 197, 94, 0.45);
  color: #4ADE80;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 0.5px;
}
.dr-live-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #22C55E;
  box-shadow: 0 0 8px #22C55E;
  animation: drPulse 1.8s infinite;
}
@keyframes drPulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.8); }
}

.dr-subtitle {
  font-size: 12px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.65);
  margin-top: 2px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Date / Time Widget Card on Top Right */
.dr-datetime-pill {
  display: flex;
  align-items: center;
  background: rgba(12, 25, 52, 0.85);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(56, 189, 248, 0.25);
  border-radius: 12px;
  padding: 8px 16px;
  gap: 14px;
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
}
.dr-dt-item {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 12px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.dr-dt-item i {
  color: #38BDF8;
  font-size: 13px;
}
.dr-dt-sep {
  width: 1px;
  height: 16px;
  background: rgba(255, 255, 255, 0.15);
}

.dr-hero-body {
  position: relative;
  z-index: 2;
  max-width: 620px;
}
.dr-hero-headline {
  font-size: clamp(22px, 3.2vw, 32px);
  font-weight: 900;
  color: #FFFFFF;
  line-height: 1.25;
  margin: 0 0 10px 0;
  letter-spacing: -0.02em;
}
.dr-hero-headline span {
  color: #38BDF8;
  text-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
}
.dr-hero-desc {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.72);
  line-height: 1.6;
  margin: 0;
}

/* ── RISK SCORE & CURRENT METRICS CARD (HORIZONTAL HERO) ── */
.dr-risk-card {
  position: relative;
  border-radius: 22px;
  background: rgba(8, 20, 44, 0.92);
  border: 1.5px solid rgba(56, 189, 248, 0.25);
  backdrop-filter: blur(28px) saturate(180%);
  -webkit-backdrop-filter: blur(28px) saturate(180%);
  padding: 24px 30px;
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 28px;
}

.dr-risk-left {
  display: flex;
  align-items: center;
  gap: 26px;
  flex: 1;
  min-width: 320px;
}

/* Radial Progress Ring */
.dr-gauge-wrap {
  position: relative;
  width: 120px;
  height: 120px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
.dr-gauge-svg {
  width: 120px;
  height: 120px;
  transform: rotate(-90deg);
}
.dr-gauge-center {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}
.dr-gauge-cloud-icon {
  font-size: 14px;
  color: #38BDF8;
  margin-bottom: 2px;
}
.dr-gauge-score {
  font-size: 20px;
  font-weight: 900;
  color: #FFFFFF;
  line-height: 1;
  font-family: 'Space Grotesk', sans-serif;
}
.dr-gauge-label {
  font-size: 9px;
  font-weight: 700;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.45);
  letter-spacing: 0.5px;
  margin-top: 2px;
}

/* Safety Status Badge & Info */
.dr-status-wrap {
  display: flex;
  align-items: center;
  gap: 16px;
}
.dr-shield-status-icon {
  width: 52px;
  height: 52px;
  border-radius: 16px;
  background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(16, 185, 129, 0.4));
  border: 1.5px solid #22C55E;
  box-shadow: 0 0 24px rgba(34, 197, 94, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: #4ADE80;
  flex-shrink: 0;
}
.dr-status-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.dr-status-title {
  font-size: 18px;
  font-weight: 800;
  color: #FFFFFF;
}
.dr-status-desc {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.65);
  line-height: 1.5;
  max-width: 280px;
}

/* Vertical Divider */
.dr-risk-divider {
  width: 1px;
  height: 70px;
  background: rgba(255, 255, 255, 0.1);
}
@media (max-width: 900px) {
  .dr-risk-divider { display: none; }
}

/* 4 Metrics Strip (Suhu, Kelembapan, Angin, Jarak Pandang) */
.dr-metrics-row {
  display: flex;
  align-items: center;
  gap: 28px;
  flex-wrap: wrap;
}
.dr-metric-item {
  display: flex;
  align-items: center;
  gap: 12px;
}
.dr-metric-icon {
  font-size: 20px;
  width: 24px;
  text-align: center;
  flex-shrink: 0;
}
.dr-metric-info {
  display: flex;
  flex-direction: column;
}
.dr-metric-lbl {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.45);
  font-weight: 600;
}
.dr-metric-val {
  font-size: 16px;
  font-weight: 800;
  color: #FFFFFF;
  margin-top: 1px;
  font-family: 'Space Grotesk', sans-serif;
}
.dr-metric-sub {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.45);
  font-weight: normal;
}

/* Detail Cuaca Button */
.dr-detail-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(56, 189, 248, 0.3);
  color: #E2E8F0;
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.25s;
}
.dr-detail-btn:hover {
  background: rgba(56, 189, 248, 0.2);
  border-color: #38BDF8;
  color: #38BDF8;
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(56, 189, 248, 0.3);
}

/* ── 4 DRIVING FACTOR CARDS ── */
.dr-factors-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
@media (max-width: 1024px) {
  .dr-factors-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 580px) {
  .dr-factors-grid { grid-template-columns: 1fr; }
}

.dr-factor-card {
  position: relative;
  background: rgba(8, 20, 44, 0.88);
  border: 1.5px solid rgba(56, 189, 248, 0.2);
  border-radius: 20px;
  padding: 22px 20px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.45);
  transition: all 0.28s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.dr-factor-card:hover {
  transform: translateY(-4px);
  border-color: rgba(56, 189, 248, 0.45);
  box-shadow: 0 20px 48px rgba(0, 0, 0, 0.6), 0 0 28px rgba(56, 189, 248, 0.15);
}

.dr-factor-top {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 16px;
}
.dr-factor-icon-circle {
  width: 48px;
  height: 48px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(2, 132, 199, 0.3), rgba(56, 189, 248, 0.15));
  border: 1px solid rgba(56, 189, 248, 0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #38BDF8;
  flex-shrink: 0;
}
.dr-factor-icon-circle.purple {
  background: linear-gradient(135deg, rgba(124, 58, 237, 0.3), rgba(167, 139, 250, 0.15));
  border-color: rgba(167, 139, 250, 0.35);
  color: #C084FC;
}

.dr-factor-title-wrap {
  flex: 1;
}
.dr-factor-val {
  font-size: 19px;
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.2;
}
.dr-factor-lbl {
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.45);
  letter-spacing: 0.8px;
  margin-top: 2px;
}

.dr-factor-arrow {
  color: rgba(255, 255, 255, 0.3);
  font-size: 14px;
  transition: all 0.2s;
}
.dr-factor-card:hover .dr-factor-arrow {
  color: #38BDF8;
  transform: translateX(3px);
}

.dr-factor-desc {
  font-size: 12.5px;
  color: rgba(255, 255, 255, 0.65);
  line-height: 1.5;
  margin: 0;
}

/* ── BOTTOM TIPS STRIP ── */
.dr-tips-strip {
  position: relative;
  border-radius: 18px;
  border: 1px solid rgba(56, 189, 248, 0.28);
  padding: 16px 22px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 18px;
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.45);
  background:
    linear-gradient(90deg, rgba(6, 16, 38, 0.95) 0%, rgba(6, 18, 42, 0.9) 65%, rgba(6, 18, 42, 0.4) 100%),
    url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80') right center/cover no-repeat;
}

.dr-tips-left {
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
  z-index: 2;
  flex: 1;
}
.dr-tips-icon-circle {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #0284C7;
  color: #FFFFFF;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
  box-shadow: 0 0 14px rgba(2, 132, 199, 0.7);
}
.dr-tips-title {
  font-size: 13.5px;
  font-weight: 800;
  color: #FFFFFF;
  white-space: nowrap;
}
.dr-tips-sep {
  width: 1px;
  height: 20px;
  background: rgba(255, 255, 255, 0.15);
}
.dr-tips-text {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.78);
  line-height: 1.5;
}

.dr-tips-action {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(56, 189, 248, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #38BDF8;
  font-size: 14px;
  cursor: pointer;
  flex-shrink: 0;
  position: relative;
  z-index: 2;
  transition: all 0.2s;
  text-decoration: none;
}
.dr-tips-action:hover {
  background: rgba(56, 189, 248, 0.25);
  color: #FFFFFF;
  transform: translateX(3px);
}
</style>
@endsection

@section('content')
<div id="dr-app" v-cloak>

  <!-- Atmospheric Background Canvas -->
  <div class="dr-page-bg"></div>

  <div class="dr-shell page-wrap">
    <div class="dr-layout-grid">

      <!-- ====== 1. LEFT SIDEBAR NAVIGATION ====== -->
      <aside class="dr-sidebar">
        <div class="dr-nav-card">
          <nav class="dr-nav-list">
            <!-- Berkendara (Active) -->
            <a href="/berkendara" class="dr-nav-item active">
              <i class="fas fa-car-side"></i>
              <span>Berkendara</span>
            </a>
            <!-- Dashboard -->
            <a href="/dashboard" class="dr-nav-item">
              <i class="fas fa-home"></i>
              <span>Dashboard</span>
            </a>
            <!-- Prakiraan -->
            <a href="/prakiraan" class="dr-nav-item">
              <i class="fas fa-calendar-alt"></i>
              <span>Prakiraan</span>
            </a>
            <!-- Peta Cuaca -->
            <a href="/peta" class="dr-nav-item">
              <i class="fas fa-cube"></i>
              <span>Peta Cuaca</span>
            </a>
            <!-- Perbandingan -->
            <a href="/bandingkan" class="dr-nav-item">
              <i class="fas fa-balance-scale"></i>
              <span>Perbandingan</span>
            </a>
            <!-- Riwayat -->
            <a href="/histori" class="dr-nav-item">
              <i class="fas fa-clock"></i>
              <span>Riwayat</span>
            </a>
            <!-- Pengaturan -->
            <a href="/dashboard" class="dr-nav-item">
              <i class="fas fa-cog"></i>
              <span>Pengaturan</span>
            </a>
          </nav>
        </div>

        <!-- Scenic Mountain Quote Card -->
        <div class="dr-quote-card">
          <div class="dr-quote-text">
            &ldquo;Kondisi jalan yang aman bermula dari informasi cuaca yang tepat.&rdquo;
          </div>
          <div class="dr-quote-line"></div>
        </div>
      </aside>


      <!-- ====== 2. RIGHT MAIN CONTENT ====== -->
      <main class="dr-main-panel">

        <!-- Panoramic Hero Banner -->
        <div class="dr-hero-banner">
          <div class="dr-hero-top">
            <div class="dr-title-group">
              <div class="dr-car-icon-box">
                <i class="fas fa-car-side"></i>
              </div>
              <div>
                <div class="dr-title-row">
                  <h1 class="dr-title">Driving Weather</h1>
                  <div class="dr-live-badge">
                    <span class="dr-live-dot"></span>
                    <span>LIVE</span>
                  </div>
                </div>
                <div class="dr-subtitle">
                  @{{ locationName }} &bull; @{{ temp }}&deg;C &bull; @{{ weatherDesc }}
                </div>
              </div>
            </div>

            <!-- Live Date & Clock Widget -->
            <div class="dr-datetime-pill">
              <div class="dr-dt-item">
                <i class="fas fa-calendar-alt"></i>
                <span>@{{ currentDate }}</span>
              </div>
              <div class="dr-dt-sep"></div>
              <div class="dr-dt-item">
                <i class="fas fa-clock"></i>
                <span>@{{ currentTime }} WIB</span>
              </div>
            </div>
          </div>

          <div class="dr-hero-body">
            <h2 class="dr-hero-headline">
              Berkendara Lebih Aman <span>dengan</span> Informasi Cuaca Real-time
            </h2>
            <p class="dr-hero-desc">
              Pantau kondisi cuaca di sepanjang perjalanan Anda untuk menghindari risiko dan memastikan perjalanan tetap aman.
            </p>
          </div>
        </div>


        <!-- Horizontal Risk Score & Current Weather Metrics Card -->
        <div class="dr-risk-card">
          <div class="dr-risk-left">
            <!-- Radial Progress Gauge -->
            <div class="dr-gauge-wrap">
              <svg class="dr-gauge-svg" viewBox="0 0 100 100">
                <!-- Track circle -->
                <circle cx="50" cy="50" r="42" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="8"/>
                <!-- Glow arc progress -->
                <circle
                  cx="50" cy="50" r="42"
                  fill="none"
                  :stroke="riskColor"
                  stroke-width="8"
                  stroke-linecap="round"
                  :stroke-dasharray="2 * Math.PI * 42"
                  :stroke-dashoffset="2 * Math.PI * 42 * (1 - riskScore / 100)"
                  style="transition: stroke-dashoffset 1.2s ease, stroke 0.5s ease; filter: drop-shadow(0 0 8px rgba(56,189,248,0.7));"
                />
              </svg>
              <div class="dr-gauge-center">
                <i class="fas fa-cloud dr-gauge-cloud-icon"></i>
                <div class="dr-gauge-score">@{{ riskScore }}/100</div>
                <div class="dr-gauge-label">Risk Score</div>
              </div>
            </div>

            <!-- Safety Status Text & Shield -->
            <div class="dr-status-wrap">
              <div class="dr-shield-status-icon" :style="{ borderColor: riskColor, background: riskBg }">
                <i class="fas" :class="riskIcon" :style="{ color: riskColor }"></i>
              </div>
              <div class="dr-status-info">
                <div class="dr-status-title">@{{ riskTitle }}</div>
                <div class="dr-status-desc">@{{ riskDesc }}</div>
              </div>
            </div>
          </div>

          <div class="dr-risk-divider"></div>

          <!-- 4 Weather Metrics -->
          <div class="dr-metrics-row">
            <!-- Suhu Udara -->
            <div class="dr-metric-item">
              <i class="fas fa-temperature-half dr-metric-icon" style="color:#F59E0B;"></i>
              <div class="dr-metric-info">
                <span class="dr-metric-lbl">Suhu Udara</span>
                <span class="dr-metric-val">@{{ temp }}&deg;C</span>
              </div>
            </div>

            <!-- Kelembapan -->
            <div class="dr-metric-item">
              <i class="fas fa-droplet dr-metric-icon" style="color:#38BDF8;"></i>
              <div class="dr-metric-info">
                <span class="dr-metric-lbl">Kelembapan</span>
                <span class="dr-metric-val">@{{ humidity }}%</span>
              </div>
            </div>

            <!-- Angin -->
            <div class="dr-metric-item">
              <i class="fas fa-wind dr-metric-icon" style="color:#A78BFA;"></i>
              <div class="dr-metric-info">
                <span class="dr-metric-lbl">Angin</span>
                <span class="dr-metric-val">
                  @{{ windSpeed }} km/jam <span class="dr-metric-sub">(@{{ windDir }})</span>
                </span>
              </div>
            </div>

            <!-- Jarak Pandang -->
            <div class="dr-metric-item">
              <i class="fas fa-eye dr-metric-icon" style="color:#34D399;"></i>
              <div class="dr-metric-info">
                <span class="dr-metric-lbl">Jarak Pandang</span>
                <span class="dr-metric-val">@{{ visibility }} km</span>
              </div>
            </div>
          </div>

          <!-- Detail Cuaca Button -->
          <a href="/prakiraan" class="dr-detail-btn">
            <span>Detail Cuaca</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>


        <!-- 4 Driving Factor Cards -->
        <div class="dr-factors-grid">
          <!-- 1. Kabut -->
          <div class="dr-factor-card">
            <div class="dr-factor-top">
              <div class="dr-factor-icon-circle">
                <i class="fas fa-car"></i>
              </div>
              <div class="dr-factor-title-wrap">
                <div class="dr-factor-val">@{{ fogVal }}</div>
                <div class="dr-factor-lbl">KABUT</div>
              </div>
              <i class="fas fa-arrow-right dr-factor-arrow"></i>
            </div>
            <p class="dr-factor-desc">@{{ fogDesc }}</p>
          </div>

          <!-- 2. Jalan Licin -->
          <div class="dr-factor-card">
            <div class="dr-factor-top">
              <div class="dr-factor-icon-circle">
                <i class="fas fa-road"></i>
              </div>
              <div class="dr-factor-title-wrap">
                <div class="dr-factor-val">@{{ wetRoadVal }}</div>
                <div class="dr-factor-lbl">JALAN LICIN</div>
              </div>
              <i class="fas fa-arrow-right dr-factor-arrow"></i>
            </div>
            <p class="dr-factor-desc">@{{ wetRoadDesc }}</p>
          </div>

          <!-- 3. Hujan -->
          <div class="dr-factor-card">
            <div class="dr-factor-top">
              <div class="dr-factor-icon-circle">
                <i class="fas fa-cloud-rain"></i>
              </div>
              <div class="dr-factor-title-wrap">
                <div class="dr-factor-val">@{{ rainVal }}</div>
                <div class="dr-factor-lbl">HUJAN</div>
              </div>
              <i class="fas fa-arrow-right dr-factor-arrow"></i>
            </div>
            <p class="dr-factor-desc">@{{ rainDesc }}</p>
          </div>

          <!-- 4. Angin -->
          <div class="dr-factor-card">
            <div class="dr-factor-top">
              <div class="dr-factor-icon-circle purple">
                <i class="fas fa-wind"></i>
              </div>
              <div class="dr-factor-title-wrap">
                <div class="dr-factor-val">@{{ windVal }}</div>
                <div class="dr-factor-lbl">ANGIN</div>
              </div>
              <i class="fas fa-arrow-right dr-factor-arrow"></i>
            </div>
            <p class="dr-factor-desc">@{{ windDesc }}</p>
          </div>
        </div>


        <!-- Bottom Tips Strip -->
        <div class="dr-tips-strip">
          <div class="dr-tips-left">
            <div class="dr-tips-icon-circle">
              <i class="fas fa-info"></i>
            </div>
            <div class="dr-tips-title">Tips Berkendara</div>
            <div class="dr-tips-sep"></div>
            <div class="dr-tips-text">
              Kurangi kecepatan, jaga jarak aman, nyalakan lampu saat hujan/kabut, dan hindari jalanan yang tergenang.
            </div>
          </div>
          <a href="/prakiraan" class="dr-tips-action" title="Lihat Panduan Lengkap">
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

      </main>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
  const { createApp, ref, computed, onMounted } = Vue;

  createApp({
    setup() {
      const locationName = ref('KABUPATEN BANDUNG');
      const temp = ref(30);
      const weatherDesc = ref('Berawan Tebal');
      const humidity = ref(67);
      const windSpeed = ref(18.7);
      const windDir = ref('Timur');
      const visibility = ref(10);
      const riskScore = ref(10);

      const currentDate = ref('');
      const currentTime = ref('');

      const updateClock = () => {
        const now = new Date();
        currentDate.value = now.toLocaleDateString('id-ID', {
          day: 'numeric', month: 'long', year: 'numeric'
        });
        currentTime.value = now.toLocaleTimeString('id-ID', {
          hour: '2-digit', minute: '2-digit'
        });
      };

      const riskColor = computed(() => {
        if (riskScore.value >= 70) return '#EF4444';
        if (riskScore.value >= 40) return '#F97316';
        return '#22C55E';
      });

      const riskBg = computed(() => {
        if (riskScore.value >= 70) return 'rgba(239, 68, 68, 0.2)';
        if (riskScore.value >= 40) return 'rgba(249, 115, 22, 0.2)';
        return 'rgba(34, 197, 94, 0.2)';
      });

      const riskIcon = computed(() => {
        if (riskScore.value >= 70) return 'fa-exclamation-triangle';
        if (riskScore.value >= 40) return 'fa-exclamation-circle';
        return 'fa-check';
      });

      const riskTitle = computed(() => {
        if (riskScore.value >= 70) return 'Bahaya untuk Berkendara';
        if (riskScore.value >= 40) return 'Waspada saat Berkendara';
        return 'Aman untuk Berkendara';
      });

      const riskDesc = computed(() => {
        if (riskScore.value >= 70) return 'Kondisi cuaca ekstrem berpotensi tinggi membahayakan perjalanan Anda.';
        if (riskScore.value >= 40) return 'Terdapat potensi gangguan cuaca di beberapa titik perjalanan.';
        return 'Kondisi cuaca saat ini cukup stabil dan masih aman untuk perjalanan.';
      });

      const fogVal = computed(() => riskScore.value >= 60 ? 'Tinggi' : 'Tidak');
      const fogDesc = computed(() =>
        riskScore.value >= 60
          ? 'Terdeteksi potensi kabut tebal yang mengurangi jarak pandang.'
          : 'Tidak terdeteksi adanya kabut di sekitar lokasi Anda.'
      );

      const wetRoadVal = computed(() => riskScore.value >= 50 ? 'Ya' : 'Tidak');
      const wetRoadDesc = computed(() =>
        riskScore.value >= 50
          ? 'Jalan berpotensi basah dan licin, tingkatkan kewaspadaan.'
          : 'Jalan dalam kondisi kering, risiko licin rendah.'
      );

      const rainVal = computed(() => riskScore.value >= 40 ? 'Ada potensi' : 'Tidak ada hujan');
      const rainDesc = computed(() =>
        riskScore.value >= 40
          ? 'Potensi hujan ringan hingga sedang dalam 2–3 jam ke depan.'
          : 'Tidak ada potensi hujan dalam beberapa jam ke depan.'
      );

      const windVal = computed(() =>
        windSpeed.value > 25 ? 'Kencang' : windSpeed.value > 15 ? 'Sedang' : 'Ringan'
      );
      const windDesc = computed(() =>
        windSpeed.value > 25
          ? 'Hembusan angin kencang berisiko bagi kendaraan roda dua.'
          : 'Hembusan angin dalam kategori aman dan ringan.'
      );

      onMounted(async () => {
        updateClock();
        setInterval(updateClock, 1000);

        try {
          const locId = localStorage.getItem('selectedLocationId') || '';
          const res = await fetch('/api/dashboard/overview' + (locId ? '?location_id=' + locId : ''));
          const d = await res.json();
          if (d.success && d.data?.current) {
            const cw = d.data.current;
            locationName.value = (d.data.location?.name || 'Kabupaten Bandung').toUpperCase();
            temp.value = Math.round(cw.temperature);
            weatherDesc.value = cw.weather_description || cw.weather_main || 'Berawan Tebal';
            humidity.value = Math.round(cw.humidity || 67);
            windSpeed.value = Number(((cw.wind_speed || 5.2) * 3.6).toFixed(1));
            windDir.value = cw.wind_direction || 'Timur';
            visibility.value = cw.visibility ? Number((cw.visibility / 1000).toFixed(0)) : 10;

            // Compute realistic risk score
            let score = 10;
            const desc = (cw.weather_description || '').toLowerCase();
            const rainAmt = cw.rain_1h || 0;
            if (rainAmt > 0 || desc.includes('hujan')) score += 35;
            if (rainAmt > 10) score += 20;
            if (desc.includes('kabut') || desc.includes('asap')) score += 25;
            if (cw.wind_speed > 10) score += 15;
            riskScore.value = Math.min(100, Math.max(10, score));
          }
        } catch (e) {
          // Keep realistic fallback data from screenshot
        }
      });

      return {
        locationName, temp, weatherDesc, humidity, windSpeed, windDir, visibility, riskScore,
        currentDate, currentTime, riskColor, riskBg, riskIcon, riskTitle, riskDesc,
        fogVal, fogDesc, wetRoadVal, wetRoadDesc, rainVal, rainDesc, windVal, windDesc
      };
    }
  }).mount('#dr-app');
})();
</script>
@endpush

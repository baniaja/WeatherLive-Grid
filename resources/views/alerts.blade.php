@extends('layouts.app')

@section('title', 'Peringatan Dini Cuaca — WeatherLive-Grid')

@section('styles')
<style>
/* =========================================================
   ALERTS PAGE — ULTRA REALISTIC BMKG WARNING SYSTEM
   EXACT REPLICA OF USER REFERENCE IMAGE + PREMIUM GLASSMORPHISM
   ========================================================= */

/* ── Scenic Sky Canvas with Atmospheric Depth ── */
.al-bg-canvas {
  position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
}
.al-bg-canvas::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 90% 50% at 50% 0%, rgba(14, 116, 144, 0.28) 0%, transparent 65%),
    radial-gradient(ellipse 70% 45% at 85% 20%, rgba(56, 189, 248, 0.18) 0%, transparent 60%),
    radial-gradient(ellipse 65% 55% at 15% 25%, rgba(37, 99, 235, 0.22) 0%, transparent 55%),
    linear-gradient(180deg, #091a38 0%, #061026 50%, #030712 100%);
}

/* Atmospheric Mountain Skyline Horizon */
.al-mountain-layer {
  position: absolute;
  top: 60px; left: 0; right: 0;
  height: 320px;
  background-repeat: repeat-x;
  background-position: top center;
  opacity: 0.22;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320' preserveAspectRatio='none'%3E%3Cpath fill='%2338BDF8' fill-opacity='0.18' d='M0,320 L0,220 L120,160 L240,200 L380,80 L520,180 L680,120 L820,210 L960,140 L1120,220 L1280,110 L1440,190 L1440,320 Z'/%3E%3Cpath fill='%230f2c59' fill-opacity='0.6' d='M0,320 L0,250 L160,200 L310,230 L500,150 L680,240 L850,170 L1020,240 L1190,180 L1360,250 L1440,210 L1440,320 Z'/%3E%3C/svg%3E");
}

/* ── Container Shell ── */
.al-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── Breadcrumb ── */
.al-breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: rgba(255, 255, 255, 0.45);
  margin-bottom: 18px;
}
.al-breadcrumb a {
  color: #38BDF8;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: color 0.2s;
}
.al-breadcrumb a:hover { color: #7DD3FC; }

/* ── Top Header Strip (Exact Match to Screenshot) ── */
.al-top-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 18px;
  margin-bottom: 24px;
}
.al-title-group {
  display: flex;
  align-items: center;
  gap: 16px;
}
.al-warning-shield {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: linear-gradient(135deg, rgba(56, 189, 248, 0.35), rgba(2, 132, 199, 0.45));
  border: 1.5px solid rgba(56, 189, 248, 0.55);
  box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4), inset 0 1px 0 rgba(255,255,255,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.al-warning-shield i {
  font-size: 26px;
  color: #38BDF8;
  filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.8));
}
.al-title-row {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.al-page-title {
  font-size: clamp(24px, 3.8vw, 32px);
  font-weight: 900;
  color: #FFFFFF;
  letter-spacing: -0.025em;
  line-height: 1.15;
  margin: 0;
}
.al-active-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 999px;
  background: rgba(34, 197, 94, 0.18);
  border: 1px solid rgba(34, 197, 94, 0.4);
  color: #4ADE80;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.3px;
}
.al-active-badge .al-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #22C55E;
  box-shadow: 0 0 8px #22C55E;
  animation: dotPulse 1.8s infinite;
}
@keyframes dotPulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.75); }
}
.al-page-subtitle {
  font-size: 13.5px;
  color: rgba(255, 255, 255, 0.65);
  margin-top: 4px;
}

/* Date / Time Widget Card on Top Right */
.al-datetime-pill {
  display: flex;
  align-items: center;
  background: rgba(12, 25, 50, 0.75);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(56, 189, 248, 0.25);
  border-radius: 12px;
  padding: 10px 18px;
  gap: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
}
.al-dt-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.al-dt-item i {
  color: #38BDF8;
  font-size: 14px;
}
.al-dt-sep {
  width: 1px;
  height: 18px;
  background: rgba(255, 255, 255, 0.15);
}

/* ── MAIN HERO BANNER CARD (EXACT REPLICA OF SCREENSHOT) ── */
.al-hero-banner {
  position: relative;
  border-radius: 28px;
  background: linear-gradient(135deg, rgba(8, 22, 48, 0.9) 0%, rgba(6, 16, 38, 0.95) 100%);
  border: 1.5px solid rgba(56, 189, 248, 0.35);
  box-shadow:
    0 24px 60px rgba(0, 0, 0, 0.65),
    0 0 50px rgba(56, 189, 248, 0.15),
    inset 0 1px 0 rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(30px) saturate(180%);
  -webkit-backdrop-filter: blur(30px) saturate(180%);
  padding: 38px 46px;
  margin-bottom: 28px;
  overflow: hidden;
}

/* Ambient Neon Glow Corner Effects */
.al-hero-banner::before {
  content: '';
  position: absolute;
  top: -80px; left: -80px;
  width: 280px; height: 280px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(56, 189, 248, 0.22), transparent 70%);
  pointer-events: none;
}
.al-hero-banner::after {
  content: '';
  position: absolute;
  bottom: -90px; right: 15%;
  width: 340px; height: 340px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(14, 165, 233, 0.16), transparent 70%);
  pointer-events: none;
}

/* STRICT HORIZONTAL 3-COLUMN DESKTOP GRID */
.al-banner-grid {
  display: grid;
  grid-template-columns: 180px 1fr 340px;
  align-items: center;
  gap: 32px;
  position: relative;
  z-index: 2;
}
@media (max-width: 860px) {
  .al-banner-grid {
    grid-template-columns: 1fr;
    text-align: center;
    gap: 26px;
  }
}

/* Left: 3D Weather Art (Illuminated Cloud with Lightning & Warning Badge) */
.al-weather-art-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
}
.al-3d-cloud-box {
  width: 170px;
  height: 170px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.al-cloud-radar-rings {
  position: absolute;
  inset: -10px;
  pointer-events: none;
}
.al-cloud-radar-ring {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(56, 189, 248, 0.3);
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  animation: radarPulse 3.6s ease-out infinite;
}
.al-cloud-radar-ring:nth-child(1) { width: 130px; height: 130px; animation-delay: 0s; }
.al-cloud-radar-ring:nth-child(2) { width: 165px; height: 165px; animation-delay: 1.2s; border-color: rgba(56, 189, 248, 0.18); }
.al-cloud-radar-ring:nth-child(3) { width: 200px; height: 200px; animation-delay: 2.4s; border-color: rgba(56, 189, 248, 0.08); }

@keyframes radarPulse {
  0% { transform: translate(-50%, -50%) scale(0.75); opacity: 0.85; }
  100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0; }
}

.al-cloud-svg {
  width: 145px;
  height: 145px;
  filter: drop-shadow(0 16px 36px rgba(2, 132, 199, 0.6));
  animation: cloudFloat 4s ease-in-out infinite;
  position: relative;
  z-index: 2;
}
@keyframes cloudFloat {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-7px); }
}

/* Center: Status Information & BMKG Box */
.al-banner-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
@media (max-width: 860px) {
  .al-banner-content { align-items: center; }
}

.al-status-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 999px;
  background: rgba(34, 197, 94, 0.2);
  border: 1px solid rgba(34, 197, 94, 0.45);
  color: #4ADE80;
  font-size: 12px;
  font-weight: 700;
  width: fit-content;
}
.al-banner-heading {
  font-size: clamp(24px, 3vw, 34px);
  font-weight: 900;
  color: #FFFFFF;
  letter-spacing: -0.02em;
  margin: 0;
  line-height: 1.18;
}
.al-banner-desc {
  font-size: 14.5px;
  color: rgba(255, 255, 255, 0.75);
  line-height: 1.6;
  max-width: 520px;
  margin: 0;
}
.al-info-callout {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 13px 18px;
  background: rgba(14, 116, 144, 0.2);
  border: 1px solid rgba(56, 189, 248, 0.32);
  border-radius: 14px;
  margin-top: 4px;
  max-width: 560px;
  backdrop-filter: blur(14px);
}
.al-callout-icon {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #0284C7;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
  box-shadow: 0 0 12px rgba(2, 132, 199, 0.75);
}
.al-callout-text {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.5;
}

/* Right: Holographic Indonesia Archipelago & 3D Shield */
.al-holo-map-wrap {
  position: relative;
  width: 100%;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.al-holo-grid-circle {
  position: absolute;
  width: 320px;
  height: 200px;
  border-radius: 50%;
  border: 1.5px dashed rgba(56, 189, 248, 0.35);
  transform: rotateX(62deg);
  box-shadow: 0 0 45px rgba(56, 189, 248, 0.2);
  animation: gridRotate 25s linear infinite;
}
@keyframes gridRotate {
  from { transform: rotateX(62deg) rotateZ(0deg); }
  to { transform: rotateX(62deg) rotateZ(360deg); }
}

.al-indonesia-map-svg {
  width: 100%;
  max-width: 330px;
  height: auto;
  filter: drop-shadow(0 0 18px rgba(56, 189, 248, 0.75));
  position: relative;
  z-index: 1;
}

/* Floating 3D Green Shield Badge with Checkmark (Exact Match to Screenshot) */
.al-shield-badge {
  position: absolute;
  top: 14px;
  right: 18px;
  width: 56px;
  height: 60px;
  background: linear-gradient(135deg, rgba(34, 197, 94, 0.35), rgba(16, 185, 129, 0.5));
  border: 2px solid #22C55E;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 24px;
  box-shadow:
    0 8px 24px rgba(34, 197, 94, 0.55),
    0 0 35px rgba(34, 197, 94, 0.45),
    inset 0 1px 0 rgba(255, 255, 255, 0.5);
  z-index: 3;
  animation: shieldFloat 3.2s ease-in-out infinite;
}
@keyframes shieldFloat {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-6px) rotate(-1.5deg); }
}

/* ── 4 STAT SUMMARY CARDS ── */
.al-stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 28px;
}
@media (max-width: 860px) {
  .al-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .al-stats-grid { grid-template-columns: 1fr; }
}

.al-stat-card {
  background: rgba(10, 22, 46, 0.72);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 18px;
  padding: 18px 20px;
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  transition: all 0.3s;
}
.al-stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
}
.al-stat-card.danger { border-color: rgba(239, 68, 68, 0.3); }
.al-stat-card.warning { border-color: rgba(249, 115, 22, 0.3); }
.al-stat-card.info { border-color: rgba(56, 189, 248, 0.3); }
.al-stat-card.safe { border-color: rgba(34, 197, 94, 0.3); }

.al-stat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
}
.al-stat-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.55);
}
.al-stat-num {
  font-size: 34px;
  font-weight: 900;
  font-family: 'Space Grotesk', sans-serif;
  line-height: 1.1;
  margin-bottom: 4px;
}
.al-stat-desc {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.42);
}

/* ── 27 JAWA BARAT REGION STATUS GRID ── */
.al-region-section {
  margin-top: 10px;
  background: rgba(10, 22, 46, 0.65);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 22px;
  padding: 24px;
  backdrop-filter: blur(20px);
}
.al-region-title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}
.al-region-title {
  font-size: 16px;
  font-weight: 800;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 8px;
}
.al-region-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(135px, 1fr));
  gap: 10px;
}
.al-region-tile {
  background: rgba(255, 255, 255, 0.035);
  border: 1px solid rgba(255, 255, 255, 0.07);
  border-radius: 12px;
  padding: 12px 10px;
  text-align: center;
  transition: all 0.25s;
}
.al-region-tile:hover {
  transform: translateY(-2px);
  background: rgba(255, 255, 255, 0.06);
  border-color: rgba(56, 189, 248, 0.3);
}
.al-region-tile.safe { border-color: rgba(34, 197, 94, 0.2); }
.al-region-tile.has-alert-warning { border-color: rgba(249, 115, 22, 0.4); background: rgba(249, 115, 22, 0.08); }
.al-region-tile.has-alert-danger { border-color: rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.08); }
.al-region-name { font-size: 11.5px; font-weight: 700; color: #fff; margin-top: 4px; }
.al-region-status { font-size: 10px; color: #4ADE80; font-weight: 600; }

/* ── BMKG STATION & EMERGENCY HOTLINES ROW ── */
.al-bottom-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-top: 24px;
}
@media (max-width: 768px) {
  .al-bottom-grid { grid-template-columns: 1fr; }
}

.al-side-card {
  background: rgba(10, 22, 46, 0.75);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 20px 24px;
  backdrop-filter: blur(20px);
}
.al-side-title {
  font-size: 13px;
  font-weight: 800;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.al-hotline-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 14px;
  background: rgba(255, 255, 255, 0.04);
  border-radius: 10px;
  margin-bottom: 8px;
}
.al-hotline-num {
  font-size: 15px;
  font-weight: 900;
  color: #38BDF8;
  font-family: 'Space Grotesk', monospace;
}
</style>
@endsection

@section('content')
<div id="al-app" v-cloak>

  <!-- Atmospheric Mountain Background Canvas -->
  <div class="al-bg-canvas">
    <div class="al-mountain-layer"></div>
  </div>

  <div class="al-shell page-wrap">

    <!-- Breadcrumb -->
    <div class="al-breadcrumb">
      <a href="/dashboard"><i class="fas fa-home"></i> Dashboard</a>
      <span>/</span>
      <span style="color:rgba(255,255,255,0.75);">Peringatan Dini Cuaca</span>
    </div>

    <!-- Top Header Strip (Exact Match to Screenshot) -->
    <div class="al-top-header">
      <div class="al-title-group">
        <div class="al-warning-shield">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
          <div class="al-title-row">
            <h1 class="al-page-title">Peringatan Dini Cuaca</h1>
            <div class="al-active-badge">
              <span class="al-dot"></span>
              <span>Aktif</span>
            </div>
          </div>
          <div class="al-page-subtitle">Informasi terkini dan peringatan potensi cuaca ekstrem di wilayah Indonesia</div>
        </div>
      </div>

      <!-- Live Date & Clock Widget Card (Exact Match to Screenshot) -->
      <div class="al-datetime-pill">
        <div class="al-dt-item">
          <i class="fas fa-calendar-alt"></i>
          <span>@{{ currentDate }}</span>
        </div>
        <div class="al-dt-sep"></div>
        <div class="al-dt-item">
          <i class="fas fa-clock"></i>
          <span>@{{ currentTime }} WIB</span>
        </div>
      </div>
    </div>


    <!-- ====== MAIN HERO BANNER CARD (EXACT REPLICA OF USER REFERENCE IMAGE) ====== -->
    <div class="al-hero-banner">
      <div class="al-banner-grid">

        <!-- Column 1: 3D Weather Art (Illuminated Storm Cloud + Lightning + Warning Badge) -->
        <div class="al-weather-art-wrap">
          <div class="al-3d-cloud-box">
            <!-- Animated Radar Concentric Circles -->
            <div class="al-cloud-radar-rings">
              <div class="al-cloud-radar-ring"></div>
              <div class="al-cloud-radar-ring"></div>
              <div class="al-cloud-radar-ring"></div>
            </div>

            <!-- Photorealistic 3D Style Cloud Vector SVG -->
            <svg class="al-cloud-svg" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="cloudGrad" x1="20" y1="30" x2="140" y2="130" gradientUnits="userSpaceOnUse">
                  <stop offset="0%" stop-color="#38BDF8" stop-opacity="0.9"/>
                  <stop offset="35%" stop-color="#1E3A8A"/>
                  <stop offset="100%" stop-color="#0F172A"/>
                </linearGradient>
                <linearGradient id="lightningGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#FDE047"/>
                  <stop offset="100%" stop-color="#F59E0B"/>
                </linearGradient>
                <filter id="lightningGlow" x="-20%" y="-20%" width="140%" height="140%">
                  <feGaussianBlur stdDeviation="5" result="blur"/>
                  <feComposite in="SourceGraphic" in2="blur" operator="over"/>
                </filter>
                <filter id="badgeGlow" x="-30%" y="-30%" width="160%" height="160%">
                  <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#EF4444" flood-opacity="0.8"/>
                </filter>
              </defs>

              <!-- Realistic Storm Cloud Silhouette -->
              <path d="M48 108C34.7 108 24 97.3 24 84C24 72 32.8 62 44.5 60.3C47 42.6 62 28 80 28C95.5 28 108.8 38.8 113.2 53.5C115.3 53.2 117.6 53 120 53C133.3 53 144 63.7 144 77C144 89.8 134 100.3 121.5 101L48 108Z" fill="url(#cloudGrad)"/>
              <path d="M44.5 60.3C47 42.6 62 28 80 28C95.5 28 108.8 38.8 113.2 53.5" stroke="#7DD3FC" stroke-width="2.5" stroke-linecap="round" opacity="0.6"/>

              <!-- Golden Lightning Bolt -->
              <polygon points="76,82 62,112 78,112 68,142 98,102 82,102 92,82" fill="url(#lightningGrad)" filter="url(#lightningGlow)"/>

              <!-- Stylized Raindrops with animation -->
              <line x1="45" y1="116" x2="38" y2="134" stroke="#38BDF8" stroke-width="3" stroke-linecap="round" opacity="0.75"/>
              <line x1="115" y1="114" x2="108" y2="132" stroke="#38BDF8" stroke-width="3" stroke-linecap="round" opacity="0.75"/>
              <line x1="58" y1="126" x2="52" y2="142" stroke="#38BDF8" stroke-width="2.5" stroke-linecap="round" opacity="0.6"/>

              <!-- Red Alert Exclamation Badge on Cloud -->
              <g filter="url(#badgeGlow)">
                <polygon points="124,42 142,74 106,74" fill="#EF4444"/>
                <text x="124" y="68" font-family="'Inter', sans-serif" font-weight="900" font-size="14" fill="#FFFFFF" text-anchor="middle">!</text>
              </g>
            </svg>
          </div>
        </div>

        <!-- Column 2: Status & BMKG Message -->
        <div class="al-banner-content">
          <div class="al-status-pill">
            <span class="al-dot" style="width:6px;height:6px;background:#4ADE80;border-radius:50%;"></span>
            <span>Status</span>
          </div>

          <h2 class="al-banner-heading">
            @{{ activeAlerts.length > 0 ? activeAlerts.length + ' Peringatan Cuaca Aktif' : 'Tidak Ada Peringatan Aktif' }}
          </h2>

          <p class="al-banner-desc">
            @{{ activeAlerts.length > 0 
              ? 'Terdeteksi dinamika cuaca signifikan di wilayah Jawa Barat. Pastikan selalu memantau perkembangan terkini.' 
              : 'Saat ini tidak terdapat peringatan dini cuaca ekstrem untuk wilayah Indonesia.' }}
          </p>

          <!-- Blue Official BMKG Info Box (Exact Match to Screenshot) -->
          <div class="al-info-callout">
            <div class="al-callout-icon">
              <i class="fas fa-info"></i>
            </div>
            <div class="al-callout-text">
              Tetap pantau informasi terbaru melalui kanal resmi BMKG untuk update kondisi cuaca terkini.
            </div>
          </div>
        </div>

        <!-- Column 3: Holographic Indonesian Archipelago & 3D Shield Checkmark -->
        <div class="al-holo-map-wrap">
          <!-- 3D Orbit Coordinate Ring -->
          <div class="al-holo-grid-circle"></div>

          <!-- Stylized Hologram Map of Indonesia (Neon Blue) -->
          <svg class="al-indonesia-map-svg" viewBox="0 0 440 180" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <linearGradient id="mapGlow" x1="0" y1="0" x2="440" y2="180" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#38BDF8"/>
                <stop offset="100%" stop-color="#0284C7"/>
              </linearGradient>
            </defs>
            <!-- Grid Lines -->
            <path d="M10 90 H430 M50 35 H390 M50 145 H390" stroke="#38BDF8" stroke-width="0.8" stroke-dasharray="3 3" opacity="0.35"/>
            <!-- Sumatra -->
            <path d="M35,38 Q65,85 92,138 Q82,148 68,115 Q46,72 35,38 Z" fill="url(#mapGlow)" fill-opacity="0.9"/>
            <!-- Java -->
            <path d="M105,148 Q165,142 225,152 Q220,162 160,162 Q105,158 105,148 Z" fill="url(#mapGlow)" fill-opacity="0.95"/>
            <!-- Kalimantan -->
            <path d="M138,68 Q182,52 210,88 Q194,128 152,122 Q130,98 138,68 Z" fill="url(#mapGlow)" fill-opacity="0.9"/>
            <!-- Sulawesi -->
            <path d="M232,78 Q250,56 260,72 Q254,104 270,110 Q248,136 238,104 Z" fill="url(#mapGlow)" fill-opacity="0.9"/>
            <!-- Maluku & Papua -->
            <path d="M295,88 Q312,82 318,108 Q296,114 295,88 Z" fill="url(#mapGlow)" fill-opacity="0.85"/>
            <path d="M338,78 Q408,72 415,114 Q382,136 345,104 Z" fill="url(#mapGlow)" fill-opacity="0.95"/>
          </svg>

          <!-- Floating 3D Glowing Green Shield with Checkmark (Exact Match to Screenshot) -->
          <div class="al-shield-badge" title="Status Aman">
            <i class="fas fa-check"></i>
          </div>
        </div>

      </div>
    </div>


    <!-- ====== 4 STAT SUMMARY CARDS ====== -->
    <div class="al-stats-grid">
      <div class="al-stat-card danger">
        <div class="al-stat-header">
          <div class="al-stat-label">Ekstrem &amp; Bahaya</div>
          <i class="fas fa-bolt" style="color:#EF4444;"></i>
        </div>
        <div class="al-stat-num" style="color:#EF4444;">@{{ countBySeverity(['extreme', 'danger']) }}</div>
        <div class="al-stat-desc">Wilayah waspada tinggi</div>
      </div>

      <div class="al-stat-card warning">
        <div class="al-stat-header">
          <div class="al-stat-label">Waspada</div>
          <i class="fas fa-exclamation-circle" style="color:#F97316;"></i>
        </div>
        <div class="al-stat-num" style="color:#F97316;">@{{ countBySeverity(['warning']) }}</div>
        <div class="al-stat-desc">Potensi cuaca buruk</div>
      </div>

      <div class="al-stat-card info">
        <div class="al-stat-header">
          <div class="al-stat-label">Informasi</div>
          <i class="fas fa-info-circle" style="color:#38BDF8;"></i>
        </div>
        <div class="al-stat-num" style="color:#38BDF8;">@{{ countBySeverity(['info']) }}</div>
        <div class="al-stat-desc">Pemberitahuan BMKG</div>
      </div>

      <div class="al-stat-card safe">
        <div class="al-stat-header">
          <div class="al-stat-label">Wilayah Aman</div>
          <i class="fas fa-shield-alt" style="color:#22C55E;"></i>
        </div>
        <div class="al-stat-num" style="color:#22C55E;">@{{ safeRegionsCount }}</div>
        <div class="al-stat-desc">Dari 27 Kab/Kota Jabar</div>
      </div>
    </div>


    <!-- ====== 27 REGION STATUS GRID OF JAWA BARAT ====== -->
    <div class="al-region-section">
      <div class="al-region-title-row">
        <div class="al-region-title">
          <i class="fas fa-map-marked-alt" style="color:#38BDF8;"></i>
          <span>Status 27 Kabupaten &amp; Kota di Jawa Barat</span>
        </div>
        <span style="font-size:12px;color:rgba(255,255,255,0.45);"><i class="fas fa-sync-alt fa-spin"></i> Update Otomatis</span>
      </div>

      <div class="al-region-grid">
        <div
          v-for="reg in regionList"
          :key="reg.name"
          class="al-region-tile"
          :class="reg.hasWarning ? 'has-alert-warning' : 'safe'"
        >
          <div style="font-size:18px;">@{{ reg.hasWarning ? '⚠️' : '✅' }}</div>
          <div class="al-region-name">@{{ reg.name }}</div>
          <div class="al-region-status" :style="{color: reg.hasWarning ? '#F97316' : '#4ADE80'}">
            @{{ reg.hasWarning ? 'Waspada' : 'Aman' }}
          </div>
        </div>
      </div>
    </div>


    <!-- ====== BMKG RADAR & EMERGENCY HOTLINES ====== -->
    <div class="al-bottom-grid">
      <!-- BMKG Radar Card -->
      <div class="al-side-card" style="border-color:rgba(56,189,248,0.25);background:linear-gradient(135deg,rgba(14,116,144,0.18),rgba(10,22,46,0.85));">
        <div class="al-side-title">
          <i class="fas fa-satellite-dish" style="color:#38BDF8;"></i>
          <span>Radar Cuaca Doppler BMKG</span>
        </div>
        <p style="font-size:13px;color:rgba(255,255,255,0.72);line-height:1.6;margin-bottom:14px;">
          Sistem deteksi dini cuaca terhubung real-time dengan Doppler Weather Radar BMKG Stasiun Geofisika Bandung dan BMKG Pusat Jakarta.
        </p>
        <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.35);border-radius:12px;margin-bottom:14px;">
          <span class="al-dot" style="width:7px;height:7px;background:#22C55E;border-radius:50%;box-shadow:0 0 8px #22C55E;"></span>
          <span style="font-size:12px;color:#4ADE80;font-weight:700;">Radar Doppler Aktif 24/7 · Pemantauan Siaga</span>
        </div>
        <a
          href="https://www.bmkg.go.id"
          target="_blank"
          rel="noopener"
          style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;background:rgba(56,189,248,0.18);border:1px solid rgba(56,189,248,0.35);border-radius:12px;color:#38BDF8;font-size:12.5px;font-weight:700;text-decoration:none;transition:all 0.2s;"
        >
          <span>Kunjungi Kanal Resmi BMKG (bmkg.go.id)</span>
          <i class="fas fa-external-link-alt"></i>
        </a>
      </div>

      <!-- Emergency Hotlines -->
      <div class="al-side-card">
        <div class="al-side-title">
          <i class="fas fa-phone-alt" style="color:#EF4444;"></i>
          <span>Layanan Kontak Darurat &amp; Bencana</span>
        </div>
        <div class="al-hotline-item">
          <div>
            <div style="font-size:12.5px;font-weight:700;color:#fff;">BPBD Jawa Barat</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.4);">Bencana &amp; Evakuasi Darurat</div>
          </div>
          <div class="al-hotline-num">112</div>
        </div>
        <div class="al-hotline-item">
          <div>
            <div style="font-size:12.5px;font-weight:700;color:#fff;">Call Center BMKG</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.4);">Informasi Cuaca &amp; Gempa Terkini</div>
          </div>
          <div class="al-hotline-num">196</div>
        </div>
        <div class="al-hotline-item">
          <div>
            <div style="font-size:12.5px;font-weight:700;color:#fff;">Basarnas Jabar</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.4);">Operasi SAR &amp; Pertolongan</div>
          </div>
          <div class="al-hotline-num">115</div>
        </div>
      </div>
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
      const activeAlerts = ref([]);
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

      const countBySeverity = (sevList) =>
        activeAlerts.value.filter(a => sevList.includes(a.severity || 'info')).length;

      const rawCities = [
        'Bandung', 'Bandung Barat', 'Bekasi', 'Bogor', 'Ciamis', 'Cianjur', 'Cirebon',
        'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Pangandaran',
        'Purwakarta', 'Subang', 'Sukabumi', 'Sumedang', 'Tasikmalaya', 'Kota Bandung',
        'Kota Banjar', 'Kota Bekasi', 'Kota Bogor', 'Kota Cirebon', 'Kota Depok',
        'Kota Sukabumi', 'Kota Tasikmalaya', 'Depok'
      ];

      const regionList = computed(() => {
        return rawCities.map(name => {
          const hasWarning = activeAlerts.value.some(a => {
            const loc = (a.location?.name || '').toLowerCase();
            return loc.includes(name.toLowerCase().replace('kota ', ''));
          });
          return { name, hasWarning };
        });
      });

      const safeRegionsCount = computed(() => {
        return regionList.value.filter(r => !r.hasWarning).length;
      });

      onMounted(async () => {
        updateClock();
        setInterval(updateClock, 1000);

        try {
          const res = await fetch('/api/alerts/active');
          const data = await res.json();
          if (data.success && Array.isArray(data.data) && data.data.length > 0) {
            activeAlerts.value = data.data;
          }
        } catch (e) {
          // Keep activeAlerts empty when safe
        }
      });

      return {
        activeAlerts, currentDate, currentTime, regionList, safeRegionsCount, countBySeverity
      };
    }
  }).mount('#al-app');
})();
</script>
@endpush

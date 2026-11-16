@extends('layouts.app')

@section('title', 'Peta Interaktif — WeatherLive-Grid')

@section('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* =========================================================
   PETA INTERAKTIF — ULTRA REALISTIC LIVE RADAR WEATHER MAP
   PIXEL-PERFECT REPLICA OF USER REFERENCE DESIGN
   ========================================================= */

.mp-page-bg {
  position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
}
.mp-page-bg::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 80% 50% at 50% -10%, rgba(14, 116, 144, 0.22) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 90% 20%, rgba(56, 189, 248, 0.14) 0%, transparent 55%),
    linear-gradient(180deg, #07152e 0%, #060e1d 50%, #030712 100%);
}

.mp-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── 2-Column Layout (Sidebar + Main) ── */
.mp-layout-grid {
  display: grid;
  grid-template-columns: 220px minmax(0, 1fr);
  gap: 22px;
  align-items: start;
}
@media (max-width: 1024px) {
  .mp-layout-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

/* ── Left Sidebar Navigation ── */
.mp-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 220px;
  flex-shrink: 0;
}
@media (max-width: 1024px) {
  .mp-sidebar {
    display: none;
  }
}

.mp-nav-card {
  background: rgba(10, 22, 46, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 12px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
}
.mp-nav-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.mp-nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 14px;
  border-radius: 12px;
  color: rgba(255, 255, 255, 0.68);
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.22s;
  cursor: pointer;
}
.mp-nav-item i {
  font-size: 14px;
  width: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.45);
  transition: color 0.2s;
}
.mp-nav-item:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #fff;
}
.mp-nav-item:hover i { color: #38BDF8; }

.mp-nav-item.active {
  background: #0284C7;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
}
.mp-nav-item.active i {
  color: #FFFFFF;
}

/* Quote Box at Bottom of Sidebar */
.mp-quote-card {
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
.mp-quote-text {
  position: relative;
  z-index: 2;
  font-size: 12.5px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.85);
  font-style: italic;
}
.mp-quote-line {
  width: 28px;
  height: 2px;
  background: #38BDF8;
  margin-top: 10px;
  border-radius: 99px;
}

/* ── Right Main Panel (Strictly contained, no overflow) ── */
.mp-main-panel {
  display: flex;
  flex-direction: column;
  gap: 16px;
  min-width: 0;
  width: 100%;
}

/* ── Top Header Strip ── */
.mp-top-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  width: 100%;
}
@media (max-width: 900px) {
  .mp-top-header { flex-wrap: wrap; }
}

.mp-title-group {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  min-width: 0;
}
.mp-header-icon {
  font-size: 26px;
  color: #38BDF8;
  margin-top: 2px;
  filter: drop-shadow(0 0 12px rgba(56, 189, 248, 0.7));
  flex-shrink: 0;
}
.mp-title {
  font-size: 26px;
  font-weight: 900;
  color: #FFFFFF;
  margin: 0;
  letter-spacing: -0.025em;
  line-height: 1.2;
}
.mp-subtitle {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.65);
  margin-top: 4px;
  max-width: 580px;
  line-height: 1.5;
}

/* Date / Time Widget Card on Top Right (Guaranteed fully visible) */
.mp-datetime-pill {
  display: inline-flex;
  align-items: center;
  background: rgba(12, 25, 52, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(56, 189, 248, 0.32);
  border-radius: 12px;
  padding: 8px 16px;
  gap: 14px;
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
  white-space: nowrap;
  flex-shrink: 0;
}
.mp-dt-item {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12.5px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.mp-dt-item i {
  color: #38BDF8;
  font-size: 13px;
}
.mp-dt-sep {
  width: 1px;
  height: 16px;
  background: rgba(255, 255, 255, 0.18);
}

/* ── Layer Filter Buttons Strip (Horizontal Scroll) ── */
.mp-layers-strip {
  display: flex;
  align-items: center;
  gap: 8px;
  overflow-x: auto;
  scrollbar-width: none;
  padding-bottom: 2px;
  width: 100%;
  max-width: 100%;
}
.mp-layers-strip::-webkit-scrollbar { display: none; }

.mp-layer-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  border-radius: 999px;
  background: rgba(10, 22, 46, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.12);
  color: rgba(255, 255, 255, 0.75);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.22s;
  backdrop-filter: blur(14px);
  flex-shrink: 0;
}
.mp-layer-btn:hover {
  background: rgba(56, 189, 248, 0.14);
  border-color: rgba(56, 189, 248, 0.4);
  color: #38BDF8;
}
.mp-layer-btn.active {
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  border-color: transparent;
  color: #FFFFFF;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5), 0 0 16px rgba(56, 189, 248, 0.4);
}
.mp-layer-btn i {
  font-size: 13px;
}

/* ── MAP CONTAINER (HIGH-TECH GLASS FRAME) ── */
.mp-map-card {
  position: relative;
  width: 100%;
  max-width: 100%;
  height: 520px;
  border-radius: 24px;
  overflow: hidden;
  border: 1.5px solid rgba(56, 189, 248, 0.35);
  box-shadow:
    0 24px 60px rgba(0, 0, 0, 0.65),
    0 0 45px rgba(56, 189, 248, 0.18),
    inset 0 1px 0 rgba(255, 255, 255, 0.15);
  background: #061124;
}
@media (max-width: 768px) {
  .mp-map-card { height: 440px; }
}

#weatherMap {
  width: 100%;
  height: 100%;
  z-index: 1;
  background: #050d1a;
}

/* Custom Zoom Controls (Top-Left) */
.mp-zoom-controls {
  position: absolute;
  top: 18px;
  left: 18px;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.mp-ctrl-btn {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: rgba(10, 22, 46, 0.88);
  border: 1px solid rgba(56, 189, 248, 0.3);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  color: #FFFFFF;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
}
.mp-ctrl-btn:hover {
  background: rgba(56, 189, 248, 0.25);
  color: #38BDF8;
  border-color: #38BDF8;
  transform: scale(1.05);
}

/* Floating Glass Legend (Top-Right, guaranteed full text width) */
.mp-map-legend {
  position: absolute;
  top: 18px;
  right: 18px;
  z-index: 1000;
  background: rgba(8, 20, 44, 0.92);
  border: 1.5px solid rgba(56, 189, 248, 0.32);
  border-radius: 16px;
  padding: 14px 18px;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.55);
  font-size: 11.5px;
  color: #E2E8F0;
  min-width: 190px;
  white-space: nowrap;
}
.mp-legend-title {
  font-size: 12px;
  font-weight: 800;
  color: #FFFFFF;
  margin-bottom: 10px;
}
.mp-legend-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 6px;
}
.mp-legend-color-box {
  width: 14px;
  height: 14px;
  border-radius: 3px;
  flex-shrink: 0;
}
.mp-legend-divider {
  height: 1px;
  background: rgba(255, 255, 255, 0.12);
  margin: 10px 0;
}
.mp-legend-sym-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 6px;
  color: rgba(255, 255, 255, 0.75);
}
.mp-sym-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #38BDF8;
  box-shadow: 0 0 6px #38BDF8;
  flex-shrink: 0;
}
.mp-sym-target {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  flex-shrink: 0;
}

/* Floating Bottom-Left Controls (Layer & Waktu) */
.mp-bottom-ctrls {
  position: absolute;
  bottom: 18px;
  left: 18px;
  z-index: 1000;
  display: flex;
  align-items: center;
  gap: 8px;
}
.mp-select-pill {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(8, 20, 44, 0.9);
  border: 1px solid rgba(56, 189, 248, 0.35);
  border-radius: 12px;
  padding: 8px 14px;
  font-size: 12px;
  font-weight: 700;
  color: #FFFFFF;
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.45);
}
.mp-select-pill i {
  color: #38BDF8;
}

/* Floating Bottom-Right Map Inset & Scale */
.mp-bottom-right-inset {
  position: absolute;
  bottom: 18px;
  right: 18px;
  z-index: 1000;
  display: flex;
  align-items: center;
  gap: 14px;
  pointer-events: none;
}
.mp-scale-group {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}
.mp-scale-bar {
  display: flex;
  justify-content: space-between;
  width: 140px;
  font-size: 9.5px;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.85);
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.95);
}
.mp-scale-line {
  width: 140px;
  height: 2px;
  background: #FFFFFF;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.8);
  position: relative;
}
.mp-scale-line::before, .mp-scale-line::after {
  content: '';
  position: absolute;
  top: -3px;
  width: 2px;
  height: 8px;
  background: #FFFFFF;
}
.mp-scale-line::before { left: 0; }
.mp-scale-line::after { right: 0; }

.mp-compass-box {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  filter: drop-shadow(0 2px 6px rgba(0,0,0,0.8));
}

.mp-mini-inset-box {
  width: 110px;
  height: 55px;
  border-radius: 10px;
  background: rgba(8, 20, 44, 0.88);
  border: 1px solid rgba(56, 189, 248, 0.35);
  backdrop-filter: blur(12px);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.45);
}
.mp-mini-inset-box svg {
  width: 90%;
  height: auto;
  opacity: 0.75;
}
.mp-inset-crosshair {
  position: absolute;
  border: 1.5px solid #38BDF8;
  width: 24px;
  height: 18px;
  border-radius: 4px;
}

/* Sea Labels on Ocean */
.mp-sea-label span {
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  font-weight: 600;
  font-style: italic;
  letter-spacing: 0.08em;
  color: rgba(56, 189, 248, 0.45);
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.95);
  pointer-events: none;
  user-select: none;
}

/* Custom Marker Styles */
.mp-city-marker {
  display: flex;
  align-items: center;
  gap: 6px;
  white-space: nowrap;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
}
.mp-marker-pin {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #38BDF8;
  box-shadow: 0 0 12px #38BDF8, 0 0 20px rgba(56, 189, 248, 0.8);
  border: 2px solid #FFFFFF;
}
.mp-marker-pin.active {
  background: #22C55E;
  box-shadow: 0 0 14px #22C55E, 0 0 24px rgba(34, 197, 94, 0.8);
  transform: scale(1.3);
}
.mp-marker-label {
  font-size: 11px;
  font-weight: 700;
  color: #FFFFFF;
  text-shadow: 0 2px 6px rgba(0, 0, 0, 0.95), 0 0 8px rgba(0, 0, 0, 0.9);
}

/* ── BOTTOM SELECTED LOCATION WEATHER CARD (EXACT REPLICA) ── */
.mp-city-weather-card {
  position: relative;
  border-radius: 22px;
  background: rgba(8, 20, 44, 0.92);
  border: 1.5px solid rgba(56, 189, 248, 0.3);
  backdrop-filter: blur(28px) saturate(180%);
  -webkit-backdrop-filter: blur(28px) saturate(180%);
  padding: 22px 28px;
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 24px;
}

.mp-cw-location-group {
  display: flex;
  align-items: center;
  gap: 16px;
  min-width: 220px;
}
.mp-cw-icon-box {
  width: 48px;
  height: 48px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(56, 189, 248, 0.35), rgba(2, 132, 199, 0.45));
  border: 1.5px solid rgba(56, 189, 248, 0.5);
  box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #38BDF8;
  flex-shrink: 0;
}
.mp-cw-loc-name {
  font-size: 18px;
  font-weight: 900;
  color: #FFFFFF;
  line-height: 1.2;
}
.mp-cw-coords {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.5);
  font-family: 'Space Grotesk', monospace;
  margin-top: 3px;
}

.mp-cw-temp-group {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 0 16px;
  border-left: 1px solid rgba(255, 255, 255, 0.1);
  border-right: 1px solid rgba(255, 255, 255, 0.1);
}
@media (max-width: 900px) {
  .mp-cw-temp-group { border: none; padding: 0; }
}

.mp-cw-weather-icon {
  font-size: 32px;
  filter: drop-shadow(0 4px 10px rgba(56, 189, 248, 0.4));
}
.mp-cw-temp-val {
  font-size: 26px;
  font-weight: 900;
  color: #FFFFFF;
  line-height: 1;
  font-family: 'Space Grotesk', sans-serif;
}
.mp-cw-condition-text {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.65);
  margin-top: 3px;
}

.mp-cw-stats-strip {
  display: flex;
  align-items: center;
  gap: 24px;
  flex-wrap: wrap;
}
.mp-cw-stat-col {
  display: flex;
  align-items: center;
  gap: 10px;
}
.mp-cw-stat-icon {
  font-size: 18px;
  width: 20px;
  text-align: center;
}
.mp-cw-stat-info {
  display: flex;
  flex-direction: column;
}
.mp-cw-stat-lbl {
  font-size: 10.5px;
  color: rgba(255, 255, 255, 0.45);
  font-weight: 600;
}
.mp-cw-stat-val {
  font-size: 14px;
  font-weight: 800;
  color: #FFFFFF;
  margin-top: 1px;
}

.mp-cw-detail-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 9px 18px;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(56, 189, 248, 0.35);
  color: #E2E8F0;
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.25s;
}
.mp-cw-detail-btn:hover {
  background: rgba(56, 189, 248, 0.22);
  border-color: #38BDF8;
  color: #38BDF8;
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(56, 189, 248, 0.35);
}
</style>
@endsection

@section('content')
<div id="map-app" v-cloak>

  <!-- Atmospheric Background Canvas -->
  <div class="mp-page-bg"></div>

  <div class="mp-shell page-wrap">
    <div class="mp-layout-grid">

      <!-- ====== 1. LEFT SIDEBAR NAVIGATION ====== -->
      <aside class="mp-sidebar">
        <div class="mp-nav-card">
          <nav class="mp-nav-list">
            <!-- Peta Interaktif (Active) -->
            <a href="/peta" class="mp-nav-item active">
              <i class="fas fa-map-marked-alt"></i>
              <span>Peta Interaktif</span>
            </a>
            <!-- Radar Cuaca -->
            <div class="mp-nav-item" @click="setLayer('rain')">
              <i class="fas fa-satellite-dish"></i>
              <span>Radar Cuaca</span>
            </div>
            <!-- Histori Cuaca -->
            <a href="/histori" class="mp-nav-item">
              <i class="fas fa-history"></i>
              <span>Histori</span>
            </a>
            <!-- Peringatan Dini -->
            <a href="/peringatan" class="mp-nav-item">
              <i class="fas fa-exclamation-circle"></i>
              <span>Peringatan Dini</span>
            </a>
            <!-- Temperature -->
            <div class="mp-nav-item" @click="setLayer('temperature')">
              <i class="fas fa-temperature-half"></i>
              <span>Temperature</span>
            </div>
            <!-- Kelembapan -->
            <div class="mp-nav-item" @click="setLayer('humidity')">
              <i class="fas fa-droplet"></i>
              <span>Kelembapan</span>
            </div>
            <!-- Angin -->
            <div class="mp-nav-item" @click="setLayer('wind')">
              <i class="fas fa-wind"></i>
              <span>Angin</span>
            </div>
            <!-- Tekanan Udara -->
            <div class="mp-nav-item" @click="setLayer('pressure')">
              <i class="fas fa-compress-alt"></i>
              <span>Tekanan Udara</span>
            </div>
            <!-- Kualitas Udara -->
            <a href="/kualitas-udara" class="mp-nav-item">
              <i class="fas fa-leaf"></i>
              <span>Kualitas Udara</span>
            </a>
          </nav>
        </div>

        <!-- Scenic Mountain Quote Card (Matches Screenshot) -->
        <div class="mp-quote-card">
          <div class="mp-quote-text">
            &ldquo;Cuaca lebih baik, kehidupan lebih mudah.&rdquo;
          </div>
          <div class="mp-quote-line"></div>
        </div>
      </aside>


      <!-- ====== 2. RIGHT MAIN CONTENT ====== -->
      <main class="mp-main-panel">

        <!-- Top Header Strip (Non-overflowing, nowrap on date pill) -->
        <div class="mp-top-header">
          <div class="mp-title-group">
            <i class="fas fa-map-marker-alt mp-header-icon"></i>
            <div>
              <h1 class="mp-title">Peta Interaktif</h1>
              <div class="mp-subtitle">
                Pantau kondisi cuaca secara real-time di seluruh wilayah Indonesia melalui peta interaktif dengan data akurat dan terkini.
              </div>
            </div>
          </div>

          <!-- Live Date & Clock Widget (Guaranteed no text clipping) -->
          <div class="mp-datetime-pill">
            <div class="mp-dt-item">
              <i class="fas fa-calendar-alt"></i>
              <span>@{{ currentDate }}</span>
            </div>
            <div class="mp-dt-sep"></div>
            <div class="mp-dt-item">
              <i class="fas fa-clock"></i>
              <span>@{{ currentTime }} WIB</span>
            </div>
          </div>
        </div>


        <!-- Horizontal Layer Filter Buttons Strip -->
        <div class="mp-layers-strip">
          <button
            v-for="ly in layerList"
            :key="ly.id"
            class="mp-layer-btn"
            :class="{ active: activeLayer === ly.id }"
            @click="setLayer(ly.id)"
          >
            <i :class="ly.icon"></i>
            <span>@{{ ly.name }}</span>
          </button>
        </div>


        <!-- Interactive Map Container -->
        <div class="mp-map-card">
          <!-- Leaflet Map Canvas -->
          <div id="weatherMap"></div>

          <!-- Custom Zoom Controls (Top-Left) -->
          <div class="mp-zoom-controls">
            <button class="mp-ctrl-btn" @click="zoomIn" title="Perbesar">+</button>
            <button class="mp-ctrl-btn" @click="zoomOut" title="Perkecil">&minus;</button>
            <button class="mp-ctrl-btn" @click="recenterMap" title="Pusatkan Seluruh Indonesia">
              <i class="fas fa-crosshairs" style="font-size:13px;"></i>
            </button>
          </div>

          <!-- Floating Glass Legend (Top-Right, generous width) -->
          <div class="mp-map-legend">
            <div class="mp-legend-title">Intensitas Hujan</div>
            <div class="mp-legend-row">
              <span class="mp-legend-color-box" style="background:#38BDF8;"></span>
              <span>Ringan</span>
            </div>
            <div class="mp-legend-row">
              <span class="mp-legend-color-box" style="background:#22C55E;"></span>
              <span>Sedang</span>
            </div>
            <div class="mp-legend-row">
              <span class="mp-legend-color-box" style="background:#F59E0B;"></span>
              <span>Lebat</span>
            </div>
            <div class="mp-legend-row">
              <span class="mp-legend-color-box" style="background:#EF4444;"></span>
              <span>Sangat Lebat</span>
            </div>

            <div class="mp-legend-divider"></div>

            <div class="mp-legend-sym-row">
              <span class="mp-sym-dot"></span>
              <span>Lokasi Pengamatan</span>
            </div>
            <div class="mp-legend-sym-row">
              <span class="mp-sym-target"></span>
              <span>Kota Besar</span>
            </div>
            <div class="mp-legend-sym-row">
              <span style="font-weight:bold;color:#38BDF8;">&mdash;</span>
              <span>Batas Provinsi</span>
            </div>
            <div class="mp-legend-sym-row">
              <span style="font-weight:bold;color:rgba(255,255,255,0.4);">- -</span>
              <span>Batas Negara</span>
            </div>
          </div>

          <!-- Bottom-Left Floating Control Buttons (Layer & Waktu) -->
          <div class="mp-bottom-ctrls">
            <div class="mp-select-pill" @click="cycleLayer">
              <i class="fas fa-layer-group"></i>
              <span>Layer: @{{ currentLayerName }}</span>
              <i class="fas fa-chevron-down" style="font-size:10px;margin-left:4px;"></i>
            </div>
            <div class="mp-select-pill">
              <i class="fas fa-clock"></i>
              <span>Waktu: Real-time</span>
              <i class="fas fa-chevron-down" style="font-size:10px;margin-left:4px;"></i>
            </div>
          </div>

          <!-- Bottom-Right Floating Inset & Scale -->
          <div class="mp-bottom-right-inset">
            <div class="mp-scale-group">
              <div class="mp-scale-bar">
                <span>0</span>
                <span>250</span>
                <span>500</span>
                <span>750</span>
                <span>1.000 km</span>
              </div>
              <div class="mp-scale-line"></div>
            </div>

            <!-- Compass / North Arrow -->
            <div class="mp-compass-box" title="Arah Utara">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <polygon points="12,2 17,21 12,17" fill="#FFFFFF" />
                <polygon points="12,2 7,21 12,17" fill="rgba(255,255,255,0.55)" />
                <circle cx="12" cy="17" r="1.5" fill="#38BDF8" />
              </svg>
            </div>

            <!-- Mini Inset Box -->
            <div class="mp-mini-inset-box" title="Gambaran Wilayah Indonesia">
              <svg viewBox="0 0 200 80" fill="none">
                <path d="M10,25 Q30,50 45,70 Q35,75 25,60 Z" fill="#38BDF8"/>
                <path d="M50,70 Q80,68 110,72 Q105,76 75,76 Z" fill="#38BDF8"/>
                <path d="M65,35 Q85,25 95,45 Q90,65 70,60 Z" fill="#38BDF8"/>
                <path d="M110,40 Q120,30 125,38 Q120,55 115,50 Z" fill="#38BDF8"/>
                <path d="M145,40 Q175,35 180,55 Q165,65 148,52 Z" fill="#38BDF8"/>
              </svg>
              <div class="mp-inset-crosshair"></div>
            </div>
          </div>
        </div>


        <!-- ====== 3. BOTTOM SELECTED LOCATION WEATHER CARD ====== -->
        <div class="mp-city-weather-card">
          <!-- Location Name & Coordinates -->
          <div class="mp-cw-location-group">
            <div class="mp-cw-icon-box">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <div class="mp-cw-loc-name">@{{ selectedCity.name }}</div>
              <div class="mp-cw-coords">@{{ selectedCity.coords }}</div>
            </div>
          </div>

          <!-- Temperature & Weather Condition -->
          <div class="mp-cw-temp-group">
            <div class="mp-cw-weather-icon">@{{ selectedCity.icon }}</div>
            <div>
              <div class="mp-cw-temp-val">@{{ selectedCity.temp }}&deg;C</div>
              <div class="mp-cw-condition-text">@{{ selectedCity.condition }}</div>
            </div>
          </div>

          <!-- 4 Metrik Parameter -->
          <div class="mp-cw-stats-strip">
            <!-- Kelembapan -->
            <div class="mp-cw-stat-col">
              <i class="fas fa-droplet mp-cw-stat-icon" style="color:#38BDF8;"></i>
              <div class="mp-cw-stat-info">
                <span class="mp-cw-stat-lbl">Kelembapan</span>
                <span class="mp-cw-stat-val">@{{ selectedCity.humidity }}%</span>
              </div>
            </div>

            <!-- Angin -->
            <div class="mp-cw-stat-col">
              <i class="fas fa-wind mp-cw-stat-icon" style="color:#A78BFA;"></i>
              <div class="mp-cw-stat-info">
                <span class="mp-cw-stat-lbl">Angin</span>
                <span class="mp-cw-stat-val">@{{ selectedCity.wind }} km/jam <small style="font-size:11px;color:rgba(255,255,255,0.5);">(@{{ selectedCity.windDir }})</small></span>
              </div>
            </div>

            <!-- Tekanan Udara -->
            <div class="mp-cw-stat-col">
              <i class="fas fa-gauge-high mp-cw-stat-icon" style="color:#34D399;"></i>
              <div class="mp-cw-stat-info">
                <span class="mp-cw-stat-lbl">Tekanan Udara</span>
                <span class="mp-cw-stat-val">@{{ selectedCity.pressure }} hPa</span>
              </div>
            </div>

            <!-- Indeks UV -->
            <div class="mp-cw-stat-col">
              <i class="fas fa-sun mp-cw-stat-icon" style="color:#F59E0B;"></i>
              <div class="mp-cw-stat-info">
                <span class="mp-cw-stat-lbl">Indeks UV</span>
                <span class="mp-cw-stat-val">@{{ selectedCity.uv }}</span>
              </div>
            </div>
          </div>

          <!-- Detail Button -->
          <a href="/prakiraan" class="mp-cw-detail-btn">
            <span>Lihat Detail</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

      </main>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
  const { createApp, ref, computed, onMounted } = Vue;

  createApp({
    setup() {
      const activeLayer = ref('rain');
      const currentDate = ref('');
      const currentTime = ref('');

      const layerList = [
        { id: 'rain', name: 'Rain Radar', icon: 'fas fa-cloud-showers-heavy' },
        { id: 'cloud', name: 'Cloud Radar', icon: 'fas fa-cloud' },
        { id: 'wind', name: 'Wind Animation', icon: 'fas fa-wind' },
        { id: 'temperature', name: 'Temperature Map', icon: 'fas fa-temperature-half' },
        { id: 'humidity', name: 'Humidity Map', icon: 'fas fa-tint' },
        { id: 'lightning', name: 'Lightning', icon: 'fas fa-bolt' },
        { id: 'snow', name: 'Snow', icon: 'fas fa-snowflake' },
        { id: 'pressure', name: 'Pressure', icon: 'fas fa-compress-alt' },
        { id: 'aqi', name: 'AQI', icon: 'fas fa-smog' },
        { id: 'fog', name: 'Fog', icon: 'fas fa-water' },
      ];

      const currentLayerName = computed(() => {
        const found = layerList.find(l => l.id === activeLayer.value);
        return found ? found.name : 'Rain Radar';
      });

      const selectedCity = ref({
        name: 'Denpasar, Bali',
        coords: '8.6705° S, 115.2126° E',
        icon: '🌧️',
        temp: 26,
        condition: 'Hujan Ringan',
        humidity: 87,
        wind: 12.6,
        windDir: 'Timur',
        pressure: 1009,
        uv: '3 (Sedang)'
      });

      const cities = [
        { name: 'Denpasar', fullName: 'Denpasar, Bali', lat: -8.6705, lng: 115.2126, coords: '8.6705° S, 115.2126° E', temp: 26, condition: 'Hujan Ringan', icon: '🌧️', humidity: 87, wind: 12.6, windDir: 'Timur', pressure: 1009, uv: '3 (Sedang)' },
        { name: 'Jakarta', fullName: 'Jakarta', lat: -6.2088, lng: 106.8456, coords: '6.2088° S, 106.8456° E', temp: 31, condition: 'Berawan', icon: '⛅', humidity: 74, wind: 14.2, windDir: 'Utara', pressure: 1010, uv: '6 (Tinggi)' },
        { name: 'Bandung', fullName: 'Bandung', lat: -6.9175, lng: 107.6191, coords: '6.9175° S, 107.6191° E', temp: 24, condition: 'Hujan Sedang', icon: '🌧️', humidity: 89, wind: 9.5, windDir: 'Barat Daya', pressure: 1012, uv: '2 (Rendah)' },
        { name: 'Surabaya', fullName: 'Surabaya', lat: -7.2575, lng: 112.7521, coords: '7.2575° S, 112.7521° E', temp: 32, condition: 'Cerah Berawan', icon: '🌤️', humidity: 68, wind: 16.0, windDir: 'Timur Laut', pressure: 1008, uv: '7 (Tinggi)' },
        { name: 'Banda Aceh', fullName: 'Banda Aceh', lat: 5.5483, lng: 95.3238, coords: '5.5483° N, 95.3238° E', temp: 29, condition: 'Cerah', icon: '☀️', humidity: 76, wind: 11.0, windDir: 'Barat', pressure: 1011, uv: '8 (Sangat Tinggi)' },
        { name: 'Medan', fullName: 'Medan', lat: 3.5952, lng: 98.6722, coords: '3.5952° N, 98.6722° E', temp: 30, condition: 'Hujan Ringan', icon: '🌦️', humidity: 82, wind: 8.4, windDir: 'Barat Laut', pressure: 1009, uv: '5 (Sedang)' },
        { name: 'Kuala Lumpur', fullName: 'Kuala Lumpur', lat: 3.1390, lng: 101.6869, coords: '3.1390° N, 101.6869° E', temp: 30, condition: 'Berawan', icon: '☁️', humidity: 80, wind: 10.2, windDir: 'Barat', pressure: 1010, uv: '5 (Sedang)' },
        { name: 'Kuching', fullName: 'Kuching', lat: 1.5533, lng: 110.3592, coords: '1.5533° N, 110.3592° E', temp: 28, condition: 'Hujan Lebat', icon: '⛈️', humidity: 91, wind: 15.1, windDir: 'Selatan', pressure: 1008, uv: '3 (Sedang)' },
        { name: 'Pontianak', fullName: 'Pontianak', lat: -0.0263, lng: 109.3425, coords: '0.0263° S, 109.3425° E', temp: 31, condition: 'Berawan', icon: '⛅', humidity: 78, wind: 12.0, windDir: 'Tenggara', pressure: 1009, uv: '6 (Tinggi)' },
        { name: 'Palangkaraya', fullName: 'Palangkaraya', lat: -2.2088, lng: 113.9140, coords: '2.2088° S, 113.9140° E', temp: 29, condition: 'Hujan Ringan', icon: '🌧️', humidity: 85, wind: 7.8, windDir: 'Timur', pressure: 1010, uv: '4 (Sedang)' },
        { name: 'Samarinda', fullName: 'Samarinda', lat: -0.5022, lng: 117.1536, coords: '0.5022° S, 117.1536° E', temp: 30, condition: 'Berawan Tebal', icon: '☁️', humidity: 80, wind: 10.5, windDir: 'Utara', pressure: 1009, uv: '5 (Sedang)' },
        { name: 'Makassar', fullName: 'Makassar', lat: -5.1477, lng: 119.4327, coords: '5.1477° S, 119.4327° E', temp: 31, condition: 'Cerah Berawan', icon: '🌤️', humidity: 71, wind: 17.5, windDir: 'Barat', pressure: 1009, uv: '7 (Tinggi)' },
        { name: 'Ambon', fullName: 'Ambon', lat: -3.6554, lng: 128.1906, coords: '3.6554° S, 128.1906° E', temp: 27, condition: 'Hujan Ringan', icon: '🌦️', humidity: 86, wind: 13.0, windDir: 'Tenggara', pressure: 1010, uv: '4 (Sedang)' },
        { name: 'Jayapura', fullName: 'Jayapura', lat: -2.5337, lng: 140.7181, coords: '2.5337° S, 140.7181° E', temp: 29, condition: 'Cerah Berawan', icon: '🌤️', humidity: 79, wind: 9.0, windDir: 'Timur', pressure: 1011, uv: '6 (Tinggi)' },
        { name: 'Kupang', fullName: 'Kupang', lat: -10.1772, lng: 123.6070, coords: '10.1772° S, 123.6070° E', temp: 32, condition: 'Cerah', icon: '☀️', humidity: 62, wind: 21.0, windDir: 'Tenggara', pressure: 1009, uv: '8 (Sangat Tinggi)' }
      ];

      const seaLabels = [
        { name: 'Samudra Hindia', lat: -10.5, lng: 102.0 },
        { name: 'Laut Jawa', lat: -5.2, lng: 111.5 },
        { name: 'Laut Banda', lat: -5.5, lng: 127.8 },
        { name: 'Laut Arafura', lat: -8.8, lng: 136.5 }
      ];

      let mapInstance = null;
      let cityMarkers = [];
      let radarCanvasLayer = null;

      const updateClock = () => {
        const now = new Date();
        currentDate.value = now.toLocaleDateString('id-ID', {
          day: 'numeric', month: 'long', year: 'numeric'
        });
        currentTime.value = now.toLocaleTimeString('id-ID', {
          hour: '2-digit', minute: '2-digit'
        });
      };

      const selectCity = (c) => {
        selectedCity.value = {
          name: c.fullName || c.name,
          coords: c.coords,
          temp: c.temp,
          condition: c.condition,
          icon: c.icon,
          humidity: c.humidity,
          wind: c.wind,
          windDir: c.windDir,
          pressure: c.pressure,
          uv: c.uv
        };
        cityMarkers.forEach(m => {
          const el = m.getElement();
          if (el) {
            const pin = el.querySelector('.mp-marker-pin');
            if (pin) {
              if (m._cityName === c.name) {
                pin.classList.add('active');
              } else {
                pin.classList.remove('active');
              }
            }
          }
        });
      };

      const setLayer = (id) => {
        activeLayer.value = id;
        if (radarCanvasLayer) radarCanvasLayer.redraw();
      };

      const cycleLayer = () => {
        const idx = layerList.findIndex(l => l.id === activeLayer.value);
        const next = layerList[(idx + 1) % layerList.length];
        setLayer(next.id);
      };

      const zoomIn = () => { if (mapInstance) mapInstance.zoomIn(); };
      const zoomOut = () => { if (mapInstance) mapInstance.zoomOut(); };
      const recenterMap = () => {
        if (mapInstance) {
          // Perfectly frame all Indonesia from Sabang to Merauke
          mapInstance.setView([-2.2, 118.5], 4.6);
        }
      };

      // Realistic vivid Doppler Radar cells matching user reference image
      const radarBlobs = [
        // West Sumatra cluster (Padang & Mentawai) - Strong storm core (red/yellow/green)
        { lat: -0.6, lng: 100.8, radius: 120, type: 'severe' },
        { lat: -1.4, lng: 101.4, radius: 100, type: 'heavy' },
        { lat: 0.8, lng: 99.2, radius: 90, type: 'moderate' },
        { lat: -2.8, lng: 102.2, radius: 110, type: 'moderate' },
        { lat: -3.8, lng: 103.5, radius: 95, type: 'light' },
        { lat: -1.8, lng: 98.2, radius: 130, type: 'moderate' },
        { lat: -3.2, lng: 97.4, radius: 110, type: 'light' },

        // Sunda Strait & West Java (Jakarta & Bandung precipitation band)
        { lat: -5.8, lng: 105.8, radius: 90, type: 'moderate' },
        { lat: -6.4, lng: 107.2, radius: 95, type: 'moderate' },
        { lat: -7.2, lng: 110.5, radius: 100, type: 'heavy' },

        // East Java & Bali Sea cluster (Intense thunderstorm core)
        { lat: -7.6, lng: 112.8, radius: 125, type: 'severe' },
        { lat: -8.1, lng: 114.2, radius: 100, type: 'heavy' },
        { lat: -8.6, lng: 115.3, radius: 95, type: 'moderate' },
        { lat: -9.2, lng: 109.5, radius: 140, type: 'light' },
        { lat: -9.8, lng: 113.5, radius: 130, type: 'moderate' },

        // South Kalimantan & Java Sea (Scattered convective cells)
        { lat: -5.0, lng: 109.8, radius: 100, type: 'light' },
        { lat: -4.5, lng: 112.5, radius: 95, type: 'moderate' },
        { lat: -3.2, lng: 114.6, radius: 85, type: 'light' },
        { lat: -2.4, lng: 112.8, radius: 80, type: 'moderate' },
        { lat: -1.2, lng: 110.5, radius: 75, type: 'light' },

        // Maluku & Halmahera Sea rain bands
        { lat: 0.8, lng: 128.2, radius: 110, type: 'moderate' },
        { lat: 1.6, lng: 129.5, radius: 95, type: 'heavy' },

        // Papua North Coast (Jayapura)
        { lat: -1.2, lng: 137.5, radius: 100, type: 'light' },
        { lat: -2.2, lng: 139.8, radius: 110, type: 'moderate' },
        { lat: -2.8, lng: 140.6, radius: 85, type: 'light' }
      ];

      const drawRadarOverlay = (canvas) => {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (!mapInstance) return;

        // Draw depending on activeLayer
        if (activeLayer.value === 'rain' || activeLayer.value === 'cloud') {
          radarBlobs.forEach(blob => {
            const pt = mapInstance.latLngToContainerPoint([blob.lat, blob.lng]);
            const r = blob.radius * (mapInstance.getZoom() / 5);

            // Radial gradient matching Doppler legend colors
            const grad = ctx.createRadialGradient(pt.x, pt.y, 0, pt.x, pt.y, r);

            if (activeLayer.value === 'rain') {
              if (blob.type === 'severe') {
                grad.addColorStop(0, 'rgba(239, 68, 68, 0.95)');   // Sangat Lebat (Red)
                grad.addColorStop(0.25, 'rgba(245, 158, 11, 0.88)'); // Lebat (Yellow/Orange)
                grad.addColorStop(0.55, 'rgba(34, 197, 94, 0.75)');  // Sedang (Green)
                grad.addColorStop(0.85, 'rgba(56, 189, 248, 0.55)'); // Ringan (Blue)
                grad.addColorStop(1, 'rgba(56, 189, 248, 0)');
              } else if (blob.type === 'heavy') {
                grad.addColorStop(0, 'rgba(245, 158, 11, 0.9)');
                grad.addColorStop(0.4, 'rgba(34, 197, 94, 0.75)');
                grad.addColorStop(0.75, 'rgba(56, 189, 248, 0.5)');
                grad.addColorStop(1, 'rgba(56, 189, 248, 0)');
              } else if (blob.type === 'moderate') {
                grad.addColorStop(0, 'rgba(34, 197, 94, 0.8)');
                grad.addColorStop(0.5, 'rgba(56, 189, 248, 0.6)');
                grad.addColorStop(1, 'rgba(56, 189, 248, 0)');
              } else {
                grad.addColorStop(0, 'rgba(56, 189, 248, 0.65)');
                grad.addColorStop(0.7, 'rgba(14, 165, 233, 0.4)');
                grad.addColorStop(1, 'rgba(14, 165, 233, 0)');
              }
            } else {
              // Cloud radar (monochrome white/gray)
              grad.addColorStop(0, 'rgba(255, 255, 255, 0.75)');
              grad.addColorStop(0.6, 'rgba(226, 232, 240, 0.4)');
              grad.addColorStop(1, 'rgba(226, 232, 240, 0)');
            }

            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(pt.x, pt.y, r, 0, Math.PI * 2);
            ctx.fill();
          });
        }
      };

      const initMap = async () => {
        const mapEl = document.getElementById('weatherMap');
        if (!mapEl || mapInstance) return;

        // Perfectly framed on Indonesia with smooth zoom
        mapInstance = L.map('weatherMap', {
          center: [-2.2, 118.5],
          zoom: 4.6,
          zoomSnap: 0.1,
          minZoom: 4,
          maxZoom: 10,
          zoomControl: false,
          attributionControl: false
        });

        // High quality Esri Satellite World Imagery
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
          maxZoom: 18,
          opacity: 0.95
        }).addTo(mapInstance);

        // Custom Canvas Doppler Radar Layer
        const CanvasOverlay = L.Layer.extend({
          onAdd(map) {
            this._map = map;
            this._canvas = L.DomUtil.create('canvas', 'leaflet-radar-canvas');
            this._canvas.style.position = 'absolute';
            this._canvas.style.top = '0';
            this._canvas.style.left = '0';
            this._canvas.style.pointerEvents = 'none';
            this._canvas.style.zIndex = '400';
            this._canvas.style.filter = 'blur(6px) saturate(160%)';
            map.getPanes().overlayPane.appendChild(this._canvas);
            map.on('move', this.redraw, this);
            map.on('resize', this.redraw, this);
            this.redraw();
          },
          onRemove(map) {
            L.DomUtil.remove(this._canvas);
            map.off('move', this.redraw, this);
            map.off('resize', this.redraw, this);
          },
          redraw() {
            if (!this._canvas || !this._map) return;
            const size = this._map.getSize();
            this._canvas.width = size.x;
            this._canvas.height = size.y;
            drawRadarOverlay(this._canvas);
          }
        });

        radarCanvasLayer = new CanvasOverlay();
        radarCanvasLayer.addTo(mapInstance);

        // Add Oceanic Sea Labels matching reference design
        seaLabels.forEach(s => {
          const icon = L.divIcon({
            className: 'mp-sea-label',
            html: `<span>${s.name}</span>`,
            iconSize: [160, 24],
            iconAnchor: [80, 12]
          });
          L.marker([s.lat, s.lng], { icon, interactive: false }).addTo(mapInstance);
        });

        // Add Cities Markers matching screenshot
        cities.forEach(c => {
          const isDefault = c.name === 'Denpasar';
          const icon = L.divIcon({
            className: 'custom-city-div',
            html: `
              <div class="mp-city-marker">
                <div class="mp-marker-pin ${isDefault ? 'active' : ''}"></div>
                <span class="mp-marker-label">${c.name}</span>
              </div>
            `,
            iconSize: [120, 24],
            iconAnchor: [5, 12]
          });

          const m = L.marker([c.lat, c.lng], { icon }).addTo(mapInstance);
          m._cityName = c.name;
          m.on('click', () => { selectCity(c); });
          cityMarkers.push(m);
        });

        setTimeout(() => {
          if (mapInstance) {
            mapInstance.invalidateSize();
            recenterMap();
          }
        }, 300);
      };

      onMounted(() => {
        updateClock();
        setInterval(updateClock, 1000);
        setTimeout(initMap, 100);
      });

      return {
        activeLayer, layerList, currentLayerName, selectedCity, currentDate, currentTime,
        setLayer, cycleLayer, zoomIn, zoomOut, recenterMap
      };
    }
  }).mount('#map-app');
})();
</script>
@endpush

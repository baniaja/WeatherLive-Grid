@extends('layouts.app')

@section('title', 'Indeks Outdoor — WeatherLive-Grid')

@section('styles')
<style>
/* =========================================================
   INDEKS OUTDOOR — WEATHERLIVE-GRID v3.0
   PIXEL-PERFECT REPLICA OF USER REFERENCE DESIGN
   ULTRA-PREMIUM OUTDOOR ACTIVITY WEATHER DASHBOARD
   ========================================================= */

.od-page-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  overflow: hidden;
  background:
    linear-gradient(180deg, rgba(6, 13, 26, 0.35) 0%, rgba(6, 13, 26, 0.78) 380px, #060e1d 650px, #030712 100%),
    url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=85') top center/100% auto no-repeat;
}

.od-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── 2-Column Layout (Sidebar + Main) ── */
.od-layout-grid {
  display: grid;
  grid-template-columns: 220px minmax(0, 1fr);
  gap: 24px;
  align-items: start;
}
@media (max-width: 1024px) {
  .od-layout-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

/* ── Left Sidebar Navigation ── */
.od-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 220px;
  flex-shrink: 0;
}
@media (max-width: 1024px) {
  .od-sidebar {
    display: none;
  }
}

.od-nav-card {
  background: rgba(10, 22, 46, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 12px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
}
.od-nav-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.od-nav-item {
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
.od-nav-item i {
  font-size: 14px;
  width: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.45);
  transition: color 0.2s;
}
.od-nav-item:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #fff;
}
.od-nav-item:hover i { color: #38BDF8; }

.od-nav-item.active {
  background: #0284C7;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
}
.od-nav-item.active i {
  color: #FFFFFF;
}

/* Quote Box at Bottom of Sidebar */
.od-quote-card {
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
.od-quote-text {
  position: relative;
  z-index: 2;
  font-size: 12.5px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.85);
  font-style: italic;
}
.od-quote-line {
  width: 28px;
  height: 2px;
  background: #38BDF8;
  margin-top: 10px;
  border-radius: 99px;
}

/* ── Right Main Panel (Strictly contained, no overflow) ── */
.od-main-panel {
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-width: 0;
  width: 100%;
}

/* ── Top Header Section (Title + Subtitle + Control Pills in 1 Level) ── */
.od-top-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
}

.od-title-col {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
}

.od-pill-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 99px;
  background: rgba(34, 197, 94, 0.18);
  border: 1px solid rgba(34, 197, 94, 0.45);
  color: #22C55E;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  width: fit-content;
}

.od-main-title {
  font-size: 32px;
  font-weight: 900;
  color: #FFFFFF;
  margin: 0;
  letter-spacing: -0.025em;
  line-height: 1.1;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
}

.od-subtitle {
  font-size: 13.5px;
  color: rgba(255, 255, 255, 0.7);
  max-width: 580px;
  line-height: 1.5;
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.8);
}

/* Header Controls Strip on Top Right (Single Row) */
.od-header-ctrls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
  white-space: nowrap;
  flex-shrink: 0;
}
@media (max-width: 900px) {
  .od-header-ctrls {
    flex-wrap: wrap;
  }
}

/* Location Selector Dropdown Pill */
.od-location-pill {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(12, 25, 52, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(56, 189, 248, 0.32);
  border-radius: 12px;
  padding: 8px 14px;
  font-size: 12.5px;
  font-weight: 700;
  color: #FFFFFF;
  cursor: pointer;
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
  transition: all 0.2s;
}
.od-location-pill:hover {
  background: rgba(56, 189, 248, 0.18);
  border-color: #38BDF8;
}
.od-location-pill i.fa-map-marker-alt { color: #38BDF8; font-size: 13px; }
.od-location-pill i.fa-chevron-down { font-size: 10px; color: rgba(255,255,255,0.5); }

/* Weather Pill */
.od-weather-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(12, 25, 52, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(56, 189, 248, 0.32);
  border-radius: 12px;
  padding: 8px 14px;
  font-size: 12.5px;
  font-weight: 700;
  color: #FFFFFF;
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
}
.od-weather-pill i { color: #38BDF8; font-size: 14px; }

/* Date / Time Widget Card on Top Right (Guaranteed no text clipping) */
.od-datetime-pill {
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
.od-dt-item {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12.5px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.od-dt-item i {
  color: #38BDF8;
  font-size: 13px;
}
.od-dt-sep {
  width: 1px;
  height: 16px;
  background: rgba(255, 255, 255, 0.18);
}

/* ── Activity Cards Grids (Row 1: 4 Cards, Row 2: 5 Cards) ── */
.od-grid-row1 {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
@media (max-width: 1100px) {
  .od-grid-row1 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .od-grid-row1 { grid-template-columns: 1fr; }
}

.od-grid-row2 {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
}
@media (max-width: 1200px) {
  .od-grid-row2 { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
  .od-grid-row2 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
  .od-grid-row2 { grid-template-columns: 1fr; }
}

/* ── Individual Activity Card (Rich & Atmospheric) ── */
.od-card {
  position: relative;
  border-radius: 18px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.12);
  box-shadow: 0 14px 34px rgba(0, 0, 0, 0.5);
  padding: 18px 18px 16px;
  min-height: 180px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
  background-size: cover;
  background-position: center;
  transition: all 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
}
.od-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(6, 14, 32, 0.35) 0%, rgba(6, 14, 32, 0.65) 50%, rgba(6, 14, 32, 0.94) 100%);
  z-index: 1;
  transition: background 0.25s;
}
.od-card:hover {
  transform: translateY(-4px);
  border-color: rgba(56, 189, 248, 0.45);
  box-shadow: 0 20px 48px rgba(0, 0, 0, 0.65), 0 0 24px rgba(56, 189, 248, 0.25);
}
.od-card:hover::before {
  background: linear-gradient(180deg, rgba(6, 14, 32, 0.2) 0%, rgba(6, 14, 32, 0.55) 50%, rgba(6, 14, 32, 0.9) 100%);
}

.od-card-header {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 10px;
}

.od-icon-title-group {
  display: flex;
  align-items: center;
  gap: 12px;
}

.od-icon-box {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);
}

.od-card-title {
  font-size: 15px;
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.2;
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.9);
}
.od-card-subtitle {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.7);
  margin-top: 2px;
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.9);
}

.od-card-chevron {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.4);
  margin-top: 6px;
  transition: transform 0.2s, color 0.2s;
}
.od-card:hover .od-card-chevron {
  color: #38BDF8;
  transform: translateX(3px);
}

.od-card-bottom {
  position: relative;
  z-index: 2;
  margin-top: 14px;
}

.od-score-row {
  display: flex;
  align-items: baseline;
  gap: 8px;
  margin-bottom: 8px;
}
.od-score-val {
  font-size: 24px;
  font-weight: 900;
  color: #FFFFFF;
  font-family: 'Space Grotesk', sans-serif;
  line-height: 1;
  text-shadow: 0 1px 4px rgba(0, 0, 0, 0.9);
}
.od-score-label {
  font-size: 11px;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.85);
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.9);
}

.od-progress-track {
  width: 100%;
  height: 5px;
  border-radius: 99px;
  background: rgba(255, 255, 255, 0.14);
  overflow: hidden;
}
.od-progress-fill {
  height: 100%;
  border-radius: 99px;
  transition: width 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

/* ── Bottom Recommendation Panoramic Banner ── */
.od-recommend-banner {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  border: 1.5px solid rgba(56, 189, 248, 0.28);
  box-shadow:
    0 20px 50px rgba(0, 0, 0, 0.6),
    0 0 35px rgba(56, 189, 248, 0.12);
  padding: 24px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  background:
    linear-gradient(90deg, rgba(6, 18, 42, 0.94) 0%, rgba(6, 18, 42, 0.8) 55%, rgba(6, 14, 32, 0.55) 100%),
    url('https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
}
@media (max-width: 800px) {
  .od-recommend-banner { flex-direction: column; align-items: flex-start; }
}

.od-rec-left {
  display: flex;
  align-items: center;
  gap: 18px;
  position: relative;
  z-index: 2;
}

.od-bulb-badge {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #FFFFFF;
  box-shadow: 0 0 20px rgba(56, 189, 248, 0.5);
  flex-shrink: 0;
}

.od-rec-title {
  font-size: 16px;
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.2;
}
.od-rec-desc {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.75);
  margin-top: 4px;
  max-width: 680px;
  line-height: 1.5;
}

.od-detail-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 22px;
  border-radius: 99px;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #FFFFFF;
  font-size: 12.5px;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  white-space: nowrap;
  backdrop-filter: blur(12px);
  transition: all 0.25s;
  position: relative;
  z-index: 2;
}
.od-detail-btn:hover {
  background: rgba(56, 189, 248, 0.22);
  border-color: #38BDF8;
  color: #38BDF8;
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(56, 189, 248, 0.35);
}

/* ── Sub-footer Micro Strip (Exact Match) ── */
.od-subfooter {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 16px 6px 0;
  font-size: 11.5px;
  color: rgba(255, 255, 255, 0.45);
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  margin-top: 4px;
  flex-wrap: wrap;
}
.od-subfooter-left {
  display: flex;
  align-items: center;
  gap: 10px;
}
.od-subfooter-left i {
  color: #38BDF8;
  font-size: 14px;
}
.od-subfooter-brand {
  font-weight: 700;
  color: rgba(255, 255, 255, 0.85);
}
.od-subfooter-right {
  color: rgba(255, 255, 255, 0.4);
}
</style>
@endsection

@section('content')
<div id="ou-app" v-cloak>

  <!-- Atmospheric Background Canvas with Panoramic Golden Sunset Mountain Vista -->
  <div class="od-page-bg"></div>

  <div class="od-shell page-wrap">
    <div class="od-layout-grid">

      <!-- ====== 1. LEFT SIDEBAR NAVIGATION ====== -->
      <aside class="od-sidebar">
        <div class="od-nav-card">
          <nav class="od-nav-list">
            <!-- Beranda (Active) -->
            <a href="/indeks-outdoor" class="od-nav-item active">
              <i class="fas fa-home"></i>
              <span>Beranda</span>
            </a>
            <!-- Prakiraan -->
            <a href="/prakiraan" class="od-nav-item">
              <i class="fas fa-calendar-alt"></i>
              <span>Prakiraan</span>
            </a>
            <!-- Peta Cuaca -->
            <a href="/peta" class="od-nav-item">
              <i class="fas fa-map-marked-alt"></i>
              <span>Peta Cuaca</span>
            </a>
            <!-- Perbandingan -->
            <a href="/bandingkan" class="od-nav-item">
              <i class="fas fa-scale-balanced"></i>
              <span>Perbandingan</span>
            </a>
            <!-- Riwayat -->
            <a href="/histori" class="od-nav-item">
              <i class="fas fa-clock-rotate-left"></i>
              <span>Riwayat</span>
            </a>
            <!-- Pengaturan -->
            <a href="/developer" class="od-nav-item">
              <i class="fas fa-gear"></i>
              <span>Pengaturan</span>
            </a>
          </nav>
        </div>

        <!-- Scenic Nature Valley Quote Card (Matches Screenshot) -->
        <div class="od-quote-card">
          <div class="od-quote-text">
            &ldquo;Cuaca terbaik adalah saat kamu menikmati aktivitasmu di alam.&rdquo;
          </div>
          <div class="od-quote-line"></div>
        </div>
      </aside>


      <!-- ====== 2. RIGHT MAIN CONTENT ====== -->
      <main class="od-main-panel">

        <!-- Top Header Strip (Badge, Title, Subtitle & Control Pills) -->
        <div class="od-top-header">
          <div class="od-title-col">
            <div class="od-pill-badge">
              <i class="fas fa-tree"></i>
              <span>AKTIVITAS LUAR RUANGAN</span>
            </div>
            <h1 class="od-main-title">Indeks Outdoor</h1>
            <div class="od-subtitle">
              Rekomendasi aktivitas luar ruangan berdasarkan kondisi cuaca di wilayah Anda.
            </div>
          </div>

          <!-- Header Right Controls Strip (Single Clean Row) -->
          <div class="od-header-ctrls">
            <!-- Location Selector Dropdown Pill -->
            <div class="od-location-pill" @click="cycleLocation" title="Klik untuk berganti wilayah Jawa Barat">
              <i class="fas fa-map-marker-alt"></i>
              <span>@{{ selectedLocationName }}</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <!-- Weather Status Pill -->
            <div class="od-weather-pill">
              <i class="fas fa-cloud"></i>
              <span>@{{ currentTemp }}&deg;C &middot; @{{ conditionText }}</span>
            </div>

            <!-- Live Date & Clock Widget (Guaranteed no text clipping) -->
            <div class="od-datetime-pill">
              <div class="od-dt-item">
                <i class="fas fa-calendar-alt"></i>
                <span>@{{ currentDate }}</span>
              </div>
              <div class="od-dt-sep"></div>
              <div class="od-dt-item">
                <i class="fas fa-clock"></i>
                <span>@{{ currentTime }} WIB</span>
              </div>
            </div>
          </div>
        </div>


        <!-- ====== 3. ROW 1: 4 ACTIVITY CARDS (Running, Cycling, Golf, Fishing) ====== -->
        <div class="od-grid-row1">
          <div
            v-for="act in row1Activities"
            :key="act.id"
            class="od-card"
            :style="{ backgroundImage: 'url(' + act.bg + ')' }"
            @click="showDetail(act)"
          >
            <!-- Card Header -->
            <div class="od-card-header">
              <div class="od-icon-title-group">
                <div class="od-icon-box" :style="{ background: act.iconBg, color: act.iconColor }">
                  <i :class="act.icon"></i>
                </div>
                <div>
                  <div class="od-card-title">@{{ act.name }}</div>
                  <div class="od-card-subtitle">@{{ act.subtitle }}</div>
                </div>
              </div>
              <i class="fas fa-chevron-right od-card-chevron"></i>
            </div>

            <!-- Card Bottom Score & Bar -->
            <div class="od-card-bottom">
              <div class="od-score-row">
                <span class="od-score-val">@{{ act.score }}/10</span>
                <span class="od-score-label">@{{ act.label }}</span>
              </div>
              <div class="od-progress-track">
                <div
                  class="od-progress-fill"
                  :style="{ width: (act.score * 10) + '%', background: act.barGradient }"
                ></div>
              </div>
            </div>
          </div>
        </div>


        <!-- ====== 4. ROW 2: 5 ACTIVITY CARDS (Camping, BBQ, Beach, Photography, Stargazing) ====== -->
        <div class="od-grid-row2">
          <div
            v-for="act in row2Activities"
            :key="act.id"
            class="od-card"
            :style="{ backgroundImage: 'url(' + act.bg + ')' }"
            @click="showDetail(act)"
          >
            <!-- Card Header -->
            <div class="od-card-header">
              <div class="od-icon-title-group">
                <div class="od-icon-box" :style="{ background: act.iconBg, color: act.iconColor }">
                  <i :class="act.icon"></i>
                </div>
                <div>
                  <div class="od-card-title">@{{ act.name }}</div>
                  <div class="od-card-subtitle">@{{ act.subtitle }}</div>
                </div>
              </div>
              <i class="fas fa-chevron-right od-card-chevron"></i>
            </div>

            <!-- Card Bottom Score & Bar -->
            <div class="od-card-bottom">
              <div class="od-score-row">
                <span class="od-score-val">@{{ act.score }}/10</span>
                <span class="od-score-label">@{{ act.label }}</span>
              </div>
              <div class="od-progress-track">
                <div
                  class="od-progress-fill"
                  :style="{ width: (act.score * 10) + '%', background: act.barGradient }"
                ></div>
              </div>
            </div>
          </div>
        </div>


        <!-- ====== 5. BOTTOM RECOMMENDATION PANORAMIC BANNER ====== -->
        <div class="od-recommend-banner">
          <div class="od-rec-left">
            <div class="od-bulb-badge">
              <i class="fas fa-lightbulb"></i>
            </div>
            <div>
              <div class="od-rec-title">Rekomendasi Hari Ini</div>
              <div class="od-rec-desc">
                Aktivitas outdoor terbaik untuk hari ini adalah <strong>Running</strong>, <strong>Cycling</strong>, dan <strong>Camping</strong>. Cuaca cukup baik dengan suhu yang nyaman dan risiko hujan rendah.
              </div>
            </div>
          </div>

          <button class="od-detail-btn" @click="openTipsModal">
            <span>Lihat Detail</span>
            <i class="fas fa-chevron-right" style="font-size:11px;"></i>
          </button>
        </div>


        <!-- ====== 6. SUB-FOOTER MICRO STRIP ====== -->
        <div class="od-subfooter">
          <div class="od-subfooter-left">
            <i class="fas fa-mountain-sun"></i>
            <span class="od-subfooter-brand">WeatherLive &middot; Grid</span>
            <span>Data cuaca akurat untuk keputusan yang lebih baik.</span>
          </div>
          <div class="od-subfooter-right">
            <span>Sumber data: BMKG, OpenWeather &nbsp;&bull;&nbsp; Terakhir diperbarui: @{{ currentDate }} @{{ currentTime }} WIB</span>
          </div>
        </div>

      </main>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
  const { createApp, ref, onMounted } = Vue;

  createApp({
    setup() {
      const currentDate = ref('');
      const currentTime = ref('');

      // Location & Weather State
      const selectedLocationName = ref('Kabupaten Bandung');
      const currentTemp = ref(32);
      const conditionText = ref('Berawan Tebal');

      const locations = [
        'Kabupaten Bandung',
        'Kota Bandung',
        'Kota Bogor',
        'Kabupaten Bogor',
        'Kota Bekasi',
        'Kabupaten Cianjur',
        'Kabupaten Garut',
        'Kabupaten Sukabumi',
        'Kabupaten Tasikmalaya',
        'Kabupaten Cirebon'
      ];
      let locIdx = 0;

      const cycleLocation = () => {
        locIdx = (locIdx + 1) % locations.length;
        selectedLocationName.value = locations[locIdx];
        if (window.showToast) {
          window.showToast('Lokasi Outdoor', 'Wilayah dialihkan ke ' + selectedLocationName.value, 'info');
        }
      };

      // 4 Cards in Row 1 (Running, Cycling, Golf, Fishing) - Matching User Reference Photos
      const row1Activities = ref([
        {
          id: 'running',
          name: 'Running',
          subtitle: 'Olahraga Lari',
          icon: 'fas fa-running',
          iconBg: 'rgba(14, 165, 233, 0.3)',
          iconColor: '#38BDF8',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=600&q=80',
          tips: 'Suhu ideal untuk lari pagi atau sore. Gunakan pakaian breathable dan bawa air minum.'
        },
        {
          id: 'cycling',
          name: 'Cycling',
          subtitle: 'Bersepeda',
          icon: 'fas fa-bicycle',
          iconBg: 'rgba(34, 197, 94, 0.3)',
          iconColor: '#22C55E',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=600&q=80',
          tips: 'Jalur kering dan visibilitas jernih. Pastikan tekanan ban optimal dan gunakan helm.'
        },
        {
          id: 'golf',
          name: 'Golf',
          subtitle: 'Bermain Golf',
          icon: 'fas fa-golf-ball-tee',
          iconBg: 'rgba(168, 85, 247, 0.3)',
          iconColor: '#A855F7',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=600&q=80',
          tips: 'Kecepatan angin tenang dan rumput lapangan kering. Sempurna untuk 18 hole.'
        },
        {
          id: 'fishing',
          name: 'Fishing',
          subtitle: 'Memancing',
          icon: 'fas fa-fish',
          iconBg: 'rgba(59, 130, 246, 0.3)',
          iconColor: '#3B82F6',
          score: 9,
          label: 'Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=600&q=80',
          tips: 'Aktivitas ikan aktif di permukaan dan tepian danau saat berawan teduh.'
        }
      ]);

      // 5 Cards in Row 2 (Camping, BBQ, Beach, Photography, Stargazing)
      const row2Activities = ref([
        {
          id: 'camping',
          name: 'Camping',
          subtitle: 'Berkemah',
          icon: 'fas fa-campground',
          iconBg: 'rgba(249, 115, 22, 0.3)',
          iconColor: '#F97316',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=600&q=80',
          tips: 'Peluang hujan minim. Waktu sempurna untuk mendirikan tenda di dataran tinggi.'
        },
        {
          id: 'bbq',
          name: 'BBQ',
          subtitle: 'Piknik & BBQ',
          icon: 'fas fa-fire-burner',
          iconBg: 'rgba(239, 68, 68, 0.3)',
          iconColor: '#EF4444',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80',
          tips: 'Angin sejuk sepoi-sepoi mendukung memanggang di luar tanpa gangguan hujan.'
        },
        {
          id: 'beach',
          name: 'Beach',
          subtitle: 'Pantai',
          icon: 'fas fa-water',
          iconBg: 'rgba(20, 184, 166, 0.3)',
          iconColor: '#14B8A6',
          score: 10,
          label: 'Sangat Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #22C55E)',
          bg: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
          tips: 'Ombak sedang dan air laut hangat. Gunakan tabir surya dan nikmati pesisir.'
        },
        {
          id: 'photography',
          name: 'Photography',
          subtitle: 'Fotografi',
          icon: 'fas fa-camera',
          iconBg: 'rgba(99, 102, 241, 0.3)',
          iconColor: '#6366F1',
          score: 8,
          label: 'Baik',
          barGradient: 'linear-gradient(90deg, #10B981, #34D399)',
          bg: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=600&q=80',
          tips: 'Cahaya lembut terdispersi awan menciptakan kontras dramatis untuk lanskap.'
        },
        {
          id: 'stargazing',
          name: 'Stargazing',
          subtitle: 'Melihat Bintang',
          icon: 'fas fa-star',
          iconBg: 'rgba(59, 130, 246, 0.3)',
          iconColor: '#60A5FA',
          score: 5,
          label: 'Cukup',
          barGradient: 'linear-gradient(90deg, #F59E0B, #F97316)',
          bg: 'https://images.unsplash.com/photo-1506703719100-a0f3a48c0f86?auto=format&fit=crop&w=600&q=80',
          tips: 'Sebagian langit tertutup awan. Pilih lokasi tinggi dan pantau celah awan malam hari.'
        }
      ]);

      const updateClock = () => {
        const now = new Date();
        currentDate.value = now.toLocaleDateString('id-ID', {
          day: 'numeric',
          month: 'long',
          year: 'numeric'
        });
        currentTime.value = now.toLocaleTimeString('id-ID', {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false
        });
      };

      const fetchWeather = async () => {
        try {
          const res = await fetch('/api/dashboard/overview');
          const data = await res.json();
          if (data.success && data.data) {
            if (data.data.location?.name) {
              selectedLocationName.value = data.data.location.name
                .toLowerCase()
                .replace(/(^|\s|-)\S/g, l => l.toUpperCase());
            }
            if (data.data.current) {
              currentTemp.value = Math.round(data.data.current.temperature);
              conditionText.value = data.data.current.weather_description || 'Berawan Tebal';
            }
          }
        } catch (e) {
          console.warn('Gagal memuat overview cuaca real-time:', e);
        }
      };

      const showDetail = (act) => {
        if (window.showToast) {
          window.showToast(act.name + ' (' + act.score + '/10 · ' + act.label + ')', act.tips, 'info');
        } else {
          alert(act.name + ' (' + act.score + '/10): ' + act.tips);
        }
      };

      const openTipsModal = () => {
        if (window.showToast) {
          window.showToast('Rekomendasi Outdoor', 'Kondisi cuaca sangat mendukung aktivitas lari, bersepeda, golf, dan berkemah. Nikmati akhir pekan Anda!', 'success');
        } else {
          alert('Rekomendasi Hari Ini: Cuaca cerah berawan dengan suhu sejuk. Sangat disarankan untuk kegiatan luar ruangan bersama keluarga!');
        }
      };

      onMounted(() => {
        updateClock();
        setInterval(updateClock, 1000);
        fetchWeather();
      });

      return {
        currentDate, currentTime, selectedLocationName, currentTemp, conditionText,
        row1Activities, row2Activities, cycleLocation, showDetail, openTipsModal
      };
    }
  }).mount('#ou-app');
})();
</script>
@endpush

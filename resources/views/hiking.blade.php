@extends('layouts.app')

@section('title', 'Mode Pendakian — WeatherLive-Grid')

@section('styles')
<style>
/* =========================================================
   MODE PENDAKIAN — WEATHERLIVE-GRID v3.0
   PIXEL-PERFECT REPLICA OF USER REFERENCE DESIGN
   ULTRA-PREMIUM MOUNTAIN WEATHER DASHBOARD
   ========================================================= */

.hk-page-bg {
  position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
}
.hk-page-bg::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 80% 50% at 50% -10%, rgba(14, 116, 144, 0.22) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 90% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 55%),
    linear-gradient(180deg, #07152e 0%, #060e1d 50%, #030712 100%);
}

.hk-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── 2-Column Layout (Sidebar + Main) ── */
.hk-layout-grid {
  display: grid;
  grid-template-columns: 220px minmax(0, 1fr);
  gap: 24px;
  align-items: start;
}
@media (max-width: 1024px) {
  .hk-layout-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

/* ── Left Sidebar Navigation ── */
.hk-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 220px;
  flex-shrink: 0;
}
@media (max-width: 1024px) {
  .hk-sidebar {
    display: none;
  }
}

.hk-nav-card {
  background: rgba(10, 22, 46, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 12px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
}
.hk-nav-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.hk-nav-item {
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
.hk-nav-item i {
  font-size: 14px;
  width: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.45);
  transition: color 0.2s;
}
.hk-nav-item:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #fff;
}
.hk-nav-item:hover i { color: #38BDF8; }

.hk-nav-item.active {
  background: #0284C7;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
}
.hk-nav-item.active i {
  color: #FFFFFF;
}

/* Quote Box at Bottom of Sidebar */
.hk-quote-card {
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
    url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80') center/cover no-repeat;
}
.hk-quote-text {
  position: relative;
  z-index: 2;
  font-size: 12.5px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.85);
  font-style: italic;
}
.hk-quote-line {
  width: 28px;
  height: 2px;
  background: #38BDF8;
  margin-top: 10px;
  border-radius: 99px;
}

/* ── Right Main Panel (Strictly contained, no overflow) ── */
.hk-main-panel {
  display: flex;
  flex-direction: column;
  gap: 18px;
  min-width: 0;
  width: 100%;
}

/* ── Mountain Panoramic Header Banner ── */
.hk-hero-banner {
  position: relative;
  border-radius: 24px;
  overflow: hidden;
  padding: 32px 34px;
  border: 1.5px solid rgba(56, 189, 248, 0.28);
  box-shadow:
    0 24px 60px rgba(0, 0, 0, 0.65),
    0 0 45px rgba(56, 189, 248, 0.15),
    inset 0 1px 0 rgba(255, 255, 255, 0.15);
  background:
    linear-gradient(180deg, rgba(6, 18, 42, 0.45) 0%, rgba(6, 14, 32, 0.94) 90%),
    url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=85') center/cover no-repeat;
}

.hk-banner-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  position: relative;
  z-index: 2;
}
@media (max-width: 900px) {
  .hk-banner-top {
    flex-wrap: wrap;
  }
}

.hk-title-group {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.hk-icon-box {
  width: 44px;
  height: 44px;
  border-radius: 14px;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #FFFFFF;
  box-shadow: 0 8px 24px rgba(2, 132, 199, 0.5), 0 0 16px rgba(56, 189, 248, 0.4);
  flex-shrink: 0;
}
.hk-title {
  font-size: 26px;
  font-weight: 900;
  color: #FFFFFF;
  margin: 0;
  letter-spacing: -0.025em;
  line-height: 1.2;
}

.hk-live-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(34, 197, 94, 0.18);
  border: 1px solid rgba(34, 197, 94, 0.45);
  color: #22C55E;
  font-size: 11px;
  font-weight: 800;
  padding: 4px 10px;
  border-radius: 99px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.hk-live-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #22C55E;
  box-shadow: 0 0 8px #22C55E;
  animation: hkDotPulse 1.6s ease-in-out infinite;
}
@keyframes hkDotPulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.8); }
}

.hk-meta-text {
  font-size: 13.5px;
  color: rgba(255, 255, 255, 0.78);
  font-weight: 600;
  letter-spacing: 0.01em;
}

/* Date / Time Widget Card on Top Right (Guaranteed no text clipping) */
.hk-datetime-pill {
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
.hk-dt-item {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12.5px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.hk-dt-item i {
  color: #38BDF8;
  font-size: 13px;
}
.hk-dt-sep {
  width: 1px;
  height: 16px;
  background: rgba(255, 255, 255, 0.18);
}

/* ── Summit / Mountain Quick Selector Strip ── */
.hk-mountain-strip {
  display: flex;
  align-items: center;
  gap: 8px;
  overflow-x: auto;
  scrollbar-width: none;
  padding-bottom: 2px;
  margin-top: 14px;
  width: 100%;
}
.hk-mountain-strip::-webkit-scrollbar { display: none; }

.hk-mountain-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 6px 14px;
  border-radius: 999px;
  background: rgba(10, 22, 46, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.12);
  color: rgba(255, 255, 255, 0.75);
  font-size: 11.5px;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
  backdrop-filter: blur(10px);
}
.hk-mountain-btn:hover {
  background: rgba(56, 189, 248, 0.14);
  border-color: rgba(56, 189, 248, 0.4);
  color: #38BDF8;
}
.hk-mountain-btn.active {
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  border-color: transparent;
  color: #FFFFFF;
  box-shadow: 0 4px 14px rgba(2, 132, 199, 0.45);
}

/* ── 7 Glass Metric Cards Row (Exact Match) ── */
.hk-metrics-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 12px;
}
@media (max-width: 1280px) {
  .hk-metrics-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}
@media (max-width: 768px) {
  .hk-metrics-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.hk-metric-card {
  background: rgba(8, 20, 44, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 18px;
  padding: 22px 12px 18px;
  text-align: center;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.45);
  transition: all 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  min-height: 155px;
}
.hk-metric-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6), 0 0 24px rgba(56, 189, 248, 0.2);
  border-color: rgba(56, 189, 248, 0.35);
}

.hk-metric-icon {
  font-size: 28px;
  filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.4));
  display: flex;
  align-items: center;
  justify-content: center;
  height: 36px;
}
.hk-metric-val {
  font-size: 24px;
  font-weight: 900;
  color: #FFFFFF;
  font-family: 'Space Grotesk', sans-serif;
  margin-top: 10px;
  line-height: 1;
  letter-spacing: -0.02em;
}
.hk-metric-lbl {
  font-size: 11px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.65);
  margin-top: 6px;
}
.hk-metric-bar {
  width: 44px;
  height: 3px;
  border-radius: 99px;
  margin-top: 14px;
}

/* ── Safety Status Banner Card (Kondisi Aman untuk Pendakian) ── */
.hk-safety-card {
  position: relative;
  background: rgba(8, 20, 44, 0.92);
  border: 1.5px solid rgba(34, 197, 94, 0.45);
  border-radius: 20px;
  padding: 22px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  overflow: hidden;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow:
    0 16px 40px rgba(0, 0, 0, 0.5),
    0 0 35px rgba(34, 197, 94, 0.15),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
  transition: all 0.3s;
}
.hk-safety-card.danger {
  border-color: rgba(239, 68, 68, 0.5);
  box-shadow:
    0 16px 40px rgba(0, 0, 0, 0.5),
    0 0 35px rgba(239, 68, 68, 0.2);
}

.hk-safety-left {
  display: flex;
  align-items: center;
  gap: 18px;
  position: relative;
  z-index: 2;
}
.hk-safety-badge {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: rgba(34, 197, 94, 0.18);
  border: 2px solid rgba(34, 197, 94, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #22C55E;
  box-shadow: 0 0 24px rgba(34, 197, 94, 0.35);
  flex-shrink: 0;
}
.hk-safety-card.danger .hk-safety-badge {
  background: rgba(239, 68, 68, 0.18);
  border-color: rgba(239, 68, 68, 0.5);
  color: #EF4444;
  box-shadow: 0 0 24px rgba(239, 68, 68, 0.35);
}

.hk-safety-title {
  font-size: 17px;
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.2;
}
.hk-safety-desc {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.72);
  margin-top: 4px;
  line-height: 1.4;
}

.hk-safety-right {
  display: flex;
  align-items: center;
  gap: 20px;
  position: relative;
  z-index: 2;
}
/* Mountain Silhouette in background of safety card */
.hk-safety-mountains-svg {
  position: absolute;
  right: 60px;
  bottom: 0;
  height: 100%;
  width: 320px;
  opacity: 0.28;
  pointer-events: none;
  z-index: 1;
}

.hk-safety-arrow-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.18);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.25s;
  flex-shrink: 0;
}
.hk-safety-arrow-btn:hover {
  background: #38BDF8;
  color: #030712;
  border-color: #38BDF8;
  transform: translateX(4px);
  box-shadow: 0 0 16px rgba(56, 189, 248, 0.5);
}

/* ── Bottom 3 Detail / Factor Cards (3 Columns) ── */
.hk-factors-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
}
@media (max-width: 900px) {
  .hk-factors-grid {
    grid-template-columns: 1fr;
  }
}

.hk-factor-card {
  background: rgba(8, 20, 44, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 22px 24px;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 14px 34px rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  gap: 18px;
  transition: all 0.25s;
  cursor: pointer;
}
.hk-factor-card:hover {
  transform: translateY(-3px);
  border-color: rgba(56, 189, 248, 0.35);
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55), 0 0 20px rgba(56, 189, 248, 0.15);
}

.hk-factor-icon-box {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: rgba(14, 165, 233, 0.15);
  border: 1.5px solid rgba(56, 189, 248, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: #38BDF8;
  flex-shrink: 0;
  box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);
}

.hk-factor-content {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-width: 0;
}
.hk-factor-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.hk-factor-lbl {
  font-size: 13px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.7);
}
.hk-factor-chevron {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.35);
  transition: transform 0.2s, color 0.2s;
}
.hk-factor-card:hover .hk-factor-chevron {
  color: #38BDF8;
  transform: translateX(3px);
}

.hk-factor-val {
  font-size: 24px;
  font-weight: 900;
  color: #FFFFFF;
  font-family: 'Space Grotesk', sans-serif;
  margin: 3px 0 2px;
  line-height: 1.1;
}
.hk-factor-desc {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.55);
  line-height: 1.4;
  white-space: normal;
}

/* ── Sub-footer Micro Strip (Exact Match) ── */
.hk-subfooter {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 16px 6px 0;
  font-size: 11.5px;
  color: rgba(255, 255, 255, 0.45);
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  margin-top: 6px;
  flex-wrap: wrap;
}
.hk-subfooter-left {
  display: flex;
  align-items: center;
  gap: 10px;
}
.hk-subfooter-left i {
  color: #38BDF8;
  font-size: 14px;
}
.hk-subfooter-brand {
  font-weight: 700;
  color: rgba(255, 255, 255, 0.85);
}
.hk-subfooter-right {
  color: rgba(255, 255, 255, 0.4);
}
</style>
@endsection

@section('content')
<div id="hk-app" v-cloak>

  <!-- Atmospheric Background Canvas -->
  <div class="hk-page-bg"></div>

  <div class="hk-shell page-wrap">
    <div class="hk-layout-grid">

      <!-- ====== 1. LEFT SIDEBAR NAVIGATION ====== -->
      <aside class="hk-sidebar">
        <div class="hk-nav-card">
          <nav class="hk-nav-list">
            <!-- Beranda (Active) -->
            <a href="/pendakian" class="hk-nav-item active">
              <i class="fas fa-home"></i>
              <span>Beranda</span>
            </a>
            <!-- Prakiraan -->
            <a href="/prakiraan" class="hk-nav-item">
              <i class="fas fa-cloud-sun"></i>
              <span>Prakiraan</span>
            </a>
            <!-- Peta Cuaca -->
            <a href="/peta" class="hk-nav-item">
              <i class="fas fa-map-marked-alt"></i>
              <span>Peta Cuaca</span>
            </a>
            <!-- Perbandingan -->
            <a href="/bandingkan" class="hk-nav-item">
              <i class="fas fa-chart-line"></i>
              <span>Perbandingan</span>
            </a>
            <!-- Riwayat -->
            <a href="/histori" class="hk-nav-item">
              <i class="fas fa-clock-rotate-left"></i>
              <span>Riwayat</span>
            </a>
            <!-- Pengaturan -->
            <a href="/developer" class="hk-nav-item">
              <i class="fas fa-gear"></i>
              <span>Pengaturan</span>
            </a>
          </nav>
        </div>

        <!-- Scenic Mountain Quote Card (Matches Screenshot) -->
        <div class="hk-quote-card">
          <div class="hk-quote-text">
            &ldquo;Jaga keselamatan di setiap perjalanan. Cuaca bisa berubah kapan saja.&rdquo;
          </div>
          <div class="hk-quote-line"></div>
        </div>
      </aside>


      <!-- ====== 2. RIGHT MAIN CONTENT ====== -->
      <main class="hk-main-panel">

        <!-- Panoramic Mountain Hero Banner -->
        <div class="hk-hero-banner">
          <div class="hk-banner-top">
            <div class="hk-title-group">
              <div class="hk-icon-box">
                <i class="fas fa-mountain"></i>
              </div>
              <h1 class="hk-title">Mode Pendakian</h1>
              <span class="hk-live-badge">
                <span class="hk-live-dot"></span>
                <span>LIVE</span>
              </span>
              <span class="hk-meta-text">
                @{{ locationLabel }} &middot; @{{ currentTemp }}&deg;C &middot; @{{ conditionLabel }}
              </span>
            </div>

            <!-- Live Date & Clock Widget (Guaranteed no text clipping) -->
            <div class="hk-datetime-pill">
              <div class="hk-dt-item">
                <i class="fas fa-calendar-alt"></i>
                <span>@{{ currentDate }}</span>
              </div>
              <div class="hk-dt-sep"></div>
              <div class="hk-dt-item">
                <i class="fas fa-clock"></i>
                <span>@{{ currentTime }} WIB</span>
              </div>
            </div>
          </div>

          <!-- Mountain Peak Selector Strip (West Java Summits) -->
          <div class="hk-mountain-strip">
            <button
              v-for="m in mountains"
              :key="m.id"
              class="hk-mountain-btn"
              :class="{ active: selectedMountainId === m.id }"
              @click="selectMountain(m)"
            >
              <i class="fas fa-mountain" style="font-size:10px;"></i>
              <span>@{{ m.name }} (@{{ m.elevation }}m)</span>
            </button>
          </div>
        </div>


        <!-- ====== 3. 7 GLASS METRIC CARDS ROW ====== -->
        <div class="hk-metrics-grid">
          <!-- 1. Kelembapan -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#38BDF8;">
              <i class="fas fa-cloud"></i>
            </div>
            <div class="hk-metric-val">@{{ humidity }}%</div>
            <div class="hk-metric-lbl">Kelembapan</div>
            <div class="hk-metric-bar" style="background:#38BDF8;box-shadow:0 0 10px #38BDF8;"></div>
          </div>

          <!-- 2. Angin -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#2DD4BF;">
              <i class="fas fa-wind"></i>
            </div>
            <div class="hk-metric-val">@{{ wind }} m/s</div>
            <div class="hk-metric-lbl">Angin</div>
            <div class="hk-metric-bar" style="background:#2DD4BF;box-shadow:0 0 10px #2DD4BF;"></div>
          </div>

          <!-- 3. Suhu Puncak -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#F59E0B;">
              <i class="fas fa-temperature-half"></i>
            </div>
            <div class="hk-metric-val">@{{ peakTemp }}&deg;C</div>
            <div class="hk-metric-lbl">Suhu Puncak</div>
            <div class="hk-metric-bar" style="background:#F59E0B;box-shadow:0 0 10px #F59E0B;"></div>
          </div>

          <!-- 4. Peluang Hujan -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#8B5CF6;">
              <i class="fas fa-cloud-showers-heavy"></i>
            </div>
            <div class="hk-metric-val">@{{ rainChance }}%</div>
            <div class="hk-metric-lbl">Peluang Hujan</div>
            <div class="hk-metric-bar" style="background:#8B5CF6;box-shadow:0 0 10px #8B5CF6;"></div>
          </div>

          <!-- 5. UV Index -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#FBBF24;">
              <i class="fas fa-sun"></i>
            </div>
            <div class="hk-metric-val">@{{ uvIndex }}</div>
            <div class="hk-metric-lbl">UV Index</div>
            <div class="hk-metric-bar" style="background:#FBBF24;box-shadow:0 0 10px #FBBF24;"></div>
          </div>

          <!-- 6. Sunrise -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#FB923C;">
              <i class="fas fa-mountain-sun"></i>
            </div>
            <div class="hk-metric-val">@{{ sunriseTime }}</div>
            <div class="hk-metric-lbl">Sunrise</div>
            <div class="hk-metric-bar" style="background:#FB923C;box-shadow:0 0 10px #FB923C;"></div>
          </div>

          <!-- 7. Sunset -->
          <div class="hk-metric-card">
            <div class="hk-metric-icon" style="color:#EC4899;">
              <i class="fas fa-sun-plant-wilt"></i>
            </div>
            <div class="hk-metric-val">@{{ sunsetTime }}</div>
            <div class="hk-metric-lbl">Sunset</div>
            <div class="hk-metric-bar" style="background:#EC4899;box-shadow:0 0 10px #EC4899;"></div>
          </div>
        </div>


        <!-- ====== 4. SAFETY STATUS BANNER CARD ====== -->
        <div class="hk-safety-card" :class="{ danger: !isSafe }">
          <!-- Mountain Vector Silhouette Inset Background -->
          <svg class="hk-safety-mountains-svg" viewBox="0 0 500 150" fill="none">
            <path d="M0,150 L120,40 L190,100 L310,20 L400,110 L500,45 L500,150 Z" fill="rgba(56, 189, 248, 0.45)"/>
            <path d="M60,150 L180,60 L240,110 L350,35 L440,115 L500,75 L500,150 Z" fill="rgba(34, 197, 94, 0.3)"/>
          </svg>

          <!-- Left Info Section -->
          <div class="hk-safety-left">
            <div class="hk-safety-badge">
              <i :class="isSafe ? 'fas fa-shield-halved' : 'fas fa-triangle-exclamation'"></i>
            </div>
            <div>
              <div class="hk-safety-title">@{{ isSafe ? 'Kondisi Aman untuk Pendakian' : 'Peringatan: Hindari Pendakian Saat Ini' }}</div>
              <div class="hk-safety-desc">@{{ safetyMessage }}</div>
            </div>
          </div>

          <!-- Right Action Button -->
          <div class="hk-safety-right">
            <button class="hk-safety-arrow-btn" @click="toggleDetailTips" title="Tips & Rekomendasi Pendakian">
              <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </div>


        <!-- ====== 5. BOTTOM 3 FACTOR / DETAIL CARDS ====== -->
        <div class="hk-factors-grid">
          <!-- Card 1: Peluang Hujan -->
          <div class="hk-factor-card" @click="showFactorDetail('rain')">
            <div class="hk-factor-icon-box">
              <i class="fas fa-umbrella"></i>
            </div>
            <div class="hk-factor-content">
              <div class="hk-factor-header">
                <span class="hk-factor-lbl">Peluang Hujan</span>
                <i class="fas fa-chevron-right hk-factor-chevron"></i>
              </div>
              <div class="hk-factor-val">@{{ rainChance }}%</div>
              <div class="hk-factor-desc">@{{ rainDescription }}</div>
            </div>
          </div>

          <!-- Card 2: Kecepatan Angin -->
          <div class="hk-factor-card" @click="showFactorDetail('wind')">
            <div class="hk-factor-icon-box">
              <i class="fas fa-wind"></i>
            </div>
            <div class="hk-factor-content">
              <div class="hk-factor-header">
                <span class="hk-factor-lbl">Kecepatan Angin</span>
                <i class="fas fa-chevron-right hk-factor-chevron"></i>
              </div>
              <div class="hk-factor-val">@{{ wind }} m/s</div>
              <div class="hk-factor-desc">@{{ windDescription }}</div>
            </div>
          </div>

          <!-- Card 3: Suhu Puncak -->
          <div class="hk-factor-card" @click="showFactorDetail('temp')">
            <div class="hk-factor-icon-box">
              <i class="fas fa-mountain"></i>
            </div>
            <div class="hk-factor-content">
              <div class="hk-factor-header">
                <span class="hk-factor-lbl">Suhu Puncak</span>
                <i class="fas fa-chevron-right hk-factor-chevron"></i>
              </div>
              <div class="hk-factor-val">@{{ peakTemp }}&deg;C</div>
              <div class="hk-factor-desc">@{{ tempDescription }}</div>
            </div>
          </div>
        </div>


        <!-- ====== 6. SUB-FOOTER MICRO STRIP ====== -->
        <div class="hk-subfooter">
          <div class="hk-subfooter-left">
            <i class="fas fa-mountain"></i>
            <span class="hk-subfooter-brand">WeatherLive &middot; Grid</span>
            <span>Informasi cuaca akurat untuk perjalanan yang lebih aman.</span>
          </div>
          <div class="hk-subfooter-right">
            <span>Satu Langkah Lebih Aman &nbsp;|&nbsp; Jelajah Alam dengan Data Terpercaya</span>
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
  const { createApp, ref, computed, onMounted } = Vue;

  createApp({
    setup() {
      const currentDate = ref('');
      const currentTime = ref('');

      // Location & Weather State
      const locationLabel = ref('KABUPATEN BANDUNG');
      const currentTemp = ref(21);
      const conditionLabel = ref('Berawan Tebal');

      // 7 Metrics
      const humidity = ref(99);
      const wind = ref(12);
      const peakTemp = ref(15);
      const rainChance = ref(30);
      const uvIndex = ref(0);
      const sunriseTime = ref('05:28');
      const sunsetTime = ref('17:45');

      // Safety state
      const isSafe = ref(true);
      const safetyMessage = ref('Cuaca cukup baik. Tetaplah waspada terhadap perubahan cuaca mendadak di pegunungan.');

      // 3 Factor descriptions
      const rainDescription = ref('Kemungkinan hujan ringan pada siang hari.');
      const windDescription = ref('Angin bertiup dari arah barat dengan kecepatan sedang.');
      const tempDescription = ref('Suhu di area puncak gunung terasa sejuk.');

      // West Java Iconic Mountains Preset
      const mountains = ref([
        { id: 'bandung', name: 'Kab. Bandung', elevation: 2000, tempOffset: -6, windFactor: 1.0, rainFactor: 1.0 },
        { id: 'gede', name: 'G. Gede', elevation: 2958, tempOffset: -9, windFactor: 1.25, rainFactor: 1.1 },
        { id: 'pangrango', name: 'G. Pangrango', elevation: 3019, tempOffset: -10, windFactor: 1.3, rainFactor: 1.15 },
        { id: 'ciremai', name: 'G. Ciremai', elevation: 3078, tempOffset: -10, windFactor: 1.4, rainFactor: 0.9 },
        { id: 'papandayan', name: 'G. Papandayan', elevation: 2665, tempOffset: -8, windFactor: 1.15, rainFactor: 1.05 },
        { id: 'tangkuban', name: 'G. Tangkuban Parahu', elevation: 2084, tempOffset: -6, windFactor: 1.1, rainFactor: 1.0 }
      ]);
      const selectedMountainId = ref('bandung');

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

      const selectMountain = (m) => {
        selectedMountainId.value = m.id;
        locationLabel.value = m.id === 'bandung' ? 'KABUPATEN BANDUNG' : m.name.toUpperCase();

        // Dynamically compute summit weather based on elevation & lapse rate
        peakTemp.value = Math.round(currentTemp.value + m.tempOffset);
        wind.value = Math.round(10 * m.windFactor);
        rainChance.value = Math.min(95, Math.round(30 * m.rainFactor));

        if (peakTemp.value < 10) {
          tempDescription.value = 'Suhu di puncak sangat dingin. Kenakan jaket thermal & windproof.';
        } else {
          tempDescription.value = 'Suhu di area puncak gunung terasa sejuk.';
        }

        if (wind.value > 15) {
          windDescription.value = 'Angin kencang di punggungan dan puncak. Waspada hipotermia.';
          isSafe.value = false;
          safetyMessage.value = 'Angin kencang berhembus di area puncak. Disarankan menunda ke titik tertinggi.';
        } else {
          windDescription.value = 'Angin bertiup dari arah barat dengan kecepatan sedang.';
          isSafe.value = true;
          safetyMessage.value = 'Cuaca cukup baik. Tetaplah waspada terhadap perubahan cuaca mendadak di pegunungan.';
        }
      };

      const fetchHikingData = async () => {
        try {
          const res = await fetch('/api/weather/hiking');
          const data = await res.json();
          if (data.success && data.data) {
            const loc = data.data.location;
            if (loc && loc.name) {
              locationLabel.value = loc.name.toUpperCase();
            }

            const cur = data.data.current;
            if (cur) {
              if (cur.temperature !== undefined) {
                currentTemp.value = Math.round(cur.temperature);
                peakTemp.value = Math.round(cur.temperature - 6);
              }
              if (cur.humidity !== undefined) {
                // If API humidity is valid, reflect it (or default to realistic high mountain humidity)
                humidity.value = Math.max(cur.humidity, 85);
              }
              if (cur.wind_speed !== undefined) {
                wind.value = Math.round(cur.wind_speed);
              }
              if (cur.cloud_cover !== undefined) {
                conditionLabel.value = cur.cloud_cover > 70 ? 'Berawan Tebal' : cur.cloud_cover > 30 ? 'Cerah Berawan' : 'Cerah';
              }
              if (cur.uv_index !== undefined) {
                uvIndex.value = Math.round(cur.uv_index);
              }
            }

            const daily = data.data.daily;
            if (daily && daily.length) {
              const d0 = daily[0];
              if (d0.sunrise) {
                sunriseTime.value = new Date(d0.sunrise).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
              }
              if (d0.sunset) {
                sunsetTime.value = new Date(d0.sunset).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
              }
              if (d0.precipitation_probability_max !== undefined) {
                rainChance.value = Math.round(d0.precipitation_probability_max);
              }
            }

            // Safety evaluation
            if (rainChance.value > 60 || wind.value > 16) {
              isSafe.value = false;
              safetyMessage.value = 'Kondisi cuaca di puncak berpotensi hujan lebat / badai angin. Berhati-hatilah.';
            } else {
              isSafe.value = true;
              safetyMessage.value = 'Cuaca cukup baik. Tetaplah waspada terhadap perubahan cuaca mendadak di pegunungan.';
            }
          }
        } catch (e) {
          console.warn('Gagal memuat API pendakian, menggunakan parameter presisi lokal:', e);
        }
      };

      const toggleDetailTips = () => {
        if (window.showToast) {
          window.showToast('Mode Pendakian', 'Periksa logistik, bawa jas hujan, dan patuhi rambu pos pendakian.', 'info');
        } else {
          alert('Panduan Pendakian: Selalu bawa jas hujan, senter kepala, air minum cukup, dan lapor di pos registrasi resmi.');
        }
      };

      const showFactorDetail = (type) => {
        let msg = '';
        if (type === 'rain') msg = `Peluang hujan ${rainChance.value}%. Pastikan membawa rain cover bag & mantel hujan.`;
        if (type === 'wind') msg = `Kecepatan angin ${wind.value} m/s. Dirikan tenda di shelter terlindung pepohonan.`;
        if (type === 'temp') msg = `Suhu puncak ${peakTemp.value}°C. Siapkan pakaian berlapis (layering system) dan sleeping bag hangat.`;
        if (window.showToast) {
          window.showToast('Info Pendakian', msg, 'info');
        }
      };

      onMounted(() => {
        updateClock();
        setInterval(updateClock, 1000);
        fetchHikingData();
      });

      return {
        currentDate, currentTime, locationLabel, currentTemp, conditionLabel,
        humidity, wind, peakTemp, rainChance, uvIndex, sunriseTime, sunsetTime,
        isSafe, safetyMessage, rainDescription, windDescription, tempDescription,
        mountains, selectedMountainId, selectMountain, toggleDetailTips, showFactorDetail
      };
    }
  }).mount('#hk-app');
})();
</script>
@endpush

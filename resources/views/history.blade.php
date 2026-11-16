@extends('layouts.app')

@section('title', 'Histori Cuaca — WeatherLive-Grid')

@section('styles')
<style>
/* =========================================================
   HISTORI CUACA — WEATHERLIVE-GRID v3.0
   ULTRA-PREMIUM HISTORICAL CLIMATE ARCHIVE DASHBOARD
   ========================================================= */

.hi-page-bg {
  position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
  background:
    radial-gradient(ellipse 80% 50% at 50% -10%, rgba(14, 116, 144, 0.22) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 90% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 55%),
    linear-gradient(180deg, #07152e 0%, #060e1d 50%, #030712 100%);
}

.hi-shell {
  position: relative;
  z-index: 2;
  padding-top: 14px;
  padding-bottom: 70px;
}

/* ── 2-Column Layout (Sidebar + Main) ── */
.hi-layout-grid {
  display: grid;
  grid-template-columns: 220px minmax(0, 1fr);
  gap: 24px;
  align-items: start;
}
@media (max-width: 1024px) {
  .hi-layout-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}

/* ── Left Sidebar Navigation ── */
.hi-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 220px;
  flex-shrink: 0;
}
@media (max-width: 1024px) {
  .hi-sidebar {
    display: none;
  }
}

.hi-nav-card {
  background: rgba(10, 22, 46, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 12px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
}
.hi-nav-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.hi-nav-item {
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
.hi-nav-item i {
  font-size: 14px;
  width: 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.45);
  transition: color 0.2s;
}
.hi-nav-item:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #fff;
}
.hi-nav-item:hover i { color: #38BDF8; }

.hi-nav-item.active {
  background: #0284C7;
  color: #FFFFFF;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
}
.hi-nav-item.active i {
  color: #FFFFFF;
}

/* Quote Box at Bottom of Sidebar */
.hi-quote-card {
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
.hi-quote-text {
  position: relative;
  z-index: 2;
  font-size: 12.5px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.85);
  font-style: italic;
}
.hi-quote-line {
  width: 28px;
  height: 2px;
  background: #38BDF8;
  margin-top: 10px;
  border-radius: 99px;
}

/* ── Right Main Panel ── */
.hi-main-panel {
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-width: 0;
  width: 100%;
}

/* ── Top Header Strip ── */
.hi-top-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
}

.hi-title-col {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
}

.hi-pill-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 99px;
  background: rgba(56, 189, 248, 0.15);
  border: 1px solid rgba(56, 189, 248, 0.4);
  color: #38BDF8;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  width: fit-content;
}

.hi-main-title {
  font-size: 30px;
  font-weight: 900;
  color: #FFFFFF;
  margin: 0;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.hi-subtitle {
  font-size: 13.5px;
  color: rgba(255, 255, 255, 0.65);
  max-width: 580px;
  line-height: 1.5;
}

/* Header Controls Strip on Top Right */
.hi-header-ctrls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
  white-space: nowrap;
  flex-shrink: 0;
}
@media (max-width: 900px) {
  .hi-header-ctrls {
    flex-wrap: wrap;
  }
}

/* Location Selector Dropdown Pill */
.hi-location-pill {
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
.hi-location-pill:hover {
  background: rgba(56, 189, 248, 0.18);
  border-color: #38BDF8;
}
.hi-location-pill i.fa-map-marker-alt { color: #38BDF8; font-size: 13px; }
.hi-location-pill i.fa-chevron-down { font-size: 10px; color: rgba(255,255,255,0.5); }

/* Date / Time Widget Card on Top Right (Guaranteed no text clipping) */
.hi-datetime-pill {
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
.hi-dt-item {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12.5px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}
.hi-dt-item i {
  color: #38BDF8;
  font-size: 13px;
}
.hi-dt-sep {
  width: 1px;
  height: 16px;
  background: rgba(255, 255, 255, 0.18);
}

/* ── 4 Stat Cards Row ── */
.hi-stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
@media (max-width: 1024px) {
  .hi-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 540px) {
  .hi-stats-grid { grid-template-columns: 1fr; }
}

.hi-stat-card {
  background: rgba(8, 20, 44, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  padding: 22px 20px;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 14px 34px rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  gap: 16px;
  transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}
.hi-stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 48px rgba(0, 0, 0, 0.6), 0 0 24px rgba(56, 189, 248, 0.2);
  border-color: rgba(56, 189, 248, 0.35);
}

.hi-stat-icon-box {
  width: 50px;
  height: 50px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
}

.hi-stat-info {
  display: flex;
  flex-direction: column;
}
.hi-stat-lbl {
  font-size: 11.5px;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.6);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.hi-stat-val {
  font-size: 24px;
  font-weight: 900;
  color: #FFFFFF;
  font-family: 'Space Grotesk', sans-serif;
  margin-top: 4px;
  line-height: 1;
}

/* ── Historical Chart Container Card ── */
.hi-chart-card {
  position: relative;
  border-radius: 24px;
  background: rgba(8, 20, 44, 0.9);
  border: 1.5px solid rgba(56, 189, 248, 0.28);
  padding: 24px 28px;
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  box-shadow:
    0 24px 60px rgba(0, 0, 0, 0.6),
    0 0 35px rgba(56, 189, 248, 0.12);
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.hi-chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}

.hi-chart-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 17px;
  font-weight: 800;
  color: #FFFFFF;
}
.hi-chart-title i {
  color: #38BDF8;
}

/* Range Filter Button Strip */
.hi-range-strip {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(10, 22, 46, 0.8);
  padding: 4px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.1);
}
.hi-range-btn {
  padding: 6px 14px;
  border-radius: 8px;
  border: none;
  background: transparent;
  color: rgba(255, 255, 255, 0.65);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}
.hi-range-btn:hover {
  color: #38BDF8;
}
.hi-range-btn.active {
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  color: #FFFFFF;
  box-shadow: 0 4px 14px rgba(2, 132, 199, 0.45);
}

.hi-canvas-wrap {
  position: relative;
  width: 100%;
  height: 300px;
}
@media (max-width: 768px) {
  .hi-canvas-wrap { height: 230px; }
}

/* ── Historical Logs & Table Card ── */
.hi-table-card {
  position: relative;
  border-radius: 20px;
  background: rgba(8, 20, 44, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 22px 26px;
  backdrop-filter: blur(20px);
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.45);
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.hi-table-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.hi-table-title {
  font-size: 15px;
  font-weight: 800;
  color: #FFFFFF;
  display: flex;
  align-items: center;
  gap: 8px;
}
.hi-table-title i { color: #38BDF8; }

.hi-table-scroll {
  width: 100%;
  overflow-x: auto;
}
.hi-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
  text-align: left;
}
.hi-table th {
  padding: 12px 16px;
  color: rgba(255, 255, 255, 0.55);
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.hi-table td {
  padding: 12px 16px;
  color: rgba(255, 255, 255, 0.88);
  border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}
.hi-table tr:hover td {
  background: rgba(56, 189, 248, 0.05);
}

.hi-temp-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Space Grotesk', monospace;
  font-weight: 700;
}
.hi-tmax { color: #EF4444; }
.hi-tmin { color: #38BDF8; }

.hi-badge-rain {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 10px;
  border-radius: 99px;
  font-size: 11px;
  font-weight: 700;
  background: rgba(14, 165, 233, 0.18);
  color: #38BDF8;
  border: 1px solid rgba(56, 189, 248, 0.3);
}

/* ── Sub-footer Micro Strip ── */
.hi-subfooter {
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
.hi-subfooter-left {
  display: flex;
  align-items: center;
  gap: 10px;
}
.hi-subfooter-left i {
  color: #38BDF8;
  font-size: 14px;
}
.hi-subfooter-brand {
  font-weight: 700;
  color: rgba(255, 255, 255, 0.85);
}
.hi-subfooter-right {
  color: rgba(255, 255, 255, 0.4);
}
</style>
@endsection

@section('content')
<div id="hi-app" v-cloak>

  <!-- Atmospheric Background Canvas -->
  <div class="hi-page-bg"></div>

  <div class="hi-shell page-wrap">
    <div class="hi-layout-grid">

      <!-- ====== 1. LEFT SIDEBAR NAVIGATION ====== -->
      <aside class="hi-sidebar">
        <div class="hi-nav-card">
          <nav class="hi-nav-list">
            <!-- Beranda / Histori (Active) -->
            <a href="/histori" class="hi-nav-item active">
              <i class="fas fa-clock-rotate-left"></i>
              <span>Histori Cuaca</span>
            </a>
            <!-- Prakiraan -->
            <a href="/prakiraan" class="hi-nav-item">
              <i class="fas fa-calendar-alt"></i>
              <span>Prakiraan</span>
            </a>
            <!-- Peta Cuaca -->
            <a href="/peta" class="hi-nav-item">
              <i class="fas fa-map-marked-alt"></i>
              <span>Peta Cuaca</span>
            </a>
            <!-- Perbandingan -->
            <a href="/bandingkan" class="hi-nav-item">
              <i class="fas fa-scale-balanced"></i>
              <span>Perbandingan</span>
            </a>
            <!-- Outdoor -->
            <a href="/indeks-outdoor" class="hi-nav-item">
              <i class="fas fa-tree"></i>
              <span>Indeks Outdoor</span>
            </a>
            <!-- Pengaturan -->
            <a href="/developer" class="hi-nav-item">
              <i class="fas fa-gear"></i>
              <span>Pengaturan</span>
            </a>
          </nav>
        </div>

        <!-- Scenic Climate Wisdom Quote Card -->
        <div class="hi-quote-card">
          <div class="hi-quote-text">
            &ldquo;Mempelajari pola masa lalu untuk mempersiapkan masa depan yang lebih aman.&rdquo;
          </div>
          <div class="hi-quote-line"></div>
        </div>
      </aside>


      <!-- ====== 2. RIGHT MAIN CONTENT ====== -->
      <main class="hi-main-panel">

        <!-- Top Header Strip (Badge, Title, Subtitle & Control Pills) -->
        <div class="hi-top-header">
          <div class="hi-title-col">
            <div class="hi-pill-badge">
              <i class="fas fa-database"></i>
              <span>ARSIP IKLIM & HISTORI CUACA</span>
            </div>
            <h1 class="hi-main-title">Histori Cuaca</h1>
            <div class="hi-subtitle">
              Analisis tren suhu historis, curah hujan, dan fluktuasi iklim di Jawa Barat berbasis data Open-Meteo Archive.
            </div>
          </div>

          <!-- Header Right Controls Strip -->
          <div class="hi-header-ctrls">
            <!-- Location Selector Dropdown Pill -->
            <div class="hi-location-pill" @click="cycleLocation" title="Ganti Wilayah">
              <i class="fas fa-map-marker-alt"></i>
              <span>@{{ selectedLocationName }}</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <!-- Live Date & Clock Widget -->
            <div class="hi-datetime-pill">
              <div class="hi-dt-item">
                <i class="fas fa-calendar-alt"></i>
                <span>@{{ currentDate }}</span>
              </div>
              <div class="hi-dt-sep"></div>
              <div class="hi-dt-item">
                <i class="fas fa-clock"></i>
                <span>@{{ currentTime }} WIB</span>
              </div>
            </div>
          </div>
        </div>


        <!-- ====== 3. 4 STAT CARDS ROW ====== -->
        <div class="hi-stats-grid">
          <!-- 1. Suhu Tertinggi -->
          <div class="hi-stat-card">
            <div class="hi-stat-icon-box" style="background:rgba(239, 68, 68, 0.2);color:#EF4444;">
              <i class="fas fa-temperature-arrow-up"></i>
            </div>
            <div class="hi-stat-info">
              <span class="hi-stat-lbl">Suhu Tertinggi</span>
              <span class="hi-stat-val">@{{ stats.maxTemp }}</span>
            </div>
          </div>

          <!-- 2. Suhu Terendah -->
          <div class="hi-stat-card">
            <div class="hi-stat-icon-box" style="background:rgba(56, 189, 248, 0.2);color:#38BDF8;">
              <i class="fas fa-temperature-arrow-down"></i>
            </div>
            <div class="hi-stat-info">
              <span class="hi-stat-lbl">Suhu Terendah</span>
              <span class="hi-stat-val">@{{ stats.minTemp }}</span>
            </div>
          </div>

          <!-- 3. Total Presipitasi -->
          <div class="hi-stat-card">
            <div class="hi-stat-icon-box" style="background:rgba(168, 85, 247, 0.2);color:#A855F7;">
              <i class="fas fa-cloud-showers-heavy"></i>
            </div>
            <div class="hi-stat-info">
              <span class="hi-stat-lbl">Total Presipitasi</span>
              <span class="hi-stat-val">@{{ stats.totalRain }}</span>
            </div>
          </div>

          <!-- 4. Rata-rata Suhu -->
          <div class="hi-stat-card">
            <div class="hi-stat-icon-box" style="background:rgba(34, 197, 94, 0.2);color:#22C55E;">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="hi-stat-info">
              <span class="hi-stat-lbl">Suhu Rata-Rata</span>
              <span class="hi-stat-val">@{{ stats.avgTemp }}</span>
            </div>
          </div>
        </div>


        <!-- ====== 4. HISTORICAL CLIMATE CHART ====== -->
        <div class="hi-chart-card">
          <div class="hi-chart-header">
            <div class="hi-chart-title">
              <i class="fas fa-chart-area"></i>
              <span>Grafik Fluktuasi Suhu Historis (@{{ activeRangeLabel }})</span>
            </div>

            <!-- Range Filter Buttons -->
            <div class="hi-range-strip">
              <button
                v-for="r in ranges"
                :key="r.id"
                class="hi-range-btn"
                :class="{ active: activeRange === r.id }"
                @click="setRange(r.id)"
              >
                @{{ r.name }}
              </button>
            </div>
          </div>

          <!-- Chart.js Canvas -->
          <div class="hi-canvas-wrap">
            <canvas id="hiChart"></canvas>
          </div>
        </div>


        <!-- ====== 5. HISTORICAL RECORDS TABLE ====== -->
        <div class="hi-table-card">
          <div class="hi-table-header">
            <div class="hi-table-title">
              <i class="fas fa-table-list"></i>
              <span>Log Arsip Harian Terperinci</span>
            </div>
            <span style="font-size:12px;color:rgba(255,255,255,0.5);">Menampilkan @{{ rows.length }} hari terakhir</span>
          </div>

          <div class="hi-table-scroll">
            <table class="hi-table">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Rentang Suhu (Min - Max)</th>
                  <th>Curah Hujan</th>
                  <th>Status Cuaca</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, idx) in rows.slice(-15).reverse()" :key="idx">
                  <td style="font-weight:600;">@{{ formatDate(row.date) }}</td>
                  <td>
                    <div class="hi-temp-pill">
                      <span class="hi-tmin">@{{ Math.round(row.temp_min) }}&deg;C</span>
                      <span style="color:rgba(255,255,255,0.3);">&mdash;</span>
                      <span class="hi-tmax">@{{ Math.round(row.temp_max) }}&deg;C</span>
                    </div>
                  </td>
                  <td>
                    <span class="hi-badge-rain">
                      <i class="fas fa-droplet"></i>
                      <span>@{{ row.precipitation ? row.precipitation.toFixed(1) : '0.0' }} mm</span>
                    </span>
                  </td>
                  <td>
                    <span v-if="row.precipitation > 5" style="color:#60A5FA;"><i class="fas fa-cloud-showers-heavy"></i> Hujan Sedang</span>
                    <span v-else-if="row.precipitation > 0.5" style="color:#93C5FD;"><i class="fas fa-cloud-rain"></i> Hujan Ringan</span>
                    <span v-else style="color:#FBBF24;"><i class="fas fa-sun"></i> Cerah Berawan</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


        <!-- ====== 6. SUB-FOOTER MICRO STRIP ====== -->
        <div class="hi-subfooter">
          <div class="hi-subfooter-left">
            <i class="fas fa-database"></i>
            <span class="hi-subfooter-brand">WeatherLive &middot; Grid</span>
            <span>Data arsip iklim resmi Open-Meteo Archive.</span>
          </div>
          <div class="hi-subfooter-right">
            <span>Terakhir diperbarui: @{{ currentDate }} @{{ currentTime }} WIB</span>
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
  const { createApp, ref, computed, onMounted, nextTick } = Vue;

  createApp({
    setup() {
      const currentDate = ref('');
      const currentTime = ref('');

      const selectedLocationName = ref('Kabupaten Bandung');
      const activeRange = ref(30);
      const loading = ref(false);
      const rows = ref([]);

      const ranges = ref([
        { id: 7, name: '7 Hari' },
        { id: 30, name: '30 Hari' },
        { id: 60, name: '60 Hari' },
        { id: 90, name: '90 Hari' }
      ]);

      const activeRangeLabel = computed(() => {
        const r = ranges.value.find(x => x.id === activeRange.value);
        return r ? r.name : '30 Hari';
      });

      const stats = computed(() => {
        if (!rows.value || !rows.value.length) {
          return { maxTemp: '--', minTemp: '--', totalRain: '--', avgTemp: '--' };
        }
        let max = -Infinity, min = Infinity, rain = 0, sum = 0, n = 0;
        rows.value.forEach(r => {
          if (r.temp_max !== null && r.temp_max !== undefined) {
            if (r.temp_max > max) max = r.temp_max;
            sum += r.temp_max;
            n++;
          }
          if (r.temp_min !== null && r.temp_min !== undefined && r.temp_min < min) {
            min = r.temp_min;
          }
          if (r.precipitation) rain += r.precipitation;
        });
        return {
          maxTemp: max > -Infinity ? Math.round(max) + '°C' : '--',
          minTemp: min < Infinity ? Math.round(min) + '°C' : '--',
          totalRain: Math.round(rain) + ' mm',
          avgTemp: n ? Math.round(sum / n) + '°C' : '--'
        };
      });

      let chartInstance = null;

      const renderChart = () => {
        const ctx = document.getElementById('hiChart');
        if (!ctx || !window.Chart || !rows.value || !rows.value.length) return;

        if (chartInstance) chartInstance.destroy();

        const labels = rows.value.map(r => {
          const d = new Date(r.date);
          return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        const maxs = rows.value.map(r => r.temp_max);
        const mins = rows.value.map(r => r.temp_min);

        chartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Suhu Maksimum (°C)',
                data: maxs,
                borderColor: '#EF4444',
                backgroundColor: 'rgba(239, 68, 68, 0.12)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
                pointRadius: rows.value.length > 30 ? 0 : 3,
                pointBackgroundColor: '#EF4444'
              },
              {
                label: 'Suhu Minimum (°C)',
                data: mins,
                borderColor: '#38BDF8',
                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
                pointRadius: rows.value.length > 30 ? 0 : 3,
                pointBackgroundColor: '#38BDF8'
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              mode: 'index',
              intersect: false
            },
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  color: '#E2E8F0',
                  font: { family: 'Inter', size: 12, weight: '600' }
                }
              },
              tooltip: {
                backgroundColor: 'rgba(8, 20, 44, 0.95)',
                titleColor: '#FFFFFF',
                bodyColor: '#38BDF8',
                borderColor: 'rgba(56, 189, 248, 0.3)',
                borderWidth: 1,
                padding: 10,
                cornerRadius: 8
              }
            },
            scales: {
              y: {
                grid: { color: 'rgba(255, 255, 255, 0.06)' },
                ticks: { color: '#94A3B8', font: { family: 'Space Grotesk' } }
              },
              x: {
                grid: { display: false },
                ticks: {
                  color: '#94A3B8',
                  maxTicksLimit: 14,
                  font: { family: 'Inter', size: 11 }
                }
              }
            }
          }
        });
      };

      const load = async () => {
        loading.value = true;
        try {
          const res = await fetch('/api/enterprise/historical?days=' + activeRange.value);
          const d = await res.json();
          if (d.success && d.data) {
            rows.value = d.data;
          }
        } catch (e) {
          console.error('Gagal memuat histori cuaca:', e);
        }
        loading.value = false;
        nextTick(() => {
          setTimeout(renderChart, 150);
        });
      };

      const setRange = (id) => {
        activeRange.value = id;
        load();
      };

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

      const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
      };

      const locations = [
        'Kabupaten Bandung',
        'Kota Bandung',
        'Kota Bogor',
        'Kabupaten Bogor',
        'Kota Bekasi',
        'Kabupaten Cirebon'
      ];
      let locIdx = 0;
      const cycleLocation = () => {
        locIdx = (locIdx + 1) % locations.length;
        selectedLocationName.value = locations[locIdx];
        if (window.showToast) {
          window.showToast('Lokasi Histori', 'Wilayah dialihkan ke ' + selectedLocationName.value, 'info');
        }
      };

      onMounted(() => {
        updateClock();
        setInterval(updateClock, 1000);
        load();
      });

      // CRITICAL: Return rows and all needed properties to prevent Cannot read properties of undefined (reading 'length')
      return {
        currentDate, currentTime, selectedLocationName,
        activeRange, ranges, activeRangeLabel,
        stats, rows, loading, setRange, load,
        formatDate, cycleLocation
      };
    }
  }).mount('#hi-app');
})();
</script>
@endpush

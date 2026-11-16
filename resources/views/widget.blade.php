@if(request()->has('embed') || request('embed') == '1' || request('embed') == 'true')
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Widget Cuaca WeatherLive-Grid</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body {
    font-family: 'Inter', -apple-system, sans-serif;
    background: {{ request('transparent') == '1' ? 'transparent' : '#030712' }};
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 12px;
    overflow: hidden;
  }
  .wg-embed-card {
    width: 100%;
    max-width: 100%;
    border-radius: 20px;
    padding: 20px;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
    position: relative;
    overflow: hidden;
  }
  .theme-cyber { background: linear-gradient(135deg, rgba(8, 20, 44, 0.95), rgba(15, 30, 66, 0.9)); border-color: rgba(56, 189, 248, 0.3); color: #fff; }
  .theme-light { background: rgba(255, 255, 255, 0.96); border-color: rgba(0, 0, 0, 0.1); color: #0f172a; box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12); }
  .theme-bmkg  { background: linear-gradient(135deg, #0d47a1, #1565c0); border-color: rgba(255, 255, 255, 0.2); color: #fff; }
  .theme-amoled { background: #000000; border-color: rgba(255, 255, 255, 0.15); color: #fff; }
  .theme-emerald { background: linear-gradient(135deg, #064e3b, #047857); border-color: rgba(52, 211, 153, 0.3); color: #fff; }
  .theme-amber { background: linear-gradient(135deg, #78350f, #b45309); border-color: rgba(251, 191, 36, 0.3); color: #fff; }

  .wg-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .wg-city { font-size: 15px; font-weight: 800; font-family: 'Space Grotesk', sans-serif; display: flex; align-items: center; gap: 6px; }
  .wg-badge { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px; background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
  .theme-light .wg-badge { background: #e0f2fe; color: #0284c7; }
  .wg-main { display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px; }
  .wg-temp { font-size: 44px; font-weight: 800; line-height: 1; letter-spacing: -1px; }
  .wg-cond { font-size: 13.5px; opacity: 0.9; font-weight: 600; margin-bottom: 14px; }
  .wg-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 11.5px; }
  .theme-light .wg-grid { border-top-color: rgba(0, 0, 0, 0.08); }
  .wg-grid-item { display: flex; flex-direction: column; gap: 2px; }
  .wg-grid-label { font-size: 10px; opacity: 0.7; }
  .wg-grid-val { font-weight: 700; }
  .wg-watermark { display: flex; align-items: center; justify-content: space-between; margin-top: 14px; padding-top: 8px; font-size: 10px; opacity: 0.65; border-top: 1px dashed rgba(255, 255, 255, 0.08); }
  .theme-light .wg-watermark { border-top-color: rgba(0, 0, 0, 0.06); }
</style>
</head>
<body>
@php
  $city = request('city', 'Bandung');
  $theme = request('theme', 'cyber');
  $layout = request('layout', 'card');
  $tempUnit = request('unit', 'C');
@endphp

<div class="wg-embed-card theme-{{ $theme }}">
  <div class="wg-header">
    <div class="wg-city">
      <i class="fas fa-location-dot" style="color:#38bdf8;"></i>
      <span>{{ $city }}, Jawa Barat</span>
    </div>
    <span class="wg-badge">⚡ BMKG Live</span>
  </div>

  <div class="wg-main">
    <div class="wg-temp">30°{{ $tempUnit }}</div>
    <div style="font-size:24px;">⛅</div>
  </div>
  <div class="wg-cond">Cerah Berawan</div>

  <div class="wg-grid">
    <div class="wg-grid-item">
      <span class="wg-grid-label">Kelembaban</span>
      <span class="wg-grid-val">💧 72%</span>
    </div>
    <div class="wg-grid-item">
      <span class="wg-grid-label">Kecepatan Angin</span>
      <span class="wg-grid-val">🌬️ 3.4 m/s</span>
    </div>
    <div class="wg-grid-item">
      <span class="wg-grid-label">Peluang Hujan</span>
      <span class="wg-grid-val">🌧️ 15%</span>
    </div>
    <div class="wg-grid-item">
      <span class="wg-grid-label">Indeks UV</span>
      <span class="wg-grid-val">☀️ 6.5 Sedang</span>
    </div>
  </div>

  <div class="wg-watermark">
    <span>Diperbarui secara real-time</span>
    <span>WeatherLive-Grid</span>
  </div>
</div>
</body>
</html>
@else

@extends('layouts.app')
@section('title', 'Widget Web Cuaca Studio 2.0 — Embeddable Widget')

@section('styles')
<style>
  :root {
    --wgt-bg: #030712;
    --wgt-surface: rgba(10, 20, 42, 0.88);
    --wgt-border: rgba(56, 189, 248, 0.16);
    --wgt-border-glow: rgba(56, 189, 248, 0.4);
    --wgt-accent: #38bdf8;
    --wgt-neon-cyan: #00ffe7;
    --wgt-text: #f8fafc;
    --wgt-muted: #94a3b8;
  }

  .wgt-shell {
    max-width: 1480px;
    margin: 0 auto;
    padding: 24px 20px 80px;
  }

  .wgt-header {
    background: var(--wgt-surface);
    backdrop-filter: blur(24px);
    border: 1px solid var(--wgt-border);
    border-radius: 24px;
    padding: 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 16px 45px rgba(0, 0, 0, 0.4);
    position: relative;
    overflow: hidden;
  }

  .wgt-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, #0284c7, #00ffe7, #6366f1);
  }

  .wgt-layout-grid {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 24px;
  }

  @media(max-width: 1024px) {
    .wgt-layout-grid { grid-template-columns: 1fr; }
  }

  /* Control Panel */
  .wgt-control-card {
    background: var(--wgt-surface);
    backdrop-filter: blur(24px);
    border: 1px solid var(--wgt-border);
    border-radius: 24px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    box-shadow: 0 16px 45px rgba(0, 0, 0, 0.35);
  }

  .wgt-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .wgt-field label {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--wgt-muted);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .wgt-select, .wgt-input {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid var(--wgt-border);
    border-radius: 12px;
    padding: 10px 14px;
    color: #fff;
    font-size: 13.5px;
    font-family: inherit;
    outline: none;
    transition: all 0.2s;
  }

  .wgt-select option {
    background: #081224;
    color: #fff;
  }

  .wgt-select:focus, .wgt-input:focus {
    border-color: var(--wgt-accent);
    box-shadow: 0 0 16px rgba(56, 189, 248, 0.25);
  }

  .theme-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }

  .theme-btn {
    padding: 10px 8px;
    border-radius: 12px;
    border: 1px solid var(--wgt-border);
    background: rgba(255, 255, 255, 0.03);
    color: var(--wgt-muted);
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    transition: all 0.2s;
    font-family: inherit;
  }

  .theme-btn.active {
    background: rgba(56, 189, 248, 0.18);
    border-color: var(--wgt-accent);
    color: #fff;
    box-shadow: 0 0 14px rgba(56, 189, 248, 0.25);
  }

  /* Live Preview Workspace */
  .wgt-preview-wrap {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .wgt-viewport-bar {
    background: var(--wgt-surface);
    border: 1px solid var(--wgt-border);
    border-radius: 18px;
    padding: 10px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }

  .device-toggle {
    display: flex;
    gap: 6px;
    background: rgba(255, 255, 255, 0.04);
    padding: 4px;
    border-radius: 12px;
  }

  .device-btn {
    padding: 6px 14px;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: var(--wgt-muted);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
  }

  .device-btn.active {
    background: var(--wgt-accent);
    color: #030712;
  }

  /* Preview Screen Canvas */
  .wgt-canvas {
    background: radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 70%), #040814;
    border: 1px solid var(--wgt-border);
    border-radius: 24px;
    padding: 40px 24px;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  /* ACTUAL WIDGET COMPONENT STYLING */
  .widget-box {
    border-radius: 24px;
    padding: 24px;
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
  }

  .widget-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 26px 60px rgba(0, 0, 0, 0.6);
  }

  /* Preset Widths */
  .layout-compact { width: 320px; }
  .layout-card { width: 360px; }
  .layout-bento { width: 560px; }
  .layout-forecast { width: 640px; }

  /* Theme Presets */
  .theme-cyber { background: linear-gradient(135deg, rgba(8, 20, 44, 0.95), rgba(15, 30, 66, 0.9)); border-color: rgba(56, 189, 248, 0.35); color: #fff; }
  .theme-light { background: #ffffff; border-color: #e2e8f0; color: #0f172a; box-shadow: 0 16px 45px rgba(0, 0, 0, 0.12); }
  .theme-bmkg { background: linear-gradient(135deg, #0d47a1, #1976d2); border-color: rgba(255, 255, 255, 0.25); color: #fff; }
  .theme-amoled { background: #000000; border-color: rgba(255, 255, 255, 0.18); color: #fff; }
  .theme-emerald { background: linear-gradient(135deg, #064e3b, #047857); border-color: rgba(52, 211, 153, 0.4); color: #fff; }
  .theme-amber { background: linear-gradient(135deg, #78350f, #b45309); border-color: rgba(251, 191, 36, 0.4); color: #fff; }

  /* Code Block */
  .code-container {
    background: #020617;
    border: 1px solid var(--wgt-border);
    border-radius: 18px;
    padding: 18px;
    font-family: 'Courier New', monospace;
    font-size: 12.5px;
    color: #7dd3fc;
    line-height: 1.6;
    overflow-x: auto;
    position: relative;
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.5);
  }

  .copy-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(56, 189, 248, 0.18);
    border: 1px solid rgba(56, 189, 248, 0.35);
    color: var(--wgt-accent);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
  }

  .copy-btn:hover {
    background: var(--wgt-accent);
    color: #020617;
  }
</style>
@endsection

@section('content')
<div id="wgt-app" class="wgt-shell" v-cloak>

  <!-- HEADER STUDIO -->
  <div class="wgt-header">
    <div style="display:flex;align-items:center;gap:16px;">
      <div style="width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#0284c7,#2563eb);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;box-shadow:0 0 25px rgba(2,132,199,0.5);">
        <i class="fas fa-code"></i>
      </div>
      <div>
        <h1 style="font-size:22px;font-weight:800;font-family:'Space Grotesk',sans-serif;margin:0;">
          Widget Web Studio 2.0
          <span style="font-size:11px;font-weight:700;background:rgba(0,255,231,0.15);color:var(--wgt-neon-cyan);border:1px solid rgba(0,255,231,0.3);padding:3px 10px;border-radius:20px;margin-left:8px;">
            Kompatibel & Responsive
          </span>
        </h1>
        <p style="font-size:13px;color:var(--wgt-muted);margin-top:4px;">
          Kustomisasi dan pasang widget cuaca real-time resmi BMKG ke website, blog, atau aplikasi Anda hanya dalam 1 klik.
        </p>
      </div>
    </div>
    <div style="display:flex;gap:10px;">
      <a :href="embedUrl" target="_blank" class="adm-btn-ghost" style="padding:10px 16px;border-radius:12px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.05);border:1px solid var(--wgt-border);color:#fff;">
        <i class="fas fa-external-link-alt"></i> Buka Fullscreen Widget
      </a>
    </div>
  </div>

  <!-- STUDIO MAIN GRID -->
  <div class="wgt-layout-grid">

    <!-- LEFT: CONTROLS & SETTINGS -->
    <div class="wgt-control-card">
      <div style="font-size:16px;font-weight:700;display:flex;align-items:center;gap:8px;padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.06);">
        <i class="fas fa-sliders" style="color:var(--wgt-accent);"></i> Pengaturan Widget
      </div>

      <!-- City Selector -->
      <div class="wgt-field">
        <label><i class="fas fa-location-dot"></i> Wilayah / Kota Jawa Barat</label>
        <select v-model="selectedCity" class="wgt-select">
          <option v-for="c in cities" :key="c" :value="c" v-text="c"></option>
        </select>
      </div>

      <!-- Layout Selector -->
      <div class="wgt-field">
        <label><i class="fas fa-table-cells-large"></i> Format Tampilan Layout</label>
        <select v-model="selectedLayout" class="wgt-select">
          <option value="compact">Compact Mini Pill (320px)</option>
          <option value="card">Standard Weather Card (360px)</option>
          <option value="bento">Bento Grid Dashboard (560px)</option>
          <option value="forecast">5-Day Extended Forecast (640px)</option>
        </select>
      </div>

      <!-- Theme Presets -->
      <div class="wgt-field">
        <label><i class="fas fa-palette"></i> Tema Desain Visual</label>
        <div class="theme-grid">
          <button class="theme-btn" :class="{active: selectedTheme === 'cyber'}" @click="selectedTheme = 'cyber'">Cyber Dark</button>
          <button class="theme-btn" :class="{active: selectedTheme === 'light'}" @click="selectedTheme = 'light'">Alpine Light</button>
          <button class="theme-btn" :class="{active: selectedTheme === 'bmkg'}" @click="selectedTheme = 'bmkg'">BMKG Azure</button>
          <button class="theme-btn" :class="{active: selectedTheme === 'amoled'}" @click="selectedTheme = 'amoled'">AMOLED Black</button>
          <button class="theme-btn" :class="{active: selectedTheme === 'emerald'}" @click="selectedTheme = 'emerald'">Emerald Eco</button>
          <button class="theme-btn" :class="{active: selectedTheme === 'amber'}" @click="selectedTheme = 'amber'">Sunset Amber</button>
        </div>
      </div>

      <!-- Temperature Unit -->
      <div class="wgt-field">
        <label><i class="fas fa-temperature-half"></i> Satuan Suhu</label>
        <div style="display:flex;gap:10px;">
          <button class="theme-btn" style="flex:1;" :class="{active: tempUnit === 'C'}" @click="tempUnit = 'C'">Celsius (°C)</button>
          <button class="theme-btn" style="flex:1;" :class="{active: tempUnit === 'F'}" @click="tempUnit = 'F'">Fahrenheit (°F)</button>
        </div>
      </div>

      <!-- Feature Toggles -->
      <div class="wgt-field">
        <label><i class="fas fa-toggle-on"></i> Opsi Tambahan</label>
        <div style="display:flex;flex-direction:column;gap:10px;font-size:12.5px;">
          <label style="cursor:pointer;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" v-model="showDetails" style="accent-color:var(--wgt-accent);">
            <span>Tampilkan Telemetri (Angin, Lembab, UV)</span>
          </label>
          <label style="cursor:pointer;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" v-model="showAqi" style="accent-color:var(--wgt-accent);">
            <span>Tampilkan Indeks Kualitas Udara (AQI)</span>
          </label>
          <label style="cursor:pointer;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" v-model="showBmkgBadge" style="accent-color:var(--wgt-accent);">
            <span>Badge Resmi "BMKG Verified"</span>
          </label>
        </div>
      </div>
    </div>

    <!-- RIGHT: LIVE PREVIEW & CODE GENERATOR -->
    <div class="wgt-preview-wrap">

      <!-- Device Viewport Toggle -->
      <div class="wgt-viewport-bar">
        <div style="font-size:13px;font-weight:700;display:flex;align-items:center;gap:8px;">
          <span style="width:8px;height:8px;border-radius:50%;background:#10b981;box-shadow:0 0 8px #10b981;"></span>
          Live Interactive Preview
        </div>
        <div class="device-toggle">
          <button class="device-btn" :class="{active: deviceMode === 'desktop'}" @click="deviceMode = 'desktop'">
            <i class="fas fa-desktop"></i> Desktop
          </button>
          <button class="device-btn" :class="{active: deviceMode === 'tablet'}" @click="deviceMode = 'tablet'">
            <i class="fas fa-tablet-screen-button"></i> Tablet (768px)
          </button>
          <button class="device-btn" :class="{active: deviceMode === 'mobile'}" @click="deviceMode = 'mobile'">
            <i class="fas fa-mobile-screen"></i> Ponsel (380px)
          </button>
        </div>
      </div>

      <!-- PREVIEW CANVAS -->
      <div class="wgt-canvas" :style="{maxWidth: deviceMode === 'mobile' ? '390px' : (deviceMode === 'tablet' ? '768px' : '100%'), margin:'0 auto'}">

        <!-- 1. COMPACT PILL LAYOUT -->
        <div v-if="selectedLayout === 'compact'" class="widget-box layout-compact" :class="'theme-' + selectedTheme">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
            <div style="font-size:14px;font-weight:800;display:flex;align-items:center;gap:6px;">
              <i class="fas fa-location-dot" style="color:#38bdf8;"></i> @{{ selectedCity }}
            </div>
            <span v-if="showBmkgBadge" style="font-size:10px;font-weight:700;background:rgba(56,189,248,0.2);color:#38bdf8;padding:2px 8px;border-radius:12px;">
              BMKG
            </span>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <div>
              <div style="font-size:36px;font-weight:800;line-height:1;">@{{ displayTemp }}°@{{ tempUnit }}</div>
              <div style="font-size:12.5px;opacity:.85;margin-top:2px;">Cerah Berawan</div>
            </div>
            <div style="font-size:38px;">🌤️</div>
          </div>
        </div>

        <!-- 2. STANDARD WEATHER CARD LAYOUT -->
        <div v-if="selectedLayout === 'card'" class="widget-box layout-card" :class="'theme-' + selectedTheme">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <div>
              <div style="font-size:16px;font-weight:800;font-family:'Space Grotesk';">@{{ selectedCity }}, Jawa Barat</div>
              <div style="font-size:11.5px;opacity:.8;">Stasiun Meteorologi Terverifikasi</div>
            </div>
            <span v-if="showBmkgBadge" style="font-size:10.5px;font-weight:700;background:rgba(56,189,248,0.2);color:#38bdf8;padding:3px 8px;border-radius:12px;">
              ⚡ BMKG Live
            </span>
          </div>

          <div style="display:flex;align-items:baseline;justify-content:space-between;margin-bottom:6px;">
            <div>
              <div style="font-size:46px;font-weight:800;line-height:1;letter-spacing:-1.5px;">@{{ displayTemp }}°@{{ tempUnit }}</div>
              <div style="font-size:14px;font-weight:600;opacity:.9;margin-top:4px;">Cerah Berawan</div>
            </div>
            <div style="font-size:48px;">⛅</div>
          </div>

          <div v-if="showDetails" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.1);font-size:12px;">
            <div>💧 Kelembaban: <strong>74%</strong></div>
            <div>🌬️ Angin: <strong>3.6 m/s</strong></div>
            <div>☀️ Indeks UV: <strong>6 (Sedang)</strong></div>
            <div>🌧️ Peluang Hujan: <strong>10%</strong></div>
          </div>

          <div v-if="showAqi" style="margin-top:12px;padding:8px 12px;border-radius:10px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);font-size:11.5px;color:#34d399;display:flex;align-items:center;justify-content:space-between;">
            <span><i class="fas fa-smog"></i> Kualitas Udara: Baik</span>
            <strong>AQI 42</strong>
          </div>
        </div>

        <!-- 3. BENTO GRID DASHBOARD LAYOUT -->
        <div v-if="selectedLayout === 'bento'" class="widget-box layout-bento" :class="'theme-' + selectedTheme">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="font-size:20px;font-weight:800;font-family:'Space Grotesk';">@{{ selectedCity }}</div>
              <span v-if="showBmkgBadge" style="font-size:11px;font-weight:700;background:rgba(56,189,248,0.2);color:#38bdf8;padding:3px 10px;border-radius:12px;">
                Verified BMKG
              </span>
            </div>
            <div style="font-size:12px;opacity:.8;">Update: Real-time</div>
          </div>

          <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:16px;">
            <div style="background:rgba(255,255,255,0.04);border-radius:18px;padding:16px;border:1px solid rgba(255,255,255,0.08);">
              <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                  <div style="font-size:44px;font-weight:800;line-height:1;">@{{ displayTemp }}°@{{ tempUnit }}</div>
                  <div style="font-size:13.5px;margin-top:4px;font-weight:600;">Cerah Berawan</div>
                </div>
                <div style="font-size:46px;">🌤️</div>
              </div>
              <div style="display:flex;gap:12px;margin-top:14px;font-size:12px;opacity:.85;">
                <span>Min: 22°C</span>
                <span>Max: 31°C</span>
                <span>Feels: 29°C</span>
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
              <div style="background:rgba(255,255,255,0.04);border-radius:14px;padding:12px;border:1px solid rgba(255,255,255,0.08);text-align:center;">
                <div style="font-size:11px;opacity:.7;">💧 Kelembaban</div>
                <div style="font-size:18px;font-weight:800;margin-top:2px;">72%</div>
              </div>
              <div style="background:rgba(255,255,255,0.04);border-radius:14px;padding:12px;border:1px solid rgba(255,255,255,0.08);text-align:center;">
                <div style="font-size:11px;opacity:.7;">🌬️ Angin</div>
                <div style="font-size:18px;font-weight:800;margin-top:2px;">3.4 m/s</div>
              </div>
              <div style="background:rgba(255,255,255,0.04);border-radius:14px;padding:12px;border:1px solid rgba(255,255,255,0.08);text-align:center;">
                <div style="font-size:11px;opacity:.7;">☀️ Indeks UV</div>
                <div style="font-size:18px;font-weight:800;margin-top:2px;">6.2</div>
              </div>
              <div style="background:rgba(255,255,255,0.04);border-radius:14px;padding:12px;border:1px solid rgba(255,255,255,0.08);text-align:center;">
                <div style="font-size:11px;opacity:.7;">🍃 Kualitas Udara</div>
                <div style="font-size:18px;font-weight:800;color:#34d399;margin-top:2px;">Baik</div>
              </div>
            </div>
          </div>
        </div>

        <!-- 4. 5-DAY EXTENDED FORECAST LAYOUT -->
        <div v-if="selectedLayout === 'forecast'" class="widget-box layout-forecast" :class="'theme-' + selectedTheme">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <div style="font-size:16px;font-weight:800;display:flex;align-items:center;gap:8px;">
              <i class="fas fa-calendar-week" style="color:#38bdf8;"></i> Prakiraan 5 Hari — @{{ selectedCity }}
            </div>
            <span v-if="showBmkgBadge" style="font-size:10.5px;font-weight:700;background:rgba(56,189,248,0.2);color:#38bdf8;padding:3px 8px;border-radius:12px;">
              BMKG Forecast
            </span>
          </div>

          <div style="display:grid;grid-template-columns:repeat(5, 1fr);gap:10px;">
            <div v-for="d in forecastDays" :key="d.day" style="background:rgba(255,255,255,0.04);border-radius:14px;padding:14px 10px;text-align:center;border:1px solid rgba(255,255,255,0.08);">
              <div style="font-size:12px;font-weight:700;margin-bottom:6px;">@{{ d.day }}</div>
              <div style="font-size:26px;margin:4px 0;">@{{ d.icon }}</div>
              <div style="font-size:15px;font-weight:800;">@{{ d.temp }}°@{{ tempUnit }}</div>
              <div style="font-size:10px;opacity:.7;margin-top:2px;">🌧️ @{{ d.rain }}</div>
            </div>
          </div>
        </div>

      </div>

      <!-- EMBED CODE GENERATOR CARD -->
      <div class="adm-panel">
        <div class="adm-panel-head">
          <div class="adm-panel-title">
            <i class="fas fa-terminal"></i> Salin Kode Integrasi Website
          </div>
          <div style="font-size:12px;color:var(--wgt-muted);">
            Dapat dipasang di WordPress, React, Next.js, Webflow, atau HTML statis.
          </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px;">
          <!-- IFRAME CODE -->
          <div>
            <div style="font-size:12.5px;font-weight:700;color:var(--wgt-muted);margin-bottom:6px;">
              1. HTML &lt;iframe&gt; Embed Code (Universal & Terisolasi)
            </div>
            <div class="code-container">
              <code>@{{ iframeCode }}</code>
              <button class="copy-btn" @click="copyCode(iframeCode)">
                <i class="fas fa-copy"></i> Salin Iframe
              </button>
            </div>
          </div>

          <!-- DIRECT LINK -->
          <div>
            <div style="font-size:12.5px;font-weight:700;color:var(--wgt-muted);margin-bottom:6px;">
              2. URL Tautan Langsung
            </div>
            <div class="code-container">
              <code>@{{ embedUrl }}</code>
              <button class="copy-btn" @click="copyCode(embedUrl)">
                <i class="fas fa-copy"></i> Salin URL
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- TOAST NOTIFICATION -->
  <div v-if="toastMsg" class="adm-toast" style="position:fixed;bottom:24px;right:24px;background:#081224;border:1px solid #38bdf8;padding:12px 20px;border-radius:12px;display:flex;align-items:center;gap:10px;z-index:9999;">
    <i class="fas fa-check-circle" style="color:#10b981;"></i>
    <span v-text="toastMsg"></span>
  </div>

</div>
@endsection

@push('scripts')
<script>
const { createApp, ref, computed } = Vue;

createApp({
  setup() {
    const selectedCity = ref('Bandung');
    const selectedLayout = ref('card');
    const selectedTheme = ref('cyber');
    const tempUnit = ref('C');
    const showDetails = ref(true);
    const showAqi = ref(true);
    const showBmkgBadge = ref(true);
    const deviceMode = ref('desktop');
    const toastMsg = ref('');

    const cities = ref([
      'Bandung', 'Bogor', 'Bekasi', 'Depok', 'Cimahi', 'Cirebon',
      'Sukabumi', 'Tasikmalaya', 'Karawang', 'Garut', 'Subang',
      'Purwakarta', 'Sumedang', 'Majalengka', 'Kuningan', 'Indramayu',
      'Cianjur', 'Ciamis', 'Banjar', 'Pangandaran'
    ]);

    const forecastDays = ref([
      { day: 'Hari Ini', icon: '⛅', temp: 30, rain: '10%' },
      { day: 'Besok', icon: '🌧️', temp: 28, rain: '65%' },
      { day: 'Lusa', icon: '🌦️', temp: 29, rain: '40%' },
      { day: 'Kamis', icon: '🌤️', temp: 31, rain: '20%' },
      { day: 'Jumat', icon: '☀️', temp: 32, rain: '5%' },
    ]);

    const displayTemp = computed(() => {
      return tempUnit.value === 'C' ? 30 : 86;
    });

    const embedUrl = computed(() => {
      const origin = window.location.origin;
      return `${origin}/widget?embed=true&city=${encodeURIComponent(selectedCity.value)}&layout=${selectedLayout.value}&theme=${selectedTheme.value}&unit=${tempUnit.value}`;
    });

    const iframeCode = computed(() => {
      const h = selectedLayout.value === 'compact' ? 140 : (selectedLayout.value === 'forecast' ? 220 : 360);
      const w = selectedLayout.value === 'compact' ? 340 : (selectedLayout.value === 'bento' ? 580 : (selectedLayout.value === 'forecast' ? 660 : 380));
      return `<iframe src="${embedUrl.value}" width="${w}" height="${h}" frameborder="0" style="border:none;border-radius:24px;overflow:hidden;" allowtransparency="true" loading="lazy"></iframe>`;
    });

    const copyCode = (text) => {
      navigator.clipboard.writeText(text);
      toastMsg.value = 'Kode widget berhasil disalin ke clipboard!';
      setTimeout(() => { toastMsg.value = ''; }, 3000);
    };

    return {
      selectedCity, selectedLayout, selectedTheme, tempUnit,
      showDetails, showAqi, showBmkgBadge, deviceMode, toastMsg,
      cities, forecastDays, displayTemp, embedUrl, iframeCode, copyCode
    };
  }
}).mount('#wgt-app');
</script>
@endpush
@endif

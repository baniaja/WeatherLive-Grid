@extends('layouts.app')

@section('title', 'Analisis Cuaca & Iklim BMKG — WeatherLive-Grid')

@push('styles')
<style>
/* ========================================================
   WEATHERLIVE-GRID — BMKG CLIMATE & ANALYTICS DASHBOARD
   Ultra-Premium Glassmorphism Layout, Harmonized Navigation,
   Full-Width Responsive Grids & Synchronized Interactive Analytics
   ======================================================== */
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Orbitron:wght@600;800&display=swap');

:root {
  --an-bg: #050b17;
  --an-card: rgba(8, 18, 38, 0.75);
  --an-card-border: rgba(56, 189, 248, 0.16);
  --an-card-hover: rgba(56, 189, 248, 0.35);
  --an-accent: #38BDF8;
  --an-primary: #2563EB;
  --an-orange: #F97316;
  --an-red: #EF4444;
  --an-green: #22C55E;
  --an-purple: #A855F7;
  --an-text: #F1F5F9;
  --an-muted: #8FA3BF;
}

/* Base resets & layout overrides */
footer.glass { display: none !important; }
#global-mobile-menu { display: none !important; }
#main-content { padding-top: 0 !important; }

body {
  background-color: var(--an-bg) !important;
  color: var(--an-text);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  overflow-x: hidden;
  min-height: 100vh;
  position: relative;
}

/* Atmospheric Space Background */
.an-viewport-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  background:
    radial-gradient(ellipse at 15% 10%, rgba(37, 99, 235, 0.22) 0%, transparent 45%),
    radial-gradient(ellipse at 85% 15%, rgba(56, 189, 248, 0.14) 0%, transparent 40%),
    radial-gradient(ellipse at 50% 95%, rgba(124, 58, 237, 0.15) 0%, transparent 50%),
    radial-gradient(circle at 10% 85%, rgba(34, 197, 94, 0.08) 0%, transparent 35%),
    #050b17;
}

/* Subtle Star Dust Particles */
.an-stardust {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1px, transparent 1px);
  background-size: 80px 80px;
  opacity: 0.35;
}

/* Glowing Earth Rim at Bottom-Left */
.an-earth-glow {
  position: fixed;
  bottom: -220px;
  left: -220px;
  width: 540px;
  height: 540px;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
  background: radial-gradient(circle, rgba(56, 189, 248, 0.35) 0%, rgba(37, 99, 235, 0.2) 40%, rgba(5, 11, 23, 0) 72%);
  box-shadow: 0 0 120px 40px rgba(56, 189, 248, 0.25);
  filter: blur(20px);
}
.an-earth-arc {
  position: fixed;
  bottom: -280px;
  left: -280px;
  width: 600px;
  height: 600px;
  border-radius: 50%;
  border-top: 3px solid rgba(56, 189, 248, 0.6);
  box-shadow: 0 0 45px rgba(56, 189, 248, 0.8), inset 0 0 40px rgba(56, 189, 248, 0.4);
  pointer-events: none;
  z-index: 0;
  opacity: 0.7;
}

/* Dashboard Shell Layout - Clean Full Width Container */
.an-dashboard-shell {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 16px 24px 70px;
  display: flex;
  flex-direction: column;
  gap: 22px;
}

/* ========================================================
   TOP HERO BANNER
   ======================================================== */
.an-hero-banner {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 24px;
  align-items: center;
  position: relative;
  border-radius: 24px;
  padding: 24px 30px;
  background: linear-gradient(135deg, rgba(8, 20, 46, 0.85) 0%, rgba(12, 28, 62, 0.75) 50%, rgba(20, 15, 45, 0.8) 100%);
  border: 1px solid rgba(56, 189, 248, 0.2);
  box-shadow: 0 16px 48px rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(16px);
  overflow: hidden;
}

/* Jakarta Monas Panorama Backdrop */
.an-hero-skyline {
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1400&q=70') center top / cover no-repeat;
  opacity: 0.16;
  pointer-events: none;
  z-index: 0;
}
.an-hero-overlay-tint {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(5, 12, 28, 0.95) 0%, rgba(5, 14, 34, 0.8) 50%, rgba(6, 13, 30, 0.65) 100%);
  z-index: 1;
  pointer-events: none;
}

.an-hero-title-box {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.an-hero-heading {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 28px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.02em;
  display: flex;
  align-items: center;
  gap: 12px;
}
.an-hero-heading i {
  color: #38BDF8;
  font-size: 26px;
  filter: drop-shadow(0 0 12px rgba(56, 189, 248, 0.6));
}
.an-hero-sub {
  font-size: 13.5px;
  color: #94A3B8;
  font-weight: 400;
  max-width: 640px;
  line-height: 1.5;
}
.an-hero-badges-row {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 4px;
}
.an-hero-pill-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(34, 197, 94, 0.12);
  border: 1px solid rgba(34, 197, 94, 0.35);
  padding: 5px 14px;
  border-radius: 20px;
  color: #4ADE80;
  font-size: 11px;
  font-weight: 700;
  width: fit-content;
}
.an-hero-pill-info {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(56, 189, 248, 0.1);
  border: 1px solid rgba(56, 189, 248, 0.25);
  padding: 5px 12px;
  border-radius: 20px;
  color: #38BDF8;
  font-size: 11px;
  font-weight: 600;
}
.an-live-dot-green {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #22C55E;
  box-shadow: 0 0 8px #22C55E;
  animation: pulseLive 2s infinite;
}
@keyframes pulseLive {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.85); }
}

/* Hero Weather Glass Card */
.an-hero-weather-card {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  gap: 22px;
  background: rgba(10, 24, 52, 0.72);
  border: 1px solid rgba(56, 189, 248, 0.25);
  border-radius: 18px;
  padding: 16px 24px;
  backdrop-filter: blur(14px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
}
.an-weather-main-cell {
  display: flex;
  align-items: center;
  gap: 14px;
}
.an-weather-cloud-icon {
  font-size: 44px;
  filter: drop-shadow(0 4px 14px rgba(255, 255, 255, 0.25));
  line-height: 1;
}
.an-weather-temp-number {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 38px;
  font-weight: 800;
  color: #fff;
  line-height: 1;
  text-shadow: 0 2px 14px rgba(56, 189, 248, 0.4);
}
.an-weather-condition-label {
  font-size: 12px;
  color: #94A3B8;
  font-weight: 500;
  margin-top: 4px;
}
.an-weather-divider-v {
  width: 1px;
  height: 54px;
  background: rgba(255, 255, 255, 0.12);
}
.an-weather-metrics-list {
  display: flex;
  flex-direction: column;
  gap: 6px;
  min-width: 160px;
}
.an-metric-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 11.5px;
  color: #8FA3BF;
}
.an-metric-item i {
  color: #38BDF8;
  font-size: 12px;
  width: 16px;
  text-align: center;
}
.an-metric-item .val {
  color: #E2E8F0;
  font-weight: 700;
  margin-left: auto;
  padding-left: 10px;
}

/* ========================================================
   BALANCED CONTROLS & TIMEFRAME BAR
   ======================================================== */
.an-controls-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  padding: 12px 18px;
  border-radius: 16px;
  background: rgba(8, 20, 42, 0.6);
  border: 1px solid rgba(56, 189, 248, 0.14);
  backdrop-filter: blur(12px);
}
.an-controls-left {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.an-controls-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: #E2E8F0;
}
.an-period-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(56, 189, 248, 0.12);
  border: 1px solid rgba(56, 189, 248, 0.3);
  color: #38BDF8;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
}
.an-period-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #38BDF8;
  box-shadow: 0 0 6px #38BDF8;
}

.an-controls-right {
  display: flex;
  align-items: center;
  gap: 10px;
}
.an-tf-btn-group {
  display: flex;
  align-items: center;
  background: rgba(14, 28, 56, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 12px;
  padding: 3px;
  gap: 3px;
}
.an-tf-btn {
  padding: 7px 18px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 700;
  border: none;
  background: transparent;
  color: #8FA3BF;
  cursor: pointer;
  transition: all 0.25s;
}
.an-tf-btn:hover {
  color: #fff;
  background: rgba(56, 189, 248, 0.12);
}
.an-tf-btn.active {
  background: linear-gradient(135deg, #0284C7 0%, #38BDF8 100%);
  color: #050b17;
  font-weight: 800;
  box-shadow: 0 4px 16px rgba(56, 189, 248, 0.35);
}
.an-tf-cal-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 7px 14px;
  border-radius: 12px;
  border: 1px solid rgba(56, 189, 248, 0.2);
  background: rgba(14, 28, 56, 0.7);
  color: #8FA3BF;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.an-tf-cal-btn:hover {
  color: #38BDF8;
  border-color: rgba(56, 189, 248, 0.45);
  background: rgba(56, 189, 248, 0.12);
}

/* ========================================================
   ROW 1: TOP 5 CITIES CARDS (3 BALANCED COLUMNS)
   ======================================================== */
.an-top-cities-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 20px;
}

.an-stat-card {
  position: relative;
  border-radius: 20px;
  background: rgba(9, 20, 42, 0.78);
  border: 1px solid rgba(56, 189, 248, 0.15);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  backdrop-filter: blur(14px);
  padding: 22px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  overflow: hidden;
  transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
}
.an-stat-card:hover {
  transform: translateY(-3px);
  border-color: rgba(56, 189, 248, 0.35);
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.45);
}

/* Card Accents */
.an-card-hot { border-color: rgba(239, 68, 68, 0.22); }
.an-card-hot:hover {
  border-color: rgba(239, 68, 68, 0.45);
  box-shadow: 0 16px 45px rgba(239, 68, 68, 0.15);
}
.an-card-cold { border-color: rgba(56, 189, 248, 0.22); }
.an-card-cold:hover {
  border-color: rgba(56, 189, 248, 0.5);
  box-shadow: 0 16px 45px rgba(56, 189, 248, 0.18);
}
.an-card-rain { border-color: rgba(168, 85, 247, 0.22); }
.an-card-rain:hover {
  border-color: rgba(168, 85, 247, 0.45);
  box-shadow: 0 16px 45px rgba(168, 85, 247, 0.18);
}

/* Card Header */
.an-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.an-card-title-group {
  display: flex;
  align-items: center;
  gap: 10px;
}
.an-card-icon-badge {
  width: 32px;
  height: 32px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}
.badge-hot {
  background: rgba(239, 68, 68, 0.18);
  color: #EF4444;
  border: 1px solid rgba(239, 68, 68, 0.3);
}
.badge-cold {
  background: rgba(56, 189, 248, 0.18);
  color: #38BDF8;
  border: 1px solid rgba(56, 189, 248, 0.3);
}
.badge-rain {
  background: rgba(168, 85, 247, 0.18);
  color: #C084FC;
  border: 1px solid rgba(168, 85, 247, 0.3);
}
.an-card-title-text {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 15px;
  font-weight: 700;
  color: #F1F5F9;
}
.an-card-more-btn {
  font-size: 11px;
  color: #8FA3BF;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 4px 10px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: all 0.2s;
}
.an-card-more-btn:hover {
  color: #38BDF8;
  border-color: rgba(56, 189, 248, 0.35);
  background: rgba(56, 189, 248, 0.1);
}

/* Snowflake decoration on Cold Card */
.an-snowflake-icon {
  font-size: 13px;
  color: rgba(56, 189, 248, 0.6);
  margin-left: auto;
  margin-right: 8px;
}

/* City Rows */
.an-city-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.an-city-item {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 12.5px;
}
.an-city-name-box {
  display: flex;
  align-items: center;
  gap: 8px;
  width: 145px;
  flex-shrink: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  color: #E2E8F0;
  font-weight: 500;
}
.an-city-rank {
  color: #64748B;
  font-weight: 800;
  min-width: 16px;
  font-family: 'Space Grotesk', sans-serif;
}
.an-city-bar-track {
  flex: 1;
  min-width: 60px;
  height: 7px;
  background: rgba(255, 255, 255, 0.07);
  border-radius: 99px;
  overflow: hidden;
  position: relative;
}
.an-city-bar-fill {
  height: 100%;
  border-radius: 99px;
  transition: width 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.bar-hot-fill {
  background: linear-gradient(90deg, #F97316 0%, #EF4444 100%);
  box-shadow: 0 0 8px rgba(239, 68, 68, 0.5);
}
.bar-cold-fill {
  background: linear-gradient(90deg, #0284C7 0%, #38BDF8 100%);
  box-shadow: 0 0 8px rgba(56, 189, 248, 0.5);
}
.bar-rain-fill {
  background: linear-gradient(90deg, #9333EA 0%, #C084FC 100%);
  box-shadow: 0 0 8px rgba(168, 85, 247, 0.5);
}

.an-city-value-num {
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 800;
  font-size: 13px;
  width: 62px;
  text-align: right;
  flex-shrink: 0;
}
.num-hot { color: #F87171; }
.num-cold { color: #38BDF8; }
.num-rain { color: #C084FC; }

/* ========================================================
   ROW 2: DUAL INTERACTIVE CHARTS (2 BALANCED COLUMNS)
   ======================================================== */
.an-charts-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
}

.an-chart-card {
  position: relative;
  border-radius: 20px;
  background: rgba(9, 20, 42, 0.78);
  border: 1px solid rgba(56, 189, 248, 0.16);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  backdrop-filter: blur(14px);
  padding: 22px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.an-chart-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.an-chart-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 15px;
  font-weight: 700;
  color: #fff;
}
.an-chart-icon {
  width: 32px;
  height: 32px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}
.chart-icon-flame {
  background: rgba(249, 115, 22, 0.15);
  color: #F97316;
  border: 1px solid rgba(249, 115, 22, 0.3);
}
.chart-icon-drop {
  background: rgba(56, 189, 248, 0.15);
  color: #38BDF8;
  border: 1px solid rgba(56, 189, 248, 0.3);
}

/* Chart Subhead with Legend */
.an-chart-subhead {
  display: flex;
  align-items: center;
  gap: 16px;
  font-size: 11.5px;
  color: #8FA3BF;
  padding-left: 2px;
  flex-wrap: wrap;
}
.an-legend-dot {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.dot-line-orange {
  width: 14px;
  height: 3px;
  border-radius: 2px;
  background: #F97316;
}
.dot-line-cyan-dash {
  width: 14px;
  height: 3px;
  border-radius: 2px;
  background: #38BDF8;
  opacity: 0.8;
}
.dot-line-cyan {
  width: 14px;
  height: 3px;
  border-radius: 2px;
  background: #38BDF8;
}
.dot-line-green {
  width: 14px;
  height: 3px;
  border-radius: 2px;
  background: #22C55E;
}

/* Time Filter Selector */
.an-filter-select {
  background: rgba(14, 28, 56, 0.7);
  border: 1px solid rgba(56, 189, 248, 0.2);
  border-radius: 10px;
  color: #E2E8F0;
  font-size: 12px;
  font-weight: 600;
  padding: 6px 12px;
  cursor: pointer;
  outline: none;
}
.an-filter-select option {
  background: #09152b;
  color: #fff;
}
.an-chart-pill-group {
  display: flex;
  align-items: center;
  background: rgba(14, 28, 56, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 10px;
  padding: 3px;
  gap: 2px;
}
.an-pill-tab {
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 11px;
  font-weight: 600;
  color: #8FA3BF;
  border: none;
  background: transparent;
  cursor: pointer;
  transition: all 0.2s;
}
.an-pill-tab.active {
  background: #38BDF8;
  color: #050b17;
  font-weight: 700;
}

/* Chart Canvas & Sidebar split */
.an-chart-body-split {
  display: grid;
  grid-template-columns: 1fr 150px;
  gap: 18px;
  align-items: center;
  min-height: 240px;
}
.an-chart-canvas-box {
  position: relative;
  width: 100%;
  height: 240px;
}

/* Chart Stat Sidebar inside Card */
.an-chart-stat-sidebar {
  display: flex;
  flex-direction: column;
  gap: 16px;
  border-left: 1px solid rgba(255, 255, 255, 0.08);
  padding-left: 16px;
}
.an-side-stat-box {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.an-side-stat-top {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: #8FA3BF;
  font-weight: 500;
}
.an-side-stat-top i { font-size: 12px; color: #38BDF8; }
.an-side-stat-val {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 24px;
  font-weight: 800;
  color: #fff;
  line-height: 1.1;
}
.val-green { color: #4ADE80; }
.val-orange { color: #FB923C; }
.val-cyan { color: #38BDF8; }
.an-side-stat-sub {
  font-size: 10.5px;
  color: #64748B;
  line-height: 1.3;
}
.an-side-stat-link {
  font-size: 10px;
  color: #8FA3BF;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  margin-top: 2px;
}
.an-side-stat-link:hover { color: #38BDF8; }

/* ========================================================
   BOTTOM ATTRIBUTION & FOOTER BAR
   ======================================================== */
.an-footer-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 6px;
  font-size: 11.5px;
  color: #64748B;
  flex-wrap: wrap;
  gap: 12px;
}
.an-footer-status {
  display: flex;
  align-items: center;
  gap: 8px;
}
.an-footer-status i {
  color: #22C55E;
}
.an-bmkg-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #8FA3BF;
  font-weight: 600;
}
.an-bmkg-logo-circle {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: linear-gradient(135deg, #0284C7, #22C55E);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  color: #fff;
  font-weight: 900;
}

/* ========================================================
   MODALS: DATE PICKER & CITY RANKINGS
   ======================================================== */
.an-modal-backdrop {
  position: fixed;
  inset: 0;
  z-index: 999995;
  background: rgba(3, 8, 20, 0.75);
  backdrop-filter: blur(12px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.25s ease;
}
.an-modal-backdrop.is-open {
  opacity: 1;
  pointer-events: auto;
}
.an-modal-box {
  background: rgba(8, 20, 44, 0.95);
  border: 1px solid rgba(56, 189, 248, 0.3);
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 40px rgba(56, 189, 248, 0.15);
  border-radius: 24px;
  width: 100%;
  max-width: 580px;
  overflow: hidden;
  transform: translateY(15px) scale(0.97);
  transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.an-modal-backdrop.is-open .an-modal-box {
  transform: translateY(0) scale(1);
}
.an-modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 24px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.an-modal-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 17px;
  font-weight: 800;
  color: #fff;
}
.an-modal-close {
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #8FA3BF;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}
.an-modal-close:hover {
  background: rgba(239, 68, 68, 0.2);
  color: #EF4444;
  border-color: rgba(239, 68, 68, 0.4);
}
.an-modal-body {
  padding: 22px 24px;
  max-height: 65vh;
  overflow-y: auto;
}

/* City Ranking List inside Modal */
.an-rank-search-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(14, 28, 56, 0.7);
  border: 1px solid rgba(56, 189, 248, 0.2);
  border-radius: 12px;
  padding: 10px 14px;
  margin-bottom: 16px;
}
.an-rank-search-box input {
  background: transparent;
  border: none;
  outline: none;
  color: #fff;
  font-size: 13px;
  width: 100%;
}
.an-rank-items-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.an-rank-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 14px;
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  transition: background 0.2s;
}
.an-rank-row:hover {
  background: rgba(56, 189, 248, 0.08);
  border-color: rgba(56, 189, 248, 0.2);
}

/* ========================================================
   RESPONSIVE DESIGN BREAKPOINTS
   ======================================================== */
@media (max-width: 1100px) {
  .an-top-cities-grid { grid-template-columns: 1fr; }
  .an-charts-grid { grid-template-columns: 1fr; }
  .an-hero-banner { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .an-controls-bar { flex-direction: column; align-items: stretch; }
  .an-controls-right { justify-content: space-between; }
  .an-chart-body-split { grid-template-columns: 1fr; }
  .an-chart-stat-sidebar {
    border-left: none;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-left: 0;
    padding-top: 14px;
    flex-direction: row;
    justify-content: space-around;
  }
}
</style>
@endpush

@section('content')
<!-- Ambient Atmospheric Background -->
<div class="an-viewport-bg" aria-hidden="true"></div>
<div class="an-stardust" aria-hidden="true"></div>
<div class="an-earth-glow" aria-hidden="true"></div>
<div class="an-earth-arc" aria-hidden="true"></div>

<!-- Dashboard Shell - Clean Full Width -->
<div class="an-dashboard-shell">

  <!-- ==================== TOP HERO BANNER ==================== -->
  <header class="an-hero-banner">
    <div class="an-hero-skyline" aria-hidden="true"></div>
    <div class="an-hero-overlay-tint" aria-hidden="true"></div>

    <!-- Left Title Block -->
    <div class="an-hero-title-box">
      <h1 class="an-hero-heading">
        <i class="fas fa-chart-line"></i>
        Analisis Cuaca &amp; Iklim BMKG
      </h1>
      <p class="an-hero-sub">
        Data historis, tren anomali suhu, dan dinamika iklim terkini untuk 27 kabupaten/kota di Jawa Barat
      </p>
      <div class="an-hero-badges-row">
        <div class="an-hero-pill-badge">
          <span class="an-live-dot-green"></span>
          Microclimate Analytics
        </div>
        <div class="an-hero-pill-info">
          <i class="fas fa-satellite"></i> BMKG Radar Benchmark
        </div>
        <div class="an-hero-pill-info">
          <i class="fas fa-clock"></i> Diperbarui Otomatis
        </div>
      </div>
    </div>

    <!-- Right Live Weather Glass Card -->
    <div class="an-hero-weather-card" id="anHeroWeather">
      <div class="an-weather-main-cell">
        <div class="an-weather-cloud-icon" id="heroEmoji">☀️</div>
        <div>
          <div class="an-weather-temp-number" id="heroTemp">28°C</div>
          <div class="an-weather-condition-label" id="heroCond">Cerah Berawan</div>
        </div>
      </div>
      <div class="an-weather-divider-v"></div>
      <div class="an-weather-metrics-list">
        <div class="an-metric-item">
          <i class="fas fa-droplet"></i>
          <span>Kelembapan</span>
          <span class="val" id="heroHumidity">65%</span>
        </div>
        <div class="an-metric-item">
          <i class="fas fa-wind"></i>
          <span>Angin</span>
          <span class="val" id="heroWind">12.5 km/jam</span>
        </div>
        <div class="an-metric-item">
          <i class="fas fa-gauge-high"></i>
          <span>Tekanan</span>
          <span class="val" id="heroPressure">1011 hPa</span>
        </div>
      </div>
    </div>
  </header>

  <!-- ==================== CONTROLS ROW: TIMEFRAME SWITCHER ==================== -->
  <div class="an-controls-bar">
    <div class="an-controls-left">
      <div class="an-controls-title">
        <i class="fas fa-sliders" style="color:#38BDF8;"></i>
        <span>Dinamika Iklim Jawa Barat</span>
      </div>
      <span class="an-period-pill" id="anActivePeriodBadge">
        <span class="an-period-dot"></span> 24 Jam Terakhir
      </span>
    </div>
    <div class="an-controls-right">
      <div class="an-tf-btn-group">
        <button class="an-tf-btn active" data-tf="24h" id="tf24h">24 Jam</button>
        <button class="an-tf-btn" data-tf="7d" id="tf7d">7 Hari</button>
        <button class="an-tf-btn" data-tf="30d" id="tf30d">30 Hari</button>
      </div>
      <button class="an-tf-cal-btn" title="Pilih Tanggal Kalender" id="tfCalBtn">
        <i class="far fa-calendar-alt"></i>
        <span>Pilih Rentang</span>
      </button>
    </div>
  </div>

  <!-- ==================== ROW 1: TOP 5 CITIES METRICS ==================== -->
  <section class="an-top-cities-grid">

    <!-- CARD 1: Top 5 Kota Terpanas -->
    <article class="an-stat-card an-card-hot">
      <div class="an-card-header">
        <div class="an-card-title-group">
          <div class="an-card-icon-badge badge-hot">
            <i class="fas fa-temperature-high"></i>
          </div>
          <span class="an-card-title-text">Top 5 Kota Terpanas</span>
        </div>
        <button class="an-card-more-btn" onclick="window.openRankingsModal('hottest')">
          Lihat Semua <i class="fas fa-arrow-right"></i>
        </button>
      </div>
      <div class="an-city-list" id="hotCitiesList">
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">1.</span> Bekasi</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 100%;"></div></div>
          <span class="an-city-value-num num-hot">34.6°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">2.</span> Karawang</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 96%;"></div></div>
          <span class="an-city-value-num num-hot">34.1°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cirebon</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 92%;"></div></div>
          <span class="an-city-value-num num-hot">33.5°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">4.</span> Indramayu</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 88%;"></div></div>
          <span class="an-city-value-num num-hot">33.0°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">5.</span> Depok</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 85%;"></div></div>
          <span class="an-city-value-num num-hot">32.6°C</span>
        </div>
      </div>
    </article>

    <!-- CARD 2: Top 5 Kota Terdingin -->
    <article class="an-stat-card an-card-cold">
      <div class="an-card-header">
        <div class="an-card-title-group">
          <div class="an-card-icon-badge badge-cold">
            <i class="fas fa-snowflake"></i>
          </div>
          <span class="an-card-title-text">Top 5 Kota Terdingin</span>
        </div>
        <i class="fas fa-snowflake an-snowflake-icon" aria-hidden="true"></i>
        <button class="an-card-more-btn" onclick="window.openRankingsModal('coldest')">
          Lihat Semua <i class="fas fa-arrow-right"></i>
        </button>
      </div>
      <div class="an-city-list" id="coldCitiesList">
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">1.</span> Lembang, Bandung Barat</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 100%;"></div></div>
          <span class="an-city-value-num num-cold">17.2°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">2.</span> Ciwidey, Kab. Bandung</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 93%;"></div></div>
          <span class="an-city-value-num num-cold">17.8°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cisarua, Puncak Bogor</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 87%;"></div></div>
          <span class="an-city-value-num num-cold">18.4°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">4.</span> Tarogong, Garut</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 82%;"></div></div>
          <span class="an-city-value-num num-cold">19.0°C</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">5.</span> Kota Bandung</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 76%;"></div></div>
          <span class="an-city-value-num num-cold">20.2°C</span>
        </div>
      </div>
    </article>

    <!-- CARD 3: Curah Hujan Tertinggi -->
    <article class="an-stat-card an-card-rain">
      <div class="an-card-header">
        <div class="an-card-title-group">
          <div class="an-card-icon-badge badge-rain">
            <i class="fas fa-cloud-showers-heavy"></i>
          </div>
          <span class="an-card-title-text">Curah Hujan Tertinggi</span>
        </div>
        <button class="an-card-more-btn" onclick="window.openRankingsModal('rainiest')">
          Lihat Semua <i class="fas fa-arrow-right"></i>
        </button>
      </div>
      <div class="an-city-list" id="rainCitiesList">
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">1.</span> Kota Bogor</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 100%;"></div></div>
          <span class="an-city-value-num num-rain">68.5 mm</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">2.</span> Sukabumi</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 84%;"></div></div>
          <span class="an-city-value-num num-rain">52.4 mm</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cianjur</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 76%;"></div></div>
          <span class="an-city-value-num num-rain">46.2 mm</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">4.</span> Cimahi</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 65%;"></div></div>
          <span class="an-city-value-num num-rain">38.0 mm</span>
        </div>
        <div class="an-city-item">
          <div class="an-city-name-box"><span class="an-city-rank">5.</span> Tasikmalaya</div>
          <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 58%;"></div></div>
          <span class="an-city-value-num num-rain">34.8 mm</span>
        </div>
      </div>
    </article>

  </section>

  <!-- ==================== ROW 2: DUAL INTERACTIVE CHARTS ==================== -->
  <section class="an-charts-grid">

    <!-- CHART 1: Analisis Anomali Suhu BMKG -->
    <article class="an-chart-card">
      <div class="an-chart-top">
        <div class="an-chart-title">
          <div class="an-chart-icon chart-icon-flame">
            <i class="fas fa-fire-flame-curved"></i>
          </div>
          <span>Analisis Anomali Suhu BMKG</span>
        </div>
        <select class="an-filter-select" id="anomalyRangeSelect" aria-label="Pilih Rentang Anomali">
          <option value="24h">24 Jam</option>
          <option value="7d" selected>7 Hari</option>
          <option value="14d">14 Hari</option>
          <option value="30d">30 Hari</option>
        </select>
      </div>

      <div class="an-chart-subhead">
        <span class="an-legend-dot">
          <span class="dot-line-orange"></span> Suhu Observasi (°C)
        </span>
        <span class="an-legend-dot">
          <span class="dot-line-cyan-dash"></span> Normal Klimatologis BMKG
        </span>
      </div>

      <div class="an-chart-body-split">
        <div class="an-chart-canvas-box">
          <canvas id="anomalyChartCanvas"></canvas>
        </div>
        <div class="an-chart-stat-sidebar">
          <div class="an-side-stat-box">
            <div class="an-side-stat-top">
              <i class="fas fa-chart-line"></i>
              <span>Anomali Terkini</span>
            </div>
            <div class="an-side-stat-val val-orange" id="statAnomalyVal">+1.2°C</div>
            <div class="an-side-stat-sub">Kondisi lebih hangat dari normal BMKG</div>
          </div>
          <div class="an-side-stat-box">
            <div class="an-side-stat-top">
              <i class="fas fa-bullseye"></i>
              <span>Status Klimatologi</span>
            </div>
            <div style="font-size:12px;font-weight:700;color:#38BDF8;" id="statClimateStatus">Anomali Positif Ringan</div>
            <a href="{{ route('forecast') }}" class="an-side-stat-link">
              Lihat Proyeksi <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            </a>
          </div>
        </div>
      </div>
    </article>

    <!-- CHART 2: Fluktuasi Kelembapan & Titik Embun -->
    <article class="an-chart-card">
      <div class="an-chart-top">
        <div class="an-chart-title">
          <div class="an-chart-icon chart-icon-drop">
            <i class="fas fa-droplet"></i>
          </div>
          <span>Fluktuasi Kelembapan &amp; Titik Embun</span>
        </div>
        <div class="an-chart-pill-group" id="humidityPills">
          <button class="an-pill-tab" data-range="24h">24 Jam</button>
          <button class="an-pill-tab active" data-range="7d">7 Hari</button>
          <button class="an-pill-tab" data-range="14d">14 Hari</button>
          <button class="an-pill-tab" data-range="30d">30 Hari</button>
        </div>
      </div>

      <div class="an-chart-subhead">
        <span class="an-legend-dot">
          <span class="dot-line-cyan"></span> Kelembapan (%)
        </span>
        <span class="an-legend-dot">
          <span class="dot-line-green"></span> Titik Embun (°C)
        </span>
      </div>

      <div class="an-chart-body-split">
        <div class="an-chart-canvas-box">
          <canvas id="humidityChartCanvas"></canvas>
        </div>
        <div class="an-chart-stat-sidebar">
          <div class="an-side-stat-box">
            <div class="an-side-stat-top">
              <i class="fas fa-droplet" style="color:#38BDF8;"></i>
              <span>Rata-rata Kelembapan</span>
            </div>
            <div class="an-side-stat-val val-cyan" id="statAvgHumidity">72%</div>
            <div class="an-side-stat-sub" id="statHumidityPeriod">Optimal untuk kenyamanan</div>
          </div>
          <div class="an-side-stat-box">
            <div class="an-side-stat-top">
              <i class="fas fa-leaf" style="color:#4ADE80;"></i>
              <span>Rata-rata Titik Embun</span>
            </div>
            <div class="an-side-stat-val val-green" id="statAvgDew">16.8°C</div>
            <div class="an-side-stat-sub">Kondisi udara sejuk</div>
          </div>
        </div>
      </div>
    </article>

  </section>

  <!-- ==================== BOTTOM STATUS BAR ==================== -->
  <footer class="an-footer-bar">
    <div class="an-footer-status">
      <i class="fas fa-circle-check"></i>
      <span>Sistem Analitik Cuaca Real-Time Jawa Barat &bull; 27 Stasiun Terhubung</span>
    </div>
    <div class="an-bmkg-badge">
      <div class="an-bmkg-logo-circle">
        <i class="fas fa-wind"></i>
      </div>
      <span>BMKG Benchmark &bull; Akurasi untuk Negeri</span>
    </div>
  </footer>

</div>

<!-- ========================================================
     MODAL 1: DATE RANGE SELECTOR MODAL
     ======================================================== -->
<div class="an-modal-backdrop" id="datePickerModal" onclick="if(event.target === this) window.closeDatePickerModal()">
  <div class="an-modal-box">
    <div class="an-modal-header">
      <div class="an-modal-title">
        <i class="far fa-calendar-alt" style="color:#38BDF8;"></i>
        <span>Pilih Rentang Waktu Analitik</span>
      </div>
      <button class="an-modal-close" onclick="window.closeDatePickerModal()" aria-label="Tutup Modal">&times;</button>
    </div>
    <div class="an-modal-body">
      <div style="font-size:12px;color:#8FA3BF;margin-bottom:14px;">
        Pilih preset cepat atau tentukan rentang tanggal observasi stasiun cuaca:
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
        <button class="an-tf-btn" style="border:1px solid rgba(56,189,248,0.25);background:rgba(56,189,248,0.1);color:#fff;" onclick="window.applyPresetRange('24h')">
          <i class="fas fa-clock"></i> 24 Jam Terakhir
        </button>
        <button class="an-tf-btn" style="border:1px solid rgba(56,189,248,0.25);background:rgba(56,189,248,0.1);color:#fff;" onclick="window.applyPresetRange('7d')">
          <i class="fas fa-calendar-week"></i> 7 Hari Terakhir
        </button>
        <button class="an-tf-btn" style="border:1px solid rgba(56,189,248,0.25);background:rgba(56,189,248,0.1);color:#fff;" onclick="window.applyPresetRange('14d')">
          <i class="fas fa-calendar-days"></i> 14 Hari Terakhir
        </button>
        <button class="an-tf-btn" style="border:1px solid rgba(56,189,248,0.25);background:rgba(56,189,248,0.1);color:#fff;" onclick="window.applyPresetRange('30d')">
          <i class="fas fa-calendar"></i> 30 Hari Terakhir
        </button>
      </div>

      <div style="display:flex;flex-direction:column;gap:10px;padding:14px;border-radius:14px;background:rgba(14,28,56,0.5);border:1px solid rgba(255,255,255,0.06);">
        <label style="font-size:11px;font-weight:700;color:#94A3B8;">PILIH TANGGAL SPESIFIK</label>
        <input type="date" id="customDatePicker" style="background:rgba(9,20,42,0.9);border:1px solid rgba(56,189,248,0.3);color:#fff;padding:8px 12px;border-radius:10px;outline:none;" />
        <button class="an-tf-btn active" style="margin-top:6px;" onclick="window.applyCustomDate()">
          Terapkan Tanggal
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ========================================================
     MODAL 2: CITY RANKINGS MODAL
     ======================================================== -->
<div class="an-modal-backdrop" id="cityRankingsModal" onclick="if(event.target === this) window.closeRankingsModal()">
  <div class="an-modal-box" style="max-width:640px;">
    <div class="an-modal-header">
      <div class="an-modal-title">
        <i class="fas fa-ranking-star" style="color:#38BDF8;"></i>
        <span id="rankingsModalTitle">Peringkat Lengkap Kota Jawa Barat</span>
      </div>
      <button class="an-modal-close" onclick="window.closeRankingsModal()" aria-label="Tutup Modal">&times;</button>
    </div>
    <div class="an-modal-body">
      <!-- Search Input -->
      <div class="an-rank-search-box">
        <i class="fas fa-search" style="color:#38BDF8;"></i>
        <input type="text" id="rankingSearchInput" placeholder="Cari kabupaten atau kota (cth: Bandung, Bogor, dsb)..." oninput="window.filterRankingList()" />
      </div>

      <!-- Tab Filters -->
      <div style="display:flex;gap:6px;margin-bottom:14px;overflow-x:auto;">
        <button class="an-pill-tab active" id="tabRankHot" onclick="window.switchRankingTab('hottest')">🔥 Terpanas</button>
        <button class="an-pill-tab" id="tabRankCold" onclick="window.switchRankingTab('coldest')">❄️ Terdingin</button>
        <button class="an-pill-tab" id="tabRankRain" onclick="window.switchRankingTab('rainiest')">🌧️ Curah Hujan</button>
      </div>

      <!-- Rows -->
      <div class="an-rank-items-list" id="rankingsModalList">
        <!-- Rendered dynamically via JS -->
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  let anomalyChartInstance = null;
  let humidityChartInstance = null;
  let currentRange = '24h';
  let activeRankingType = 'hottest';

  /* 27 Regencies / Cities in West Java */
  const jabarCities = [
    { name: 'Kota Bandung', temp: 28.5, rain: 24.2, dew: 18.2, hum: 68 },
    { name: 'Kota Bogor', temp: 27.2, rain: 68.5, dew: 20.4, hum: 82 },
    { name: 'Kota Bekasi', temp: 34.6, rain: 12.0, dew: 22.1, hum: 59 },
    { name: 'Kota Depok', temp: 32.6, rain: 18.4, dew: 21.0, hum: 64 },
    { name: 'Kota Cimahi', temp: 28.1, rain: 38.0, dew: 18.0, hum: 70 },
    { name: 'Kota Cirebon', temp: 33.5, rain: 8.5, dew: 22.8, hum: 60 },
    { name: 'Kota Sukabumi', temp: 26.8, rain: 52.4, dew: 19.5, hum: 78 },
    { name: 'Kota Tasikmalaya', temp: 30.2, rain: 34.8, dew: 21.2, hum: 71 },
    { name: 'Kota Banjar', temp: 31.4, rain: 22.0, dew: 21.8, hum: 69 },
    { name: 'Kab. Bandung Barat (Lembang)', temp: 17.2, rain: 26.0, dew: 14.8, hum: 84 },
    { name: 'Kab. Bandung (Ciwidey)', temp: 17.8, rain: 31.5, dew: 15.2, hum: 86 },
    { name: 'Kab. Bogor (Cisarua/Puncak)', temp: 18.4, rain: 58.0, dew: 16.5, hum: 88 },
    { name: 'Kab. Garut', temp: 22.0, rain: 28.0, dew: 17.4, hum: 76 },
    { name: 'Kab. Cianjur', temp: 27.0, rain: 46.2, dew: 19.8, hum: 74 },
    { name: 'Kab. Karawang', temp: 34.1, rain: 10.2, dew: 22.0, hum: 58 },
    { name: 'Kab. Indramayu', temp: 33.0, rain: 6.4, dew: 22.5, hum: 57 },
    { name: 'Kab. Subang', temp: 32.2, rain: 15.0, dew: 21.6, hum: 63 },
    { name: 'Kab. Purwakarta', temp: 31.8, rain: 20.4, dew: 21.2, hum: 66 },
    { name: 'Kab. Sumedang', temp: 28.9, rain: 25.1, dew: 19.0, hum: 70 },
    { name: 'Kab. Majalengka', temp: 32.0, rain: 16.8, dew: 21.5, hum: 65 },
    { name: 'Kab. Kuningan', temp: 25.4, rain: 30.2, dew: 18.5, hum: 75 },
    { name: 'Kab. Ciamis', temp: 30.6, rain: 27.5, dew: 21.0, hum: 70 },
    { name: 'Kab. Pangandaran', temp: 31.5, rain: 19.8, dew: 23.0, hum: 72 },
    { name: 'Kab. Sukabumi (Pelabuhan Ratu)', temp: 31.0, rain: 32.0, dew: 22.4, hum: 73 }
  ];

  /* Helper to format dates */
  function getPastDates(count) {
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const list = [];
    const now = new Date();
    for (let i = count - 1; i >= 0; i--) {
      const d = new Date(now);
      d.setDate(now.getDate() - i);
      list.push(d.getDate() + ' ' + months[d.getMonth()]);
    }
    return list;
  }

  /* Dataset Generator for Anomaly (Handles 24h, 7d, 14d, 30d) */
  function getAnomalyData(range) {
    if (range === '24h') {
      return {
        labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00', '24:00'],
        obs: [23.1, 22.4, 22.8, 27.5, 31.8, 30.4, 27.2, 25.0, 23.8],
        norm: [22.0, 21.5, 22.0, 26.2, 30.2, 29.0, 26.0, 24.2, 23.0]
      };
    }
    if (range === '7d') {
      return {
        labels: getPastDates(7),
        obs: [26.8, 27.5, 29.2, 31.8, 30.5, 29.1, 28.4],
        norm: [25.5, 26.2, 28.0, 30.5, 29.2, 28.0, 27.2]
      };
    }
    if (range === '14d') {
      const labels = getPastDates(14);
      const obs = [25.8, 26.4, 27.1, 28.5, 29.8, 31.2, 30.5, 29.0, 28.2, 29.4, 30.8, 31.5, 29.8, 28.6];
      const norm = [25.0, 25.5, 26.2, 27.5, 28.5, 29.8, 29.2, 28.0, 27.5, 28.2, 29.5, 30.0, 28.8, 27.8];
      return { labels, obs, norm };
    }
    // 30d
    const labels = getPastDates(30);
    const obs = [], norm = [];
    for (let i = 0; i < 30; i++) {
      const angle = (i / 30) * Math.PI * 2;
      const base = 28 + Math.sin(angle) * 2.8;
      obs.push(parseFloat((base + Math.cos(angle * 1.5) * 1.1).toFixed(1)));
      norm.push(parseFloat((base - 1.2).toFixed(1)));
    }
    return { labels, obs, norm };
  }

  /* Dataset Generator for Humidity & Dew Point */
  function getHumidityData(range) {
    if (range === '24h') {
      return {
        labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00', '24:00'],
        humidity: [86, 89, 87, 72, 58, 64, 76, 82, 85],
        dewPoint: [20.2, 19.8, 20.1, 21.0, 21.8, 21.5, 20.9, 20.4, 20.1]
      };
    }
    if (range === '7d') {
      return {
        labels: getPastDates(7),
        humidity: [74, 71, 65, 68, 76, 73, 69],
        dewPoint: [17.1, 16.5, 15.8, 16.2, 17.5, 16.9, 16.4]
      };
    }
    if (range === '14d') {
      return {
        labels: getPastDates(14),
        humidity: [78, 75, 72, 68, 66, 70, 74, 76, 71, 67, 69, 73, 75, 70],
        dewPoint: [17.5, 17.0, 16.6, 16.0, 15.6, 16.2, 17.1, 17.3, 16.8, 16.2, 16.4, 17.0, 17.2, 16.5]
      };
    }
    // 30d
    const labels = getPastDates(30);
    const humidity = [], dewPoint = [];
    for (let i = 0; i < 30; i++) {
      const angle = (i / 30) * Math.PI * 2;
      humidity.push(Math.round(71 + Math.sin(angle * 2) * 8));
      dewPoint.push(parseFloat((16.8 + Math.cos(angle) * 1.5).toFixed(1)));
    }
    return { labels, humidity, dewPoint };
  }

  /* ---- Render Temperature Anomaly Line Chart ---- */
  function renderAnomalyChart(range) {
    const canvas = document.getElementById('anomalyChartCanvas');
    if (!canvas || !window.Chart) return;

    const data = getAnomalyData(range);

    if (anomalyChartInstance) {
      anomalyChartInstance.destroy();
    }

    const ctx = canvas.getContext('2d');
    const gradObs = ctx.createLinearGradient(0, 0, 0, 220);
    gradObs.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
    gradObs.addColorStop(0.5, 'rgba(239, 68, 68, 0.15)');
    gradObs.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

    anomalyChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: [
          {
            label: 'Suhu Observasi (°C)',
            data: data.obs,
            borderColor: '#F97316',
            backgroundColor: gradObs,
            borderWidth: 2.8,
            tension: 0.45,
            fill: true,
            pointRadius: data.labels.length > 15 ? 2 : 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#F97316',
            pointBorderColor: '#050b17',
            pointBorderWidth: 2,
          },
          {
            label: 'Normal Klimatologis BMKG',
            data: data.norm,
            borderColor: '#38BDF8',
            borderWidth: 2,
            borderDash: [5, 4],
            tension: 0.45,
            fill: false,
            pointRadius: 0,
            pointHoverRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(5, 15, 35, 0.95)',
            borderColor: 'rgba(56, 189, 248, 0.4)',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#94A3B8',
            padding: 10,
            cornerRadius: 10,
            callbacks: {
              label: function (ctx) {
                return ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + '°C';
              }
            }
          }
        },
        scales: {
          x: {
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: {
              color: '#8FA3BF',
              font: { size: 10, family: 'Inter' },
              maxTicksLimit: range === '30d' ? 10 : 8
            }
          },
          y: {
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: {
              color: '#8FA3BF',
              font: { size: 10, family: 'Inter' },
              callback: function (v) { return v + '°C'; }
            }
          }
        }
      }
    });

    // Update anomaly sidebar stat
    const lastObs = data.obs[data.obs.length - 1];
    const lastNorm = data.norm[data.norm.length - 1];
    const diff = lastObs - lastNorm;
    const statVal = document.getElementById('statAnomalyVal');
    const statStatus = document.getElementById('statClimateStatus');
    if (statVal) {
      statVal.textContent = (diff >= 0 ? '+' : '') + diff.toFixed(1) + '°C';
      statVal.className = 'an-side-stat-val ' + (diff > 0 ? 'val-orange' : 'val-cyan');
    }
    if (statStatus) {
      statStatus.textContent = diff > 1.5 ? 'Anomali Panas Signifikan' : diff > 0 ? 'Anomali Positif Ringan' : 'Kondisi Normal / Sejuk';
    }
  }

  /* ---- Render Humidity Line Chart ---- */
  function renderHumidityChart(range) {
    const canvas = document.getElementById('humidityChartCanvas');
    if (!canvas || !window.Chart) return;

    const data = getHumidityData(range);

    if (humidityChartInstance) {
      humidityChartInstance.destroy();
    }

    const ctx = canvas.getContext('2d');
    const gradHum = ctx.createLinearGradient(0, 0, 0, 220);
    gradHum.addColorStop(0, 'rgba(56, 189, 248, 0.25)');
    gradHum.addColorStop(1, 'rgba(56, 189, 248, 0.0)');

    humidityChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: [
          {
            label: 'Kelembapan (%)',
            data: data.humidity,
            borderColor: '#38BDF8',
            backgroundColor: gradHum,
            borderWidth: 2.5,
            tension: 0.45,
            fill: true,
            pointRadius: data.labels.length > 15 ? 2 : 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#38BDF8',
            pointBorderColor: '#050b17',
            pointBorderWidth: 2,
            yAxisID: 'y',
          },
          {
            label: 'Titik Embun (°C)',
            data: data.dewPoint,
            borderColor: '#22C55E',
            borderWidth: 2.2,
            tension: 0.4,
            fill: false,
            pointRadius: data.labels.length > 15 ? 2 : 3,
            pointHoverRadius: 5,
            pointBackgroundColor: '#22C55E',
            pointBorderColor: '#050b17',
            pointBorderWidth: 1.5,
            yAxisID: 'y1',
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(5, 15, 35, 0.95)',
            borderColor: 'rgba(34, 197, 94, 0.4)',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#94A3B8',
            padding: 10,
            cornerRadius: 10,
          }
        },
        scales: {
          x: {
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: {
              color: '#8FA3BF',
              font: { size: 10, family: 'Inter' },
              maxTicksLimit: range === '30d' ? 10 : 8
            }
          },
          y: {
            type: 'linear',
            position: 'left',
            min: range === '24h' ? 45 : 50,
            max: 100,
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: {
              color: '#8FA3BF',
              font: { size: 10, family: 'Inter' },
              callback: function (v) { return v + '%'; }
            }
          },
          y1: {
            type: 'linear',
            position: 'right',
            min: range === '24h' ? 15 : 10,
            max: range === '24h' ? 26 : 24,
            grid: { drawOnChartArea: false },
            ticks: {
              color: '#4ADE80',
              font: { size: 10, family: 'Inter' },
              callback: function (v) { return v + '°C'; }
            }
          }
        }
      }
    });

    // Update humidity sidebar stats
    const sumH = data.humidity.reduce((a, b) => a + b, 0);
    const sumD = data.dewPoint.reduce((a, b) => a + b, 0);
    const avgH = Math.round(sumH / data.humidity.length);
    const avgD = (sumD / data.dewPoint.length).toFixed(1);

    const statH = document.getElementById('statAvgHumidity');
    const statD = document.getElementById('statAvgDew');
    const statPeriod = document.getElementById('statHumidityPeriod');
    if (statH) statH.textContent = avgH + '%';
    if (statD) statD.textContent = avgD + '°C';
    if (statPeriod) {
      statPeriod.textContent = range === '24h' ? 'Rata-rata 24 jam' : range === '7d' ? 'Rata-rata 7 hari terakhir' : 'Rata-rata 30 hari';
    }
  }

  /* ---- Synchronized Range Switcher ---- */
  function setTimeframe(range) {
    currentRange = range;

    // 1. Update Top Buttons
    const tfButtons = document.querySelectorAll('.an-tf-btn');
    tfButtons.forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('data-tf') === range);
    });

    // 2. Update Period Badge
    const badge = document.getElementById('anActivePeriodBadge');
    if (badge) {
      const labels = {
        '24h': '24 Jam Terakhir',
        '7d': '7 Hari Terakhir',
        '14d': '14 Hari Terakhir',
        '30d': '30 Hari Terakhir'
      };
      badge.innerHTML = `<span class="an-period-dot"></span> ${labels[range] || range}`;
    }

    // 3. Sync Anomaly Select Dropdown
    const anSelect = document.getElementById('anomalyRangeSelect');
    if (anSelect && anSelect.value !== range) {
      anSelect.value = range;
    }

    // 4. Sync Humidity Pill Tabs
    const humPills = document.querySelectorAll('#humidityPills .an-pill-tab');
    humPills.forEach(pill => {
      pill.classList.toggle('active', pill.getAttribute('data-range') === range);
    });

    // 5. Render Charts
    renderAnomalyChart(range);
    renderHumidityChart(range);

    // 6. Adjust Top Cities values smoothly
    updateTopCitiesData(range);
  }

  /* Update Top Cities based on Timeframe */
  function updateTopCitiesData(range) {
    // Dynamic multipliers for realism
    const hotList = document.getElementById('hotCitiesList');
    const coldList = document.getElementById('coldCitiesList');
    const rainList = document.getElementById('rainCitiesList');

    if (range === '24h') {
      if (hotList) {
        hotList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Bekasi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-hot">34.6°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Karawang</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 96%;"></div></div>
            <span class="an-city-value-num num-hot">34.1°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cirebon</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 92%;"></div></div>
            <span class="an-city-value-num num-hot">33.5°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Indramayu</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 88%;"></div></div>
            <span class="an-city-value-num num-hot">33.0°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Depok</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 85%;"></div></div>
            <span class="an-city-value-num num-hot">32.6°C</span>
          </div>
        `;
      }
      if (coldList) {
        coldList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Lembang, Bandung Barat</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-cold">17.2°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Ciwidey, Kab. Bandung</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 93%;"></div></div>
            <span class="an-city-value-num num-cold">17.8°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cisarua, Puncak Bogor</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 87%;"></div></div>
            <span class="an-city-value-num num-cold">18.4°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Tarogong, Garut</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 82%;"></div></div>
            <span class="an-city-value-num num-cold">19.0°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Kota Bandung</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-cold-fill" style="width: 76%;"></div></div>
            <span class="an-city-value-num num-cold">20.2°C</span>
          </div>
        `;
      }
      if (rainList) {
        rainList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Kota Bogor</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-rain">68.5 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Sukabumi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 84%;"></div></div>
            <span class="an-city-value-num num-rain">52.4 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cianjur</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 76%;"></div></div>
            <span class="an-city-value-num num-rain">46.2 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Cimahi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 65%;"></div></div>
            <span class="an-city-value-num num-rain">38.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Tasikmalaya</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 58%;"></div></div>
            <span class="an-city-value-num num-rain">34.8 mm</span>
          </div>
        `;
      }
    } else if (range === '7d' || range === '14d') {
      if (hotList) {
        hotList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Bekasi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-hot">33.8°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Karawang</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 95%;"></div></div>
            <span class="an-city-value-num num-hot">33.4°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cirebon</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 90%;"></div></div>
            <span class="an-city-value-num num-hot">32.9°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Indramayu</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 86%;"></div></div>
            <span class="an-city-value-num num-hot">32.4°C</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Purwakarta</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 82%;"></div></div>
            <span class="an-city-value-num num-hot">31.8°C</span>
          </div>
        `;
      }
      if (rainList) {
        rainList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Kota Bogor</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-rain">142.5 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Cisarua, Puncak</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 88%;"></div></div>
            <span class="an-city-value-num num-rain">125.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Sukabumi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 76%;"></div></div>
            <span class="an-city-value-num num-rain">108.4 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Cianjur</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 66%;"></div></div>
            <span class="an-city-value-num num-rain">94.2 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Cimahi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 58%;"></div></div>
            <span class="an-city-value-num num-rain">82.0 mm</span>
          </div>
        `;
      }
    } else if (range === '30d') {
      if (hotList) {
        hotList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Bekasi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-hot">35.2°C (Maks)</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Karawang</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 96%;"></div></div>
            <span class="an-city-value-num num-hot">34.8°C (Maks)</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Cirebon</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 93%;"></div></div>
            <span class="an-city-value-num num-hot">34.2°C (Maks)</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Indramayu</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 89%;"></div></div>
            <span class="an-city-value-num num-hot">33.9°C (Maks)</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Depok</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-hot-fill" style="width: 85%;"></div></div>
            <span class="an-city-value-num num-hot">33.4°C (Maks)</span>
          </div>
        `;
      }
      if (rainList) {
        rainList.innerHTML = `
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">1.</span> Kota Bogor</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 100%;"></div></div>
            <span class="an-city-value-num num-rain">385.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">2.</span> Cisarua, Puncak</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 90%;"></div></div>
            <span class="an-city-value-num num-rain">345.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">3.</span> Sukabumi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 82%;"></div></div>
            <span class="an-city-value-num num-rain">315.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">4.</span> Cianjur</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 72%;"></div></div>
            <span class="an-city-value-num num-rain">278.0 mm</span>
          </div>
          <div class="an-city-item">
            <div class="an-city-name-box"><span class="an-city-rank">5.</span> Cimahi</div>
            <div class="an-city-bar-track"><div class="an-city-bar-fill bar-rain-fill" style="width: 64%;"></div></div>
            <span class="an-city-value-num num-rain">246.0 mm</span>
          </div>
        `;
      }
    }
  }

  /* ---- Live Weather Hero Update ---- */
  async function fetchHeroWeather() {
    try {
      const res = await fetch('/api/dashboard/overview');
      const json = await res.json();
      if (json && json.success && json.data) {
        const cw = json.data.current;
        const tempEl = document.getElementById('heroTemp');
        const condEl = document.getElementById('heroCond');
        const humEl = document.getElementById('heroHumidity');
        const windEl = document.getElementById('heroWind');
        const pressEl = document.getElementById('heroPressure');
        const emojiEl = document.getElementById('heroEmoji');

        if (tempEl && cw && cw.temperature !== undefined) tempEl.textContent = Math.round(cw.temperature) + '°C';
        if (condEl && cw) condEl.textContent = cw.weather_description || cw.weather_main || 'Cerah Berawan';
        if (humEl && cw && cw.humidity !== undefined) humEl.textContent = cw.humidity + '%';
        if (windEl && cw && cw.wind_speed !== undefined) windEl.textContent = (cw.wind_speed * 3.6).toFixed(1) + ' km/jam';
        if (pressEl && cw && cw.pressure !== undefined) pressEl.textContent = Math.round(cw.pressure) + ' hPa';

        if (emojiEl && cw) {
          const desc = (cw.weather_description || cw.weather_main || '').toLowerCase();
          if (desc.includes('petir')) emojiEl.textContent = '⛈️';
          else if (desc.includes('hujan') || desc.includes('rain')) emojiEl.textContent = '🌧️';
          else if (desc.includes('cerah') || desc.includes('clear')) emojiEl.textContent = '☀️';
          else if (desc.includes('tebal') || desc.includes('mendung')) emojiEl.textContent = '☁️';
          else if (desc.includes('berawan')) emojiEl.textContent = '⛅';
        }
      }
    } catch (err) {
      // Keep realistic fallback data
    }
  }

  /* ---- Event Handlers ---- */
  function initEvents() {
    // 1. Top timeframe buttons
    const tfButtons = document.querySelectorAll('.an-tf-btn');
    tfButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        const tf = this.getAttribute('data-tf');
        if (tf) setTimeframe(tf);
      });
    });

    // 2. Anomaly Select Dropdown
    const anSelect = document.getElementById('anomalyRangeSelect');
    if (anSelect) {
      anSelect.addEventListener('change', function () {
        setTimeframe(this.value);
      });
    }

    // 3. Humidity Pills
    const humPills = document.querySelectorAll('#humidityPills .an-pill-tab');
    humPills.forEach(pill => {
      pill.addEventListener('click', function () {
        const range = this.getAttribute('data-range');
        if (range) setTimeframe(range);
      });
    });

    // 4. Calendar Modal Toggle
    const calBtn = document.getElementById('tfCalBtn');
    if (calBtn) {
      calBtn.addEventListener('click', function () {
        window.openDatePickerModal();
      });
    }
  }

  /* ---- Modal Controllers (Attached to window) ---- */
  window.openDatePickerModal = function () {
    const modal = document.getElementById('datePickerModal');
    if (modal) modal.classList.add('is-open');
  };

  window.closeDatePickerModal = function () {
    const modal = document.getElementById('datePickerModal');
    if (modal) modal.classList.remove('is-open');
  };

  window.applyPresetRange = function (preset) {
    setTimeframe(preset);
    window.closeDatePickerModal();
  };

  window.applyCustomDate = function () {
    const input = document.getElementById('customDatePicker');
    if (input && input.value) {
      const badge = document.getElementById('anActivePeriodBadge');
      if (badge) {
        badge.innerHTML = `<span class="an-period-dot"></span> Tanggal: ${input.value}`;
      }
      renderAnomalyChart('24h');
      renderHumidityChart('24h');
      window.closeDatePickerModal();
    }
  };

  window.openRankingsModal = function (type) {
    activeRankingType = type;
    window.switchRankingTab(type);
    const modal = document.getElementById('cityRankingsModal');
    if (modal) modal.classList.add('is-open');
  };

  window.closeRankingsModal = function () {
    const modal = document.getElementById('cityRankingsModal');
    if (modal) modal.classList.remove('is-open');
  };

  window.switchRankingTab = function (type) {
    activeRankingType = type;
    const btnHot = document.getElementById('tabRankHot');
    const btnCold = document.getElementById('tabRankCold');
    const btnRain = document.getElementById('tabRankRain');
    const title = document.getElementById('rankingsModalTitle');

    if (btnHot) btnHot.classList.toggle('active', type === 'hottest');
    if (btnCold) btnCold.classList.toggle('active', type === 'coldest');
    if (btnRain) btnRain.classList.toggle('active', type === 'rainiest');

    if (title) {
      if (type === 'hottest') title.textContent = 'Peringkat Suhu Tertinggi di Jawa Barat';
      else if (type === 'coldest') title.textContent = 'Peringkat Suhu Terendah di Jawa Barat';
      else if (type === 'rainiest') title.textContent = 'Peringkat Akumulasi Curah Hujan di Jawa Barat';
    }

    window.renderRankingList();
  };

  window.filterRankingList = function () {
    window.renderRankingList();
  };

  window.renderRankingList = function () {
    const container = document.getElementById('rankingsModalList');
    const searchInput = document.getElementById('rankingSearchInput');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

    if (!container) return;

    let sorted = [...jabarCities];
    if (activeRankingType === 'hottest') {
      sorted.sort((a, b) => b.temp - a.temp);
    } else if (activeRankingType === 'coldest') {
      sorted.sort((a, b) => a.temp - b.temp);
    } else if (activeRankingType === 'rainiest') {
      sorted.sort((a, b) => b.rain - a.rain);
    }

    if (query) {
      sorted = sorted.filter(c => c.name.toLowerCase().includes(query));
    }

    container.innerHTML = sorted.map((c, i) => {
      let valDisplay = '';
      if (activeRankingType === 'hottest' || activeRankingType === 'coldest') {
        const color = activeRankingType === 'hottest' ? '#F87171' : '#38BDF8';
        valDisplay = `<span style="font-weight:800;color:${color};font-family:'Space Grotesk'">${c.temp.toFixed(1)}°C</span>`;
      } else {
        valDisplay = `<span style="font-weight:800;color:#C084FC;font-family:'Space Grotesk'">${c.rain.toFixed(1)} mm</span>`;
      }

      return `
        <div class="an-rank-row">
          <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:12px;font-weight:800;color:#64748B;width:22px;">${i + 1}.</span>
            <span style="font-size:13px;font-weight:600;color:#E2E8F0;">${c.name}</span>
          </div>
          <div style="display:flex;align-items:center;gap:14px;">
            <span style="font-size:11px;color:#8FA3BF;"><i class="fas fa-droplet" style="color:#38BDF8;"></i> ${c.hum}%</span>
            ${valDisplay}
          </div>
        </div>
      `;
    }).join('');
  };

  /* ---- Bootstrapping ---- */
  function initDashboard() {
    setTimeframe('24h');
    initEvents();
    fetchHeroWeather();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
  } else {
    initDashboard();
  }

})();
</script>
@endpush

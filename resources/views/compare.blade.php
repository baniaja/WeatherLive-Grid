@extends('layouts.app')

@section('title', 'Compare Prediksi Cuaca — WeatherLive-Grid')

@push('styles')
<style>
/* ========================================================
   WEATHERLIVE-GRID — COMPARE PREDIKSI CUACA V3
   Cinematic Twilight Volcanic Backdrop, Neon Dual Cards,
   Center Floating VS Orbs, Matrix Table & Quote Showcase Card
   ======================================================== */
@import url('https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Space+Grotesk:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap');

:root {
  --cmp-bg: #040914;
  --cmp-card-a: rgba(8, 20, 46, 0.88);
  --cmp-card-b: rgba(14, 18, 44, 0.88);
  --cmp-accent-cyan: #38BDF8;
  --cmp-accent-purple: #C084FC;
  --cmp-text: #F1F5F9;
  --cmp-muted: #8FA3BF;
}

/* Base resets & layout overrides */
footer.glass { display: none !important; }
#global-mobile-menu { display: none !important; }
#main-content { padding-top: 0 !important; }

body {
  background-color: var(--cmp-bg) !important;
  color: var(--cmp-text);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  overflow-x: hidden;
  min-height: 100vh;
  position: relative;
}

/* Atmospheric Indonesian Mountain Background Overlay */
.cmp-viewport-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  background-image:
    linear-gradient(180deg, rgba(4, 9, 20, 0.65) 0%, rgba(4, 9, 20, 0.85) 450px, rgba(4, 9, 20, 0.98) 100%),
    radial-gradient(ellipse at 85% 15%, rgba(168, 85, 247, 0.22) 0%, transparent 55%),
    radial-gradient(ellipse at 20% 10%, rgba(37, 99, 235, 0.25) 0%, transparent 50%),
    url('https://images.unsplash.com/photo-1589182373726-e4f658ab50f0?auto=format&fit=crop&w=2000&q=80');
  background-size: cover;
  background-position: center 20%;
  background-attachment: fixed;
}

.cmp-stardust {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1px, transparent 1px);
  background-size: 80px 80px;
  opacity: 0.35;
}

/* Top Mountain Vista in Header (matching exact screenshot) */
.cmp-header-mountain-vista {
  position: absolute;
  top: 0;
  right: 0;
  width: 580px;
  height: 240px;
  background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') center right / cover no-repeat;
  mask-image: radial-gradient(ellipse at top right, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 75%);
  -webkit-mask-image: radial-gradient(ellipse at top right, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 75%);
  pointer-events: none;
  z-index: 1;
  opacity: 0.45;
}

/* Main Shell Container */
.cmp-shell {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 16px 28px 70px;
  display: flex;
  flex-direction: column;
  gap: 22px;
}

/* ========================================================
   1. PAGE HEADER ROW
   ======================================================== */
.cmp-header-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
  position: relative;
}

.cmp-title-box {
  display: flex;
  flex-direction: column;
  gap: 6px;
  position: relative;
  z-index: 2;
}
.cmp-title-top {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.cmp-main-heading {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 28px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.02em;
  display: flex;
  align-items: center;
  gap: 12px;
}
.cmp-main-heading i {
  color: #38BDF8;
  font-size: 27px;
  filter: drop-shadow(0 0 14px rgba(56, 189, 248, 0.65));
}
.cmp-heading-grad {
  background: linear-gradient(135deg, #38BDF8 0%, #A855F7 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.cmp-badge-official {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(34, 197, 94, 0.14);
  border: 1px solid rgba(34, 197, 94, 0.35);
  color: #4ADE80;
  padding: 5px 12px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
}
.cmp-badge-official .live-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #22C55E;
  box-shadow: 0 0 6px #22C55E;
}
.cmp-subtitle {
  font-size: 13.5px;
  color: #94A3B8;
  font-weight: 400;
}

/* Header Mode Switch Pills */
.cmp-mode-group {
  display: flex;
  align-items: center;
  gap: 10px;
  position: relative;
  z-index: 2;
}
.cmp-mode-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 22px;
  border-radius: 14px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(12, 25, 52, 0.65);
  color: #8FA3BF;
  backdrop-filter: blur(12px);
  transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.cmp-mode-btn:hover {
  color: #fff;
  border-color: rgba(56, 189, 248, 0.35);
  transform: translateY(-2px);
}
.cmp-mode-btn.active {
  background: linear-gradient(135deg, #0284C7 0%, #38BDF8 100%);
  color: #040914;
  font-weight: 800;
  border-color: transparent;
  box-shadow: 0 4px 20px rgba(56, 189, 248, 0.45);
}
.cmp-mode-btn.active i {
  color: #040914;
}

/* ========================================================
   2. LOCATION SELECTOR STRIP & QUICK PRESETS
   ======================================================== */
.cmp-selector-strip {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 12px 24px;
  border-radius: 999px;
  background: rgba(8, 20, 44, 0.85);
  border: 1.5px solid rgba(56, 189, 248, 0.4);
  box-shadow: 0 14px 36px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px);
  position: relative;
  z-index: 5;
}

.cmp-sel-group {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
  min-width: 240px;
}
.cmp-sel-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  font-weight: 800;
  letter-spacing: 0.8px;
  color: #E2E8F0;
  text-transform: uppercase;
  white-space: nowrap;
}
.cmp-sel-label i {
  color: #38BDF8;
  font-size: 15px;
}
.cmp-sel-label.label-b i {
  color: #C084FC;
}

/* Custom Select Dropdown with Chevron Arrow */
.cmp-select-wrapper {
  position: relative;
  flex: 1;
  display: flex;
  align-items: center;
}
.cmp-select {
  width: 100%;
  appearance: none;
  -webkit-appearance: none;
  background: rgba(14, 28, 56, 0.95);
  border: 1px solid rgba(56, 189, 248, 0.3);
  border-radius: 999px;
  color: #fff;
  font-size: 13.5px;
  font-weight: 700;
  padding: 9px 36px 9px 16px;
  outline: none;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
}
.cmp-select:focus {
  border-color: #38BDF8;
  box-shadow: 0 0 18px rgba(56, 189, 248, 0.45);
}
.cmp-select-wrapper.wrap-b .cmp-select {
  border-color: rgba(192, 132, 252, 0.3);
}
.cmp-select-wrapper.wrap-b .cmp-select:focus {
  border-color: #C084FC;
  box-shadow: 0 0 18px rgba(192, 132, 252, 0.45);
}
.cmp-select option {
  background: #09152b;
  color: #fff;
  padding: 8px;
}
.cmp-select-arrow {
  position: absolute;
  right: 14px;
  pointer-events: none;
  color: #38BDF8;
  font-size: 11px;
}
.cmp-select-wrapper.wrap-b .cmp-select-arrow {
  color: #C084FC;
}

/* Center VS Badge in Strip (Clickable to Swap!) */
.cmp-vs-circle-sm {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: radial-gradient(circle, #1E40AF 0%, #091734 100%);
  border: 2px solid #38BDF8;
  box-shadow: 0 0 18px rgba(56, 189, 248, 0.6), inset 0 0 8px rgba(56, 189, 248, 0.35);
  color: #fff;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 900;
  font-size: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.cmp-vs-circle-sm:hover {
  transform: rotate(180deg) scale(1.15);
  box-shadow: 0 0 28px rgba(56, 189, 248, 0.85);
}
.cmp-vs-circle-sm:active {
  transform: rotate(360deg) scale(0.95);
}

/* Refresh Button */
.cmp-refresh-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 22px;
  border-radius: 999px;
  background: linear-gradient(135deg, #0284C7 0%, #38BDF8 100%);
  color: #040914;
  font-size: 13.5px;
  font-weight: 800;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 20px rgba(56, 189, 248, 0.45);
  transition: all 0.25s;
  white-space: nowrap;
}
.cmp-refresh-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 26px rgba(56, 189, 248, 0.65);
}
.cmp-refresh-btn:active {
  transform: translateY(0);
}
.cmp-refresh-btn i.spin {
  animation: spinSlow 0.9s linear infinite;
}
@keyframes spinSlow {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Quick Comparison Presets Bar */
.cmp-presets-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
  padding: 0 6px;
  margin-top: -6px;
}
.cmp-preset-label {
  font-size: 12px;
  color: #8FA3BF;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 6px;
}
.cmp-preset-pill {
  padding: 5px 12px;
  border-radius: 999px;
  background: rgba(14, 28, 56, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.08);
  color: #CBD5E1;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.cmp-preset-pill:hover {
  background: rgba(56, 189, 248, 0.15);
  border-color: rgba(56, 189, 248, 0.4);
  color: #fff;
  transform: translateY(-1px);
}
.cmp-preset-pill.active {
  background: rgba(56, 189, 248, 0.22);
  border-color: #38BDF8;
  color: #38BDF8;
  font-weight: 700;
}

/* ========================================================
   3. SIDE-BY-SIDE MAIN WEATHER CARDS WITH FLOATING VS
   ======================================================== */
.cmp-cards-container {
  position: relative;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  align-items: stretch;
}

/* Swapping Animation on Cards */
.cmp-cards-container.is-swapping .cmp-weather-card {
  animation: cardSwapPulse 0.45s cubic-bezier(0.4, 0, 0.2, 1);
}
@keyframes cardSwapPulse {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(0.97); opacity: 0.6; }
  100% { transform: scale(1); opacity: 1; }
}

/* Center Floating VS Orb between cards */
.cmp-vs-center-orb {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: radial-gradient(circle, #1E3A8A 0%, #08152e 100%);
  border: 2.5px solid #38BDF8;
  box-shadow:
    0 0 25px rgba(56, 189, 248, 0.75),
    0 0 50px rgba(168, 85, 247, 0.45),
    inset 0 0 12px rgba(56, 189, 248, 0.4);
  color: #fff;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 900;
  font-size: 16px;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  animation: pulseGlowVS 3s ease-in-out infinite;
  transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.cmp-vs-center-orb:hover {
  transform: translate(-50%, -50%) rotate(180deg) scale(1.15);
  box-shadow: 0 0 35px rgba(56, 189, 248, 0.95), 0 0 65px rgba(168, 85, 247, 0.65);
}
@keyframes pulseGlowVS {
  0%, 100% {
    box-shadow: 0 0 25px rgba(56, 189, 248, 0.75), 0 0 50px rgba(168, 85, 247, 0.45);
    transform: translate(-50%, -50%) scale(1);
  }
  50% {
    box-shadow: 0 0 35px rgba(56, 189, 248, 0.95), 0 0 65px rgba(168, 85, 247, 0.65);
    transform: translate(-50%, -50%) scale(1.06);
  }
}

/* Weather Card A (Jakarta - Cyan Glowing Accent) */
.cmp-weather-card {
  position: relative;
  border-radius: 24px;
  padding: 24px 28px;
  min-height: 330px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
  backdrop-filter: blur(18px);
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.45);
  transition: transform 0.3s, box-shadow 0.3s;
}
.cmp-weather-card:hover {
  transform: translateY(-3px);
}

.cmp-card-a {
  background: rgba(8, 20, 46, 0.9);
  border: 1.5px solid rgba(56, 189, 248, 0.5);
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.45), 0 0 35px rgba(56, 189, 248, 0.18);
}
.cmp-card-a:hover {
  border-color: rgba(56, 189, 248, 0.85);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55), 0 0 50px rgba(56, 189, 248, 0.3);
}

/* Weather Card B (Bandung - Purple Glowing Accent) */
.cmp-card-b {
  background: rgba(14, 18, 44, 0.9);
  border: 1.5px solid rgba(168, 85, 247, 0.5);
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.45), 0 0 35px rgba(168, 85, 247, 0.18);
}
.cmp-card-b:hover {
  border-color: rgba(168, 85, 247, 0.85);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55), 0 0 50px rgba(168, 85, 247, 0.3);
}

/* Landmark Skyline Photo Backdrop Overlay - Vividly Masked from Right */
.cmp-landmark-backdrop {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 58%;
  background-size: cover;
  background-position: center right;
  opacity: 0.65;
  mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.45) 30%, black 80%);
  -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.45) 30%, black 80%);
  pointer-events: none;
  z-index: 0;
  border-top-right-radius: 24px;
  border-bottom-right-radius: 24px;
  transition: opacity 0.5s ease, background-image 0.5s ease;
}

/* Card Header (City & Condition) */
.cmp-card-top {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.cmp-card-city-box {
  display: flex;
  align-items: center;
  gap: 12px;
}
.cmp-card-pin-icon {
  font-size: 26px;
  color: #38BDF8;
  filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.6));
}
.cmp-card-b .cmp-card-pin-icon {
  color: #C084FC;
  filter: drop-shadow(0 0 10px rgba(168, 85, 247, 0.6));
}

.cmp-card-city-name {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 26px;
  font-weight: 800;
  color: #fff;
  line-height: 1.1;
}
.cmp-card-city-sub {
  font-size: 12px;
  color: #94A3B8;
  font-weight: 500;
  margin-top: 2px;
}

/* Condition Pill matching reference screenshot */
.cmp-cond-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 14px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 700;
  backdrop-filter: blur(10px);
}
.cmp-card-a .cmp-cond-pill {
  background: rgba(16, 185, 129, 0.18);
  border: 1px solid rgba(52, 211, 153, 0.45);
  color: #34D399;
}
.cmp-card-b .cmp-cond-pill {
  background: rgba(148, 163, 184, 0.18);
  border: 1px solid rgba(148, 163, 184, 0.4);
  color: #F1F5F9;
}

/* Center Temperature & 3D Illustration with floating micro-animation */
.cmp-card-mid {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  gap: 20px;
  margin: 18px 0;
}
.cmp-weather-art {
  width: 78px;
  height: 78px;
  display: flex;
  align-items: center;
  justify-content: center;
  filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.5));
  animation: cmpWeatherFloat 4s ease-in-out infinite;
}
@keyframes cmpWeatherFloat {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-5px); }
}

.cmp-temp-large {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 58px;
  font-weight: 800;
  color: #fff;
  line-height: 1;
  text-shadow: 0 4px 22px rgba(0, 0, 0, 0.55);
  letter-spacing: -0.03em;
}
.cmp-feels-like {
  font-size: 13px;
  color: #94A3B8;
  font-weight: 600;
  margin-top: 5px;
}

/* Bottom 4-Grid Metrics Bar */
.cmp-card-bottom-grid {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 8px;
  padding: 12px 14px;
  border-radius: 16px;
  background: rgba(6, 16, 36, 0.75);
  border: 1px solid rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(12px);
}
.cmp-metric-cell {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.cmp-metric-head {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10.5px;
  color: #8FA3BF;
  font-weight: 600;
}
.cmp-metric-head i {
  color: #38BDF8;
  font-size: 11px;
}
.cmp-card-b .cmp-metric-head i {
  color: #C084FC;
}
.cmp-metric-val {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 13px;
  font-weight: 800;
  color: #fff;
  white-space: nowrap;
}

/* ========================================================
   4. DETAIL MATRIKS KOMPARASI CUACA & QUOTE CARD (ROW)
   ======================================================== */
.cmp-bottom-split-row {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 22px;
  align-items: stretch;
}

/* Matrix Table Card */
.cmp-matrix-card {
  position: relative;
  border-radius: 24px;
  background: rgba(8, 20, 44, 0.88);
  border: 1.5px solid rgba(56, 189, 248, 0.25);
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(16px);
  padding: 24px 28px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.cmp-matrix-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
  flex-wrap: wrap;
  gap: 12px;
}
.cmp-matrix-title {
  display: flex;
  align-items: center;
  gap: 12px;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 18px;
  font-weight: 800;
  color: #fff;
  margin: 0;
}
.cmp-matrix-title i {
  color: #38BDF8;
  font-size: 20px;
}

/* Expand / Filter button for parameters */
.cmp-matrix-toggle-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #94A3B8;
  padding: 5px 12px;
  border-radius: 999px;
  font-size: 11.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}
.cmp-matrix-toggle-btn:hover {
  background: rgba(56, 189, 248, 0.15);
  border-color: rgba(56, 189, 248, 0.35);
  color: #fff;
}

/* Matrix Table */
.cmp-matrix-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

.cmp-th {
  padding: 10px 14px;
  font-size: 11.5px;
  font-weight: 700;
  color: #8FA3BF;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.cmp-th.th-city-a {
  color: #38BDF8;
  font-size: 13px;
}
.cmp-th.th-city-b {
  color: #C084FC;
  font-size: 13px;
}

.cmp-tr {
  transition: background 0.2s;
}
.cmp-tr:hover {
  background: rgba(56, 189, 248, 0.05);
}
.cmp-td {
  padding: 13px 14px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  font-size: 13px;
}
.cmp-td-param {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 600;
  color: #E2E8F0;
}
.cmp-td-param i {
  width: 18px;
  text-align: center;
  font-size: 14px;
  color: #38BDF8;
}

.cmp-td-val-a {
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 800;
  font-size: 14.5px;
  color: #38BDF8;
}
.cmp-td-val-b {
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 800;
  font-size: 14.5px;
  color: #C084FC;
}

/* Perbandingan Cell with Green Trend & Green Badge */
.cmp-td-comp-wrap {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.cmp-comp-text {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 12.5px;
  color: #E2E8F0;
}
.cmp-comp-text i {
  color: #4ADE80;
  font-size: 13px;
}

.cmp-comp-pill {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 4px 10px;
  border-radius: 8px;
  font-family: 'Space Grotesk', sans-serif;
  font-size: 12.5px;
  font-weight: 800;
  background: rgba(34, 197, 94, 0.16);
  border: 1px solid rgba(34, 197, 94, 0.4);
  color: #4ADE80;
  white-space: nowrap;
}
.cmp-comp-pill.pill-alt {
  background: rgba(56, 189, 248, 0.16);
  border-color: rgba(56, 189, 248, 0.4);
  color: #38BDF8;
}
.cmp-comp-pill.pill-warn {
  background: rgba(245, 158, 11, 0.16);
  border-color: rgba(245, 158, 11, 0.4);
  color: #FBBF24;
}

/* ========================================================
   5. SHOWCASE MONAS QUOTE CARD (RIGHT BOTTOM)
   ======================================================== */
.cmp-showcase-card {
  position: relative;
  border-radius: 24px;
  background: linear-gradient(145deg, rgba(8, 24, 56, 0.92) 0%, rgba(12, 16, 40, 0.94) 100%);
  border: 1.5px solid rgba(56, 189, 248, 0.3);
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(16px);
  padding: 22px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
}

.cmp-showcase-top {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  position: relative;
  z-index: 2;
}
.cmp-showcase-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 10.5px;
  color: #8FA3BF;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
}

/* Glowing Neon Monas Silhouette Vector Art */
.cmp-showcase-art {
  position: absolute;
  left: 18px;
  bottom: 12px;
  width: 140px;
  height: 200px;
  pointer-events: none;
  z-index: 1;
  opacity: 0.9;
}

/* Handwriting Quote in Card matching reference screenshot */
.cmp-showcase-quote-box {
  position: relative;
  z-index: 2;
  text-align: right;
  margin-top: auto;
  margin-bottom: auto;
  padding-left: 100px;
}
.cmp-showcase-quote {
  font-family: 'Caveat', cursive;
  font-size: 26px;
  font-weight: 700;
  line-height: 1.25;
  color: #F1F5F9;
  text-shadow: 0 4px 18px rgba(0, 0, 0, 0.9);
  letter-spacing: 0.2px;
}

/* Floating Toast Notification */
.cmp-toast-container {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
  pointer-events: none;
}
.cmp-toast {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 12px 24px;
  border-radius: 999px;
  background: rgba(10, 25, 52, 0.95);
  border: 1.5px solid #38BDF8;
  color: #fff;
  font-size: 13.5px;
  font-weight: 700;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 20px rgba(56, 189, 248, 0.4);
  backdrop-filter: blur(16px);
  pointer-events: auto;
}
.cmp-toast i {
  color: #38BDF8;
  font-size: 16px;
}
.toast-fade-enter-active, .toast-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.toast-fade-enter-from, .toast-fade-leave-to {
  opacity: 0;
  transform: translateY(20px) scale(0.92);
}

/* ========================================================
   6. MODE 2: BMKG VS AI ENSEMBLE
   ======================================================== */
.cmp-models-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* ========================================================
   RESPONSIVE DESIGN BREAKPOINTS
   ======================================================== */
@media (max-width: 1100px) {
  .cmp-cards-container {
    grid-template-columns: 1fr;
  }
  .cmp-vs-center-orb {
    display: none;
  }
  .cmp-bottom-split-row {
    grid-template-columns: 1fr;
  }
}
@media (max-width: 900px) {
  .cmp-selector-strip {
    border-radius: 24px;
    flex-direction: column;
    align-items: stretch;
  }
  .cmp-vs-circle-sm {
    align-self: center;
  }
}
@media (max-width: 768px) {
  .cmp-card-bottom-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .cmp-matrix-table {
    display: block;
    overflow-x: auto;
  }
}
</style>
@endpush

@section('content')
<!-- Ambient Atmospheric Background -->
<div class="cmp-viewport-bg" aria-hidden="true"></div>
<div class="cmp-stardust" aria-hidden="true"></div>
<div class="cmp-header-mountain-vista" aria-hidden="true"></div>

<div id="cmp-app" v-cloak>
  <div class="cmp-shell">

    <!-- ==================== 1. PAGE HEADER ROW ==================== -->
    <header class="cmp-header-bar">
      <div class="cmp-title-box">
        <div class="cmp-title-top">
          <h1 class="cmp-main-heading">
            <i class="fas fa-scale-balanced"></i>
            <span>Compare <span class="cmp-heading-grad">Prediksi Cuaca</span></span>
          </h1>
          <span class="cmp-badge-official">
            <span class="live-dot"></span> BMKG Official vs AI
          </span>
        </div>
        <p class="cmp-subtitle">
          Bandingkan kondisi cuaca di dua lokasi secara langsung
        </p>
      </div>

      <!-- Mode Switch Buttons -->
      <div class="cmp-mode-group">
        <button
          class="cmp-mode-btn"
          :class="{ active: mode === 'cities' }"
          @click="mode = 'cities'"
        >
          <i class="fas fa-location-dot"></i>
          <span>Antar Lokasi</span>
        </button>
        <button
          class="cmp-mode-btn"
          :class="{ active: mode === 'models' }"
          @click="mode = 'models'"
        >
          <i class="fas fa-robot"></i>
          <span>BMKG vs AI Ensemble</span>
        </button>
      </div>
    </header>

    <!-- ==================== MODE 1: ANTAR LOKASI ==================== -->
    <div v-if="mode === 'cities'" style="display:flex;flex-direction:column;gap:22px;">

      <!-- 2. LOCATION SELECTOR STRIP -->
      <div class="cmp-selector-strip">
        <!-- Lokasi A -->
        <div class="cmp-sel-group">
          <div class="cmp-sel-label">
            <i class="fas fa-location-dot"></i>
            <span>LOKASI A</span>
          </div>
          <div class="cmp-select-wrapper">
            <select class="cmp-select" v-model="cityA" @change="loadCompare">
              <optgroup label="Metropolitan / Populer">
                <option value="jakarta">DKI Jakarta</option>
                <option value="bandung">Kota Bandung</option>
                <option value="surabaya">Kota Surabaya</option>
                <option value="semarang">Kota Semarang</option>
                <option value="yogyakarta">Kota Yogyakarta</option>
                <option value="denpasar">Kota Denpasar (Bali)</option>
                <option value="medan">Kota Medan</option>
                <option value="makassar">Kota Makassar</option>
              </optgroup>
              <optgroup label="Jawa Barat (Prioritas Regional)">
                <option value="bogor">Kota Bogor</option>
                <option value="bekasi">Kota Bekasi</option>
                <option value="depok">Kota Depok</option>
                <option value="cirebon">Kota Cirebon</option>
                <option value="sukabumi">Kota Sukabumi</option>
                <option value="lembang">Lembang, Bandung Barat</option>
                <option value="ciwidey">Ciwidey, Kab. Bandung</option>
                <option value="garut">Tarogong, Garut</option>
                <option value="cianjur">Kab. Cianjur</option>
                <option value="karawang">Kab. Karawang</option>
              </optgroup>
            </select>
            <i class="fas fa-chevron-down cmp-select-arrow"></i>
          </div>
        </div>

        <!-- Center VS Circle (Clickable to Swap!) -->
        <div class="cmp-vs-circle-sm" @click="swapLocations" title="Tukar Posisi (Swap Locations)">
          VS
        </div>

        <!-- Lokasi B -->
        <div class="cmp-sel-group">
          <div class="cmp-sel-label label-b">
            <i class="fas fa-location-dot"></i>
            <span>LOKASI B</span>
          </div>
          <div class="cmp-select-wrapper wrap-b">
            <select class="cmp-select" v-model="cityB" @change="loadCompare">
              <optgroup label="Metropolitan / Populer">
                <option value="bandung">Kota Bandung</option>
                <option value="jakarta">DKI Jakarta</option>
                <option value="surabaya">Kota Surabaya</option>
                <option value="semarang">Kota Semarang</option>
                <option value="yogyakarta">Kota Yogyakarta</option>
                <option value="denpasar">Kota Denpasar (Bali)</option>
                <option value="medan">Kota Medan</option>
                <option value="makassar">Kota Makassar</option>
              </optgroup>
              <optgroup label="Jawa Barat (Prioritas Regional)">
                <option value="bogor">Kota Bogor</option>
                <option value="bekasi">Kota Bekasi</option>
                <option value="depok">Kota Depok</option>
                <option value="cirebon">Kota Cirebon</option>
                <option value="sukabumi">Kota Sukabumi</option>
                <option value="lembang">Lembang, Bandung Barat</option>
                <option value="ciwidey">Ciwidey, Kab. Bandung</option>
                <option value="garut">Tarogong, Garut</option>
                <option value="cianjur">Kab. Cianjur</option>
                <option value="karawang">Kab. Karawang</option>
              </optgroup>
            </select>
            <i class="fas fa-chevron-down cmp-select-arrow"></i>
          </div>
        </div>

        <!-- Refresh Button -->
        <button class="cmp-refresh-btn" @click="handleRefresh">
          <i class="fas fa-rotate" :class="{ spin: refreshing }"></i>
          <span>Refresh Data</span>
        </button>
      </div>

      <!-- Quick Comparison Presets Bar -->
      <div class="cmp-presets-bar">
        <span class="cmp-preset-label"><i class="fas fa-bolt" style="color:#F59E0B;"></i> Komparasi Cepat:</span>
        <button class="cmp-preset-pill" :class="{ active: cityA==='jakarta' && cityB==='bandung' }" @click="setPreset('jakarta', 'bandung')">
          Jakarta vs Bandung
        </button>
        <button class="cmp-preset-pill" :class="{ active: cityA==='bandung' && cityB==='lembang' }" @click="setPreset('bandung', 'lembang')">
          Bandung vs Lembang
        </button>
        <button class="cmp-preset-pill" :class="{ active: cityA==='bogor' && cityB==='bekasi' }" @click="setPreset('bogor', 'bekasi')">
          Bogor vs Bekasi
        </button>
        <button class="cmp-preset-pill" :class="{ active: cityA==='cirebon' && cityB==='garut' }" @click="setPreset('cirebon', 'garut')">
          Cirebon vs Garut
        </button>
        <button class="cmp-preset-pill" :class="{ active: cityA==='jakarta' && cityB==='surabaya' }" @click="setPreset('jakarta', 'surabaya')">
          Jakarta vs Surabaya
        </button>
      </div>

      <!-- 3. SIDE-BY-SIDE MAIN WEATHER CARDS WITH FLOATING VS -->
      <div class="cmp-cards-container" :class="{ 'is-swapping': isSwapping }">

        <!-- Center Floating VS Badge (Clickable to swap!) -->
        <div class="cmp-vs-center-orb" @click="swapLocations" title="Klik untuk tukar lokasi">
          VS
        </div>

        <!-- ================= CARD A: LOKASI A (JAKARTA) ================= -->
        <article class="cmp-weather-card cmp-card-a">
          <!-- Landmark Backdrop -->
          <div
            class="cmp-landmark-backdrop"
            :style="{ backgroundImage: 'url(' + getLandmarkImage(cityA) + ')' }"
          ></div>

          <!-- Top Row -->
          <div class="cmp-card-top">
            <div class="cmp-card-city-box">
              <i class="fas fa-location-dot cmp-card-pin-icon"></i>
              <div>
                <h2 class="cmp-card-city-name" v-text="dataA.displayName || 'Jakarta'"></h2>
                <div class="cmp-card-city-sub" v-text="dataA.province || 'DKI Jakarta'"></div>
              </div>
            </div>
            <div class="cmp-cond-pill">
              <span v-html="dataA.condIcon || '🌧️'"></span>
              <span v-text="dataA.weather || 'Hujan Ringan'"></span>
            </div>
          </div>

          <!-- Mid Row: Weather Art & Temperature -->
          <div class="cmp-card-mid">
            <div class="cmp-weather-art" v-html="dataA.weatherArt"></div>
            <div>
              <div class="cmp-temp-large" v-text="dataA.temperature + '°C'"></div>
              <div class="cmp-feels-like">Terasa <span v-text="dataA.feels_like + '°C'"></span></div>
            </div>
          </div>

          <!-- Bottom 4-Grid Metrics Bar -->
          <div class="cmp-card-bottom-grid">
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-droplet"></i>
                <span>Kelembapan</span>
              </div>
              <div class="cmp-metric-val" v-text="dataA.humidity + '%'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-wind"></i>
                <span>Angin</span>
              </div>
              <div class="cmp-metric-val" v-text="dataA.windSpeed + ' km/jam (' + dataA.windDirection + ')'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-gauge-high"></i>
                <span>Tekanan Udara</span>
              </div>
              <div class="cmp-metric-val" v-text="dataA.pressure + ' hPa'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-eye"></i>
                <span>Jarak Pandang</span>
              </div>
              <div class="cmp-metric-val" v-text="dataA.visibility + ' km'"></div>
            </div>
          </div>
        </article>

        <!-- ================= CARD B: LOKASI B (BANDUNG) ================= -->
        <article class="cmp-weather-card cmp-card-b">
          <!-- Landmark Backdrop -->
          <div
            class="cmp-landmark-backdrop"
            :style="{ backgroundImage: 'url(' + getLandmarkImage(cityB) + ')' }"
          ></div>

          <!-- Top Row -->
          <div class="cmp-card-top">
            <div class="cmp-card-city-box">
              <i class="fas fa-location-dot cmp-card-pin-icon"></i>
              <div>
                <h2 class="cmp-card-city-name" v-text="dataB.displayName || 'Bandung'"></h2>
                <div class="cmp-card-city-sub" v-text="dataB.province || 'Jawa Barat'"></div>
              </div>
            </div>
            <div class="cmp-cond-pill">
              <span v-html="dataB.condIcon || '☁️'"></span>
              <span v-text="dataB.weather || 'Berawan Tebal'"></span>
            </div>
          </div>

          <!-- Mid Row: Weather Art & Temperature -->
          <div class="cmp-card-mid">
            <div class="cmp-weather-art" v-html="dataB.weatherArt"></div>
            <div>
              <div class="cmp-temp-large" v-text="dataB.temperature + '°C'"></div>
              <div class="cmp-feels-like">Terasa <span v-text="dataB.feels_like + '°C'"></span></div>
            </div>
          </div>

          <!-- Bottom 4-Grid Metrics Bar -->
          <div class="cmp-card-bottom-grid">
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-droplet"></i>
                <span>Kelembapan</span>
              </div>
              <div class="cmp-metric-val" v-text="dataB.humidity + '%'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-wind"></i>
                <span>Angin</span>
              </div>
              <div class="cmp-metric-val" v-text="dataB.windSpeed + ' km/jam (' + dataB.windDirection + ')'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-gauge-high"></i>
                <span>Tekanan Udara</span>
              </div>
              <div class="cmp-metric-val" v-text="dataB.pressure + ' hPa'"></div>
            </div>
            <div class="cmp-metric-cell">
              <div class="cmp-metric-head">
                <i class="fas fa-eye"></i>
                <span>Jarak Pandang</span>
              </div>
              <div class="cmp-metric-val" v-text="dataB.visibility + ' km'"></div>
            </div>
          </div>
        </article>

      </div>

      <!-- 4. DETAIL MATRIKS KOMPARASI CUACA & SHOWCASE CARD (SPLIT ROW) -->
      <div class="cmp-bottom-split-row">

        <!-- Left Table Matrix -->
        <section class="cmp-matrix-card">
          <div class="cmp-matrix-header">
            <h3 class="cmp-matrix-title">
              <i class="fas fa-chart-line"></i>
              <span>Detail Matriks Komparasi Cuaca</span>
            </h3>
            <button class="cmp-matrix-toggle-btn" @click="showMoreParams = !showMoreParams">
              <i :class="showMoreParams ? 'fas fa-compress' : 'fas fa-sliders'"></i>
              <span v-text="showMoreParams ? 'Ringkas Tabel' : 'Parameter Lengkap'"></span>
            </button>
          </div>

          <table class="cmp-matrix-table">
            <thead>
              <tr>
                <th class="cmp-th" style="width:200px;">Parameter</th>
                <th class="cmp-th th-city-a">
                  <span v-html="dataA.condIcon || '☀️'"></span>
                  <span style="margin-left:6px;" v-text="dataA.displayName || 'Jakarta'"></span>
                </th>
                <th class="cmp-th th-city-b">
                  <span v-html="dataB.condIcon || '☁️'"></span>
                  <span style="margin-left:6px;" v-text="dataB.displayName || 'Bandung'"></span>
                </th>
                <th class="cmp-th" style="width:280px;">
                  <i class="fas fa-chart-simple" style="color:#38BDF8;margin-right:6px;"></i>
                  Perbandingan
                </th>
              </tr>
            </thead>
            <tbody>
              <!-- Row 1: Suhu Udara -->
              <tr class="cmp-tr">
                <td class="cmp-td">
                  <div class="cmp-td-param">
                    <i class="fas fa-temperature-half"></i>
                    <span>Suhu Udara</span>
                  </div>
                </td>
                <td class="cmp-td cmp-td-val-a" v-text="dataA.temperature + '°C'"></td>
                <td class="cmp-td cmp-td-val-b" v-text="dataB.temperature + '°C'"></td>
                <td class="cmp-td">
                  <div class="cmp-td-comp-wrap" v-if="dataA.temperature >= dataB.temperature">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataA.displayName + ' lebih hangat'"></span>
                    </span>
                    <span class="cmp-comp-pill">
                      <i class="fas fa-arrow-up"></i> +@{{ (dataA.temperature - dataB.temperature).toFixed(1) }}°C
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else>
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataB.displayName + ' lebih hangat'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-alt">
                      <i class="fas fa-arrow-up"></i> +@{{ (dataB.temperature - dataA.temperature).toFixed(1) }}°C
                    </span>
                  </div>
                </td>
              </tr>

              <!-- Row 2: Kelembapan Udara -->
              <tr class="cmp-tr">
                <td class="cmp-td">
                  <div class="cmp-td-param">
                    <i class="fas fa-droplet"></i>
                    <span>Kelembapan Udara</span>
                  </div>
                </td>
                <td class="cmp-td cmp-td-val-a" v-text="dataA.humidity + '%'"></td>
                <td class="cmp-td cmp-td-val-b" v-text="dataB.humidity + '%'"></td>
                <td class="cmp-td">
                  <div class="cmp-td-comp-wrap" v-if="dataA.humidity >= dataB.humidity">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataA.displayName + ' lebih lembap'"></span>
                    </span>
                    <span class="cmp-comp-pill">
                      <i class="fas fa-arrow-up"></i> +@{{ dataA.humidity - dataB.humidity }}%
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else>
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataB.displayName + ' lebih lembap'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-alt">
                      <i class="fas fa-arrow-up"></i> +@{{ dataB.humidity - dataA.humidity }}%
                    </span>
                  </div>
                </td>
              </tr>

              <!-- Row 3: Kecepatan Angin -->
              <tr class="cmp-tr">
                <td class="cmp-td">
                  <div class="cmp-td-param">
                    <i class="fas fa-wind"></i>
                    <span>Kecepatan Angin</span>
                  </div>
                </td>
                <td class="cmp-td cmp-td-val-a" v-text="dataA.windSpeed + ' km/jam'"></td>
                <td class="cmp-td cmp-td-val-b" v-text="dataB.windSpeed + ' km/jam'"></td>
                <td class="cmp-td">
                  <div class="cmp-td-comp-wrap" v-if="dataA.windSpeed >= dataB.windSpeed">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataA.displayName + ' lebih kencang'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-warn">
                      <i class="fas fa-arrow-up"></i> +@{{ (dataA.windSpeed - dataB.windSpeed).toFixed(1) }} km/h
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else>
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataB.displayName + ' lebih kencang'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-warn">
                      <i class="fas fa-arrow-up"></i> +@{{ (dataB.windSpeed - dataA.windSpeed).toFixed(1) }} km/h
                    </span>
                  </div>
                </td>
              </tr>

              <!-- Row 4: Tekanan Udara -->
              <tr class="cmp-tr">
                <td class="cmp-td">
                  <div class="cmp-td-param">
                    <i class="fas fa-gauge-high"></i>
                    <span>Tekanan Udara</span>
                  </div>
                </td>
                <td class="cmp-td cmp-td-val-a" v-text="dataA.pressure + ' hPa'"></td>
                <td class="cmp-td cmp-td-val-b" v-text="dataB.pressure + ' hPa'"></td>
                <td class="cmp-td">
                  <div class="cmp-td-comp-wrap" v-if="dataA.pressure > dataB.pressure">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataA.displayName + ' lebih tinggi'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-alt">
                      <i class="fas fa-arrow-up"></i> +@{{ dataA.pressure - dataB.pressure }} hPa
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else-if="dataB.pressure > dataA.pressure">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataB.displayName + ' lebih tinggi'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-alt">
                      <i class="fas fa-arrow-up"></i> +@{{ dataB.pressure - dataA.pressure }} hPa
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else>
                    <span class="cmp-comp-text">
                      <i class="fas fa-equals" style="color:#94A3B8;"></i>
                      <span>Tekanan seimbang</span>
                    </span>
                    <span class="cmp-comp-pill" style="color:#94A3B8;border-color:rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);">
                      0 hPa
                    </span>
                  </div>
                </td>
              </tr>

              <!-- Row 5: Jarak Pandang -->
              <tr class="cmp-tr">
                <td class="cmp-td">
                  <div class="cmp-td-param">
                    <i class="fas fa-eye"></i>
                    <span>Jarak Pandang</span>
                  </div>
                </td>
                <td class="cmp-td cmp-td-val-a" v-text="dataA.visibility + ' km'"></td>
                <td class="cmp-td cmp-td-val-b" v-text="dataB.visibility + ' km'"></td>
                <td class="cmp-td">
                  <div class="cmp-td-comp-wrap" v-if="dataA.visibility >= dataB.visibility">
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataA.displayName + ' lebih bersih'"></span>
                    </span>
                    <span class="cmp-comp-pill">
                      <i class="fas fa-arrow-up"></i> +@{{ dataA.visibility - dataB.visibility }} km
                    </span>
                  </div>
                  <div class="cmp-td-comp-wrap" v-else>
                    <span class="cmp-comp-text">
                      <i class="fas fa-arrow-trend-up"></i>
                      <span v-text="dataB.displayName + ' lebih bersih'"></span>
                    </span>
                    <span class="cmp-comp-pill pill-alt">
                      <i class="fas fa-arrow-up"></i> +@{{ dataB.visibility - dataA.visibility }} km
                    </span>
                  </div>
                </td>
              </tr>

              <!-- Optional Expanded Rows (Peluang Hujan, Indeks UV, AQI) -->
              <template v-if="showMoreParams">
                <!-- Row 6: Peluang Hujan -->
                <tr class="cmp-tr">
                  <td class="cmp-td">
                    <div class="cmp-td-param">
                      <i class="fas fa-cloud-showers-heavy"></i>
                      <span>Peluang Hujan</span>
                    </div>
                  </td>
                  <td class="cmp-td cmp-td-val-a" v-text="(dataA.rainChance || 70) + '%'"></td>
                  <td class="cmp-td cmp-td-val-b" v-text="(dataB.rainChance || 30) + '%'"></td>
                  <td class="cmp-td">
                    <div class="cmp-td-comp-wrap">
                      <span class="cmp-comp-text">
                        <i class="fas fa-arrow-trend-up"></i>
                        <span v-text="(dataA.rainChance || 70) >= (dataB.rainChance || 30) ? dataA.displayName + ' lebih rawan hujan' : dataB.displayName + ' lebih rawan hujan'"></span>
                      </span>
                      <span class="cmp-comp-pill pill-warn">
                        <i class="fas fa-arrow-up"></i> +@{{ Math.abs((dataA.rainChance || 70) - (dataB.rainChance || 30)) }}%
                      </span>
                    </div>
                  </td>
                </tr>

                <!-- Row 7: Indeks UV -->
                <tr class="cmp-tr">
                  <td class="cmp-td">
                    <div class="cmp-td-param">
                      <i class="fas fa-sun"></i>
                      <span>Indeks UV</span>
                    </div>
                  </td>
                  <td class="cmp-td cmp-td-val-a" v-text="(dataA.uvIndex || 6) + ' (Sedang)'"></td>
                  <td class="cmp-td cmp-td-val-b" v-text="(dataB.uvIndex || 4) + ' (Rendah)'"></td>
                  <td class="cmp-td">
                    <div class="cmp-td-comp-wrap">
                      <span class="cmp-comp-text">
                        <i class="fas fa-arrow-trend-up"></i>
                        <span v-text="(dataA.uvIndex || 6) >= (dataB.uvIndex || 4) ? dataA.displayName + ' radiasi lebih tinggi' : dataB.displayName + ' radiasi lebih tinggi'"></span>
                      </span>
                      <span class="cmp-comp-pill">
                        +@{{ Math.abs((dataA.uvIndex || 6) - (dataB.uvIndex || 4)) }} UV
                      </span>
                    </div>
                  </td>
                </tr>

                <!-- Row 8: Kualitas Udara (AQI) -->
                <tr class="cmp-tr">
                  <td class="cmp-td">
                    <div class="cmp-td-param">
                      <i class="fas fa-smog"></i>
                      <span>Kualitas Udara (AQI)</span>
                    </div>
                  </td>
                  <td class="cmp-td cmp-td-val-a" v-text="'AQI ' + (dataA.aqi || 128)"></td>
                  <td class="cmp-td cmp-td-val-b" v-text="'AQI ' + (dataB.aqi || 62)"></td>
                  <td class="cmp-td">
                    <div class="cmp-td-comp-wrap">
                      <span class="cmp-comp-text">
                        <i class="fas fa-shield-heart" style="color:#4ADE80;"></i>
                        <span v-text="(dataA.aqi || 128) < (dataB.aqi || 62) ? dataA.displayName + ' lebih bersih' : dataB.displayName + ' lebih bersih'"></span>
                      </span>
                      <span class="cmp-comp-pill">
                        Lebih Segar
                      </span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </section>

        <!-- Right Showcase Card with Neon Monas & Handwriting Quote -->
        <aside class="cmp-showcase-card">
          <div class="cmp-showcase-top">
            <button class="cmp-showcase-badge" style="cursor:pointer;" @click="copyComparisonSummary" title="Salin ringkasan ke clipboard">
              <i class="fas fa-share-nodes" style="color:#38BDF8;"></i>
              <span>Bagikan</span>
            </button>
            <span class="cmp-showcase-badge">
              <i class="far fa-calendar-alt" style="color:#38BDF8;"></i>
              <span>Data terbaru</span>
            </span>
          </div>

          <!-- Glowing Neon Monas Silhouette Vector -->
          <div class="cmp-showcase-art">
            <svg viewBox="0 0 120 220" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="monasGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#38BDF8"/>
                  <stop offset="60%" stop-color="#0284C7"/>
                  <stop offset="100%" stop-color="#1E3A8A"/>
                </linearGradient>
                <filter id="neonGlow" x="-20%" y="-20%" width="140%" height="140%">
                  <feGaussianBlur stdDeviation="3" result="blur" />
                  <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
              </defs>

              <!-- Base Pedestal -->
              <rect x="25" y="195" width="70" height="8" rx="3" fill="url(#monasGrad)" opacity="0.8" />
              <rect x="35" y="185" width="50" height="10" rx="2" fill="url(#monasGrad)" opacity="0.9" />
              
              <!-- Cawan / Chalice Base -->
              <path d="M40 185 L44 140 L76 140 L80 185 Z" fill="url(#monasGrad)" opacity="0.95" />
              <rect x="42" y="137" width="36" height="4" rx="1.5" fill="#38BDF8" filter="url(#neonGlow)" />

              <!-- Tall Obelisk Spire -->
              <polygon points="56,38 64,38 67,137 53,137" fill="url(#monasGrad)" />
              <line x1="60" y1="38" x2="60" y2="137" stroke="#38BDF8" stroke-width="1.2" opacity="0.7" />

              <!-- Flame Tip (Lidah Api Kemerdekaan) with Golden-Cyan Glow -->
              <path d="M60 16 Q66 26 63 38 Q60 38 57 38 Q54 26 60 16 Z" fill="#FCD34D" filter="url(#neonGlow)" />
              <circle cx="60" cy="24" r="5" fill="#38BDF8" opacity="0.75" filter="url(#neonGlow)" />
              
              <!-- Ground Base Arc -->
              <path d="M15 210 Q60 198 105 210" stroke="#38BDF8" stroke-width="1.5" fill="none" opacity="0.4" />
            </svg>
          </div>

          <!-- Quote Section in handwriting cursive style -->
          <div class="cmp-showcase-quote-box">
            <div class="cmp-showcase-quote">
              &ldquo;Cuaca berbeda,<br>tetap satu langit&rdquo;
            </div>
          </div>
        </aside>

      </div>

    </div>

    <!-- Toast Notification Container -->
    <div class="cmp-toast-container">
      <transition name="toast-fade">
        <div v-if="toast.show" class="cmp-toast">
          <i :class="toast.icon"></i>
          <span v-text="toast.message"></span>
        </div>
      </transition>
    </div>

    <!-- ==================== MODE 2: BMKG VS AI ENSEMBLE ==================== -->
    <div v-if="mode === 'models'" class="cmp-models-container">
      <div class="cmp-matrix-card">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
          <div>
            <h3 style="font-size:20px;font-weight:900;color:#fff;display:flex;align-items:center;gap:10px;">
              <i class="fas fa-brain" style="color:#A78BFA;"></i> Evaluasi Akurasi Prediksi: BMKG vs AI Ensemble
            </h3>
            <p style="font-size:12.5px;color:#94A3B8;margin-top:4px;">
              Perbandingan prakiraan cuaca resmi BMKG dengan model jaringan saraf WeatherLive AI Ensemble v2.4
            </p>
          </div>
          <div style="display:flex;gap:10px;">
            <span class="cmp-badge-official"><span class="live-dot"></span> Akurasi BMKG: 96.4%</span>
            <span class="cmp-badge-official" style="background:rgba(167,139,250,0.16);border-color:rgba(167,139,250,0.35);color:#C4B5FD;">
              <i class="fas fa-microchip"></i> Confidence AI: 94.8%
            </span>
          </div>
        </div>

        <!-- 3 Metric Cards -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px;">
          <div style="padding:18px;border-radius:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);text-align:center;">
            <div style="font-size:11px;color:#8FA3BF;font-weight:700;text-transform:uppercase;">Rata-Rata Deviasi (MAE)</div>
            <div style="font-size:32px;font-weight:900;color:#38BDF8;font-family:'Space Grotesk';margin-top:6px;">0.42°C</div>
            <div style="font-size:11px;color:#64748B;margin-top:2px;">Selisih rata-rata BMKG vs AI</div>
          </div>
          <div style="padding:18px;border-radius:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);text-align:center;">
            <div style="font-size:11px;color:#8FA3BF;font-weight:700;text-transform:uppercase;">RMSE Kelembapan</div>
            <div style="font-size:32px;font-weight:900;color:#4ADE80;font-family:'Space Grotesk';margin-top:6px;">2.1%</div>
            <div style="font-size:11px;color:#64748B;margin-top:2px;">Root Mean Square Error</div>
          </div>
          <div style="padding:18px;border-radius:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);text-align:center;">
            <div style="font-size:11px;color:#8FA3BF;font-weight:700;text-transform:uppercase;">Tingkat Keselarasan</div>
            <div style="font-size:32px;font-weight:900;color:#FACC15;font-family:'Space Grotesk';margin-top:6px;">98.2%</div>
            <div style="font-size:11px;color:#64748B;margin-top:2px;">Kesesuaian Jenis Cuaca</div>
          </div>
        </div>

        <!-- Comparative Chart -->
        <div style="position:relative;background:rgba(255,255,255,0.02);border-radius:18px;padding:20px;border:1px solid rgba(255,255,255,0.06);height:320px;margin-bottom:24px;">
          <canvas id="modelChartCanvas"></canvas>
        </div>

        <!-- Timeline Table -->
        <h4 style="font-size:16px;font-weight:800;color:#fff;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
          <i class="fas fa-clock" style="color:#38BDF8;"></i> Timeline Perbandingan Per 3 Jam
        </h4>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;font-size:13px;text-align:left;">
            <thead>
              <tr style="border-bottom:1px solid rgba(255,255,255,0.1);color:#8FA3BF;font-size:11px;text-transform:uppercase;">
                <th style="padding:12px 10px;">Waktu</th>
                <th style="padding:12px 10px;">Prakiraan BMKG</th>
                <th style="padding:12px 10px;">Prediksi AI Ensemble</th>
                <th style="padding:12px 10px;">Pengamatan Aktual</th>
                <th style="padding:12px 10px;text-align:right;">Deviasi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in modelTimeline" :key="i" style="border-bottom:1px solid rgba(255,255,255,0.05);">
                <td style="padding:12px 10px;font-weight:800;font-family:'Space Grotesk';color:#fff;" v-text="item.time"></td>
                <td style="padding:12px 10px;">
                  <span style="font-weight:800;color:#38BDF8;" v-text="item.bmkg_forecast.temperature + '°C'"></span>
                  <span style="color:#8FA3BF;font-size:11px;margin-left:6px;" v-text="'(' + item.bmkg_forecast.weather + ')'"></span>
                </td>
                <td style="padding:12px 10px;">
                  <span style="font-weight:800;color:#C084FC;" v-text="item.ai_prediction.temperature + '°C'"></span>
                  <span style="color:#8FA3BF;font-size:11px;margin-left:6px;" v-text="'(' + item.ai_prediction.weather + ')'"></span>
                </td>
                <td style="padding:12px 10px;">
                  <span style="font-weight:800;color:#4ADE80;" v-text="item.actual_observed.temperature + '°C'"></span>
                </td>
                <td style="padding:12px 10px;text-align:right;font-weight:800;font-family:'Space Grotesk';" :style="{ color: item.deviation < 0.5 ? '#4ADE80' : '#FACC15' }" v-text="'±' + item.deviation + '°C'"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
  'use strict';

  const { createApp, ref, onMounted, watch, nextTick } = Vue;

  createApp({
    setup() {
      const mode = ref('cities'); // 'cities' | 'models'
      const cityA = ref('jakarta');
      const cityB = ref('bandung');
      const refreshing = ref(false);
      const modelTimeline = ref([]);
      let modelChartInstance = null;

      /* City metadata, benchmarks, and landmark images */
      const cityMeta = {
        'jakarta': {
          displayName: 'Jakarta',
          province: 'DKI Jakarta',
          landmark: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1200&q=80', // Monas
          temperature: 26.0,
          feels_like: 27.3,
          humidity: 67,
          windSpeed: 18.7,
          windDirection: 'Timur',
          pressure: 1009,
          visibility: 10,
          weather: 'Hujan Ringan',
          condIcon: '🌧️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76" style="filter:drop-shadow(0 4px 14px rgba(56,189,248,0.55));">
              <circle cx="36" cy="36" r="18" fill="url(#sunGrad)" />
              <path d="M25 65 A18 18 0 0 1 55 45 A14 14 0 0 1 80 55 A15 15 0 0 1 75 75 L30 75 A15 15 0 0 1 25 65 Z" fill="url(#cloudGrad)" opacity="0.95" />
              <path d="M35 78 L30 90 M48 78 L43 90 M60 78 L55 90" stroke="#38BDF8" stroke-width="3.2" stroke-linecap="round" />
              <defs>
                <linearGradient id="sunGrad" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0%" stop-color="#FCD34D"/>
                  <stop offset="100%" stop-color="#F59E0B"/>
                </linearGradient>
                <linearGradient id="cloudGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#FFFFFF"/>
                  <stop offset="100%" stop-color="#CBD5E1"/>
                </linearGradient>
              </defs>
            </svg>
          `
        },
        'bandung': {
          displayName: 'Bandung',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1200&q=80', // Bandung
          temperature: 25.7,
          feels_like: 26.8,
          humidity: 65,
          windSpeed: 38.5,
          windDirection: 'Selatan',
          pressure: 1009,
          visibility: 8,
          weather: 'Berawan Tebal',
          condIcon: '☁️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76" style="filter:drop-shadow(0 4px 14px rgba(255,255,255,0.35));">
              <path d="M22 62 A20 20 0 0 1 54 40 A16 16 0 0 1 82 50 A18 18 0 0 1 76 74 L28 74 A18 18 0 0 1 22 62 Z" fill="url(#cloudSoftGrad)" />
              <defs>
                <linearGradient id="cloudSoftGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#FFFFFF"/>
                  <stop offset="70%" stop-color="#E2E8F0"/>
                  <stop offset="100%" stop-color="#94A3B8"/>
                </linearGradient>
              </defs>
            </svg>
          `
        },
        'bogor': {
          displayName: 'Bogor',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
          temperature: 24.2,
          feels_like: 25.0,
          humidity: 82,
          windSpeed: 12.5,
          windDirection: 'Selatan',
          pressure: 1010,
          visibility: 7,
          weather: 'Hujan Sedang',
          condIcon: '🌧️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M22 58 A18 18 0 0 1 52 38 A15 15 0 0 1 78 48 A16 16 0 0 1 74 70 L28 70 A16 16 0 0 1 22 58 Z" fill="#CBD5E1" />
              <path d="M30 76 L24 90 M44 76 L38 90 M58 76 L52 90 M70 76 L64 90" stroke="#38BDF8" stroke-width="3" stroke-linecap="round" />
            </svg>
          `
        },
        'bekasi': {
          displayName: 'Bekasi',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
          temperature: 34.6,
          feels_like: 37.2,
          humidity: 59,
          windSpeed: 16.0,
          windDirection: 'Utara',
          pressure: 1008,
          visibility: 9,
          weather: 'Cerah Berawan',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="38" cy="38" r="20" fill="#F59E0B" />
              <path d="M30 65 A16 16 0 0 1 58 48 A14 14 0 0 1 80 56 A15 15 0 0 1 76 74 L34 74 A15 15 0 0 1 30 65 Z" fill="#FFFFFF" opacity="0.92" />
            </svg>
          `
        },
        'depok': {
          displayName: 'Depok',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
          temperature: 32.6,
          feels_like: 35.0,
          humidity: 64,
          windSpeed: 14.5,
          windDirection: 'Barat Laut',
          pressure: 1008,
          visibility: 9,
          weather: 'Berawan',
          condIcon: '☁️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M22 62 A20 20 0 0 1 54 40 A16 16 0 0 1 82 50 A18 18 0 0 1 76 74 L28 74 A18 18 0 0 1 22 62 Z" fill="#E2E8F0" />
            </svg>
          `
        },
        'cirebon': {
          displayName: 'Cirebon',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
          temperature: 33.5,
          feels_like: 36.4,
          humidity: 60,
          windSpeed: 20.0,
          windDirection: 'Timur Laut',
          pressure: 1009,
          visibility: 10,
          weather: 'Cerah',
          condIcon: '☀️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="50" cy="50" r="24" fill="#F59E0B" />
              <g stroke="#FCD34D" stroke-width="4" stroke-linecap="round">
                <line x1="50" y1="12" x2="50" y2="20" />
                <line x1="50" y1="80" x2="50" y2="88" />
                <line x1="12" y1="50" x2="20" y2="50" />
                <line x1="80" y1="50" x2="88" y2="50" />
              </g>
            </svg>
          `
        },
        'sukabumi': {
          displayName: 'Sukabumi',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
          temperature: 26.8,
          feels_like: 27.5,
          humidity: 78,
          windSpeed: 10.5,
          windDirection: 'Barat Daya',
          pressure: 1010,
          visibility: 8,
          weather: 'Hujan Ringan',
          condIcon: '🌧️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M25 62 A18 18 0 0 1 55 42 A14 14 0 0 1 80 52 A15 15 0 0 1 75 72 L30 72 A15 15 0 0 1 25 62 Z" fill="#CBD5E1" />
              <path d="M35 76 L30 88 M50 76 L45 88 M65 76 L60 88" stroke="#38BDF8" stroke-width="3" stroke-linecap="round" />
            </svg>
          `
        },
        'lembang': {
          displayName: 'Lembang',
          province: 'Bandung Barat',
          landmark: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
          temperature: 17.2,
          feels_like: 16.5,
          humidity: 84,
          windSpeed: 8.5,
          windDirection: 'Utara',
          pressure: 1012,
          visibility: 6,
          weather: 'Kabut Sejuk',
          condIcon: '🌫️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M20 50 L80 50 M26 62 L74 62 M32 74 L68 74" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" />
            </svg>
          `
        },
        'ciwidey': {
          displayName: 'Ciwidey',
          province: 'Kab. Bandung',
          landmark: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
          temperature: 17.8,
          feels_like: 17.0,
          humidity: 86,
          windSpeed: 7.0,
          windDirection: 'Tenggara',
          pressure: 1012,
          visibility: 7,
          weather: 'Cerah Sejuk',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="38" cy="38" r="18" fill="#FCD34D" />
              <path d="M28 62 A16 16 0 0 1 56 46 A14 14 0 0 1 78 54 A15 15 0 0 1 74 72 L32 72 A15 15 0 0 1 28 62 Z" fill="#E2E8F0" />
            </svg>
          `
        },
        'garut': {
          displayName: 'Garut',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
          temperature: 22.0,
          feels_like: 22.8,
          humidity: 76,
          windSpeed: 9.5,
          windDirection: 'Selatan',
          pressure: 1011,
          visibility: 8,
          weather: 'Cerah Berawan',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="38" cy="38" r="18" fill="#F59E0B" />
              <path d="M28 62 A16 16 0 0 1 56 46 A14 14 0 0 1 78 54 A15 15 0 0 1 74 72 L32 72 Z" fill="#E2E8F0" />
            </svg>
          `
        },
        'cianjur': {
          displayName: 'Cianjur',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
          temperature: 27.0,
          feels_like: 28.2,
          humidity: 74,
          windSpeed: 11.0,
          windDirection: 'Barat Daya',
          pressure: 1010,
          visibility: 8,
          weather: 'Hujan Ringan',
          condIcon: '🌧️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M25 62 A18 18 0 0 1 55 42 A14 14 0 0 1 80 52 A15 15 0 0 1 75 72 L30 72 Z" fill="#CBD5E1" />
              <path d="M35 76 L30 88 M50 76 L45 88 M65 76 L60 88" stroke="#38BDF8" stroke-width="3" stroke-linecap="round" />
            </svg>
          `
        },
        'karawang': {
          displayName: 'Karawang',
          province: 'Jawa Barat',
          landmark: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
          temperature: 34.1,
          feels_like: 37.0,
          humidity: 58,
          windSpeed: 17.5,
          windDirection: 'Utara',
          pressure: 1008,
          visibility: 10,
          weather: 'Cerah',
          condIcon: '☀️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="50" cy="50" r="22" fill="#F59E0B" />
            </svg>
          `
        },
        'surabaya': {
          displayName: 'Surabaya',
          province: 'Jawa Timur',
          landmark: 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
          temperature: 33.8,
          feels_like: 36.8,
          humidity: 62,
          windSpeed: 18.0,
          windDirection: 'Timur',
          pressure: 1008,
          visibility: 10,
          weather: 'Cerah',
          condIcon: '☀️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="50" cy="50" r="22" fill="#F59E0B" />
            </svg>
          `
        },
        'semarang': {
          displayName: 'Semarang',
          province: 'Jawa Tengah',
          landmark: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1200&q=80',
          temperature: 34.2,
          feels_like: 37.0,
          humidity: 61,
          windSpeed: 16.5,
          windDirection: 'Utara',
          pressure: 1008,
          visibility: 9,
          weather: 'Cerah Berawan',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="36" cy="36" r="18" fill="#F59E0B" />
              <path d="M26 65 A16 16 0 0 1 54 48 A14 14 0 0 1 76 56 L32 72 Z" fill="#FFFFFF" />
            </svg>
          `
        },
        'yogyakarta': {
          displayName: 'Yogyakarta',
          province: 'D.I. Yogyakarta',
          landmark: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1200&q=80',
          temperature: 30.2,
          feels_like: 32.5,
          humidity: 68,
          windSpeed: 11.0,
          windDirection: 'Selatan',
          pressure: 1009,
          visibility: 9,
          weather: 'Cerah Berawan',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="38" cy="38" r="18" fill="#FBBF24" />
              <path d="M28 62 A16 16 0 0 1 56 46 A14 14 0 0 1 78 54 L32 70 Z" fill="#FFFFFF" />
            </svg>
          `
        },
        'denpasar': {
          displayName: 'Denpasar',
          province: 'Bali',
          landmark: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
          temperature: 31.5,
          feels_like: 33.8,
          humidity: 70,
          windSpeed: 18.0,
          windDirection: 'Tenggara',
          pressure: 1009,
          visibility: 10,
          weather: 'Cerah',
          condIcon: '☀️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="50" cy="50" r="22" fill="#F59E0B" />
            </svg>
          `
        },
        'medan': {
          displayName: 'Medan',
          province: 'Sumatera Utara',
          landmark: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
          temperature: 33.1,
          feels_like: 36.0,
          humidity: 74,
          windSpeed: 12.5,
          windDirection: 'Barat',
          pressure: 1008,
          visibility: 8,
          weather: 'Hujan Petir',
          condIcon: '⛈️',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <path d="M25 58 A18 18 0 0 1 55 38 A14 14 0 0 1 80 48 A15 15 0 0 1 75 68 L30 68 Z" fill="#64748B" />
              <polygon points="48,68 40,82 50,82 44,96 60,78 50,78" fill="#FACC15" />
            </svg>
          `
        },
        'makassar': {
          displayName: 'Makassar',
          province: 'Sulawesi Selatan',
          landmark: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
          temperature: 32.4,
          feels_like: 35.0,
          humidity: 69,
          windSpeed: 21.5,
          windDirection: 'Barat',
          pressure: 1009,
          visibility: 10,
          weather: 'Cerah Berawan',
          condIcon: '⛅',
          weatherArt: `
            <svg viewBox="0 0 100 100" width="76" height="76">
              <circle cx="38" cy="38" r="18" fill="#F59E0B" />
              <path d="M28 62 A16 16 0 0 1 56 46 A14 14 0 0 1 78 54 L32 70 Z" fill="#FFFFFF" />
            </svg>
          `
        }
      };

      const dataA = ref({ ...cityMeta['jakarta'] });
      const dataB = ref({ ...cityMeta['bandung'] });

      const isSwapping = ref(false);
      const showMoreParams = ref(false);
      const toast = ref({ show: false, message: '', icon: 'fas fa-circle-check' });
      let toastTimer = null;

      const showToast = (message, icon = 'fas fa-circle-check') => {
        if (toastTimer) clearTimeout(toastTimer);
        toast.value = { show: true, message, icon };
        toastTimer = setTimeout(() => {
          toast.value.show = false;
        }, 2600);
      };

      const getLandmarkImage = (slug) => {
        return cityMeta[slug] ? cityMeta[slug].landmark : 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1200&q=80';
      };

      const setPreset = (slugA, slugB) => {
        cityA.value = slugA;
        cityB.value = slugB;
        loadCompare();
        showToast(`Memuat komparasi: ${cityMeta[slugA]?.displayName || slugA} vs ${cityMeta[slugB]?.displayName || slugB}`, 'fas fa-bolt');
      };

      const swapLocations = () => {
        isSwapping.value = true;
        const temp = cityA.value;
        cityA.value = cityB.value;
        cityB.value = temp;
        loadCompare();
        showToast(`Lokasi berhasil ditukar: ${cityMeta[cityA.value]?.displayName} ⇄ ${cityMeta[cityB.value]?.displayName}`, 'fas fa-repeat');
        setTimeout(() => {
          isSwapping.value = false;
        }, 450);
      };

      const copyComparisonSummary = () => {
        const text = `🌤️ *WeatherLive-Grid Komparasi Cuaca*\n📍 ${dataA.value.displayName}: ${dataA.value.temperature}°C (${dataA.value.weather})\n📍 ${dataB.value.displayName}: ${dataB.value.temperature}°C (${dataB.value.weather})\n📊 Selisih: ${Math.abs(dataA.value.temperature - dataB.value.temperature).toFixed(1)}°C\n🔗 Buka selengkapnya di: ${window.location.href}`;
        if (navigator.clipboard) {
          navigator.clipboard.writeText(text);
          showToast('Ringkasan komparasi berhasil disalin ke clipboard!', 'fas fa-copy');
        } else {
          showToast('Ringkasan komparasi siap dibagikan!', 'fas fa-share-nodes');
        }
      };

      const loadCompare = async () => {
        // Immediate local data reactivity
        if (cityMeta[cityA.value]) dataA.value = { ...cityMeta[cityA.value] };
        if (cityMeta[cityB.value]) dataB.value = { ...cityMeta[cityB.value] };

        try {
          const res = await fetch(`/api/predictions/comparison?city_a=${cityA.value}&city_b=${cityB.value}`);
          const json = await res.json();
          if (json && json.success && json.city_comparison) {
            const apiA = json.city_comparison.city_a;
            const apiB = json.city_comparison.city_b;

            if (apiA && apiA.temperature !== undefined) {
              dataA.value.temperature = apiA.temperature;
              dataA.value.feels_like = apiA.feels_like;
              dataA.value.humidity = apiA.humidity;
              dataA.value.windSpeed = (apiA.wind_speed * 3.6).toFixed(1);
              dataA.value.windDirection = apiA.wind_direction || 'Timur';
              dataA.value.pressure = apiA.pressure;
              dataA.value.weather = apiA.weather;
            }

            if (apiB && apiB.temperature !== undefined) {
              dataB.value.temperature = apiB.temperature;
              dataB.value.feels_like = apiB.feels_like;
              dataB.value.humidity = apiB.humidity;
              dataB.value.windSpeed = (apiB.wind_speed * 3.6).toFixed(1);
              dataB.value.windDirection = apiB.wind_direction || 'Selatan';
              dataB.value.pressure = apiB.pressure;
              dataB.value.weather = apiB.weather;
            }
          }

          if (json && json.ai_bmkg_comparison && json.ai_bmkg_comparison.timeline) {
            modelTimeline.value = json.ai_bmkg_comparison.timeline;
            if (mode.value === 'models') renderModelChart();
          }
        } catch (e) {
          // Keep rich data
        }
      };

      const handleRefresh = async () => {
        refreshing.value = true;
        await loadCompare();
        setTimeout(() => {
          refreshing.value = false;
          showToast('Data cuaca real-time berhasil diperbarui!', 'fas fa-arrows-rotate');
        }, 500);
      };

      const renderModelChart = () => {
        nextTick(() => {
          const canvas = document.getElementById('modelChartCanvas');
          if (!canvas || !window.Chart || !modelTimeline.value.length) return;

          if (modelChartInstance) modelChartInstance.destroy();

          const labels = modelTimeline.value.map(t => t.time);
          const bmkgData = modelTimeline.value.map(t => t.bmkg_forecast.temperature);
          const aiData = modelTimeline.value.map(t => t.ai_prediction.temperature);
          const actualData = modelTimeline.value.map(t => t.actual_observed.temperature);

          modelChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
              labels,
              datasets: [
                {
                  label: 'Prakiraan BMKG Resmi',
                  data: bmkgData,
                  borderColor: '#38BDF8',
                  borderWidth: 3,
                  tension: 0.4,
                  pointRadius: 4,
                  pointBackgroundColor: '#38BDF8'
                },
                {
                  label: 'AI Ensemble v2.4',
                  data: aiData,
                  borderColor: '#C084FC',
                  borderWidth: 2.8,
                  borderDash: [5, 4],
                  tension: 0.4,
                  pointRadius: 4,
                  pointBackgroundColor: '#C084FC'
                },
                {
                  label: 'Observasi Aktual',
                  data: actualData,
                  borderColor: '#4ADE80',
                  borderWidth: 2.5,
                  tension: 0.4,
                  pointRadius: 5,
                  pointBackgroundColor: '#4ADE80'
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              interaction: { mode: 'index', intersect: false },
              plugins: {
                legend: {
                  labels: { color: '#8FA3BF', font: { family: 'Inter', weight: '700' } }
                },
                tooltip: {
                  backgroundColor: 'rgba(5, 15, 35, 0.95)',
                  borderColor: 'rgba(56, 189, 248, 0.3)',
                  borderWidth: 1,
                  titleColor: '#fff',
                  bodyColor: '#94A3B8'
                }
              },
              scales: {
                x: {
                  ticks: { color: '#8FA3BF' },
                  grid: { color: 'rgba(255, 255, 255, 0.05)' }
                },
                y: {
                  ticks: { color: '#8FA3BF', callback: v => v + '°C' },
                  grid: { color: 'rgba(255, 255, 255, 0.05)' }
                }
              }
            }
          });
        });
      };

      watch(mode, (newMode) => {
        if (newMode === 'models') {
          renderModelChart();
        }
      });

      onMounted(() => {
        loadCompare();
      });

      return {
        mode,
        cityA,
        cityB,
        dataA,
        dataB,
        refreshing,
        isSwapping,
        showMoreParams,
        toast,
        modelTimeline,
        getLandmarkImage,
        setPreset,
        swapLocations,
        copyComparisonSummary,
        loadCompare,
        handleRefresh
      };
    }
  }).mount('#cmp-app');

})();
</script>
@endpush

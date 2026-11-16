@extends('layouts.app')

@section('title', 'Prakiraan Cuaca BMKG — WeatherLive-Grid')

@section('styles')
<style>
/* ===== BMKG PREMIUM FORECAST V2 — 3-COLUMN ULTRA SYSTEM ===== */
@import url('https://fonts.googleapis.com/css2?family=Caveat:wght@600&family=Space+Grotesk:wght@500;600;700;800;900&display=swap');

:root {
  --fc-max-w: 1440px;
  --fc-bg: #060e1e;
  --fc-card-bg: rgba(9, 21, 46, 0.78);
  --fc-card-border: rgba(56, 189, 248, 0.16);
  --fc-card-border-glow: rgba(56, 189, 248, 0.45);
  --fc-accent: #38BDF8;
  --fc-primary: #2563EB;
  --fc-emerald: #10B981;
  --fc-amber: #F59E0B;
  --fc-orange: #F97316;
  --fc-text: #F1F5F9;
  --fc-muted: #8FA3BF;
}

/* Base resets & override layouts */
.floating-nav { display: none !important; }
footer.glass { display: none !important; }
#global-mobile-menu { display: none !important; }
.main-content { padding-top: 0 !important; }
#main-content { padding-top: 0 !important; }

body {
  overflow-x: hidden;
  color: var(--fc-text);
  font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  background-color: var(--fc-bg) !important;
  min-height: 100vh;
  position: relative;
}

/* Atmospheric Jakarta Twilight Monas Skyline Background */
.fc-viewport-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  background-image:
    linear-gradient(180deg, rgba(6, 15, 34, 0.75) 0%, rgba(6, 14, 30, 0.9) 440px, rgba(5, 11, 23, 0.98) 100%),
    url('https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=1920&q=80');
  background-size: cover;
  background-position: center top;
  background-attachment: fixed;
  pointer-events: none;
}

/* Subtle particle glow */
.fc-particles {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
  background-size: 70px 70px;
  opacity: 0.3;
}

/* Main Container */
.fc-container {
  max-width: var(--fc-max-w);
  margin: 0 auto;
  padding: 0 28px 48px;
  position: relative;
  z-index: 2;
}

/* ===== 1. TOP NAVBAR ===== */
.fc-navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  margin-bottom: 24px;
}
.fc-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}
.fc-brand-logo {
  width: 42px; height: 42px; border-radius: 50%;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; color: #fff; flex-shrink: 0;
  box-shadow: 0 6px 18px rgba(2, 132, 199, 0.45);
  transition: transform .3s;
}
.fc-brand:hover .fc-brand-logo { transform: rotate(8deg) scale(1.05); }
.fc-brand-text h1 {
  font-size: 16px; font-weight: 900; color: #fff;
  line-height: 1.1; letter-spacing: 0.5px;
}
.fc-brand-text p {
  font-size: 10px; color: var(--fc-muted); font-weight: 500;
  margin-top: 2px;
}

/* Nav Menu Links */
.fc-nav-menu {
  display: flex;
  align-items: center;
  gap: 6px;
}
.fc-nav-link {
  display: flex; align-items: center; gap: 8px;
  padding: 8px 16px; border-radius: 12px;
  color: var(--fc-muted); font-size: 13px; font-weight: 700;
  text-decoration: none; transition: all .25s ease;
  border: 1px solid transparent;
}
.fc-nav-link:hover {
  color: #fff; background: rgba(255, 255, 255, 0.06);
}
.fc-nav-link.active {
  background: linear-gradient(135deg, rgba(37, 99, 235, 0.4), rgba(56, 189, 248, 0.25));
  color: #38BDF8;
  border-color: rgba(56, 189, 248, 0.4);
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
}

/* Navbar Right Controls */
.fc-navbar-right {
  display: flex;
  align-items: center;
  gap: 12px;
}
.fc-live-pill {
  display: flex; align-items: center; gap: 6px;
  padding: 5px 12px; border-radius: 999px;
  background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.35);
  font-size: 11px; font-weight: 800; color: #4ADE80;
}
.fc-live-dot {
  width: 6px; height: 6px; border-radius: 50%; background: #22C55E;
  box-shadow: 0 0 6px #22C55E; animation: pulseDot 2s infinite;
}
@keyframes pulseDot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

.fc-city-select-btn {
  display: flex; align-items: center; gap: 8px;
  padding: 7px 14px; border-radius: 14px;
  background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12);
  color: #fff; font-size: 12px; font-weight: 700;
  cursor: pointer; transition: all .25s; position: relative;
}
.fc-city-select-btn:hover {
  background: rgba(56, 189, 248, 0.15); border-color: rgba(56, 189, 248, 0.35);
}
.fc-city-select-btn select {
  position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.fc-nav-icon-btn {
  width: 36px; height: 36px; border-radius: 12px; border: none;
  background: rgba(255, 255, 255, 0.06); color: var(--fc-muted);
  cursor: pointer; font-size: 13px; display: flex; align-items: center;
  justify-content: center; transition: all .25s;
}
.fc-nav-icon-btn:hover { background: rgba(56, 189, 248, 0.15); color: #38BDF8; }
.fc-nav-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: #1E293B; border: 1px solid rgba(255, 255, 255, 0.12);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 13px; font-weight: 800;
}

/* ===== 2. HERO HEADER SECTION ===== */
.fc-hero-grid {
  display: grid;
  grid-template-columns: 1fr 1.35fr 1fr;
  gap: 20px;
  align-items: center;
  margin-bottom: 24px;
}

/* Left Title Column */
.fc-hero-left .fc-badge-top {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 4px 10px; border-radius: 999px;
  background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.35);
  color: #38BDF8; font-size: 11px; font-weight: 800; margin-bottom: 10px;
}
.fc-hero-left h2 {
  font-size: 32px; font-weight: 900; color: #fff;
  letter-spacing: -0.5px; margin-bottom: 12px; line-height: 1.15;
}
.fc-hero-left .fc-city-pill {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 5px 12px; border-radius: 999px;
  background: rgba(37, 99, 235, 0.28); border: 1px solid rgba(56, 189, 248, 0.45);
  color: #38BDF8; font-size: 11.5px; font-weight: 800; margin-bottom: 10px;
}
.fc-hero-left p {
  font-size: 12.5px; color: var(--fc-muted); line-height: 1.5;
}

/* Center Weather Card */
.fc-weather-center-card {
  padding: 20px 24px; border-radius: 22px;
  background: linear-gradient(135deg, rgba(8, 22, 52, 0.88), rgba(14, 38, 88, 0.78));
  border: 1px solid rgba(56, 189, 248, 0.25);
  border-top: 2px solid #38BDF8;
  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);
  box-shadow: 0 16px 44px rgba(0, 0, 0, 0.4), 0 0 30px rgba(56, 189, 248, 0.15);
  display: grid; grid-template-columns: auto 1fr;
  gap: 20px; align-items: center;
  transition: all .3s;
}
.fc-weather-center-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 52px rgba(0, 0, 0, 0.5), 0 0 40px rgba(56, 189, 248, 0.25);
}
.fc-wc-left {
  display: flex; align-items: center; gap: 14px;
}
.fc-wc-icon {
  font-size: 58px; line-height: 1;
  filter: drop-shadow(0 8px 20px rgba(56, 189, 248, 0.4));
  animation: floatCloud 4s ease-in-out infinite;
}
@keyframes floatCloud { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
.fc-wc-temp {
  font-size: 46px; font-weight: 900; color: #fff; line-height: 1;
  font-family: 'Space Grotesk';
}
.fc-wc-cond {
  font-size: 13px; font-weight: 700; color: #CBD5E1; margin-top: 4px;
}
.fc-wc-metrics {
  display: flex; flex-direction: column; gap: 8px;
  padding-left: 18px; border-left: 1px solid rgba(255, 255, 255, 0.1);
}
.fc-wcm-row {
  display: flex; align-items: center; justify-content: space-between; gap: 14px;
  font-size: 11.5px; color: var(--fc-muted); font-weight: 600;
}
.fc-wcm-row span:first-child { display: flex; align-items: center; gap: 6px; }
.fc-wcm-row span:last-child { color: #fff; font-weight: 800; font-family: 'Space Grotesk'; }

/* Right Location Widget Card */
.fc-loc-widget {
  padding: 16px 18px; border-radius: 20px;
  background: var(--fc-card-bg);
  border: 1px solid var(--fc-card-border);
  backdrop-filter: blur(24px);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  display: flex; flex-direction: column; gap: 12px;
}
.fc-loc-top {
  display: flex; align-items: center; gap: 12px;
  padding-bottom: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  cursor: pointer; position: relative;
}
.fc-loc-top select {
  position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.fc-loc-thumb {
  width: 44px; height: 38px; border-radius: 10px;
  background-image: url('https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80');
  background-size: cover; background-position: center;
  border: 1px solid rgba(56, 189, 248, 0.3);
  flex-shrink: 0;
}
.fc-loc-text h4 { font-size: 13px; font-weight: 800; color: #fff; }
.fc-loc-text p { font-size: 10.5px; color: var(--fc-muted); }
.fc-loc-bot {
  display: flex; align-items: center; gap: 10px;
}
.fc-loc-bot-icon { font-size: 26px; line-height: 1; }
.fc-loc-bot-text h5 { font-size: 11.5px; font-weight: 800; color: #F1F5F9; margin-bottom: 2px; }
.fc-loc-bot-text p { font-size: 10px; color: var(--fc-muted); line-height: 1.35; }

/* ===== 3. SECTION: PRAKIRAAN CUACA PER JAM ===== */
.fc-card {
  border-radius: 22px;
  background: var(--fc-card-bg);
  border: 1px solid var(--fc-card-border);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  padding: 20px 24px;
  margin-bottom: 24px;
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}
.fc-card:hover {
  border-color: rgba(56, 189, 248, 0.3);
}
.fc-card-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 18px;
  flex-wrap: wrap;
}
.fc-card-head-left {
  display: flex; align-items: center; gap: 12px;
}
.fc-head-icon-circle {
  width: 36px; height: 36px; border-radius: 50%;
  background: rgba(56, 189, 248, 0.15); color: #38BDF8;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; flex-shrink: 0;
}
.fc-card-head-left h3 { font-size: 15px; font-weight: 800; color: #fff; }
.fc-card-head-left p { font-size: 11px; color: var(--fc-muted); margin-top: 1px; }

/* Interval Seg Group */
.fc-seg-group {
  display: flex; align-items: center; gap: 4px;
  background: rgba(255, 255, 255, 0.04);
  padding: 4px; border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.fc-seg-btn {
  padding: 6px 14px; border-radius: 9px; border: none;
  background: transparent; color: var(--fc-muted);
  font-size: 11.5px; font-weight: 700; cursor: pointer;
  transition: all .25s ease;
}
.fc-seg-btn:hover { color: #fff; background: rgba(255, 255, 255, 0.06); }
.fc-seg-btn.active {
  background: linear-gradient(135deg, #2563EB, #38BDF8);
  color: #fff; font-weight: 800;
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
}

.fc-date-pill {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 6px 14px; border-radius: 12px;
  background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 11.5px; font-weight: 700; color: #E2E8F0;
}
.fc-dp-arrow { cursor: pointer; color: var(--fc-muted); transition: color .2s; }
.fc-dp-arrow:hover { color: #38BDF8; }

/* Hourly Carousel */
.fc-hourly-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.fc-nav-arrow {
  position: absolute;
  top: 50%; transform: translateY(-50%);
  width: 34px; height: 34px; border-radius: 50%;
  background: rgba(8, 20, 46, 0.95); border: 1px solid rgba(56, 189, 248, 0.35);
  color: #38BDF8; display: flex; align-items: center; justify-content: center;
  font-size: 13px; cursor: pointer; z-index: 5;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.45);
  transition: all .25s;
}
.fc-nav-arrow:hover {
  background: #38BDF8; color: #060e1e; transform: translateY(-50%) scale(1.1);
}
.fc-nav-arrow.left { left: -14px; }
.fc-nav-arrow.right { right: -14px; }

.fc-hourly-track {
  display: flex;
  gap: 12px;
  overflow-x: auto;
  scroll-behavior: smooth;
  padding: 6px 2px;
  width: 100%;
  scrollbar-width: none;
}
.fc-hourly-track::-webkit-scrollbar { display: none; }

.fc-hourly-card {
  flex: 0 0 calc((100% - 96px) / 9);
  min-width: 96px;
  text-align: center;
  padding: 15px 6px;
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.035);
  border: 1px solid rgba(255, 255, 255, 0.07);
  cursor: pointer;
  transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}
.fc-hourly-card:hover {
  background: rgba(56, 189, 248, 0.12);
  border-color: rgba(56, 189, 248, 0.4);
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}
.fc-hourly-card.active {
  background: linear-gradient(135deg, rgba(37, 99, 235, 0.4), rgba(56, 189, 248, 0.25));
  border-color: #38BDF8;
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
}
.fc-hc-time { font-size: 11.5px; font-weight: 700; color: var(--fc-muted); margin-bottom: 8px; }
.fc-hc-icon { font-size: 30px; line-height: 1; margin-bottom: 8px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3)); }
.fc-hc-temp { font-size: 17px; font-weight: 900; color: #fff; margin-bottom: 8px; font-family: 'Space Grotesk'; }
.fc-hc-chips {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  font-size: 9.5px; font-weight: 700; color: var(--fc-muted);
}
.fc-hc-chips span { display: flex; align-items: center; gap: 2px; }

/* ===== 4. BOTTOM 3-COLUMN SECTION ===== */
.fc-bottom-grid {
  display: grid;
  grid-template-columns: 220px 1fr 260px;
  gap: 20px;
  align-items: stretch;
}

/* Left Column: Quote + Sync */
.fc-bot-left {
  display: flex; flex-direction: column; gap: 16px;
}
.fc-quote-card {
  flex: 1;
  padding: 22px 20px; border-radius: 20px;
  background-image: 
    linear-gradient(180deg, rgba(8, 20, 48, 0.72) 0%, rgba(6, 14, 32, 0.95) 100%),
    url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80');
  background-size: cover; background-position: center bottom;
  border: 1px solid var(--fc-card-border);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  display: flex; flex-direction: column; justify-content: space-between;
}
.fc-quote-text {
  font-family: 'Caveat', cursive;
  font-size: 20px; font-weight: 600;
  line-height: 1.3; color: rgba(241, 245, 249, 0.92);
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);
  margin-top: 10px;
}
.fc-quote-brand {
  display: flex; align-items: center; gap: 8px; margin-top: 24px;
}
.fc-quote-brand img, .fc-quote-brand-logo {
  width: 20px; height: 20px; border-radius: 50%;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  display: flex; align-items: center; justify-content: center;
  font-size: 10px; color: #fff;
}
.fc-quote-brand span { font-size: 11px; font-weight: 800; color: var(--fc-muted); letter-spacing: 0.5px; }

.fc-sync-card {
  padding: 12px 14px; border-radius: 16px;
  background: var(--fc-card-bg); border: 1px solid var(--fc-card-border);
  display: flex; align-items: center; gap: 10px;
}
.fc-sync-leaf {
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(34, 197, 94, 0.15); color: #22C55E;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; flex-shrink: 0;
}
.fc-sync-text h6 { font-size: 10px; font-weight: 800; color: #CBD5E1; }
.fc-sync-text p { font-size: 9px; color: var(--fc-muted); margin-top: 1px; }

/* Middle Column: Daily Table */
.fc-daily-card {
  padding: 20px 24px; border-radius: 22px;
  background: var(--fc-card-bg); border: 1px solid var(--fc-card-border);
  backdrop-filter: blur(24px);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
}
.fc-daily-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 8px;
}
.fc-daily-table thead th {
  font-size: 10.5px; font-weight: 700; text-transform: uppercase;
  color: var(--fc-muted); letter-spacing: 1px;
  padding: 6px 14px; text-align: left;
}
.fc-daily-table tbody tr {
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: 14px;
  transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
  cursor: pointer;
}
.fc-daily-table tbody tr:hover {
  background: rgba(56, 189, 248, 0.09);
  border-color: rgba(56, 189, 248, 0.35);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
}
.fc-daily-table tbody td {
  padding: 12px 14px;
  vertical-align: middle;
  font-size: 12.5px; font-weight: 700; color: #E2E8F0;
}
.fc-daily-table tbody tr td:first-child {
  border-top-left-radius: 14px; border-bottom-left-radius: 14px;
}
.fc-daily-table tbody tr td:last-child {
  border-top-right-radius: 14px; border-bottom-right-radius: 14px;
}

.fc-dt-date h4 { font-size: 12.5px; font-weight: 800; color: #fff; margin-bottom: 2px; }
.fc-dt-date p { font-size: 10.5px; color: var(--fc-muted); font-weight: 600; }
.fc-dt-weather { display: flex; align-items: center; gap: 10px; }
.fc-dt-weather .ic { font-size: 22px; line-height: 1; }

/* Apple Weather Gradient Temperature Bar */
.fc-dt-temp-wrap {
  display: flex; align-items: center; gap: 10px; min-width: 160px;
}
.fc-dt-min { font-size: 13px; font-weight: 800; color: #38BDF8; width: 28px; text-align: right; }
.fc-dt-max { font-size: 13px; font-weight: 800; color: #F97316; width: 28px; }
.fc-temp-bar-bg {
  flex: 1; height: 5px; border-radius: 999px;
  background: rgba(255, 255, 255, 0.1);
  position: relative; overflow: hidden;
}
.fc-temp-bar-fill {
  position: absolute; top: 0; bottom: 0;
  border-radius: 999px;
  background: linear-gradient(90deg, #38BDF8, #FACC15, #F97316);
  box-shadow: 0 0 8px rgba(56, 189, 248, 0.4);
}

.fc-dt-rain { display: flex; align-items: center; gap: 5px; color: #38BDF8; font-weight: 700; }
.fc-dt-uv { display: flex; align-items: center; gap: 5px; color: #FACC15; font-weight: 700; font-size: 11.5px; }
.fc-dt-wind { display: flex; align-items: center; gap: 5px; color: #CBD5E1; font-weight: 700; font-size: 11.5px; }
.fc-dt-arrow { color: var(--fc-muted); font-size: 12px; }

/* Right Column: Radar & Map CTA */
.fc-globe-card {
  padding: 20px; border-radius: 22px;
  background: var(--fc-card-bg); border: 1px solid var(--fc-card-border);
  backdrop-filter: blur(24px);
  box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
  display: flex; flex-direction: column; justify-content: space-between;
  text-align: center;
}
.fc-radar-preview-wrap {
  width: 100%; height: 210px; position: relative;
  border-radius: 18px; overflow: hidden;
  background: radial-gradient(circle at center, rgba(14, 116, 144, 0.35) 0%, rgba(6, 18, 42, 0.95) 75%);
  border: 1px solid rgba(56, 189, 248, 0.25);
  box-shadow: 0 0 35px rgba(56, 189, 248, 0.18);
  display: flex; align-items: center; justify-content: center;
}
.fc-radar-ring {
  position: absolute; border-radius: 50%;
  border: 1px solid rgba(56, 189, 248, 0.25);
}
.fc-radar-ring.r1 { width: 60px; height: 60px; }
.fc-radar-ring.r2 { width: 120px; height: 120px; }
.fc-radar-ring.r3 { width: 180px; height: 180px; }
.fc-radar-crosshair-h {
  position: absolute; left: 0; right: 0; height: 1px;
  background: rgba(56, 189, 248, 0.2);
}
.fc-radar-crosshair-v {
  position: absolute; top: 0; bottom: 0; width: 1px;
  background: rgba(56, 189, 248, 0.2);
}
.fc-radar-sweep {
  position: absolute; width: 190px; height: 190px; border-radius: 50%;
  background: conic-gradient(from 0deg, rgba(56, 189, 248, 0.45) 0deg, transparent 65deg, transparent 360deg);
  animation: fcRadarSpin 4s linear infinite;
}
@keyframes fcRadarSpin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
.fc-radar-blip {
  position: absolute; width: 8px; height: 8px; border-radius: 50%;
  background: #38BDF8; box-shadow: 0 0 10px #38BDF8;
}
.fc-globe-text {
  text-align: left; margin: 16px 0 14px;
}
.fc-globe-text h4 { font-size: 14px; font-weight: 900; color: #fff; line-height: 1.25; }
.fc-globe-text p { font-size: 11px; color: var(--fc-muted); margin-top: 2px; }
.fc-globe-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 11px 16px; border-radius: 14px;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  color: #fff; font-size: 12.5px; font-weight: 800;
  text-decoration: none; border: none; cursor: pointer;
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
  transition: all .25s;
}
.fc-globe-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(56, 189, 248, 0.5);
}

/* Skeleton */
.fc-skeleton {
  background: linear-gradient(90deg, rgba(255,255,255,0.04), rgba(255,255,255,0.1), rgba(255,255,255,0.04));
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 14px;
}
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

/* Responsive adjustments */
@media(max-width: 1200px) {
  .fc-hero-grid { grid-template-columns: 1fr 1fr; }
  .fc-loc-widget { grid-column: span 2; }
  .fc-bottom-grid { grid-template-columns: 1fr 1fr; }
  .fc-globe-card { grid-column: span 2; }
}
@media(max-width: 900px) {
  .fc-nav-menu { display: none; }
  .fc-hero-grid { grid-template-columns: 1fr; }
  .fc-loc-widget { grid-column: span 1; }
  .fc-bottom-grid { grid-template-columns: 1fr; }
  .fc-globe-card { grid-column: span 1; }
  .fc-hourly-card { flex: 0 0 calc((100% - 36px) / 4); }
}
@media(max-width: 640px) {
  .fc-hourly-card { flex: 0 0 calc((100% - 20px) / 3); }
  .fc-weather-center-card { grid-template-columns: 1fr; }
  .fc-wc-metrics { padding-left: 0; border-left: none; padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.1); }
  .fc-daily-table { display: block; overflow-x: auto; }
}
</style>
@endsection

@section('content')
<!-- Ambient Atmospheric Viewport Background -->
<div class="fc-viewport-bg" aria-hidden="true"></div>
<div class="fc-particles" aria-hidden="true"></div>

<div id="fc-app" v-cloak>
  <div class="fc-container">

    <!-- ===== 1. TOP NAVBAR ===== -->
    <header class="fc-navbar">
      <a href="{{ route('dashboard') }}" class="fc-brand">
        <div class="fc-brand-logo"><i class="fas fa-cloud-sun"></i></div>
        <div class="fc-brand-text">
          <h1>BMKG</h1>
          <p>Badan Meteorologi, Klimatologi, dan Geofisika</p>
        </div>
      </a>

      <!-- Menu links -->
      <nav class="fc-nav-menu">
        <a href="{{ route('dashboard') }}" class="fc-nav-link">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('forecast') }}" class="fc-nav-link active">
          <i class="fas fa-cloud-sun"></i> Prakiraan
        </a>
        <a href="{{ route('analytics') }}" class="fc-nav-link">
          <i class="fas fa-chart-line"></i> Analisis
        </a>
        <a href="{{ route('compare') }}" class="fc-nav-link">
          <i class="fas fa-scale-balanced"></i> Bandingkan
        </a>
        <a href="{{ route('map') }}" class="fc-nav-link">
          <i class="fas fa-shapes"></i> Fitur <i class="fas fa-chevron-down" style="font-size:10px;margin-left:2px;"></i>
        </a>
      </nav>

      <!-- Right controls -->
      <div class="fc-navbar-right">
        <div class="fc-live-pill"><span class="fc-live-dot"></span> LIVE</div>

        <!-- City Dropdown Button -->
        <div class="fc-city-select-btn">
          <i class="fas fa-map-marker-alt" style="color:#38BDF8;"></i>
          <span v-text="selectedCityName"></span>
          <i class="fas fa-chevron-down" style="font-size:10px;"></i>
          <select v-model="selectedCity" @change="changeCity">
            <optgroup label="Kota Besar Indonesia">
              <option value="31.71">DKI Jakarta</option>
              <option value="35.78">Kota Surabaya (Jawa Timur)</option>
              <option value="33.74">Kota Semarang (Jawa Tengah)</option>
              <option value="34.71">Kota Yogyakarta (DIY)</option>
              <option value="51.71">Kota Denpasar (Bali)</option>
              <option value="12.71">Kota Medan (Sumut)</option>
              <option value="73.71">Kota Makassar (Sulsel)</option>
              <option value="16.71">Kota Palembang (Sumsel)</option>
              <option value="64.71">Kota Balikpapan (Kaltim)</option>
              <option value="71.71">Kota Manado (Sulut)</option>
            </optgroup>
            <optgroup label="Jawa Barat (27 Kota &amp; Kabupaten)">
              <option value="32.73">Kota Bandung</option>
              <option value="32.71">Kota Bogor</option>
              <option value="32.75">Kota Bekasi</option>
              <option value="32.76">Kota Depok</option>
              <option value="32.77">Kota Cimahi</option>
              <option value="32.74">Kota Cirebon</option>
              <option value="32.72">Kota Sukabumi</option>
              <option value="32.78">Kota Tasikmalaya</option>
              <option value="32.79">Kota Banjar</option>
              <option value="32.01">Kabupaten Bogor</option>
              <option value="32.04">Kabupaten Bandung</option>
              <option value="32.17">Kabupaten Bandung Barat</option>
              <option value="32.16">Kabupaten Bekasi</option>
              <option value="32.07">Kabupaten Ciamis</option>
              <option value="32.03">Kabupaten Cianjur</option>
              <option value="32.09">Kabupaten Cirebon</option>
              <option value="32.05">Kabupaten Garut</option>
              <option value="32.12">Kabupaten Indramayu</option>
              <option value="32.15">Kabupaten Karawang</option>
              <option value="32.08">Kabupaten Kuningan</option>
              <option value="32.10">Kabupaten Majalengka</option>
              <option value="32.18">Kabupaten Pangandaran</option>
              <option value="32.14">Kabupaten Purwakarta</option>
              <option value="32.13">Kabupaten Subang</option>
              <option value="32.02">Kabupaten Sukabumi</option>
              <option value="32.11">Kabupaten Sumedang</option>
              <option value="32.06">Kabupaten Tasikmalaya</option>
            </optgroup>
          </select>
        </div>

        <button class="fc-nav-icon-btn" @click="toggleDark" title="Mode Tampilan">
          <i class="fas fa-sun"></i>
        </button>
        <button class="fc-nav-icon-btn" title="Notifikasi Cuaca">
          <i class="fas fa-bell"></i>
        </button>
        <div class="fc-nav-avatar"><i class="fas fa-user"></i></div>
      </div>
    </header>

    <!-- ===== 2. HERO HEADER SECTION ===== -->
    <section class="fc-hero-grid">
      <!-- Left Column: Title & Info -->
      <div class="fc-hero-left">
        <div class="fc-badge-top"><i class="fas fa-compass"></i> Prakiraan Cuaca</div>
        <h2>Prakiraan Cuaca BMKG</h2>
        <div class="fc-city-pill">
          <i class="fas fa-map-marker-alt"></i>
          <span v-text="selectedCityName"></span>
        </div>
        <p>Informasi cuaca terkini dan prakiraan untuk aktivitas Anda</p>
      </div>

      <!-- Center Column: Glowing Main Weather Glass Card -->
      <div class="fc-weather-center-card">
        <div class="fc-wc-left">
          <div class="fc-wc-icon" v-text="getEmoji(currentWeather?.weather_main)"></div>
          <div>
            <div class="fc-wc-temp" v-text="Math.round(currentWeather?.temperature ?? 22) + '°C'"></div>
            <div class="fc-wc-cond" v-text="currentWeather?.weather_description || 'Berawan Tebal'"></div>
          </div>
        </div>
        <div class="fc-wc-metrics">
          <div class="fc-wcm-row">
            <span><i class="fas fa-droplet" style="color:#38BDF8;"></i> Kelembapan</span>
            <span v-text="(currentWeather?.humidity ?? 69) + '%'"></span>
          </div>
          <div class="fc-wcm-row">
            <span><i class="fas fa-wind" style="color:#38BDF8;"></i> Angin</span>
            <span v-text="(currentWeather?.wind_speed ?? 7.9) + ' km/jam'"></span>
          </div>
          <div class="fc-wcm-row">
            <span><i class="fas fa-gauge-high" style="color:#38BDF8;"></i> Tekanan</span>
            <span v-text="(currentWeather?.pressure ?? 1011) + ' hPa'"></span>
          </div>
        </div>
      </div>

      <!-- Right Column: Location Card & Advice -->
      <div class="fc-loc-widget">
        <div class="fc-loc-top">
          <div class="fc-loc-thumb" :style="{ backgroundImage: 'url(' + cityThumb + ')' }"></div>
          <div class="fc-loc-text">
            <h4 v-text="selectedCityName"></h4>
            <p v-text="citySubtext"></p>
          </div>
          <i class="fas fa-chevron-down" style="font-size:11px;color:var(--fc-muted);margin-left:auto;"></i>
          <select v-model="selectedCity" @change="changeCity">
            <optgroup label="Kota Besar Indonesia">
              <option value="31.71">DKI Jakarta</option>
              <option value="35.78">Kota Surabaya (Jawa Timur)</option>
              <option value="33.74">Kota Semarang (Jawa Tengah)</option>
              <option value="34.71">Kota Yogyakarta (DIY)</option>
              <option value="51.71">Kota Denpasar (Bali)</option>
              <option value="12.71">Kota Medan (Sumut)</option>
              <option value="73.71">Kota Makassar (Sulsel)</option>
              <option value="16.71">Kota Palembang (Sumsel)</option>
              <option value="64.71">Kota Balikpapan (Kaltim)</option>
              <option value="71.71">Kota Manado (Sulut)</option>
            </optgroup>
            <optgroup label="Jawa Barat (27 Kota &amp; Kabupaten)">
              <option value="32.73">Kota Bandung</option>
              <option value="32.71">Kota Bogor</option>
              <option value="32.75">Kota Bekasi</option>
              <option value="32.76">Kota Depok</option>
              <option value="32.77">Kota Cimahi</option>
              <option value="32.74">Kota Cirebon</option>
              <option value="32.72">Kota Sukabumi</option>
              <option value="32.78">Kota Tasikmalaya</option>
              <option value="32.79">Kota Banjar</option>
              <option value="32.01">Kabupaten Bogor</option>
              <option value="32.04">Kabupaten Bandung</option>
              <option value="32.17">Kabupaten Bandung Barat</option>
              <option value="32.16">Kabupaten Bekasi</option>
              <option value="32.07">Kabupaten Ciamis</option>
              <option value="32.03">Kabupaten Cianjur</option>
              <option value="32.09">Kabupaten Cirebon</option>
              <option value="32.05">Kabupaten Garut</option>
              <option value="32.12">Kabupaten Indramayu</option>
              <option value="32.15">Kabupaten Karawang</option>
              <option value="32.08">Kabupaten Kuningan</option>
              <option value="32.10">Kabupaten Majalengka</option>
              <option value="32.18">Kabupaten Pangandaran</option>
              <option value="32.14">Kabupaten Purwakarta</option>
              <option value="32.13">Kabupaten Subang</option>
              <option value="32.02">Kabupaten Sukabumi</option>
              <option value="32.11">Kabupaten Sumedang</option>
              <option value="32.06">Kabupaten Tasikmalaya</option>
            </optgroup>
          </select>
        </div>
        <div class="fc-loc-bot">
          <div class="fc-loc-bot-icon">⛅</div>
          <div class="fc-loc-bot-text">
            <h5>Cuaca saat ini</h5>
            <p v-text="recomText"></p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== 3. PRAKIRAAN CUACA PER JAM ===== -->
    <section class="fc-card">
      <div class="fc-card-head">
        <div class="fc-card-head-left">
          <div class="fc-head-icon-circle"><i class="fas fa-clock"></i></div>
          <div>
            <h3>Prakiraan Cuaca per Jam</h3>
            <p>Lihat kondisi cuaca dalam 24 jam ke depan</p>
          </div>
        </div>

        <!-- Interval step selector (1, 3, 6, 12, 24 Jam) -->
        <div class="fc-seg-group">
          <button class="fc-seg-btn" :class="{ active: hourlyStep === 1 }" @click="setHourlyStep(1)">1 Jam</button>
          <button class="fc-seg-btn" :class="{ active: hourlyStep === 3 }" @click="setHourlyStep(3)">3 Jam</button>
          <button class="fc-seg-btn" :class="{ active: hourlyStep === 6 }" @click="setHourlyStep(6)">6 Jam</button>
          <button class="fc-seg-btn" :class="{ active: hourlyStep === 12 }" @click="setHourlyStep(12)">12 Jam</button>
          <button class="fc-seg-btn" :class="{ active: hourlyStep === 24 }" @click="setHourlyStep(24)">24 Jam</button>
        </div>

        <!-- Date Pill with Arrows -->
        <div class="fc-date-pill">
          <i class="fas fa-calendar-day" style="color:#38BDF8;"></i>
          <span v-text="todayDateLabel"></span>
          <i class="fas fa-chevron-left fc-dp-arrow" @click="scrollHourly(-320)"></i>
          <i class="fas fa-chevron-right fc-dp-arrow" @click="scrollHourly(320)"></i>
        </div>
      </div>

      <!-- Horizontal Slider with Arrow buttons -->
      <div class="fc-hourly-wrapper">
        <button class="fc-nav-arrow left" @click="scrollHourly(-320)" title="Geser ke Kiri">
          <i class="fas fa-chevron-left"></i>
        </button>

        <div class="fc-hourly-track" id="hourlyTrack" v-if="filteredHourly.length">
          <div v-for="(h, i) in filteredHourly"
               :key="i"
               class="fc-hourly-card"
               :class="{ active: i === 0 }"
               @click="previewHourly(h)">
            <div class="fc-hc-time" v-text="formatHour(h.forecast_for)"></div>
            <div class="fc-hc-icon" v-text="getEmoji(h.weather_main)"></div>
            <div class="fc-hc-temp" v-text="Math.round(h.temperature) + '°'"></div>
            <div class="fc-hc-chips">
              <span><i class="fas fa-droplet" style="color:#38BDF8;"></i> <strong v-text="(h.rain_probability ?? 0) + '%'"></strong></span>
              <span><i class="fas fa-wind" style="color:#38BDF8;"></i> <strong v-text="Math.round(h.wind_speed ?? 2) + ' km/j'"></strong></span>
            </div>
          </div>
        </div>

        <div v-else style="padding:30px;text-align:center;width:100%;">
          <div class="fc-skeleton" style="height:120px;width:100%;"></div>
        </div>

        <button class="fc-nav-arrow right" @click="scrollHourly(320)" title="Geser ke Kanan">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </section>

    <!-- ===== 4. BOTTOM 3-COLUMN SECTION ===== -->
    <div class="fc-bottom-grid">

      <!-- Left Column: Quote Card + Data Sync Card -->
      <div class="fc-bot-left">
        <div class="fc-quote-card">
          <div class="fc-quote-text">
            Langit selalu<br>
            berubah, tapi<br>
            kita tetap bisa<br>
            menemukan<br>
            keindahannya.
          </div>
          <div class="fc-quote-brand">
            <div class="fc-quote-brand-logo"><i class="fas fa-cloud-sun"></i></div>
            <span>BMKG</span>
          </div>
        </div>

        <div class="fc-sync-card">
          <div class="fc-sync-leaf"><i class="fas fa-sync-alt"></i></div>
          <div class="fc-sync-text">
            <h6>Data diperbarui otomatis</h6>
            <p v-text="lastSyncText"></p>
          </div>
        </div>
      </div>

      <!-- Middle Column: Daily Forecast Table (Wide) -->
      <div class="fc-daily-card">
        <div class="fc-card-head" style="margin-bottom:14px;">
          <div class="fc-card-head-left">
            <div class="fc-head-icon-circle"><i class="fas fa-calendar-week"></i></div>
            <div>
              <h3>Prakiraan Harian</h3>
              <p>Ringkasan cuaca untuk 7, 14, dan 30 hari ke depan</p>
            </div>
          </div>

          <!-- 7, 14, 30 Hari selector -->
          <div class="fc-seg-group">
            <button class="fc-seg-btn" :class="{ active: dailyDays === 7 }" @click="setDailyDays(7)">7 Hari</button>
            <button class="fc-seg-btn" :class="{ active: dailyDays === 14 }" @click="setDailyDays(14)">14 Hari</button>
            <button class="fc-seg-btn" :class="{ active: dailyDays === 30 }" @click="setDailyDays(30)">30 Hari</button>
          </div>
        </div>

        <!-- Table List -->
        <div v-if="daily.length" style="overflow-x:auto;">
          <table class="fc-daily-table">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Cuaca</th>
                <th>Suhu (°C)</th>
                <th>Peluang Hujan</th>
                <th>UV Index</th>
                <th>Angin</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(d, i) in daily" :key="i" @click="previewDaily(d)">
                <!-- Tanggal -->
                <td>
                  <div class="fc-dt-date">
                    <h4 v-text="formatDayTitle(d.forecast_for)"></h4>
                    <p v-text="i === 0 ? 'Hari ini' : (i === 1 ? 'Besok' : formatDaySubtitle(d.forecast_for))"></p>
                  </div>
                </td>

                <!-- Cuaca -->
                <td>
                  <div class="fc-dt-weather">
                    <span class="ic" v-text="getEmoji(d.weather_main)"></span>
                    <span v-text="d.weather_description || d.weather_main || 'Berawan'"></span>
                  </div>
                </td>

                <!-- Suhu dengan Apple Weather Temperature Bar -->
                <td>
                  <div class="fc-dt-temp-wrap">
                    <span class="fc-dt-min" v-text="Math.round(d.temp_min ?? (d.temperature - 5)) + '°'"></span>
                    <div class="fc-temp-bar-bg">
                      <div class="fc-temp-bar-fill" :style="calcBarRange(d.temp_min, d.temp_max)"></div>
                    </div>
                    <span class="fc-dt-max" v-text="Math.round(d.temp_max ?? (d.temperature + 5)) + '°'"></span>
                  </div>
                </td>

                <!-- Peluang Hujan -->
                <td>
                  <div class="fc-dt-rain">
                    <i class="fas fa-droplet"></i>
                    <span v-text="(d.rain_probability ?? 20) + '%'"></span>
                  </div>
                </td>

                <!-- UV Index -->
                <td>
                  <div class="fc-dt-uv">
                    <i class="fas fa-sun"></i>
                    <span v-text="getUvText(d.uv_index)"></span>
                  </div>
                </td>

                <!-- Angin -->
                <td>
                  <div class="fc-dt-wind">
                    <i class="fas fa-wind" style="color:#38BDF8;"></i>
                    <span v-text="Math.round(d.wind_speed ?? 11) + ' km/j'"></span>
                  </div>
                </td>

                <!-- Arrow -->
                <td>
                  <i class="fas fa-chevron-right fc-dt-arrow"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else style="padding:30px;text-align:center;">
          <div class="fc-skeleton" style="height:220px;width:100%;"></div>
        </div>
      </div>

      <!-- Right Column: Radar & Map CTA -->
      <div class="fc-globe-card">
        <div>
          <div class="fc-radar-preview-wrap">
            <div class="fc-radar-crosshair-h"></div>
            <div class="fc-radar-crosshair-v"></div>
            <div class="fc-radar-ring r1"></div>
            <div class="fc-radar-ring r2"></div>
            <div class="fc-radar-ring r3"></div>
            <div class="fc-radar-sweep"></div>
            <div class="fc-radar-blip" style="top:42%;left:58%;"></div>
            <div class="fc-radar-blip" style="top:60%;left:36%;opacity:0.7;"></div>
            <i class="fas fa-satellite-dish" style="position:relative;z-index:2;color:#38BDF8;font-size:22px;filter:drop-shadow(0 0 12px rgba(56,189,248,0.6));"></i>
          </div>
          <div class="fc-globe-text">
            <h4>Radar & Peta Cuaca Jawa Barat</h4>
            <p>Pemantauan awan hujan real-time beresolusi tinggi</p>
          </div>
        </div>

        <a href="{{ route('map') }}" class="fc-globe-btn">
          <span>Jelajahi Peta Interaktif</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>

    </div><!-- /fc-bottom-grid -->

  </div><!-- /fc-container -->
</div><!-- /fc-app -->
@endsection

@push('scripts')
<script>
(function() {
  const { createApp, ref, computed, onMounted, onUnmounted, nextTick } = Vue;

  createApp({
    setup() {
      const isDark = ref(localStorage.getItem('darkMode') === 'true');
      const hourly = ref([]);
      const daily = ref([]);
      const hourlyStep = ref(1);
      const dailyDays = ref(7);
      const selectedCity = ref(localStorage.getItem('forecastCity') || '31.71');
      const lastSyncText = ref('15 Okt 2026 23:27 WIB');

      const cityData = {
        '31.71': { name: 'DKI Jakarta', sub: 'Ibukota Negara', thumb: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80', rotY: -1.85 },
        '35.78': { name: 'Kota Surabaya', sub: 'Jawa Timur', thumb: 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?auto=format&fit=crop&w=120&q=80', rotY: -1.70 },
        '33.74': { name: 'Kota Semarang', sub: 'Jawa Tengah', thumb: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=120&q=80', rotY: -1.78 },
        '34.71': { name: 'Kota Yogyakarta', sub: 'D.I. Yogyakarta', thumb: 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=120&q=80', rotY: -1.78 },
        '51.71': { name: 'Kota Denpasar', sub: 'Bali', thumb: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=120&q=80', rotY: -1.63 },
        '12.71': { name: 'Kota Medan', sub: 'Sumatera Utara', thumb: 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?auto=format&fit=crop&w=120&q=80', rotY: -2.15 },
        '73.71': { name: 'Kota Makassar', sub: 'Sulawesi Selatan', thumb: 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?auto=format&fit=crop&w=120&q=80', rotY: -1.50 },
        '16.71': { name: 'Kota Palembang', sub: 'Sumatera Selatan', thumb: 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?auto=format&fit=crop&w=120&q=80', rotY: -2.00 },
        '64.71': { name: 'Kota Balikpapan', sub: 'Kalimantan Timur', thumb: 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=120&q=80', rotY: -1.60 },
        '71.71': { name: 'Kota Manado', sub: 'Sulawesi Utara', thumb: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=120&q=80', rotY: -1.45 },
        // Jawa Barat - Kota
        '32.73': { name: 'Kota Bandung', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.71': { name: 'Kota Bogor', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.75': { name: 'Kota Bekasi', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.76': { name: 'Kota Depok', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.77': { name: 'Kota Cimahi', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.74': { name: 'Kota Cirebon', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=120&q=80', rotY: -1.83 },
        '32.72': { name: 'Kota Sukabumi', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.78': { name: 'Kota Tasikmalaya', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        '32.79': { name: 'Kota Banjar', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        // Jawa Barat - Kabupaten
        '32.01': { name: 'Kabupaten Bogor', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.04': { name: 'Kabupaten Bandung', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.17': { name: 'Kab. Bandung Barat', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.16': { name: 'Kabupaten Bekasi', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.07': { name: 'Kabupaten Ciamis', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        '32.03': { name: 'Kabupaten Cianjur', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.09': { name: 'Kabupaten Cirebon', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=120&q=80', rotY: -1.83 },
        '32.05': { name: 'Kabupaten Garut', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.85 },
        '32.12': { name: 'Kabupaten Indramayu', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        '32.15': { name: 'Kabupaten Karawang', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.08': { name: 'Kabupaten Kuningan', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        '32.10': { name: 'Kabupaten Majalengka', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 },
        '32.18': { name: 'Kab. Pangandaran', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=120&q=80', rotY: -1.83 },
        '32.14': { name: 'Kabupaten Purwakarta', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.13': { name: 'Kabupaten Subang', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.85 },
        '32.02': { name: 'Kabupaten Sukabumi', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.86 },
        '32.11': { name: 'Kabupaten Sumedang', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.85 },
        '32.06': { name: 'Kab. Tasikmalaya', sub: 'Jawa Barat', thumb: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80', rotY: -1.84 }
      };

      const selectedCityName = computed(() => cityData[selectedCity.value]?.name || 'DKI Jakarta');
      const citySubtext = computed(() => cityData[selectedCity.value]?.sub || 'Indonesia');
      const cityThumb = computed(() => cityData[selectedCity.value]?.thumb || 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=120&q=80');

      const todayDateLabel = computed(() => {
        const d = new Date();
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return 'Hari ini, ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
      });

      // Hero weather stats
      const currentWeather = computed(() => {
        if (hourly.value && hourly.value.length) {
          const h = hourly.value[0];
          return {
            temperature: h.temperature,
            weather_main: h.weather_main,
            weather_description: h.weather_description,
            humidity: h.humidity ?? 69,
            wind_speed: (h.wind_speed ? (h.wind_speed * 3.6).toFixed(1) : '7.9'),
            pressure: 1011
          };
        }
        return {
          temperature: 22,
          weather_main: 'Berawan Tebal',
          weather_description: 'Berawan Tebal',
          humidity: 69,
          wind_speed: 7.9,
          pressure: 1011
        };
      });

      const recomText = computed(() => {
        const m = (currentWeather.value?.weather_description || '').toLowerCase();
        if (m.includes('hujan')) return 'Potensi hujan terdeteksi, siapkan payung atau jas hujan.';
        return 'Cerah berawan, tetap waspada perubahan cuaca.';
      });

      const toggleDark = () => {
        isDark.value = !isDark.value;
        localStorage.setItem('darkMode', isDark.value);
        if (isDark.value) document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
      };

      const getEmoji = (m) => {
        if (!m) return '☁️';
        const str = m.toLowerCase();
        if (str.includes('petir') || str.includes('thunder')) return '⛈️';
        if (str.includes('lebat') || str.includes('sedang')) return '🌧️';
        if (str.includes('hujan') || str.includes('rain')) return '🌧️';
        if (str.includes('gerimis') || str.includes('drizzle')) return '🌦️';
        if (str.includes('tebal') || str.includes('mendung')) return '☁️';
        if (str.includes('berawan') || str.includes('cloud')) return '⛅';
        if (str.includes('cerah') || str.includes('clear')) return '☀️';
        if (str.includes('kabut') || str.includes('fog')) return '🌫️';
        return '☁️';
      };

      const formatHour = (d) => {
        if (!d) return '--:00';
        const dt = new Date(d);
        if (isNaN(dt)) return '--:00';
        const h = dt.getHours();
        return (h < 10 ? '0' : '') + h + ':00';
      };

      const formatDayTitle = (d) => {
        if (!d) return '-';
        const dt = new Date(d);
        if (isNaN(dt)) return '-';
        const days = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return days[dt.getDay()] + ', ' + dt.getDate() + ' ' + months[dt.getMonth()];
      };

      const formatDaySubtitle = (d) => {
        if (!d) return '';
        const dt = new Date(d);
        if (isNaN(dt)) return '';
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        return days[dt.getDay()];
      };

      const getUvText = (uv) => {
        if (uv === undefined || uv === null) return '7 (Tinggi)';
        const u = Math.round(uv);
        if (u <= 2) return u + ' (Rendah)';
        if (u <= 5) return u + ' (Sedang)';
        if (u <= 7) return u + ' (Tinggi)';
        if (u <= 10) return u + ' (Sangat Tinggi)';
        return u + ' (Ekstrem)';
      };

      const calcBarRange = (min, max) => {
        const actualMin = min ?? 18;
        const actualMax = max ?? 34;
        const lowerBound = 15;
        const upperBound = 40;
        const leftPercent = Math.max(0, Math.min(100, ((actualMin - lowerBound) / (upperBound - lowerBound)) * 100));
        const rightPercent = Math.max(0, Math.min(100, ((actualMax - lowerBound) / (upperBound - lowerBound)) * 100));
        const width = Math.max(20, rightPercent - leftPercent);
        return {
          left: leftPercent + '%',
          width: width + '%'
        };
      };

      // Filtered hourly by step
      const filteredHourly = computed(() => {
        if (!hourly.value.length) return [];
        const step = hourlyStep.value;
        const result = [];
        for (let i = 0; i < hourly.value.length; i += step) {
          result.push(hourly.value[i]);
        }
        return result;
      });

      const setHourlyStep = (s) => { hourlyStep.value = s; };

      const scrollHourly = (amount) => {
        const track = document.getElementById('hourlyTrack');
        if (track) track.scrollBy({ left: amount, behavior: 'smooth' });
      };

      const previewHourly = (h) => {
        if (h && h.temperature) {
          currentWeather.value.temperature = h.temperature;
          currentWeather.value.weather_description = h.weather_description || h.weather_main;
          currentWeather.value.weather_main = h.weather_main;
        }
      };

      const previewDaily = (d) => {
        if (d && d.temperature) {
          currentWeather.value.temperature = d.temperature;
          currentWeather.value.weather_description = d.weather_description || d.weather_main;
          currentWeather.value.weather_main = d.weather_main;
        }
      };

      const loadData = async () => {
        try {
          const [hRes, dRes] = await Promise.all([
            fetch('/api/weather/forecast/hourly?city_code=' + selectedCity.value + '&limit=72'),
            fetch('/api/weather/forecast/daily?city_code=' + selectedCity.value + '&days=' + dailyDays.value)
          ]);
          const h = await hRes.json();
          if (h.success && h.data) hourly.value = h.data;

          const d = await dRes.json();
          if (d.success && d.data) daily.value = d.data;

          const now = new Date();
          lastSyncText.value = now.getDate() + ' ' + ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][now.getMonth()] + ' ' + now.getFullYear() + ' ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        } catch (e) {
          console.error(e);
        }
      };

      const changeCity = () => {
        localStorage.setItem('forecastCity', selectedCity.value);
        loadData();
      };

      const setDailyDays = (d) => {
        dailyDays.value = d;
        loadData();
      };

      onMounted(() => {
        loadData();
      });

      return {
        isDark, hourly, daily, hourlyStep, dailyDays,
        selectedCity, selectedCityName, citySubtext, cityThumb, todayDateLabel, currentWeather, recomText, lastSyncText,
        changeCity, filteredHourly, toggleDark, getEmoji,
        formatHour, formatDayTitle, formatDaySubtitle, getUvText,
        calcBarRange, setHourlyStep, scrollHourly, setDailyDays,
        previewHourly, previewDaily
      };
    }
  }).mount('#fc-app');
})();
</script>
@endpush

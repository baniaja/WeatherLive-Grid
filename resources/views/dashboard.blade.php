@extends('layouts.app')
@section('title', 'WeatherLive-Grid — Cuaca Dunia dalam Satu Genggaman')
@section('styles')
<style>
/* ===== DASHBOARD V5 — CINEMATIC ULTRA-DYNAMIC LAYOUT ===== */

:root {
  --sb-w: 240px;
  --top-h: 70px;
  --dash-bg: #050b17;
  --dash-card: rgba(8, 18, 38, 0.78);
  --dash-card-hover: rgba(13, 27, 56, 0.88);
  --dash-card-border: rgba(56, 189, 248, 0.16);
  --dash-card-border-glow: rgba(56, 189, 248, 0.4);
  --dash-accent: #38BDF8;
  --dash-primary: #2563EB;
  --dash-emerald: #10B981;
  --dash-amber: #F59E0B;
  --dash-text: #F1F5F9;
  --dash-muted: #8FA3BF;
}

/* Base resets & override layouts */
.floating-nav { display: none !important; }
footer.glass { display: none !important; }
#global-mobile-menu { display: none !important; }
.main-content { padding-top: 0 !important; }
#main-content { padding-top: 0 !important; }

body {
  overflow-x: hidden;
  color: var(--dash-text);
  font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  background-color: var(--dash-bg) !important;
  min-height: 100vh;
  position: relative;
}

/* Cinematic Background — Pure CSS (zero network requests) */
.db-viewport-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  background:
    radial-gradient(ellipse at 20% 0%, rgba(30, 58, 138, 0.45) 0%, transparent 55%),
    radial-gradient(ellipse at 80% 10%, rgba(56, 189, 248, 0.12) 0%, transparent 45%),
    radial-gradient(ellipse at 50% 80%, rgba(15, 23, 42, 0.95) 0%, transparent 70%),
    linear-gradient(180deg, #0a1628 0%, #060d1a 40%, #030810 100%);
  pointer-events: none;
}

/* Subtle Floating Weather Particles / Stars */
.db-particles {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1px, transparent 1px);
  background-size: 80px 80px;
  opacity: 0.35;
  animation: particlesDrift 60s linear infinite;
}
@keyframes particlesDrift {
  from { transform: translateY(0); }
  to { transform: translateY(-80px); }
}

/* ===== FIXED LEFT SIDEBAR ===== */
.db-sidebar {
  position: fixed;
  top: 0; left: 0; bottom: 0;
  width: var(--sb-w);
  z-index: 100;
  background: rgba(6, 14, 30, 0.85);
  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);
  border-right: 1px solid rgba(56, 189, 248, 0.12);
  display: flex;
  flex-direction: column;
  padding: 22px 16px 18px;
  box-shadow: 8px 0 32px rgba(0, 0, 0, 0.4);
}

.db-sidebar-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 4px 18px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  margin-bottom: 18px;
  text-decoration: none;
}
.db-sidebar-brand .brand-logo {
  width: 42px; height: 42px; border-radius: 14px;
  background: linear-gradient(135deg, #2563EB, #38BDF8);
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; color: #fff; flex-shrink: 0;
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.45);
  transition: transform .3s;
}
.db-sidebar-brand:hover .brand-logo { transform: rotate(8deg) scale(1.05); }
.db-sidebar-brand .brand-text h2 {
  font-size: 15px; font-weight: 800; color: #fff;
  font-family: 'Space Grotesk', sans-serif; line-height: 1.15;
}
.db-sidebar-brand .brand-text h2 span { color: #38BDF8; }
.db-sidebar-brand .brand-text p {
  font-size: 10px; color: var(--dash-muted); font-weight: 500; margin-top: 3px;
}

/* Nav Menu */
.db-nav-list {
  display: flex; flex-direction: column; gap: 4px; flex: 1;
}
.db-nav-item {
  display: flex; align-items: center; gap: 12px;
  padding: 10px 14px; border-radius: 14px;
  color: var(--dash-muted); font-size: 13px; font-weight: 700;
  text-decoration: none; transition: all .25s ease;
  border: 1px solid transparent;
  position: relative;
}
.db-nav-item i { width: 18px; text-align: center; font-size: 14px; transition: transform .25s; }
.db-nav-item:hover {
  background: rgba(56, 189, 248, 0.08); color: #F1F5F9;
  border-color: rgba(56, 189, 248, 0.18);
  transform: translateX(3px);
}
.db-nav-item:hover i { transform: scale(1.15); color: #38BDF8; }
.db-nav-item.active {
  background: linear-gradient(135deg, rgba(37, 99, 235, 0.35), rgba(56, 189, 248, 0.18));
  color: #38BDF8;
  border-color: rgba(56, 189, 248, 0.38);
  box-shadow: 0 4px 20px rgba(37, 99, 235, 0.25);
}
.db-nav-item.active i {
  color: #38BDF8;
  filter: drop-shadow(0 0 8px rgba(56, 189, 248, 0.6));
}
.db-nav-item .badge-beta {
  margin-left: auto; font-size: 9px; font-weight: 800;
  padding: 2px 8px; border-radius: 999px;
  background: rgba(56, 189, 248, 0.2);
  border: 1px solid rgba(56, 189, 248, 0.4);
  color: #38BDF8;
}

/* Handwritten Script Quote in Sidebar */
.db-sidebar-quote {
  padding: 12px 10px;
  font-family: 'Caveat', cursive;
  font-size: 18px;
  line-height: 1.25;
  color: rgba(226, 232, 240, 0.85);
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
  pointer-events: none;
}

/* AI Assistant Card in Sidebar Bottom */
.db-ai-card {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 14px; border-radius: 16px;
  background: linear-gradient(135deg, rgba(14, 28, 60, 0.85), rgba(30, 58, 138, 0.45));
  border: 1px solid rgba(56, 189, 248, 0.28);
  cursor: pointer;
  transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
  margin-top: 8px;
}
.db-ai-card:hover {
  transform: translateY(-2px);
  border-color: rgba(56, 189, 248, 0.55);
  box-shadow: 0 10px 28px rgba(56, 189, 248, 0.25);
}
.db-ai-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, #0284C7, #38BDF8);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 14px; flex-shrink: 0;
  box-shadow: 0 0 14px rgba(56, 189, 248, 0.5);
  animation: pulseAiGlow 3s ease-in-out infinite;
}
@keyframes pulseAiGlow {
  0%, 100% { box-shadow: 0 0 12px rgba(56, 189, 248, 0.4); }
  50% { box-shadow: 0 0 22px rgba(56, 189, 248, 0.85); }
}
.db-ai-info { flex: 1; min-width: 0; }
.db-ai-title { font-size: 12px; font-weight: 800; color: #F8FAFC; }
.db-ai-sub { font-size: 10px; color: var(--dash-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px; }

/* ===== TOP BAR ===== */
.db-topbar {
  position: fixed; top: 0; left: var(--sb-w); right: 0;
  height: var(--top-h); z-index: 90;
  background: rgba(6, 14, 30, 0.8);
  backdrop-filter: blur(28px);
  -webkit-backdrop-filter: blur(28px);
  border-bottom: 1px solid rgba(56, 189, 248, 0.12);
  display: flex; align-items: center; gap: 16px;
  padding: 0 28px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
}
.db-search {
  flex: 1; max-width: 580px; display: flex; align-items: center; gap: 10px;
  padding: 10px 16px; border-radius: 16px;
  background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08);
  transition: all .3s;
}
.db-search:focus-within {
  border-color: rgba(56, 189, 248, 0.45);
  box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
  background: rgba(255, 255, 255, 0.08);
}
.db-search i { color: #38BDF8; font-size: 14px; }
.db-search input {
  flex: 1; background: none; border: none; outline: none;
  color: #F8FAFC; font-size: 13px; font-weight: 600;
}
.db-search input::placeholder { color: rgba(148, 163, 184, 0.55); font-weight: 500; }
.db-search-badge {
  font-size: 10px; font-weight: 800; padding: 2px 7px;
  border-radius: 6px; background: rgba(255, 255, 255, 0.08);
  color: var(--dash-muted); border: 1px solid rgba(255, 255, 255, 0.12);
}

.db-topbar-right {
  display: flex; align-items: center; gap: 14px; margin-left: auto;
}
.db-live-pill {
  display: flex; align-items: center; gap: 6px;
  padding: 6px 14px; border-radius: 999px;
  background: rgba(34, 197, 94, 0.14); border: 1px solid rgba(34, 197, 94, 0.35);
  font-size: 11px; font-weight: 800; color: #4ADE80;
}
.db-live-pill .live-dot {
  width: 6px; height: 6px; border-radius: 50%; background: #22C55E;
  box-shadow: 0 0 8px #22C55E; animation: pulseDot 2s ease-in-out infinite;
}
@keyframes pulseDot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

.db-topbar-datetime { text-align: right; }
.db-topbar-datetime .date { font-size: 12px; font-weight: 700; color: #F1F5F9; }
.db-topbar-datetime .time { font-size: 10px; color: var(--dash-muted); margin-top: 1px; }

.db-topbar-btn {
  width: 38px; height: 38px; border-radius: 12px; border: none;
  background: rgba(255, 255, 255, 0.05); color: var(--dash-muted);
  cursor: pointer; font-size: 14px; display: flex; align-items: center;
  justify-content: center; transition: all .25s;
}
.db-topbar-btn:hover {
  background: rgba(56, 189, 248, 0.15); color: #38BDF8;
  transform: translateY(-1px);
}
.db-topbar-btn.spinning i { animation: spin 0.8s linear infinite; }
@keyframes spin { 100% { transform: rotate(360deg); } }

.db-topbar-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: #1E293B; border: 1px solid rgba(255, 255, 255, 0.12);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 800; color: #fff;
}

/* Search Dropdown */
.db-search-dropdown {
  position: absolute; top: calc(var(--top-h) + 6px); left: var(--sb-w);
  width: 580px; max-width: calc(100vw - var(--sb-w) - 48px);
  margin-left: 28px; z-index: 999;
  background: rgba(8, 18, 38, 0.98); backdrop-filter: blur(28px);
  border: 1px solid rgba(56, 189, 248, 0.35); border-radius: 18px;
  box-shadow: 0 24px 60px rgba(0, 0, 0, 0.85);
  padding: 12px; max-height: 400px; overflow-y: auto;
  animation: searchDropFade 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes searchDropFade { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; } }
.srd-section { font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #38BDF8; margin: 8px 4px 6px; display: flex; align-items: center; gap: 6px; }
.srd-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; cursor: pointer; transition: all .2s; }
.srd-item:hover, .srd-item.hl { background: rgba(56, 189, 248, 0.15); }
.srd-icon { width: 32px; height: 32px; border-radius: 10px; background: rgba(56, 189, 248, 0.15); color: #38BDF8; display: flex; align-items: center; justify-content: center; font-size: 13px; }
.srd-name { font-size: 12px; font-weight: 700; color: #F8FAFC; }
.srd-sub { font-size: 10px; color: #94A3B8; }
.srd-chip-row { display: flex; flex-wrap: wrap; gap: 6px; margin: 4px 0 8px; }
.srd-chip { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 10px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.08); color: #E2E8F0; font-size: 11px; font-weight: 600; cursor: pointer; transition: all .2s; }
.srd-chip:hover { background: rgba(56, 189, 248, 0.2); border-color: rgba(56, 189, 248, 0.4); color: #38BDF8; }

/* ===== MAIN CONTENT GRID ===== */
.db-main {
  margin-left: var(--sb-w);
  margin-top: var(--top-h);
  min-height: calc(100vh - var(--top-h) - 48px);
  padding: 22px 28px;
  position: relative;
  z-index: 2;
}
.db-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 22px;
  max-width: 1440px;
}

/* Common Card System */
.db-card {
  border-radius: 22px;
  background: var(--dash-card);
  border: 1px solid var(--dash-card-border);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  overflow: hidden;
  transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
}
.db-card:hover {
  border-color: var(--dash-card-border-glow);
  box-shadow: 0 14px 40px rgba(0, 0, 0, 0.45);
}
.db-card-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 22px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.db-card-head h3 {
  font-size: 14px; font-weight: 800; color: var(--dash-text);
  font-family: 'Space Grotesk', sans-serif;
  display: flex; align-items: center; gap: 8px;
}
.db-card-head h3 i { color: #38BDF8; font-size: 14px; }
.db-card-head .card-link {
  font-size: 11px; font-weight: 700; color: #38BDF8;
  text-decoration: none; display: flex; align-items: center; gap: 4px;
  transition: transform .2s;
}
.db-card-head .card-link:hover { transform: translateX(3px); }
.db-card-head .card-pill {
  font-size: 10px; font-weight: 800; padding: 4px 10px;
  border-radius: 999px; letter-spacing: 0.5px;
}
.pill-green { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.3); }

/* ===== HERO WEATHER CARD (CINEMATIC) ===== */
.db-hero {
  border-radius: 26px; overflow: hidden; position: relative;
  background: linear-gradient(135deg, rgba(8, 20, 46, 0.92) 0%, rgba(13, 38, 86, 0.85) 60%, rgba(29, 78, 216, 0.45) 100%);
  border: 1px solid rgba(56, 189, 248, 0.22);
  min-height: 400px;
  display: grid; grid-template-columns: 1fr 1fr;
  box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5);
}
.db-hero::before {
  content: ''; position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse at 85% 30%, rgba(56, 189, 248, 0.22), transparent 55%),
    radial-gradient(ellipse at 20% 80%, rgba(37, 99, 235, 0.25), transparent 55%);
  pointer-events: none;
}
.db-hero-left {
  position: relative; z-index: 2;
  padding: 28px 32px;
  display: flex; flex-direction: column; justify-content: space-between;
}
.db-hero-right {
  position: relative; z-index: 2;
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
}

/* Floating Feels Like Mini-Card at top right of hero */
.hero-feels-floating {
  position: absolute; top: 24px; right: 28px; z-index: 10;
  display: flex; align-items: center; gap: 10px;
  padding: 8px 14px; border-radius: 16px;
  background: rgba(8, 20, 46, 0.82); border: 1px solid rgba(56, 189, 248, 0.25);
  backdrop-filter: blur(14px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
  animation: floatMini 4s ease-in-out infinite;
}
@keyframes floatMini {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-4px); }
}
.hero-feels-floating .fl-icon { font-size: 20px; }
.hero-feels-floating .fl-temp { font-size: 15px; font-weight: 800; color: #fff; }
.hero-feels-floating .fl-sub { font-size: 10px; color: var(--dash-muted); }

/* Hero Location Header */
.hero-loc-name {
  font-size: 24px; font-weight: 900; color: #fff;
  font-family: 'Space Grotesk', sans-serif;
  display: flex; align-items: center; gap: 8px; margin-bottom: 4px;
}
.hero-loc-name i { color: #38BDF8; font-size: 18px; }
.hero-loc-sub {
  font-size: 12px; color: var(--dash-muted); font-weight: 600;
  display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
}
.hero-loc-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 10px; font-weight: 800; padding: 3px 10px;
  border-radius: 999px; background: rgba(37, 99, 235, 0.28);
  border: 1px solid rgba(56, 189, 248, 0.45); color: #38BDF8;
}
.hero-loc-badge::before {
  content: ''; width: 5px; height: 5px; border-radius: 50%;
  background: #38BDF8; box-shadow: 0 0 6px #38BDF8;
}

/* Weather Display */
.hero-weather-row {
  display: flex; align-items: center; gap: 18px; margin-bottom: 8px;
}
.hero-weather-icon {
  font-size: 76px; line-height: 1;
  filter: drop-shadow(0 10px 28px rgba(56, 189, 248, 0.35));
  animation: float3d 4s ease-in-out infinite;
}
@keyframes float3d {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
.hero-temp-big {
  font-size: 72px; font-weight: 900; color: #fff;
  font-family: 'Space Grotesk', sans-serif; line-height: 1;
  letter-spacing: -3px;
}
.hero-temp-big sup { font-size: 30px; font-weight: 800; letter-spacing: 0; }

.hero-cond-title {
  font-size: 17px; font-weight: 800; color: #fff;
  margin-bottom: 4px;
}
.hero-cond-feels {
  font-size: 12px; color: var(--dash-muted); font-weight: 600;
  display: flex; align-items: center; gap: 6px; margin-bottom: 18px;
}

/* 4 Metric Chips */
.hero-chips-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
  margin-bottom: 16px;
}
.hero-chip {
  display: flex; align-items: center; gap: 8px;
  padding: 8px 12px; border-radius: 14px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.07);
  transition: all .25s;
}
.hero-chip:hover {
  background: rgba(56, 189, 248, 0.12);
  border-color: rgba(56, 189, 248, 0.3);
  transform: translateY(-2px);
}
.hero-chip-icon {
  width: 28px; height: 28px; border-radius: 8px;
  background: rgba(56, 189, 248, 0.15); color: #38BDF8;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; flex-shrink: 0;
}
.hero-chip-text .val { font-size: 12px; font-weight: 800; color: #fff; }
.hero-chip-text .lbl { font-size: 9px; color: var(--dash-muted); font-weight: 600; }

/* Dynamic Alert/Info Strip */
.hero-info-strip {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 14px; border-radius: 12px;
  background: rgba(8, 16, 36, 0.65);
  border: 1px solid rgba(56, 189, 248, 0.18);
  font-size: 11px; color: #CBD5E1; line-height: 1.45;
}
.hero-info-strip i { color: #38BDF8; font-size: 13px; flex-shrink: 0; }

/* Globe Container in Hero Right */
.hero-globe-wrap {
  position: relative; width: 300px; height: 300px;
}
.hero-globe-wrap::after {
  content: ''; position: absolute;
  inset: -14px; border-radius: 50%;
  border: 1px dashed rgba(56, 189, 248, 0.28);
  transform: rotate(-25deg);
  pointer-events: none;
  animation: orbitSpin 40s linear infinite;
}
@keyframes orbitSpin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
.hero-globe-wrap::before {
  content: ''; position: absolute;
  inset: -28px; border-radius: 50%;
  border: 1px solid rgba(56, 189, 248, 0.14);
  transform: rotate(45deg);
  pointer-events: none;
}
.hero-globe-container {
  width: 100%; height: 100%; border-radius: 50%;
  overflow: hidden; position: relative;
  box-shadow: 0 0 50px rgba(56, 189, 248, 0.25), inset 0 0 40px rgba(14, 165, 233, 0.35);
  background: radial-gradient(circle at 40% 40%, #1e3a8a 0%, #0c1a36 60%, #030814 100%);
  border: 1.5px solid rgba(56, 189, 248, 0.4);
}
.hero-radar-sweep {
  position: absolute; inset: 0; border-radius: 50%;
  background: conic-gradient(from 0deg, transparent 0deg, transparent 270deg, rgba(56, 189, 248, 0.35) 360deg);
  animation: radarSpin 4s linear infinite;
  pointer-events: none;
}
@keyframes radarSpin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
.hero-radar-rings {
  position: absolute; inset: 0; border-radius: 50%; pointer-events: none;
  background-image: radial-gradient(circle, transparent 35px, rgba(56, 189, 248, 0.15) 36px, transparent 37px, transparent 70px, rgba(56, 189, 248, 0.12) 71px, transparent 72px, transparent 110px, rgba(56, 189, 248, 0.1) 111px, transparent 112px);
}
.hero-radar-grid {
  position: absolute; inset: 0; pointer-events: none;
  background-image: linear-gradient(rgba(56, 189, 248, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(56, 189, 248, 0.08) 1px, transparent 1px);
  background-size: 25px 25px;
  background-position: center center;
}
.hero-globe-pin {
  position: absolute;
  top: 51%; left: 53%; transform: translate(-50%, -50%);
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(56, 189, 248, 0.35);
  display: flex; align-items: center; justify-content: center;
  color: #38BDF8; font-size: 15px;
  filter: drop-shadow(0 0 12px #38BDF8);
  pointer-events: none; z-index: 6;
  animation: pinPulse 2s ease-in-out infinite;
}
@keyframes pinPulse {
  0%, 100% { transform: translate(-50%, -50%) scale(1); }
  50% { transform: translate(-50%, -50%) scale(1.18); }
}
.hero-globe-label {
  position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
  display: flex; align-items: center; gap: 6px;
  padding: 6px 16px; border-radius: 999px;
  background: rgba(8, 16, 36, 0.88); border: 1px solid rgba(56, 189, 248, 0.3);
  backdrop-filter: blur(12px); z-index: 5;
}
.hero-globe-label i { color: #38BDF8; font-size: 12px; }
.hero-globe-label span { font-size: 12px; font-weight: 700; color: #E2E8F0; }

/* ===== 7-DAY FORECAST ===== */
.forecast-7d-grid {
  display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px;
}
.fc7-item {
  text-align: center; padding: 16px 8px; border-radius: 18px;
  background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.06);
  cursor: pointer; transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}
.fc7-item:hover {
  background: rgba(56, 189, 248, 0.1); border-color: rgba(56, 189, 248, 0.35);
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}
.fc7-item.active {
  background: linear-gradient(135deg, rgba(37, 99, 235, 0.35), rgba(56, 189, 248, 0.22));
  border-color: #38BDF8;
  box-shadow: 0 8px 28px rgba(37, 99, 235, 0.35);
}
.fc7-day { font-size: 13px; font-weight: 800; color: var(--dash-text); margin-bottom: 2px; }
.fc7-date { font-size: 10px; color: var(--dash-muted); margin-bottom: 10px; }
.fc7-icon { font-size: 32px; margin-bottom: 10px; line-height: 1; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3)); }
.fc7-temp { font-size: 13px; font-weight: 800; color: var(--dash-text); }
.fc7-cond { font-size: 10px; color: var(--dash-muted); margin-top: 4px; line-height: 1.3; }

/* ===== RIGHT SIDEBAR CARDS ===== */
.db-right { display: flex; flex-direction: column; gap: 18px; }

/* 1. Kondisi Cuaca Sekarang (6 Metrics Grid) */
.now-metrics-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;
  margin-bottom: 14px;
}
.nm-item {
  text-align: center; padding: 12px 6px; border-radius: 14px;
  background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.06);
  transition: all .25s;
}
.nm-item:hover {
  background: rgba(56, 189, 248, 0.1); border-color: rgba(56, 189, 248, 0.25);
  transform: translateY(-2px);
}
.nm-icon { font-size: 22px; margin-bottom: 6px; line-height: 1; }
.nm-val { font-size: 15px; font-weight: 900; color: #fff; font-family: 'Space Grotesk'; }
.nm-lbl { font-size: 10px; color: var(--dash-muted); font-weight: 600; margin-top: 2px; }

/* Recommendation Box */
.now-recom-box {
  display: flex; align-items: center; justify-content: space-between;
  padding: 12px 14px; border-radius: 14px;
  background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.22);
  cursor: pointer; transition: all .25s;
}
.now-recom-box:hover {
  background: rgba(245, 158, 11, 0.14); border-color: rgba(245, 158, 11, 0.38);
  transform: translateY(-1px);
}
.now-recom-left { display: flex; align-items: flex-start; gap: 10px; }
.now-recom-bulb {
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(245, 158, 11, 0.2); color: #F59E0B;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; flex-shrink: 0;
}
.now-recom-text h5 { font-size: 11px; font-weight: 800; color: #F59E0B; margin-bottom: 2px; }
.now-recom-text p { font-size: 10.5px; color: #CBD5E1; line-height: 1.4; }
.now-recom-arrow { color: var(--dash-muted); font-size: 12px; margin-left: 8px; }

/* 2. Hourly Forecast */
.hourly-compact-grid {
  display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px;
}
.hc-item {
  text-align: center; padding: 12px 4px; border-radius: 14px;
  background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06);
  cursor: pointer; transition: all .25s;
}
.hc-item:hover {
  background: rgba(56, 189, 248, 0.1); border-color: rgba(56, 189, 248, 0.3);
  transform: translateY(-2px);
}
.hc-item.active {
  background: linear-gradient(135deg, rgba(37, 99, 235, 0.4), rgba(56, 189, 248, 0.25));
  border-color: #38BDF8;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
}
.hc-time { font-size: 10px; color: var(--dash-muted); font-weight: 700; margin-bottom: 6px; }
.hc-icon { font-size: 22px; margin-bottom: 6px; line-height: 1; }
.hc-temp { font-size: 13px; font-weight: 800; color: var(--dash-text); }

/* 3. Air Quality Gauge */
.aqi-wrap { display: flex; align-items: center; gap: 16px; padding: 4px 0; }
.aqi-gauge-box {
  position: relative; width: 110px; height: 110px; flex-shrink: 0;
}
.aqi-gauge-box svg { transform: rotate(-90deg); }
.aqi-gauge-center {
  position: absolute; inset: 0;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.aqi-val { font-size: 30px; font-weight: 900; font-family: 'Space Grotesk'; line-height: 1; }
.aqi-sub { font-size: 10px; font-weight: 800; color: var(--dash-muted); letter-spacing: 1px; margin-top: 2px; }
.aqi-metrics { flex: 1; display: flex; flex-direction: column; gap: 8px; }
.aqi-metric-row {
  display: flex; justify-content: space-between;
  font-size: 11px; color: var(--dash-muted); font-weight: 600;
}
.aqi-metric-row span:last-child { color: var(--dash-text); font-weight: 700; }
.aqi-badge-alert {
  display: flex; align-items: center; gap: 8px;
  padding: 8px 12px; border-radius: 12px;
  background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.2);
  margin-top: 12px; font-size: 10.5px; color: #CBD5E1; line-height: 1.4;
}
.aqi-badge-alert i { color: #22C55E; font-size: 13px; flex-shrink: 0; }

/* ===== FOOTER BAR ===== */
.db-footer {
  margin-left: var(--sb-w);
  height: 48px;
  padding: 0 28px;
  display: flex; align-items: center; justify-content: space-between;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  background: rgba(6, 14, 30, 0.7);
  backdrop-filter: blur(20px);
  font-size: 11px; color: var(--dash-muted);
  position: relative; z-index: 2;
}
.db-footer-left { display: flex; align-items: center; gap: 12px; }
.db-footer-pill {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 3px 10px; border-radius: 999px;
  background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1);
  color: #fff; font-weight: 700;
}
.db-footer-right { display: flex; align-items: center; gap: 16px; }

/* ===== RESPONSIVE ===== */
@media(max-width: 1200px) {
  .db-grid { grid-template-columns: 1fr; }
  .db-right { display: grid; grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 900px) {
  .db-sidebar { display: none; }
  .db-topbar { left: 0; }
  .db-main { margin-left: 0; }
  .db-footer { margin-left: 0; }
  .db-hero { grid-template-columns: 1fr; }
  .db-hero-right { display: none; }
  .forecast-7d-grid { grid-template-columns: repeat(4, 1fr); }
  .db-right { grid-template-columns: 1fr; }
  .db-search-dropdown { left: 0; margin-left: 20px; }
}
@media(max-width: 640px) {
  .forecast-7d-grid { grid-template-columns: repeat(3, 1fr); }
  .hero-chips-grid { grid-template-columns: repeat(2, 1fr); }
  .hourly-compact-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endsection

@section('content')
<!-- Ambient Mountain & Particle Viewport -->
<div class="db-viewport-bg" aria-hidden="true"></div>
<div class="db-particles" aria-hidden="true"></div>

<div id="dash-app" v-cloak>

  <!-- ===== FIXED LEFT SIDEBAR ===== -->
  <aside class="db-sidebar">
    <a href="{{ route('dashboard') }}" class="db-sidebar-brand">
      <div class="brand-logo"><i class="fas fa-cloud-sun"></i></div>
      <div class="brand-text">
        <h2>WeatherLive<span>-Grid</span></h2>
        <p>Weather Command Center · Cuaca Dunia dalam Satu Genggaman</p>
      </div>
    </a>

    <div class="db-nav-list">
      <a href="{{ route('dashboard') }}" class="db-nav-item active">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
      <a href="{{ route('forecast') }}" class="db-nav-item">
        <i class="fas fa-calendar-alt"></i> Prakiraan
      </a>
      <a href="{{ route('map') }}" class="db-nav-item">
        <i class="fas fa-map"></i> Peta Cuaca
      </a>
      <a href="{{ route('analytics') }}" class="db-nav-item">
        <i class="fas fa-chart-line"></i> Analisis
      </a>
      <a href="{{ route('compare') }}" class="db-nav-item">
        <i class="fas fa-scale-balanced"></i> Bandingkan
      </a>
      <a href="{{ route('widget') }}" class="db-nav-item">
        <i class="fas fa-window-maximize"></i> Widget Web
      </a>
      <a href="{{ route('services') }}" class="db-nav-item">
        <i class="fas fa-handshake-angle"></i> Layanan Stamet
        <span class="badge-beta" style="background:rgba(34,197,94,0.18);border-color:rgba(34,197,94,0.4);color:#4ade80;">PTSP</span>
      </a>
      <button class="db-nav-item" @click="triggerAI" style="background:none;border:none;cursor:pointer;width:100%;text-align:left;">
        <i class="fas fa-wand-magic-sparkles"></i> Fitur AI
        <span class="badge-beta">Beta</span>
      </button>
      <button class="db-nav-item" onclick="window.openProfileAuth()" style="background:none;border:none;cursor:pointer;width:100%;text-align:left;">
        <i class="fas fa-user-circle"></i> Masuk / Akun
      </button>
      <a href="{{ route('developer') }}" class="db-nav-item">
        <i class="fas fa-gear"></i> Pengaturan
      </a>
    </div>

    <!-- Script Handwriting Quote in Sidebar -->
    <div class="db-sidebar-quote">
      Cuaca hari ini,<br>
      untuk langkah<br>
      esok yang lebih baik.
    </div>

    <!-- AI Assistant Interactive Card Widget -->
    <div class="db-ai-card" @click="triggerAI">
      <div class="db-ai-avatar">
        <i class="fas fa-brain"></i>
      </div>
      <div class="db-ai-info">
        <div class="db-ai-title">AI Weather Assistant</div>
        <div class="db-ai-sub">AI Weather Copilot · Tanya apa saja...</div>
      </div>
    </div>
  </aside>

  <!-- ===== TOP BAR ===== -->
  <header class="db-topbar">
    <div class="db-search">
      <i class="fas fa-search"></i>
      <input type="text"
             v-model="searchQ"
             @input="onSearch"
             @keydown="onSearchKeydown"
             @focus="onSearchFocus"
             @blur="onSearchBlur"
             placeholder="Cari kota, wilayah, atau koordinat... (contoh: Bogor, Jakarta, Bandung)"
             autocomplete="off" />
      <span class="db-search-badge">Ctrl + K</span>
    </div>

    <div class="db-topbar-right">
      <div class="db-live-pill"><span class="live-dot"></span> Live</div>
      <div class="db-topbar-datetime">
        <div class="date" v-text="liveDate"></div>
        <div class="time" v-text="liveClock"></div>
      </div>
      <button class="db-topbar-btn" :class="{ spinning: isRefreshing }" @click="refreshData" title="Sinkronisasi Data">
        <i class="fas fa-rotate"></i>
      </button>
      <button class="db-topbar-btn" @click="toggleUnit" title="Ubah Satuan Suhu">
        <i class="fas fa-sun"></i>
      </button>
      <button type="button" class="db-topbar-avatar" onclick="window.openProfileAuth()" style="border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#2563eb,#38bdf8);color:#fff;" title="Masuk Akun / Profil"><i class="fas fa-user-circle" style="font-size:18px;"></i></button>
    </div>
  </header>

  <!-- Search Dropdown Autocomplete -->
  <div v-if="searchDropdownOpen" class="db-search-dropdown">
    <div v-if="searchQ && searchLoading" style="padding:16px;text-align:center;color:#38BDF8;font-size:12px;">
      <i class="fas fa-spinner fa-spin"></i> Memuat lokasi...
    </div>
    <div v-else-if="searchQ && searchResults.length">
      <div class="srd-section"><i class="fas fa-map-marker-alt"></i> Hasil Pencarian</div>
      <div v-for="(item,idx) in searchResults.slice(0,8)"
           :key="idx"
           class="srd-item"
           :class="{hl: searchHighlight === idx}"
           @mousedown.prevent="selectSearch(item)"
           @mouseenter="searchHighlight = idx">
        <div class="srd-icon"><i :class="getSearchIcon(item.type)"></i></div>
        <div style="flex:1;min-width:0;">
          <div class="srd-name" v-text="item.name"></div>
          <div class="srd-sub" v-text="item.sub"></div>
        </div>
      </div>
    </div>
    <div v-else-if="searchQ && !searchLoading" style="padding:16px;text-align:center;color:#94A3B8;font-size:12px;">
      Tidak ditemukan untuk "<b v-text="searchQ"></b>"
    </div>
    <div v-else>
      <div class="srd-section"><i class="fas fa-fire" style="color:#EC4899;"></i> Akses Cepat Kota Jawa Barat</div>
      <div class="srd-chip-row">
        <button class="srd-chip" @click="quickSelectCity('Bogor')"><i class="fas fa-cloud-rain" style="color:#38BDF8;"></i> Bogor</button>
        <button class="srd-chip" @click="quickSelectCity('Bandung')"><i class="fas fa-mountain" style="color:#22C55E;"></i> Bandung</button>
        <button class="srd-chip" @click="quickSelectCity('Bekasi')"><i class="fas fa-city" style="color:#F59E0B;"></i> Bekasi</button>
        <button class="srd-chip" @click="quickSelectCity('Depok')"><i class="fas fa-building" style="color:#A78BFA;"></i> Depok</button>
        <button class="srd-chip" @click="quickSelectCity('Cirebon')"><i class="fas fa-water" style="color:#06B6D4;"></i> Cirebon</button>
        <button class="srd-chip" @click="quickSelectCity('Sukabumi')"><i class="fas fa-sun" style="color:#F59E0B;"></i> Sukabumi</button>
      </div>
    </div>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="db-main">
    <div class="db-grid">

      <!-- LEFT COLUMN -->
      <div style="display:flex;flex-direction:column;gap:20px;">

        <!-- LIVE ANNOUNCEMENT TICKER (CMS MANAGED) -->
        <div v-if="siteAnnouncement" class="hero-info-strip" style="background:linear-gradient(90deg,rgba(15,23,42,0.9),rgba(2,132,199,0.2));border:1px solid rgba(56,189,248,0.35);padding:10px 16px;border-radius:16px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 20px rgba(0,0,0,0.3);">
          <span style="font-size:10px;font-weight:900;background:linear-gradient(135deg,#0284c7,#2563eb);color:#fff;padding:3px 9px;border-radius:6px;letter-spacing:0.5px;flex-shrink:0;">
            <i class="fas fa-bullhorn" style="margin-right:4px;"></i> PENGUMUMAN
          </span>
          <marquee behavior="scroll" direction="left" scrollamount="6" onmouseover="this.stop();" onmouseout="this.start();" style="flex:1;font-weight:600;font-size:12.5px;color:#f1f5f9;" v-text="siteAnnouncement"></marquee>
        </div>

        <!-- HERO WEATHER CARD -->
        <div class="db-hero">

          <!-- Floating Feels Like Pill at top right -->
          <div class="hero-feels-floating">
            <div class="fl-icon">⛅</div>
            <div>
              <div class="fl-temp" v-text="formatTemp(currentWeather?.temperature ?? 25)"></div>
              <div class="fl-sub" v-text="'Feels Like ' + formatTemp(currentWeather?.feels_like ?? 27)"></div>
            </div>
          </div>

          <div class="db-hero-left">
            <div>
              <h1 class="hero-loc-name">
                <i class="fas fa-map-marker-alt"></i>
                <span v-text="currentLocationName || 'Kabupaten Bogor'"></span>
                <i class="fas fa-chevron-down" style="font-size:12px;color:var(--dash-muted);cursor:pointer;" @click="openSearchModal"></i>
              </h1>
              <div class="hero-loc-sub">
                <span v-text="(currentProvinceName || 'Jawa Barat') + ', Indonesia'"></span>
                <span class="hero-loc-badge">Lokasi Saat Ini</span>
              </div>

              <div class="hero-weather-row">
                <div class="hero-weather-icon" v-text="getWeatherEmoji(currentWeather?.weather_main)"></div>
                <div class="hero-temp-big">
                  <span v-text="Math.round(currentWeather?.temperature ?? 25)"></span>
                  <sup v-text="'°' + unit"></sup>
                </div>
              </div>

              <div class="hero-cond-title" v-text="currentWeather?.weather_description || 'Berawan Tebal'"></div>
              <div class="hero-cond-feels">
                <i class="fas fa-temperature-half" style="color:#38BDF8;"></i>
                <span>Terasa seperti <strong v-text="formatTemp(currentWeather?.feels_like ?? 27)"></strong></span>
              </div>
            </div>

            <!-- 4 Metric Chips -->
            <div>
              <div class="hero-chips-grid">
                <div class="hero-chip">
                  <div class="hero-chip-icon"><i class="fas fa-droplet"></i></div>
                  <div class="hero-chip-text">
                    <div class="lbl">Kelembapan</div>
                    <div class="val" v-text="(currentWeather?.humidity ?? 89) + '%'"></div>
                  </div>
                </div>
                <div class="hero-chip">
                  <div class="hero-chip-icon"><i class="fas fa-wind"></i></div>
                  <div class="hero-chip-text">
                    <div class="lbl">Angin</div>
                    <div class="val" v-text="(currentWeather?.wind_speed ?? 6.1) + ' m/s'"></div>
                  </div>
                </div>
                <div class="hero-chip">
                  <div class="hero-chip-icon"><i class="fas fa-gauge-high"></i></div>
                  <div class="hero-chip-text">
                    <div class="lbl">Tekanan</div>
                    <div class="val" v-text="(currentWeather?.pressure ?? 1012.4) + ' hPa'"></div>
                  </div>
                </div>
                <div class="hero-chip">
                  <div class="hero-chip-icon"><i class="fas fa-eye"></i></div>
                  <div class="hero-chip-text">
                    <div class="lbl">Jarak Pandang</div>
                    <div class="val" v-text="(currentWeather?.visibility ? (currentWeather.visibility/1000).toFixed(0) : '10') + ' km'"></div>
                  </div>
                </div>
              </div>

              <!-- Dynamic Alert/Info Strip -->
              <div class="hero-info-strip">
                <i class="fas fa-circle-info"></i>
                <span v-text="aiSummary?.text || ('Langit ' + (currentWeather?.weather_description || 'berawan').toLowerCase() + ' di ' + (currentLocationName || 'KABUPATEN BOGOR').toUpperCase() + ' dengan suhu ' + Math.round(currentWeather?.temperature ?? 24.7) + '°C. Kelembapan ' + (currentWeather?.humidity ?? 89) + '%, udara terasa lembap. Angin sedang (' + (currentWeather?.wind_speed ?? 6.1) + ' m/s).')"></span>
              </div>
            </div>
          </div>

          <!-- Atmospheric Radar in Hero Right -->
          <div class="db-hero-right">
            <div class="hero-globe-wrap" id="heroGlobe">
              <div class="hero-globe-container" title="Radar Pemantauan Atmosfer Jawa Barat">
                <div class="hero-radar-grid"></div>
                <div class="hero-radar-rings"></div>
                <div class="hero-radar-sweep"></div>
                <div class="hero-globe-pin"><i class="fas fa-satellite-dish"></i></div>
              </div>
              <div class="hero-globe-label">
                <i class="fas fa-satellite"></i>
                <span>Radar Atmosfer Aktif</span>
              </div>
            </div>
          </div>
        </div>

        <!-- 7-DAY FORECAST -->
        <div class="db-card">
          <div class="db-card-head">
            <h3><i class="fas fa-calendar-week"></i> Prakiraan 7 Hari ke Depan</h3>
            <a href="{{ route('forecast') }}" class="card-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="db-card-body" style="padding:18px 20px;">
            <div class="forecast-7d-grid">
              <div v-for="(day,i) in dailyForecast.slice(0,7)"
                   :key="i"
                   class="fc7-item"
                   :class="{ active: selectedDayIndex === i }"
                   @click="selectForecastDay(i, day)">
                <div class="fc7-day" v-text="formatDayLabel(day.forecast_for, i)"></div>
                <div class="fc7-date" v-text="formatDateShort(day.forecast_for)"></div>
                <div class="fc7-icon" v-text="getWeatherEmoji(day.weather_main)"></div>
                <div class="fc7-temp" v-text="Math.round(day.temp_max ?? day.temperature ?? 25) + '° / ' + Math.round(day.temp_min ?? (day.temperature - 3) ?? 22) + '°'"></div>
                <div class="fc7-cond" v-text="day.weather_description || day.weather_main || 'Berawan'"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- FITUR & LAYANAN PUBLIK (DYNAMIC CMS MANAGED BY ADMIN) -->
        <div class="db-card">
          <div class="db-card-head">
            <h3><i class="fas fa-layer-group"></i> Layanan & Fitur Publik</h3>
            <span class="card-pill pill-blue"><i class="fas fa-shield-halved"></i> Terintegrasi BMKG</span>
          </div>
          <div class="db-card-body" style="padding:16px 20px;">
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:12px;">
              <a v-for="feat in (portalFeatures.length ? portalFeatures : fallbackFeatures)"
                 :key="feat.id || feat.title"
                 :href="feat.url"
                 class="fc7-item"
                 style="text-decoration:none;display:flex;align-items:center;gap:12px;padding:12px 14px;text-align:left;transition:all 0.25s;">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(56,189,248,0.15);color:#38BDF8;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
                  <i :class="feat.icon || 'fas fa-cloud-sun'"></i>
                </div>
                <div style="flex:1;min-width:0;">
                  <div style="display:flex;align-items:center;gap:6px;">
                    <div style="font-size:13px;font-weight:800;color:#fff;" v-text="feat.title"></div>
                    <span v-if="feat.badge" style="font-size:9px;font-weight:800;padding:1px 6px;border-radius:6px;background:rgba(56,189,248,0.2);color:#38bdf8;border:1px solid rgba(56,189,248,0.35);" v-text="feat.badge"></span>
                  </div>
                  <div style="font-size:10.5px;color:var(--dash-muted);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" v-text="feat.description"></div>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- WARTA CUACA & BULETIN RESMI (ADMIN LIVE MANAGED) -->
        <div v-if="siteBulletin && siteBulletin.title" class="db-card" style="background:linear-gradient(135deg,rgba(15,23,42,0.85),rgba(30,58,138,0.25));border-color:rgba(56,189,248,0.25);">
          <div class="db-card-head" style="padding:14px 20px;">
            <h3 style="font-size:14px;color:#fff;display:flex;align-items:center;gap:8px;">
              <i class="fas fa-newspaper" style="color:#38bdf8;"></i> Warta & Buletin Resmi BMKG
            </h3>
            <span class="card-pill pill-blue"><i class="fas fa-check-circle"></i> Terverifikasi Staf</span>
          </div>
          <div class="db-card-body" style="padding:16px 20px;">
            <h4 style="font-size:14.5px;font-weight:800;color:#f8fafc;margin:0 0 6px;" v-text="siteBulletin.title"></h4>
            <p style="font-size:12px;color:#cbd5e1;line-height:1.6;margin:0 0 10px;" v-text="siteBulletin.desc || siteBulletin.summary"></p>
            <div style="display:flex;align-items:center;justify-content:space-between;font-size:11px;color:#94a3b8;">
              <span><i class="fas fa-shield-halved"></i> Pusat Pengendali Operasional Meteorologi</span>
              <a href="/peringatan" style="color:#38bdf8;text-decoration:none;font-weight:700;">Pantau Peringatan <i class="fas fa-chevron-right" style="font-size:9px;"></i></a>
            </div>
          </div>
        </div>

      </div><!-- /LEFT COLUMN -->

      <!-- RIGHT SIDEBAR -->
      <div class="db-right">

        <!-- 1. Kondisi Cuaca Sekarang -->
        <div class="db-card">
          <div class="db-card-head">
            <h3><i class="fas fa-shield-halved"></i> Kondisi Cuaca Sekarang</h3>
            <span class="card-pill pill-green">● Live</span>
          </div>
          <div class="db-card-body" style="padding:18px 20px;">
            <div class="now-metrics-grid">
              <div class="nm-item">
                <div class="nm-icon">⛅</div>
                <div class="nm-val" v-text="Math.round(currentWeather?.temperature ?? 25) + '°C'"></div>
                <div class="nm-lbl">Suhu Saat Ini</div>
              </div>
              <div class="nm-item">
                <div class="nm-icon" style="color:#38BDF8;">💧</div>
                <div class="nm-val" v-text="(currentWeather?.humidity ?? 89) + '%'"></div>
                <div class="nm-lbl">Kelembapan</div>
              </div>
              <div class="nm-item">
                <div class="nm-icon" style="color:#38BDF8;">💨</div>
                <div class="nm-val" v-text="(currentWeather?.wind_speed ?? 6.1) + ' m/s'"></div>
                <div class="nm-lbl">Angin</div>
              </div>
              <div class="nm-item">
                <div class="nm-icon" style="color:#38BDF8;"><i class="fas fa-gauge-high"></i></div>
                <div class="nm-val" v-text="(currentWeather?.pressure ?? 1012.4) + ' hPa'"></div>
                <div class="nm-lbl">Tekanan</div>
              </div>
              <div class="nm-item">
                <div class="nm-icon" style="color:#38BDF8;"><i class="fas fa-eye"></i></div>
                <div class="nm-val" v-text="(currentWeather?.visibility ? (currentWeather.visibility/1000).toFixed(0) : '10') + ' km'"></div>
                <div class="nm-lbl">Jarak Pandang</div>
              </div>
              <div class="nm-item">
                <div class="nm-icon" style="color:#F59E0B;"><i class="fas fa-sun"></i></div>
                <div class="nm-val" v-text="'UV ' + (currentWeather?.uv_index ?? 2)"></div>
                <div class="nm-lbl">Rendah</div>
              </div>
            </div>

            <!-- Rekomendasi Card -->
            <div class="now-recom-box" @click="triggerAI">
              <div class="now-recom-left">
                <div class="now-recom-bulb"><i class="fas fa-lightbulb"></i></div>
                <div class="now-recom-text">
                  <h5>Rekomendasi</h5>
                  <p v-text="recomText"></p>
                </div>
              </div>
              <i class="fas fa-chevron-right now-recom-arrow"></i>
            </div>
          </div>
        </div>

        <!-- 2. Prakiraan Per Jam -->
        <div class="db-card">
          <div class="db-card-head">
            <h3><i class="fas fa-clock"></i> Prakiraan 24 Jam</h3>
            <a href="{{ route('forecast') }}" class="card-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="db-card-body" style="padding:16px 20px;">
            <div class="hourly-compact-grid">
              <div v-for="(h,i) in hourlyForecast.slice(0,5)"
                   :key="i"
                   class="hc-item"
                   :class="{ active: i === 0 }">
                <div class="hc-time" v-text="formatHour(h.forecast_for)"></div>
                <div class="hc-icon" v-text="getWeatherEmoji(h.weather_main)"></div>
                <div class="hc-temp" v-text="Math.round(h.temperature) + '°'"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Kualitas Udara -->
        <div class="db-card">
          <div class="db-card-head">
            <h3><i class="fas fa-smog"></i> Kualitas Udara</h3>
            <span class="card-pill pill-green" v-text="'● ' + (airQuality?.label || 'Baik')"></span>
          </div>
          <div class="db-card-body" style="padding:16px 20px;">
            <div class="aqi-wrap">
              <div class="aqi-gauge-box">
                <svg width="110" height="110">
                  <circle cx="55" cy="55" r="44" fill="none" stroke="rgba(148,163,184,0.15)" stroke-width="10"/>
                  <circle cx="55" cy="55" r="44" fill="none" :stroke="aqiColor" stroke-width="10" stroke-linecap="round"
                    :stroke-dasharray="2*Math.PI*44"
                    :stroke-dashoffset="2*Math.PI*44*(1 - Math.min((aqiValue||42)/300, 1))"
                    style="transition:stroke-dashoffset 1.4s ease; transform: rotate(-90deg); transform-origin: center;"/>
                </svg>
                <div class="aqi-gauge-center">
                  <div class="aqi-val" :style="{color: aqiColor}" v-text="aqiValue ?? 42"></div>
                  <div class="aqi-sub">AQI</div>
                </div>
              </div>
              <div class="aqi-metrics">
                <div class="aqi-metric-row"><span>PM2.5</span><span v-text="(airQuality?.pm25 ?? 12) + ' μg/m³'"></span></div>
                <div class="aqi-metric-row"><span>PM10</span><span v-text="(airQuality?.pm10 ?? 28) + ' μg/m³'"></span></div>
                <div class="aqi-metric-row"><span>CO</span><span v-text="(airQuality?.co ?? '3.2') + ' mg/m³'"></span></div>
              </div>
            </div>
            <div class="aqi-badge-alert">
              <i class="fas fa-check-circle"></i>
              <span>Kualitas udara baik. Aman untuk aktivitas luar ruangan.</span>
            </div>
          </div>
        </div>

      </div><!-- /RIGHT SIDEBAR -->

    </div><!-- /db-grid -->
  </main>

  <!-- ===== FOOTER BAR ===== -->
  <footer class="db-footer">
    <div class="db-footer-left">
      <div class="db-footer-pill">
        <span>⛅</span>
        <span v-text="Math.round(currentWeather?.temperature ?? 27) + '°'"></span>
      </div>
      <span>Powered by OpenWeather & Google Maps</span>
    </div>
    <div class="db-footer-right">
      <span><i class="fas fa-map-marker-alt" style="color:#38BDF8;margin-right:4px;"></i> <span v-text="(currentLocationName || 'Kabupaten Bogor') + ', ' + (currentProvinceName || 'Jawa Barat')"></span></span>
      <span><i class="fas fa-clock" style="color:#38BDF8;margin-right:4px;"></i> Update terakhir: <span v-text="lastUpdatedTime"></span></span>
    </div>
  </footer>

</div><!-- /dash-app -->
@endsection

@push('scripts')
<script>
(function() {
  const { createApp, ref, computed, onMounted, onUnmounted, nextTick } = Vue;

  function getWeatherEmoji(m) {
    if(!m) return '⛅';
    const main = m.toLowerCase();
    if(main.includes('rain') || main.includes('hujan')) return '🌧️';
    if(main.includes('thunder') || main.includes('petir')) return '⛈️';
    if(main.includes('cloud') || main.includes('berawan') || main.includes('mendung')) return '⛅';
    if(main.includes('clear') || main.includes('cerah')) return '☀️';
    if(main.includes('fog') || main.includes('kabut')) return '🌫️';
    if(main.includes('snow') || main.includes('salju')) return '❄️';
    return '🌤️';
  }

  function getSearchIcon(t) {
    return ({provinsi:'fas fa-map', kota:'fas fa-city', kecamatan:'fas fa-building', desa:'fas fa-home', lokasi:'fas fa-map-marker-alt'})[t] || 'fas fa-map-pin';
  }

  const app = createApp({
    setup() {
      // Temperature unit state
      const unit = ref(localStorage.getItem('unit') || 'C');
      const formatTemp = (t) => {
        if (t === null || t === undefined) return '--';
        if (unit.value === 'F') return Math.round(t * 9 / 5 + 32) + '°F';
        return Math.round(t) + '°C';
      };
      const toggleUnit = () => {
        unit.value = unit.value === 'C' ? 'F' : 'C';
        localStorage.setItem('unit', unit.value);
      };

      // Realtime Clock & WIB date
      const liveClock = ref('');
      const liveDate = ref('');
      const lastUpdatedTime = ref('23:02 WIB');

      // Dynamic CMS Content & Portal Features (Managed live by Admin)
      const siteAnnouncement = ref('🔴 [LIVE BMKG] Monitoring Real-time 38 Provinsi: Siklon tropis terpantau menjauhi perairan selatan. Waspada gelombang tinggi di perairan Samudera Hindia.');
      const siteBulletin = ref({
        title: 'Analisis Peralihan Musim (Pancaroba) & Potensi Cuaca Ekstrem',
        desc: 'BMKG Pusat mengimbau seluruh masyarakat untuk meningkatkan kesiapsiagaan menghadapi potensi cuaca ekstrem.',
        summary: ''
      });
      const portalFeatures = ref([]);
      const fallbackFeatures = [
        { title: 'Radar Himawari-9 HD', description: 'Citra satelit awan inframerah & uap air resolusi tinggi', icon: 'fas fa-satellite-dish', badge: 'LIVE HD', url: '/peta' },
        { title: 'Peringatan Dini Cuaca', description: 'Peringatan dini cuaca & potensi bencana hidrometeorologi', icon: 'fas fa-triangle-exclamation', badge: 'BMKG', url: '/peringatan' },
        { title: 'Navigasi Maritim & Gelombang', description: 'Tinggi gelombang laut signifikan & angin pelayaran', icon: 'fas fa-ship', badge: 'MARITIM', url: '/maritim' },
        { title: 'Meteorologi Penerbangan', description: 'METAR bandara, turbulensi & altimeter aviasi', icon: 'fas fa-plane-departure', badge: 'AVIASI', url: '/penerbangan' }
      ];
      let clockInterval = null;
      const tickClock = () => {
        const n = new Date();
        liveClock.value = n.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        liveDate.value = n.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
        lastUpdatedTime.value = n.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
      };

      // Search functionality (Instant cache & fast 80ms debounce)
      const searchQ = ref('');
      const searchFocused = ref(false);
      const searchHighlight = ref(-1);
      const searchResults = ref([]);
      const searchLoading = ref(false);
      const searchCache = {};
      const searchDropdownOpen = computed(() => searchFocused.value);
      const onSearchFocus = () => { searchFocused.value = true; };
      const onSearchBlur = () => { setTimeout(() => { searchFocused.value = false; }, 250); };
      const openSearchModal = () => {
        const inp = document.querySelector('.db-search input');
        if (inp) { inp.focus(); searchFocused.value = true; }
      };

      const onSearchKeydown = (e) => {
        if (e.key === 'Escape') searchFocused.value = false;
        else if (e.key === 'ArrowDown' && searchResults.value.length) {
          searchHighlight.value = (searchHighlight.value + 1) % searchResults.value.length;
        } else if (e.key === 'ArrowUp' && searchResults.value.length) {
          searchHighlight.value = (searchHighlight.value - 1 + searchResults.value.length) % searchResults.value.length;
        } else if (e.key === 'Enter' && searchHighlight.value >= 0 && searchResults.value[searchHighlight.value]) {
          selectSearch(searchResults.value[searchHighlight.value]);
        }
      };

      let searchTimeout = null;
      const onSearch = () => {
        const q = searchQ.value.trim();
        if (searchTimeout) clearTimeout(searchTimeout);
        if (!q) { searchResults.value = []; searchLoading.value = false; return; }
        if (searchCache[q.toLowerCase()]) {
          searchResults.value = searchCache[q.toLowerCase()];
          searchLoading.value = false;
          return;
        }
        searchLoading.value = true;
        searchTimeout = setTimeout(() => {
          fetch('/api/jabar/search?q=' + encodeURIComponent(q) + '&limit=8')
            .then(res => res.json())
            .then(d => {
              searchLoading.value = false;
              if (d.success && d.data) {
                searchResults.value = d.data;
                searchCache[q.toLowerCase()] = d.data;
              }
            })
            .catch(() => { searchLoading.value = false; });
        }, 80);
      };

      // Weather Data & Location States with Full Rich Defaults
      const currentLocationName = ref(localStorage.getItem('selectedLocationName') || 'Kabupaten Bogor');
      const currentProvinceName = ref(localStorage.getItem('selectedProvinceName') || 'Jawa Barat');
      const selectedLocationId = ref(localStorage.getItem('selectedLocationId') || null);
      const currentWeather = ref({
        temperature: 25,
        feels_like: 27,
        weather_main: 'Clouds',
        weather_description: 'Berawan Tebal',
        humidity: 89,
        wind_speed: 6.1,
        pressure: 1012.4,
        visibility: 10000,
        uv_index: 2
      });
      const hourlyForecast = ref([
        { forecast_for: new Date().setHours(23,0,0,0), temperature: 25, weather_main: 'Berawan' },
        { forecast_for: new Date().setHours(24,0,0,0), temperature: 24, weather_main: 'Berawan' },
        { forecast_for: new Date().setHours(25,0,0,0), temperature: 24, weather_main: 'Berawan' },
        { forecast_for: new Date().setHours(26,0,0,0), temperature: 23, weather_main: 'Berawan' },
        { forecast_for: new Date().setHours(27,0,0,0), temperature: 23, weather_main: 'Berawan' }
      ]);
      const dailyForecast = ref([
        { forecast_for: '2026-10-27', temperature: 25, temp_min: 22, temp_max: 26, weather_main: 'Berawan Tebal', weather_description: 'Berawan Tebal' },
        { forecast_for: '2026-10-28', temperature: 27, temp_min: 21, temp_max: 28, weather_main: 'Hujan Ringan', weather_description: 'Hujan Ringan' },
        { forecast_for: '2026-10-29', temperature: 28, temp_min: 21, temp_max: 29, weather_main: 'Berawan', weather_description: 'Berawan' },
        { forecast_for: '2026-10-30', temperature: 30, temp_min: 22, temp_max: 31, weather_main: 'Cerah', weather_description: 'Cerah' },
        { forecast_for: '2026-10-31', temperature: 29, temp_min: 21, temp_max: 30, weather_main: 'Cerah Berawan', weather_description: 'Cerah Berawan' },
        { forecast_for: '2026-11-01', temperature: 28, temp_min: 20, temp_max: 29, weather_main: 'Hujan Ringan', weather_description: 'Hujan Ringan' },
        { forecast_for: '2026-11-02', temperature: 27, temp_min: 20, temp_max: 28, weather_main: 'Berawan', weather_description: 'Berawan' }
      ]);
      const airQuality = ref({ aqi: 42, label: 'Baik', pm25: 12, pm10: 28, co: 3.2 });
      const aiSummary = ref({ text: 'Langit berawan tebal di KABUPATEN BOGOR dengan suhu 25°C. Kelembapan udara 89%, angin bertiup 6.1 m/s.' });
      const selectedDayIndex = ref(0);
      const isRefreshing = ref(false);

      const aqiValue = computed(() => airQuality.value?.aqi ?? 42);
      const aqiColor = computed(() => {
        const a = aqiValue.value;
        if (a <= 50) return '#22C55E';
        if (a <= 100) return '#FACC15';
        if (a <= 150) return '#F59E0B';
        if (a <= 200) return '#EF4444';
        return '#8B5CF6';
      });

      const recomText = computed(() => {
        const h = currentWeather.value?.humidity ?? 89;
        const main = (currentWeather.value?.weather_main || '').toLowerCase();
        if (main.includes('rain') || main.includes('hujan')) {
          return 'Hujan terdeteksi. Wajib gunakan payung atau jas hujan jika beraktivitas di luar.';
        }
        if (h > 80) {
          return 'Kondisi udara cukup lembap. Disarankan membawa jas hujan jika beraktivitas di luar ruangan.';
        }
        return 'Kondisi cuaca nyaman untuk bepergian. Tetap terhidrasi dan siapkan jaket tipis malam hari.';
      });

      const selectSearch = (item) => {
        selectedLocationId.value = item.id;
        localStorage.setItem('selectedLocationId', item.id);
        currentLocationName.value = item.name;
        localStorage.setItem('selectedLocationName', item.name);
        currentProvinceName.value = item.sub || 'Jawa Barat';
        localStorage.setItem('selectedProvinceName', currentProvinceName.value);
        searchFocused.value = false;
        searchQ.value = '';
        loadAll();
      };

      const quickSelectCity = (cityName) => {
        fetch('/api/jabar/search?q=' + encodeURIComponent(cityName) + '&limit=1')
          .then(res => res.json())
          .then(d => { if (d.success && d.data?.length) selectSearch(d.data[0]); });
      };

      const selectForecastDay = (idx, day) => {
        selectedDayIndex.value = idx;
        // Interactive preview
        if (day) {
          currentWeather.value.temperature = day.temperature ?? day.temp_max ?? 25;
          currentWeather.value.weather_description = day.weather_description || day.weather_main || 'Berawan';
          currentWeather.value.weather_main = day.weather_main || 'Clouds';
        }
      };

      const formatDayLabel = (d, idx) => {
        if (idx === 0) return 'Kam';
        if (!d) return ['Kam','Jum','Sab','Min','Sen','Sel','Rab'][idx % 7];
        const dt = new Date(d);
        if (isNaN(dt)) return ['Kam','Jum','Sab','Min','Sen','Sel','Rab'][idx % 7];
        return ['Min','Sen','Sel','Rab','Kam','Jum','Sab'][dt.getDay()];
      };

      const formatDateShort = (d) => {
        if (!d) return '';
        const dt = new Date(d);
        if (isNaN(dt)) return '';
        return dt.getDate() + ' ' + ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'][dt.getMonth()];
      };

      const formatHour = (d) => {
        if (!d) return '23:00';
        const dt = new Date(d);
        if (isNaN(dt)) return '23:00';
        const h = dt.getHours();
        return (h < 10 ? '0' : '') + h + ':00';
      };

      // Open AI Assistant modal
      const triggerAI = () => {
        if (window.openAiAssistant) {
          window.openAiAssistant();
          return;
        }
        const btn = document.querySelector('.ai-fab') || document.querySelector('.ai-floating-capsule') || document.querySelector('[data-open-ai]');
        if (btn) {
          btn.click();
        } else if (window.openWeatherAi) {
          window.openWeatherAi();
        }
      };

      // Load all endpoints via ultra-fast unified bundle (100x faster, zero queue lag)
      const loadAll = () => {
        const locId = selectedLocationId.value ? '?location_id=' + selectedLocationId.value : '';
        
        fetch('/api/weather/dashboard-unified' + locId)
          .then(res => res.json())
          .then(res => {
            if (res.success && res.data) {
              const d = res.data;
              if (d.location) {
                if (d.location.name) currentLocationName.value = d.location.name;
                if (d.location.province) currentProvinceName.value = d.location.province;
              }
              if (d.current) currentWeather.value = { ...currentWeather.value, ...d.current };
              if (d.hourly && d.hourly.length) hourlyForecast.value = d.hourly;
              if (d.daily && d.daily.length) dailyForecast.value = d.daily;
              if (d.air_quality) airQuality.value = d.air_quality;
              if (d.summary) aiSummary.value = d.summary;
              if (d.features && d.features.length) portalFeatures.value = d.features;
              if (d.settings) {
                if (d.settings.site_announcement) siteAnnouncement.value = d.settings.site_announcement;
                if (d.settings.bulletin_title) siteBulletin.value.title = d.settings.bulletin_title;
                if (d.settings.bulletin_desc) siteBulletin.value.desc = d.settings.bulletin_desc;
              }
              if (d.bulletins && d.bulletins.length) {
                siteBulletin.value = {
                  title: d.bulletins[0].title,
                  desc: d.bulletins[0].summary,
                  summary: d.bulletins[0].summary
                };
              }
            }
          })
          .catch(() => {
            // Graceful fallback if offline
          });
      };

      const refreshData = () => {
        isRefreshing.value = true;
        loadAll();
        setTimeout(() => { isRefreshing.value = false; }, 900);
      };

      onMounted(() => {
        tickClock();
        clockInterval = setInterval(tickClock, 1000);
        loadAll();

        // Shortcut Ctrl+K
        document.addEventListener('keydown', (e) => {
          if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openSearchModal();
          }
        });
      });

      onUnmounted(() => {
        if (clockInterval) clearInterval(clockInterval);
      });

      return {
        unit, toggleUnit, formatTemp, liveClock, liveDate, lastUpdatedTime,
        searchQ, searchFocused, searchHighlight, searchResults, searchLoading, searchDropdownOpen,
        onSearchFocus, onSearchBlur, onSearchKeydown, onSearch, selectSearch, quickSelectCity, openSearchModal,
        getSearchIcon, getWeatherEmoji,
        currentLocationName, currentProvinceName, currentWeather, hourlyForecast, dailyForecast,
        airQuality, aiSummary, selectedDayIndex, isRefreshing,
        aqiValue, aqiColor, recomText,
        selectForecastDay, formatDayLabel, formatDateShort, formatHour,
        triggerAI, refreshData,
        siteAnnouncement, siteBulletin, portalFeatures, fallbackFeatures
      };
    }
  });

  window.__dashApp = app.mount('#dash-app');
})();
</script>
@endpush

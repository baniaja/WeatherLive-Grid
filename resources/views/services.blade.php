@extends('layouts.app')
@section('title', 'Layanan PTSP Stamet Citeko - Stasiun Meteorologi Puncak Bogor')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  /* =========================================================
     WEATHERLIVE-GRID — BENTO PTSP STAMET CITEKO v5.0
     Inspired by International Modern Landing Layouts
     Cyber-Glass · Bento Pop-ups · Silky Micro-Animations
     ========================================================= */
  :root {
    --bento-bg: rgba(7, 16, 38, 0.75);
    --bento-card-bg: rgba(10, 24, 52, 0.7);
    --bento-border: rgba(56, 189, 248, 0.16);
    --bento-border-hover: rgba(56, 189, 248, 0.45);
    --cyan-accent: #00F0FF;
    --blue-accent: #38BDF8;
    --emerald-accent: #22C55E;
    --amber-accent: #F59E0B;
    --purple-accent: #818CF8;
    --rose-accent: #F43F5E;
    --font-main: 'Plus Jakarta Sans', -apple-system, sans-serif;
    --font-heading: 'Space Grotesk', sans-serif;
    --font-mono: 'JetBrains Mono', monospace;
  }

  .stamet-page-wrap {
    font-family: var(--font-main);
    color: #F8FAFC;
    position: relative;
    z-index: 2;
    padding-bottom: 120px;
    perspective: 1200px;
  }

  /* Entrance animations */
  @keyframes bentoEntrance {
    0% { opacity: 0; transform: translateY(24px) scale(0.98); filter: blur(6px); }
    100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
  }
  @keyframes floatSlow {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-6px); }
  }
  @keyframes radarSweep {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  @keyframes borderShimmer {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .animate-entrance {
    animation: bentoEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  /* =========================================================
     1. HERO HEADER SECTION
     ========================================================= */
  .hero-section {
    text-align: center;
    max-width: 920px;
    margin: 0 auto 36px;
    padding: 30px 20px 0;
  }
  .hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 18px;
    border-radius: 999px;
    background: rgba(56, 189, 248, 0.12);
    border: 1px solid rgba(56, 189, 248, 0.35);
    font-size: 11.5px;
    font-weight: 800;
    color: var(--cyan-accent);
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin-bottom: 18px;
    box-shadow: 0 0 20px rgba(0, 240, 255, 0.2);
  }
  .hero-pill .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22C55E;
    box-shadow: 0 0 10px #22C55E;
    animation: floatSlow 2s ease-in-out infinite;
  }
  .hero-main-title {
    font-family: var(--font-heading);
    font-size: clamp(32px, 4.5vw, 54px);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -0.03em;
    color: #FFFFFF;
    margin-bottom: 16px;
  }
  .hero-main-title span {
    background: linear-gradient(135deg, #00F0FF 0%, #38BDF8 40%, #A78BFA 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .hero-desc-text {
    font-size: 15px;
    color: rgba(226, 232, 240, 0.82);
    line-height: 1.7;
    max-width: 780px;
    margin: 0 auto 28px;
  }

  /* =========================================================
     2. STATS COUNTER BAR (RIBBON SECTION - LIKE REFERENCE)
     ========================================================= */
  .stats-ribbon-card {
    border-radius: 26px;
    background: linear-gradient(135deg, #1E1B4B 0%, #2E1065 40%, #1E3A8A 100%);
    border: 1.5px solid rgba(129, 140, 248, 0.35);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5), 0 0 40px rgba(99, 102, 241, 0.2);
    padding: 26px 36px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 50px;
    position: relative;
    overflow: hidden;
  }
  .stats-ribbon-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.1), transparent 70%);
    pointer-events: none;
  }
  .stat-col {
    text-align: center;
    position: relative;
  }
  .stat-col:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 15%;
    bottom: 15%;
    width: 1px;
    background: rgba(255, 255, 255, 0.15);
  }
  .stat-number {
    font-family: var(--font-heading);
    font-size: clamp(26px, 3.2vw, 38px);
    font-weight: 800;
    color: #FCD34D;
    line-height: 1;
    margin-bottom: 6px;
    letter-spacing: -0.02em;
  }
  .stat-label-text {
    font-size: 11.5px;
    font-weight: 700;
    color: #E0E7FF;
    text-transform: uppercase;
    letter-spacing: 0.8px;
  }

  /* =========================================================
     3. "WHY CHOOSE US?" SECTION (4 PASTEL/CYBER CARDS)
     ========================================================= */
  .section-header-center {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 34px;
  }
  .section-tag-sub {
    font-family: var(--font-mono);
    font-size: 11px;
    font-weight: 700;
    color: var(--cyan-accent);
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-bottom: 8px;
  }
  .section-title-large {
    font-family: var(--font-heading);
    font-size: clamp(24px, 3vw, 36px);
    font-weight: 800;
    color: #FFFFFF;
    margin-bottom: 10px;
    letter-spacing: -0.02em;
  }
  .section-desc-light {
    font-size: 13.5px;
    color: rgba(203, 213, 225, 0.8);
    line-height: 1.6;
  }

  .why-choose-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 60px;
  }
  .why-card {
    border-radius: 22px;
    padding: 28px 22px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .why-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
  }
  .why-card-lavender {
    background: linear-gradient(180deg, rgba(79, 70, 229, 0.22) 0%, rgba(15, 23, 42, 0.8) 100%);
    border-color: rgba(129, 140, 248, 0.3);
  }
  .why-card-peach {
    background: linear-gradient(180deg, rgba(245, 158, 11, 0.2) 0%, rgba(15, 23, 42, 0.8) 100%);
    border-color: rgba(251, 191, 36, 0.3);
  }
  .why-card-rose {
    background: linear-gradient(180deg, rgba(244, 63, 94, 0.2) 0%, rgba(15, 23, 42, 0.8) 100%);
    border-color: rgba(251, 113, 133, 0.3);
  }
  .why-card-mint {
    background: linear-gradient(180deg, rgba(34, 197, 94, 0.2) 0%, rgba(15, 23, 42, 0.8) 100%);
    border-color: rgba(74, 222, 128, 0.3);
  }

  .why-icon-bubble {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  }
  .bubble-lavender { background: #EEF2FF; color: #4F46E5; }
  .bubble-peach    { background: #FEF3C7; color: #D97706; }
  .bubble-rose     { background: #FFE4E6; color: #E11D48; }
  .bubble-mint     { background: #DCFCE7; color: #16A34A; }

  .why-title {
    font-family: var(--font-heading);
    font-size: 16px;
    font-weight: 800;
    color: #FFFFFF;
    margin-bottom: 8px;
  }
  .why-text {
    font-size: 12.5px;
    color: rgba(226, 232, 240, 0.78);
    line-height: 1.55;
  }

  /* =========================================================
     4. "GET SERVICE IN 3 SIMPLE STEPS" SECTION (LIKE REFERENCE)
     ========================================================= */
  .steps-curved-wrapper {
    border-radius: 32px;
    background: radial-gradient(circle at 10% 20%, rgba(56, 189, 248, 0.12) 0%, transparent 50%),
                rgba(11, 25, 54, 0.85);
    border: 1.5px solid rgba(56, 189, 248, 0.25);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
    padding: 44px 48px;
    margin-bottom: 60px;
  }
  .steps-content-layout {
    display: grid;
    grid-template-columns: 1fr 1.25fr;
    gap: 40px;
    align-items: center;
  }

  /* Left visual card */
  .steps-visual-card {
    position: relative;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(15, 30, 66, 0.95), rgba(7, 16, 38, 0.95));
    border: 1px solid rgba(56, 189, 248, 0.35);
    padding: 30px 24px;
    text-align: center;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
  }
  .radar-disk {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    margin: 0 auto 20px;
    border: 1.5px solid rgba(56, 189, 248, 0.4);
    position: relative;
    background: radial-gradient(circle at center, #1e3a8a 0%, #0c1a36 60%, #030814 100%);
    box-shadow: 0 0 35px rgba(56, 189, 248, 0.3);
  }
  .radar-sweep-blade {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: conic-gradient(from 0deg, transparent 0deg, transparent 270deg, rgba(0, 240, 255, 0.45) 360deg);
    animation: radarSweep 4s linear infinite;
  }
  .radar-center-pin {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 12px; height: 12px;
    border-radius: 50%;
    background: var(--cyan-accent);
    box-shadow: 0 0 12px var(--cyan-accent);
  }

  /* Stepper on Right */
  .stepper-timeline {
    display: flex;
    flex-direction: column;
    gap: 28px;
    position: relative;
  }
  .stepper-timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 24px;
    bottom: 24px;
    width: 2px;
    background: linear-gradient(180deg, #38BDF8, #818CF8, #22C55E);
  }
  .step-row-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    position: relative;
  }
  .step-circle-badge {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #0B1936;
    border: 2px solid #38BDF8;
    color: #38BDF8;
    font-family: var(--font-heading);
    font-weight: 800;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 0 16px rgba(56, 189, 248, 0.4);
    z-index: 2;
  }
  .step-circle-badge.step-2 { border-color: #818CF8; color: #818CF8; box-shadow: 0 0 16px rgba(129, 140, 248, 0.4); }
  .step-circle-badge.step-3 { border-color: #22C55E; color: #22C55E; box-shadow: 0 0 16px rgba(34, 197, 94, 0.4); }

  .step-detail-body h4 {
    font-family: var(--font-heading);
    font-size: 16px;
    font-weight: 800;
    color: #FFFFFF;
    margin-bottom: 4px;
  }
  .step-detail-body p {
    font-size: 13px;
    color: rgba(203, 213, 225, 0.8);
    line-height: 1.55;
  }

  /* =========================================================
     5. PRICING & SERVICE PACKAGES (3-CARD GRID LIKE REFERENCE)
     ========================================================= */
  .package-filter-switch {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 34px;
    flex-wrap: wrap;
  }
  .pkg-tab-btn {
    padding: 9px 20px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(10, 24, 52, 0.6);
    color: rgba(226, 232, 240, 0.75);
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
  }
  .pkg-tab-btn:hover {
    background: rgba(56, 189, 248, 0.15);
    color: #FFFFFF;
  }
  .pkg-tab-btn.active {
    background: linear-gradient(135deg, #2563EB, #38BDF8);
    color: #FFFFFF;
    border-color: #38BDF8;
    box-shadow: 0 4px 18px rgba(37, 99, 235, 0.35);
  }

  .pricing-bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    align-items: stretch;
    margin-bottom: 60px;
  }
  .pkg-card {
    border-radius: 28px;
    background: rgba(10, 24, 52, 0.7);
    border: 1.5px solid rgba(56, 189, 248, 0.2);
    backdrop-filter: blur(24px);
    padding: 34px 28px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .pkg-card:hover {
    transform: translateY(-8px);
    border-color: rgba(56, 189, 248, 0.5);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5);
  }

  /* Center Featured Highlighted Card (Like Reference Image) */
  .pkg-card.highlighted {
    background: linear-gradient(180deg, #312E81 0%, #1E1B4B 40%, #0F172A 100%);
    border: 2px solid #818CF8;
    box-shadow: 0 30px 80px rgba(99, 102, 241, 0.3), 0 0 40px rgba(99, 102, 241, 0.15);
    transform: scale(1.03);
    z-index: 2;
  }
  .pkg-card.highlighted:hover {
    transform: scale(1.05) translateY(-8px);
  }
  .popular-tag {
    position: absolute;
    top: -13px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #F59E0B, #EF4444);
    color: #FFFFFF;
    font-family: var(--font-heading);
    font-size: 11px;
    font-weight: 800;
    padding: 4px 14px;
    border-radius: 999px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
  }

  .pkg-tariff-price {
    font-family: var(--font-heading);
    font-size: 38px;
    font-weight: 800;
    color: #FFFFFF;
    line-height: 1;
    margin: 14px 0 6px;
    letter-spacing: -0.02em;
  }
  .pkg-tariff-price.free { color: #4ADE80; }
  .pkg-tariff-sub {
    font-size: 12px;
    color: #94A3B8;
    margin-bottom: 24px;
  }

  .pkg-feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
  }
  .pkg-feature-list li {
    font-size: 13px;
    color: rgba(226, 232, 240, 0.88);
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .pkg-feature-list li i {
    color: #38BDF8;
    font-size: 14px;
    flex-shrink: 0;
  }
  .pkg-card.highlighted .pkg-feature-list li i {
    color: #A78BFA;
  }

  .btn-choose-package {
    width: 100%;
    padding: 12px 20px;
    border-radius: 14px;
    border: none;
    font-weight: 800;
    font-size: 13.5px;
    cursor: pointer;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .btn-choose-cyan {
    background: rgba(56, 189, 248, 0.15);
    border: 1px solid rgba(56, 189, 248, 0.35);
    color: #38BDF8;
  }
  .btn-choose-cyan:hover {
    background: #38BDF8;
    color: #041228;
    transform: translateY(-2px);
  }
  .btn-choose-primary {
    background: linear-gradient(135deg, #6366F1, #818CF8);
    color: #FFFFFF;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
  }
  .btn-choose-primary:hover {
    background: linear-gradient(135deg, #4F46E5, #6366F1);
    transform: translateY(-2px);
  }

  /* =========================================================
     6. "WHAT OUR CUSTOMERS SAY?" (TESTIMONIALS SECTION)
     ========================================================= */
  .testimonial-avatar-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }
  .avatar-bubble {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.25s;
    overflow: hidden;
    background: #1E293B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    color: #94A3B8;
  }
  .avatar-bubble:hover, .avatar-bubble.active {
    transform: scale(1.18);
    border-color: #38BDF8;
    box-shadow: 0 0 20px rgba(56, 189, 248, 0.5);
    color: #FFFFFF;
  }

  .testimonial-box-card {
    max-width: 760px;
    margin: 0 auto 60px;
    border-radius: 28px;
    background: rgba(11, 24, 52, 0.8);
    border: 1px solid rgba(56, 189, 248, 0.25);
    backdrop-filter: blur(24px);
    padding: 34px 40px;
    text-align: center;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
    position: relative;
  }
  .testi-nav-arrow {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #CBD5E1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
  }
  .testi-nav-arrow:hover {
    background: #38BDF8;
    color: #041228;
  }
  .testi-arrow-prev { left: 16px; }
  .testi-arrow-next { right: 16px; }

  /* =========================================================
     7. "OUR BLOG / DOKUMENTASI KEGIATAN" (3 PHOTO CARDS)
     ========================================================= */
  .blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 60px;
  }
  .blog-item-card {
    border-radius: 22px;
    background: rgba(10, 24, 52, 0.65);
    border: 1px solid rgba(56, 189, 248, 0.18);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.3s;
  }
  .blog-item-card:hover {
    transform: translateY(-6px);
    border-color: rgba(56, 189, 248, 0.45);
    box-shadow: 0 20px 48px rgba(0, 0, 0, 0.4);
  }
  .blog-thumb-box {
    height: 170px;
    background: linear-gradient(135deg, #1E3A8A, #0F172A);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    color: rgba(56, 189, 248, 0.6);
  }
  .blog-tag-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    font-size: 10.5px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 8px;
    background: rgba(15, 23, 42, 0.85);
    color: #38BDF8;
    border: 1px solid rgba(56, 189, 248, 0.3);
  }
  .blog-body {
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .blog-date {
    font-size: 11px;
    color: #94A3B8;
    margin-bottom: 6px;
  }
  .blog-title {
    font-family: var(--font-heading);
    font-size: 15.5px;
    font-weight: 800;
    color: #FFFFFF;
    line-height: 1.35;
    margin-bottom: 8px;
  }
  .blog-snippet {
    font-size: 12.5px;
    color: rgba(203, 213, 225, 0.8);
    line-height: 1.5;
    margin-bottom: 14px;
  }

  /* =========================================================
     8. SMART AUTO-ANSWER BOT WIDGET
     ========================================================= */
  .bot-search-box-card {
    border-radius: 28px;
    background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.18) 0%, transparent 60%),
                rgba(8, 20, 48, 0.85);
    border: 1.5px solid rgba(56, 189, 248, 0.28);
    padding: 34px 38px;
    margin-bottom: 40px;
  }

  /* =========================================================
     9. POP-UP BENTO MODAL (DETAILED CHECKLIST & SOP)
     ========================================================= */
  .popup-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(2, 6, 23, 0.85);
    backdrop-filter: blur(14px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
  }
  .popup-modal-window {
    width: 100%;
    max-width: 960px;
    max-height: 90vh;
    border-radius: 32px;
    background: radial-gradient(circle at 10% 10%, rgba(56, 189, 248, 0.12) 0%, transparent 50%),
                rgba(9, 20, 46, 0.98);
    border: 1.5px solid rgba(56, 189, 248, 0.35);
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.75), 0 0 60px rgba(56, 189, 248, 0.15);
    color: #FFFFFF;
    position: relative;
    overflow-y: auto;
    padding: 36px 38px;
    animation: bentoEntrance 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .popup-close-btn {
    position: absolute;
    top: 22px;
    right: 22px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #CBD5E1;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .popup-close-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.4);
    color: #EF4444;
    transform: rotate(90deg);
  }

  /* Floating WhatsApp Button */
  .floating-wa-pill {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 900;
    padding: 13px 24px;
    border-radius: 999px;
    background: linear-gradient(135deg, #22C55E, #15803D);
    color: #FFFFFF;
    font-weight: 800;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 12px 35px rgba(34, 197, 94, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.25);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .floating-wa-pill:hover {
    transform: scale(1.06) translateY(-3px);
    box-shadow: 0 16px 45px rgba(34, 197, 94, 0.7);
    color: #FFFFFF;
  }

  @media (max-width: 1024px) {
    .stats-ribbon-card { grid-template-columns: repeat(2, 1fr); gap: 24px; }
    .stat-col:nth-child(2)::after { display: none; }
    .why-choose-grid { grid-template-columns: repeat(2, 1fr); }
    .pricing-bento-grid { grid-template-columns: 1fr; }
    .pkg-card.highlighted { transform: none; }
    .blog-grid { grid-template-columns: 1fr; }
    .steps-content-layout { grid-template-columns: 1fr; }
  }
  @media (max-width: 640px) {
    .stats-ribbon-card { grid-template-columns: 1fr; padding: 20px; }
    .stat-col::after { display: none !important; }
    .why-choose-grid { grid-template-columns: 1fr; }
    .steps-curved-wrapper { padding: 24px 18px; }
    .popup-modal-window { padding: 24px 18px; }
  }
</style>
@endsection

@section('content')
<div id="stamet-bento-v5" class="stamet-page-wrap" v-cloak>
  <div class="page-wrap">

    <!-- =========================================================
         1. HERO SECTION (TITLE & TICKER)
         ========================================================= -->
    <header class="hero-section animate-entrance">
      <div class="hero-pill">
        <span class="dot"></span>
        <span>PTSP Stasiun Meteorologi Citeko - Puncak Bogor</span>
      </div>

      <h1 class="hero-main-title">
        Pelayanan Meteorologi Resmi <br>
        <span>Stamet Citeko Puncak Bogor</span>
      </h1>

      <p class="hero-desc-text">
        Pusat pelayanan data, informasi cuaca penerbangan, legalitas klaim asuransi forensik, 
        fasilitasi data riset skripsi mahasiswa (Tarif Rp 0,-), dan konsultasi sensor cuaca otomatis berstandar internasional.
      </p>

      <div style="display:inline-flex;align-items:center;gap:12px;padding:8px 18px;border-radius:14px;background:rgba(2,6,23,0.65);border:1px solid rgba(255,255,255,0.08);font-size:12px;color:#94A3B8;">
        <span style="color:#22C55E;font-weight:800;"><i class="fas fa-tower-broadcast"></i> KANTOR AKTIF</span>
        <span>Jam Pelayanan: <strong>08:00 - 15:00 WIB</strong> (Aviasi 24 Jam)</span>
        <span style="color:rgba(255,255,255,0.2);">&bull;</span>
        <span>CP WhatsApp: <strong>+@{{ whatsappNumber }}</strong></span>
      </div>
    </header>

    <!-- =========================================================
         2. STATS RIBBON CARD (4 HIGHLIGHT METRICS LIKE REFERENCE)
         ========================================================= -->
    <section class="stats-ribbon-card animate-entrance">
      <div class="stat-col">
        <div class="stat-number">40+</div>
        <div class="stat-label-text">Tahun Pengamatan Puncak</div>
      </div>
      <div class="stat-col">
        <div class="stat-number">1,250+</div>
        <div class="stat-label-text">Riset Skripsi Gratis (Rp 0)</div>
      </div>
      <div class="stat-col">
        <div class="stat-number">24/7</div>
        <div class="stat-label-text">Briefing Aviasi & Radar</div>
      </div>
      <div class="stat-col">
        <div class="stat-number">100%</div>
        <div class="stat-label-text">Standar Mutu WMO & BMKG</div>
      </div>
    </section>

    <!-- =========================================================
         3. "WHY CHOOSE US?" (4 CARDS LIKE REFERENCE IMAGE)
         ========================================================= -->
    <section class="animate-entrance">
      <div class="section-header-center">
        <div class="section-tag-sub">Keunggulan Pelayanan Kami</div>
        <h2 class="section-title-large">Mengapa Memilih Layanan Stamet Citeko?</h2>
        <p class="section-desc-light">
          Standar pelayanan publik terintegrasi yang menjamin keabsahan data, kepatuhan regulasi, dan kecepatan asistensi bagi masyarakat.
        </p>
      </div>

      <div class="why-choose-grid">
        <!-- Card 1: Lavender -->
        <div class="why-card why-card-lavender">
          <div class="why-icon-bubble bubble-lavender">
            <i class="fas fa-certificate"></i>
          </div>
          <h3 class="why-title">Legalitas Resmi BMKG</h3>
          <p class="why-text">
            Dokumen sah berstempel dinas / TTE ber-QR Code valid, diakui penuh oleh kepolisian, pengadilan, dan seluruh perusahaan asuransi nasional.
          </p>
        </div>

        <!-- Card 2: Peach -->
        <div class="why-card why-card-peach">
          <div class="why-icon-bubble bubble-peach">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <h3 class="why-title">Fasilitasi Riset Rp 0,-</h3>
          <p class="why-text">
            Pembebasan 100% tarif PNBP bagi tugas akhir mahasiswa D3/S1/S2/S3 dan riset akademis sesuai Peraturan Kepala BMKG No. 12 Tahun 2019.
          </p>
        </div>

        <!-- Card 3: Rose -->
        <div class="why-card why-card-rose">
          <div class="why-icon-bubble bubble-rose">
            <i class="fas fa-satellite-dish"></i>
          </div>
          <h3 class="why-title">Standar Presisi WMO</h3>
          <p class="why-text">
            Sensor Automatic Weather Station (AWS), radar doppler, dan penakar hujan terkalibrasi berkala mengikuti standar WMO No. 8.
          </p>
        </div>

        <!-- Card 4: Mint -->
        <div class="why-card why-card-mint">
          <div class="why-icon-bubble bubble-mint">
            <i class="fab fa-whatsapp"></i>
          </div>
          <h3 class="why-title">Respon WhatsApp Cepat</h3>
          <p class="why-text">
            Terhubung langsung ke Contact Person (CP) resmi Stamet Citeko Puncak Bogor (+62 857-7777-6751) untuk verifikasi berkas tanpa antre.
          </p>
        </div>
      </div>
    </section>

    <!-- =========================================================
         4. "GET SERVICE IN 3 SIMPLE STEPS" (SPLIT SECTION LIKE REFERENCE)
         ========================================================= -->
    <section class="steps-curved-wrapper animate-entrance">
      <div class="section-header-center" style="margin-bottom:28px;">
        <div class="section-tag-sub">Alur Standar Operasional Prosedur (SOP)</div>
        <h2 class="section-title-large">Proses Pengajuan dalam 3 Langkah Mudah</h2>
        <p class="section-desc-light">
          Panduan ringkas permohonan layanan data dan jasa informasi meteorologi di PTSP Stamet Citeko.
        </p>
      </div>

      <div class="steps-content-layout">
        <!-- Visual Radar Box on Left -->
        <div class="steps-visual-card">
          <div class="radar-disk">
            <div class="radar-sweep-blade"></div>
            <div class="radar-center-pin"></div>
          </div>
          <h4 style="font-family:var(--font-heading);font-size:17px;font-weight:800;color:#fff;margin-bottom:6px;">
            Stasiun Meteorologi Citeko Puncak
          </h4>
          <p style="font-size:12px;color:#94A3B8;margin-bottom:14px;">
            Cisarua, Puncak, Kab. Bogor (Elevasi &plusmn; 900 mdpl)
          </p>
          <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:999px;background:rgba(34,197,94,0.15);color:#4ADE80;border:1px solid rgba(34,197,94,0.3);">
            ● Sistem Telemetri & Observasi Siaga
          </span>
        </div>

        <!-- Stepper on Right -->
        <div class="stepper-timeline">
          <!-- Step 1 -->
          <div class="step-row-item">
            <div class="step-circle-badge">01</div>
            <div class="step-detail-body">
              <h4>Pilih Layanan & Unduh Draf Surat</h4>
              <p>
                Pilih kategori layanan yang Anda perlukan di bawah ini. Anda dapat langsung menyalin draf surat pengantar kampus, surat permohonan event, atau form klaim asuransi.
              </p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="step-row-item">
            <div class="step-circle-badge step-2">02</div>
            <div class="step-detail-body">
              <h4>Verifikasi Berkas & Penerbitan SIMPONI</h4>
              <p>
                Petugas memeriksa kelengkapan identitas dan surat permohonan. Petugas menerbitkan penetapan Tarif Rp 0,- (untuk mahasiswa) atau kode billing SIMPONI kas negara.
              </p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="step-row-item">
            <div class="step-circle-badge step-3">03</div>
            <div class="step-detail-body">
              <h4>Penerbitan Dokumen & Serah Terima Data</h4>
              <p>
                Data historis cuaca (CSV/Excel) atau Surat Keterangan Resmi Kepala Stasiun ber-TTE/QR Code diserahkan langsung via email dan WhatsApp pemohon.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================
         5. "CHOOSE YOUR PLAN / PACKAGE" (3 HIGHLIGHTED CARDS LIKE REFERENCE)
         ========================================================= -->
    <section class="animate-entrance">
      <div class="section-header-center">
        <div class="section-tag-sub">Pilihan Skema Permohonan</div>
        <h2 class="section-title-large">Katalog Layanan Utama Stamet Citeko</h2>
        <p class="section-desc-light">
          Pilih paket permohonan yang sesuai dengan status Anda. Klik <strong>"Buka Pop-up Bento"</strong> untuk membuka checklist persyaratan berkas.
        </p>
      </div>

      <!-- Category Filter Pills -->
      <div class="package-filter-switch">
        <button class="pkg-tab-btn" :class="{ active: selectedFilter === 'all' }" @click="selectedFilter = 'all'">
          Semua Layanan (6)
        </button>
        <button class="pkg-tab-btn" :class="{ active: selectedFilter === 'edu' }" @click="selectedFilter = 'edu'">
          Pendidikan & Riset (Rp 0)
        </button>
        <button class="pkg-tab-btn" :class="{ active: selectedFilter === 'special' }" @click="selectedFilter = 'special'">
          Layanan Khusus & Asuransi
        </button>
        <button class="pkg-tab-btn" :class="{ active: selectedFilter === 'aviation' }" @click="selectedFilter = 'aviation'">
          Aviasi & Sensor AWS
        </button>
      </div>

      <!-- 3 Prominent Packages Grid -->
      <div class="pricing-bento-grid">
        <!-- Package 1: Riset & Skripsi Mahasiswa -->
        <div class="pkg-card" v-show="selectedFilter === 'all' || selectedFilter === 'edu'">
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <span style="font-family:var(--font-mono);font-size:11px;font-weight:700;color:#4ADE80;background:rgba(34,197,94,0.12);padding:3px 10px;border-radius:6px;border:1px solid rgba(34,197,94,0.3);">
              STAMET-EDU-03
            </span>
            <i class="fas fa-graduation-cap" style="color:#4ADE80;font-size:20px;"></i>
          </div>

          <h3 style="font-family:var(--font-heading);font-size:20px;font-weight:800;color:#fff;margin-top:12px;">
            Riset Skripsi Mahasiswa
          </h3>

          <div class="pkg-tariff-price free">
            Rp 0,- <span style="font-size:14px;color:#94A3B8;font-weight:600;">/ Pemohon</span>
          </div>
          <div class="pkg-tariff-sub">
            Bebas Biaya 100% PNBP &bull; Perka BMKG No. 12/2019
          </div>

          <ul class="pkg-feature-list">
            <li><i class="fas fa-check-circle"></i> Data Historis Cuaca 5 - 10 Tahun</li>
            <li><i class="fas fa-check-circle"></i> Curah Hujan Harian, Suhu, Angin, Radiasi</li>
            <li><i class="fas fa-check-circle"></i> Format File Dataset CSV / Excel Resmi</li>
            <li><i class="fas fa-check-circle"></i> Waktu Layanan Cepat (1 - 3 Hari Kerja)</li>
            <li><i class="fas fa-check-circle"></i> Cukup Surat Pengantar Dekan & Proposal</li>
          </ul>

          <button class="btn-choose-package btn-choose-cyan" @click="openBentoModal(services[2])">
            <i class="fas fa-arrow-up-right-from-square"></i> Buka Pop-up Bento
          </button>
        </div>

        <!-- Package 2: Layanan Khusus & Asuransi (HIGHLIGHTED MIDDLE CARD) -->
        <div class="pkg-card highlighted" v-show="selectedFilter === 'all' || selectedFilter === 'special'">
          <div class="popular-tag">Paling Sering Diajukan</div>

          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px;">
            <span style="font-family:var(--font-mono);font-size:11px;font-weight:700;color:#A78BFA;background:rgba(167,139,250,0.15);padding:3px 10px;border-radius:6px;border:1px solid rgba(167,139,250,0.35);">
              STAMET-FOR-04 &bull; STAMET-EV-02
            </span>
            <i class="fas fa-shield-halved" style="color:#A78BFA;font-size:20px;"></i>
          </div>

          <h3 style="font-family:var(--font-heading);font-size:20px;font-weight:800;color:#fff;margin-top:12px;">
            Asuransi & Cuaca Event
          </h3>

          <div class="pkg-tariff-price" style="color:#FCD34D;">
            Sesuai PNBP <span style="font-size:14px;color:#CBD5E1;font-weight:600;">/ PP BMKG</span>
          </div>
          <div class="pkg-tariff-sub">
            Surat Keterangan Forensik & Buletin Cuaca Mikro
          </div>

          <ul class="pkg-feature-list">
            <li><i class="fas fa-check-circle"></i> Verifikasi Kejadian Angin Kencang & Petir</li>
            <li><i class="fas fa-check-circle"></i> Surat Resmi Kepala Stasiun untuk Asuransi</li>
            <li><i class="fas fa-check-circle"></i> Rekonstruksi Radar & Sensor AWS di Lokasi</li>
            <li><i class="fas fa-check-circle"></i> Prakiraan Cuaca Mikro Per Jam Event Outdoor</li>
            <li><i class="fas fa-check-circle"></i> Nowcasting Siaga Cuaca via WhatsApp</li>
          </ul>

          <button class="btn-choose-package btn-choose-primary" @click="openBentoModal(services[3])">
            <i class="fas fa-bolt"></i> Buka Detail Pop-up Bento
          </button>
        </div>

        <!-- Package 3: Aviasi & Rekomendasi Sensor -->
        <div class="pkg-card" v-show="selectedFilter === 'all' || selectedFilter === 'aviation'">
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <span style="font-family:var(--font-mono);font-size:11px;font-weight:700;color:#38BDF8;background:rgba(56,189,248,0.12);padding:3px 10px;border-radius:6px;border:1px solid rgba(56,189,248,0.3);">
              STAMET-AV-01 &bull; STAMET-TEC-06
            </span>
            <i class="fas fa-plane-departure" style="color:#38BDF8;font-size:20px;"></i>
          </div>

          <h3 style="font-family:var(--font-heading);font-size:20px;font-weight:800;color:#fff;margin-top:12px;">
            Aviasi & Sensor AWS
          </h3>

          <div class="pkg-tariff-price" style="color:#38BDF8;">
            Standar WMO <span style="font-size:14px;color:#94A3B8;font-weight:600;">/ Resmi</span>
          </div>
          <div class="pkg-tariff-sub">
            Operasional 24 Jam & Verifikasi Tapak Sensor
          </div>

          <ul class="pkg-feature-list">
            <li><i class="fas fa-check-circle"></i> Flight Folder METAR, TAF, SPECI, WAFS</li>
            <li><i class="fas fa-check-circle"></i> Real-time Briefing H-2 Jam Sebelum ETD</li>
            <li><i class="fas fa-check-circle"></i> Survei Tapak & Bebas Halangan (Obstruction)</li>
            <li><i class="fas fa-check-circle"></i> Sertifikat Rekomendasi Teknis WMO No. 8</li>
            <li><i class="fas fa-check-circle"></i> Kalibrasi Sensor Suhu, Hujan, & Barometer</li>
          </ul>

          <button class="btn-choose-package btn-choose-cyan" @click="openBentoModal(services[0])">
            <i class="fas fa-arrow-up-right-from-square"></i> Buka Pop-up Bento
          </button>
        </div>
      </div>
    </section>

    <!-- =========================================================
         6. TESTIMONIALS SECTION ("WHAT OUR CUSTOMERS SAY?" LIKE REFERENCE)
         ========================================================= -->
    <section class="animate-entrance">
      <div class="section-header-center">
        <div class="section-tag-sub">Pengalaman Pemohon Layanan</div>
        <h2 class="section-title-large">Apa Kata Pemohon & Mitra Stamet Citeko?</h2>
        <p class="section-desc-light">
          Ulasan nyata dari mahasiswa, praktisi penerbangan, panitia event, dan masyarakat yang telah memanfaatkan layanan PTSP Stamet Citeko.
        </p>
      </div>

      <!-- Avatar Selector Arc -->
      <div class="testimonial-avatar-row">
        <div 
          v-for="(t, idx) in testimonials" 
          :key="idx" 
          class="avatar-bubble"
          :class="{ active: activeTestimonialIndex === idx }"
          @click="activeTestimonialIndex = idx"
        >
          <span v-text="t.initials"></span>
        </div>
      </div>

      <!-- Testimonial Quote Box with Slider Arrows -->
      <div class="testimonial-box-card">
        <button class="testi-nav-arrow testi-arrow-prev" @click="prevTestimonial">
          <i class="fas fa-chevron-left"></i>
        </button>

        <div style="color:#F59E0B;font-size:15px;margin-bottom:12px;">
          <i class="fas fa-star" v-for="s in 5" :key="s"></i>
        </div>

        <p style="font-size:15px;font-weight:500;color:#F1F5F9;line-height:1.75;font-style:italic;margin-bottom:18px;">
          "@{{ testimonials[activeTestimonialIndex].quote }}"
        </p>

        <div style="font-family:var(--font-heading);font-size:16px;font-weight:800;color:#fff;">
          @{{ testimonials[activeTestimonialIndex].name }}
        </div>
        <div style="font-size:12px;color:#38BDF8;font-weight:700;">
          @{{ testimonials[activeTestimonialIndex].role }}
        </div>

        <button class="testi-nav-arrow testi-arrow-next" @click="nextTestimonial">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </section>

    <!-- =========================================================
         7. "OUR BLOG / DOKUMENTASI KEGIATAN" (3 PHOTO CARDS LIKE REFERENCE)
         ========================================================= -->
    <section class="animate-entrance">
      <div class="section-header-center">
        <div class="section-tag-sub">Publikasi & Dokumentasi Lapangan</div>
        <h2 class="section-title-large">Warta & Kegiatan Stasiun Meteorologi Citeko</h2>
        <p class="section-desc-light">
          Aktivitas pengamatan atmosfer, edukasi cuaca siswa, dan pemantauan dinamika cuaca ekstrem di kawasan Puncak Cisarua Bogor.
        </p>
      </div>

      <div class="blog-grid">
        <!-- Post 1 -->
        <article class="blog-item-card">
          <div class="blog-thumb-box">
            <span class="blog-tag-badge">EDUKASI PUBLIK</span>
            <i class="fas fa-school"></i>
          </div>
          <div class="blog-body">
            <span class="blog-date"><i class="fas fa-calendar-alt"></i> 24 Oktober 2026</span>
            <h3 class="blog-title">Kunjungan Edukasi Siswa Mengenal Taman Alat Meteorologi</h3>
            <p class="blog-snippet">
              Siswa sekolah diajak melihat langsung cara kerja sangkar meteorologi, panci penguapan, dan Campbell Stokes di stasiun pengamatan Citeko.
            </p>
            <button class="btn-bento-open" style="margin-top:auto;width:fit-content;" @click="openBentoModal(services[4])">
              Pelajari Kunjungan <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </article>

        <!-- Post 2 -->
        <article class="blog-item-card">
          <div class="blog-thumb-box" style="background:linear-gradient(135deg, #1E1B4B, #0F172A);">
            <span class="blog-tag-badge" style="color:#A78BFA;border-color:rgba(167,139,250,0.4);">RISET AKADEMIS</span>
            <i class="fas fa-database" style="color:#A78BFA;"></i>
          </div>
          <div class="blog-body">
            <span class="blog-date"><i class="fas fa-calendar-alt"></i> 18 Oktober 2026</span>
            <h3 class="blog-title">Pemanfaatan Data AWS Presisi untuk Pemodelan Hidrometeorologi</h3>
            <p class="blog-snippet">
              Fasilitasi data curah hujan dan kelembapan ekstrem bagi riset mitigasi bencana longsor lereng curam di kawasan Puncak Bogor.
            </p>
            <button class="btn-bento-open" style="margin-top:auto;width:fit-content;" @click="openBentoModal(services[2])">
              Ajukan Riset Rp 0 <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </article>

        <!-- Post 3 -->
        <article class="blog-item-card">
          <div class="blog-thumb-box" style="background:linear-gradient(135deg, #064E3B, #0F172A);">
            <span class="blog-tag-badge" style="color:#4ADE80;border-color:rgba(74,222,128,0.4);">SIAGA CUACA</span>
            <i class="fas fa-cloud-bolt" style="color:#4ADE80;"></i>
          </div>
          <div class="blog-body">
            <span class="blog-date"><i class="fas fa-calendar-alt"></i> 12 Oktober 2026</span>
            <h3 class="blog-title">Nowcasting Cuaca Ekstrem Jalur Wisata Puncak Cisarua</h3>
            <p class="blog-snippet">
              Tim Forecaster Stamet Citeko memperkuat siaga pemantauan kabut tebal dan hembusan angin kencang bagi keselamatan wisatawan.
            </p>
            <button class="btn-bento-open" style="margin-top:auto;width:fit-content;" @click="openBentoModal(services[1])">
              Layanan Event <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </article>
      </div>
    </section>

    <!-- =========================================================
         8. SMART AUTO-ANSWER BOT WIDGET
         ========================================================= -->
    <section class="bot-search-box-card animate-entrance">
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">
        <div style="width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,#0284C7,#38BDF8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;box-shadow:0 0 20px rgba(56,189,248,0.4);">
          <i class="fas fa-robot"></i>
        </div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:20px;font-weight:800;color:#fff;margin:0;">
            Sistem Tanya Jawab Otomatis Stamet Citeko
          </h3>
          <p style="font-size:12.5px;color:rgba(148,163,184,0.85);margin:2px 0 0;">
            Ketik pertanyaan Anda. Sistem akan mencari jawaban resmi standar BMKG atau menghubungkan Anda ke WhatsApp CP Stamet Citeko.
          </p>
        </div>
      </div>

      <!-- Search Input -->
      <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:18px;background:rgba(255,255,255,0.05);border:1.5px solid rgba(56,189,248,0.25);margin-bottom:14px;">
        <i class="fas fa-search" style="color:var(--cyan-accent);font-size:15px;"></i>
        <input 
          type="text" 
          v-model="userQuery" 
          @keyup.enter="handleAutoAnswer"
          placeholder="Tanyakan syarat skripsi, biaya event, klaim asuransi petir, kunjungan sekolah..."
          style="flex:1;background:none;border:none;outline:none;color:#fff;font-size:13.5px;font-family:var(--font-main);"
        >
        <button class="btn-choose-package btn-choose-cyan" style="width:auto;padding:8px 18px;" @click="handleAutoAnswer" :disabled="isSearching">
          <span v-if="!isSearching"><i class="fas fa-paper-plane"></i> Cari Jawaban</span>
          <span v-else><i class="fas fa-spinner fa-spin"></i> Memproses...</span>
        </button>
      </div>

      <!-- Result Bubble -->
      <div v-if="autoResult" style="padding:20px;border-radius:20px;background:rgba(14,28,62,0.9);border:1px solid rgba(56,189,248,0.35);margin-top:14px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
          <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:999px;background:rgba(34,197,94,0.15);color:#4ADE80;border:1px solid rgba(34,197,94,0.35);">
            <i class="fas fa-check-circle"></i> Jawaban Resmi Terverifikasi Stamet Citeko
          </span>
          <span style="font-size:11.5px;color:#94A3B8;">
            Topik: <strong style="color:#38BDF8;">@{{ autoResult.data.service }}</strong>
          </span>
        </div>
        <div style="font-size:15px;font-weight:800;color:#fff;margin-bottom:6px;">
          @{{ autoResult.data.question }}
        </div>
        <div style="font-size:13px;color:#E2E8F0;line-height:1.65;margin-bottom:14px;">
          @{{ autoResult.data.answer }}
        </div>
        <button class="btn-choose-package btn-choose-primary" style="width:fit-content;padding:8px 18px;" @click="openWhatsAppModal(autoResult.data.service, userQuery)">
          <i class="fab fa-whatsapp"></i> Chat CP Stamet Citeko di WhatsApp
        </button>
      </div>
    </section>

    <!-- =========================================================
         9. POP-UP BENTO MODAL (DETAIL, CHECKLIST, SOP, TEMPLATE)
         ========================================================= -->
    <div v-if="activeBentoModal" class="popup-backdrop" @click.self="closeBentoModal">
      <div class="popup-modal-window">
        <button class="popup-close-btn" @click="closeBentoModal">&times;</button>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap;">
          <span style="font-family:var(--font-mono);font-size:11px;font-weight:700;padding:3px 10px;border-radius:8px;background:rgba(0,240,255,0.12);color:var(--cyan-accent);border:1px solid rgba(0,240,255,0.3);">
            @{{ activeBentoModal.code }}
          </span>
          <span style="font-size:12px;color:#94A3B8;">Stasiun Meteorologi Citeko Puncak Bogor</span>
        </div>

        <h2 style="font-family:var(--font-heading);font-size:24px;font-weight:800;color:#fff;line-height:1.25;margin-bottom:8px;">
          @{{ activeBentoModal.title }}
        </h2>
        <p style="font-size:13px;color:rgba(203,213,225,0.85);line-height:1.6;margin-bottom:20px;">
          @{{ activeBentoModal.summary }}
        </p>

        <!-- 4-Quadrant Sub-Bento Tile inside Modal -->
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px;">
          <div style="padding:14px;border-radius:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px;font-weight:700;color:#94A3B8;">TARIF RESMI</div>
            <div style="font-size:13px;font-weight:800;color:#4ADE80;margin-top:2px;">@{{ activeBentoModal.tariff_label }}</div>
          </div>
          <div style="padding:14px;border-radius:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px;font-weight:700;color:#94A3B8;">SLA WAKTU</div>
            <div style="font-size:13px;font-weight:800;color:#fff;margin-top:2px;">@{{ activeBentoModal.sla }}</div>
          </div>
          <div style="padding:14px;border-radius:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px;font-weight:700;color:#94A3B8;">BENTUK LUARAN</div>
            <div style="font-size:12px;font-weight:800;color:#38BDF8;margin-top:2px;">@{{ activeBentoModal.deliverable }}</div>
          </div>
          <div style="padding:14px;border-radius:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px;font-weight:700;color:#94A3B8;">DASAR HUKUM</div>
            <div style="font-size:11px;color:#CBD5E1;margin-top:2px;">@{{ activeBentoModal.legal_basis }}</div>
          </div>
        </div>

        <!-- Modal Nav Tabs -->
        <div style="display:flex;gap:8px;border-bottom:1px solid rgba(255,255,255,0.1);margin-bottom:18px;">
          <button 
            style="padding:10px 16px;border:none;background:none;font-size:13px;font-weight:700;color:rgba(148,163,184,0.7);cursor:pointer;border-bottom:2px solid transparent;"
            :style="modalActiveTab === 'requirements' ? 'color:var(--cyan-accent);border-bottom-color:var(--cyan-accent);' : ''"
            @click="modalActiveTab = 'requirements'"
          >
            <i class="fas fa-list-check"></i> Checklist Persyaratan Berkas
          </button>
          <button 
            style="padding:10px 16px;border:none;background:none;font-size:13px;font-weight:700;color:rgba(148,163,184,0.7);cursor:pointer;border-bottom:2px solid transparent;"
            :style="modalActiveTab === 'sop' ? 'color:var(--cyan-accent);border-bottom-color:var(--cyan-accent);' : ''"
            @click="modalActiveTab = 'sop'"
          >
            <i class="fas fa-timeline"></i> Alur SOP
          </button>
          <button 
            style="padding:10px 16px;border:none;background:none;font-size:13px;font-weight:700;color:rgba(148,163,184,0.7);cursor:pointer;border-bottom:2px solid transparent;"
            :style="modalActiveTab === 'template' ? 'color:var(--cyan-accent);border-bottom-color:var(--cyan-accent);' : ''"
            @click="modalActiveTab = 'template'"
          >
            <i class="fas fa-copy"></i> Format Surat Permohonan
          </button>
        </div>

        <!-- Tab 1: Checklist -->
        <div v-if="modalActiveTab === 'requirements'" style="display:flex;flex-direction:column;gap:10px;">
          <div 
            v-for="(req, idx) in activeBentoModal.requirements" 
            :key="idx" 
            style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;border-radius:12px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);cursor:pointer;"
            :style="checkedItems[activeBentoModal.slug + '-' + idx] ? 'background:rgba(34,197,94,0.1);border-color:rgba(34,197,94,0.3);' : ''"
            @click="toggleCheck(activeBentoModal.slug + '-' + idx)"
          >
            <i class="fas fa-check-circle" :style="checkedItems[activeBentoModal.slug + '-' + idx] ? 'color:#22C55E;' : 'color:rgba(255,255,255,0.2);'" style="font-size:18px;margin-top:2px;"></i>
            <div style="font-size:13px;color:#E2E8F0;line-height:1.5;">@{{ req }}</div>
          </div>
        </div>

        <!-- Tab 2: SOP -->
        <div v-if="modalActiveTab === 'sop'" style="display:flex;flex-direction:column;gap:12px;">
          <div v-for="step in activeBentoModal.flow_steps" :key="step.step" style="display:flex;gap:14px;padding:14px;border-radius:12px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);">
            <div style="width:30px;height:30px;border-radius:50%;background:#0284C7;color:#fff;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">@{{ step.step }}</div>
            <div>
              <div style="font-size:13.5px;font-weight:800;color:#fff;">@{{ step.title }}</div>
              <div style="font-size:12.5px;color:rgba(203,213,225,0.8);margin-top:2px;">@{{ step.desc }}</div>
            </div>
          </div>
        </div>

        <!-- Tab 3: Template -->
        <div v-if="modalActiveTab === 'template'" style="position:relative;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
            <span style="font-size:12.5px;font-weight:700;color:#fff;">@{{ activeBentoModal.template_doc.title }}</span>
            <button class="btn-choose-package btn-choose-cyan" style="width:auto;padding:4px 12px;font-size:11px;" @click="copyTemplateText(activeBentoModal.template_doc.content)">
              <i class="fas fa-copy"></i> @{{ copySuccess ? 'Tersalin!' : 'Salin Teks' }}
            </button>
          </div>
          <pre style="background:rgba(2,6,23,0.95);border:1px solid rgba(56,189,248,0.2);border-radius:14px;padding:16px;font-family:var(--font-mono);font-size:12px;color:#93C5FD;white-space:pre-wrap;max-height:260px;overflow-y:auto;">@{{ activeBentoModal.template_doc.content }}</pre>
        </div>

        <!-- Direct WhatsApp Action in Modal -->
        <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;margin-top:24px;padding:16px 20px;border-radius:16px;background:linear-gradient(135deg,rgba(22,101,52,0.35),rgba(34,197,94,0.15));border:1px solid rgba(34,197,94,0.45);flex-wrap:wrap;">
          <div>
            <div style="font-size:13.5px;font-weight:800;color:#4ADE80;"><i class="fab fa-whatsapp"></i> Hubungi CP Stamet Citeko Puncak via WhatsApp</div>
            <div style="font-size:12px;color:#CBD5E1;">Nomor Resmi CP: +@{{ whatsappNumber }} &bull; Cisarua, Puncak Bogor</div>
          </div>
          <button class="btn-choose-package btn-choose-primary" style="background:#22C55E;width:auto;padding:10px 20px;" @click="openWhatsAppModal(activeBentoModal.short_title)">
            <i class="fab fa-whatsapp"></i> Chat WhatsApp Sekarang
          </button>
        </div>
      </div>
    </div>

    <!-- =========================================================
         10. FLOATING WHATSAPP BUTTON (CP STAMET CITEKO)
         ========================================================= -->
    <a 
      :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Petugas Pelayanan PTSP Stamet Citeko Puncak Bogor (BMKG), saya ingin berkonsultasi mengenai permohonan layanan meteorologi. Terima kasih.')" 
      target="_blank" 
      rel="noopener noreferrer"
      class="floating-wa-pill"
      title="Hubungi CP Stamet Citeko Puncak via WhatsApp (+62 857-7777-6751)"
    >
      <i class="fab fa-whatsapp" style="font-size:20px;"></i>
      <span>Chat CP Stamet Citeko</span>
    </a>

    <!-- =========================================================
         11. MODAL FORM WHATSAPP SCRIPT
         ========================================================= -->
    <div v-if="showWaModal" class="popup-backdrop" @click.self="showWaModal = false">
      <div class="popup-modal-window" style="max-width:520px;">
        <button class="popup-close-btn" @click="showWaModal = false">&times;</button>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
          <div style="width:42px;height:42px;border-radius:12px;background:#22C55E;color:#fff;display:flex;align-items:center;justify-content:center;font-size:22px;">
            <i class="fab fa-whatsapp"></i>
          </div>
          <div>
            <h4 style="font-family:var(--font-heading);font-size:16px;font-weight:800;color:#fff;margin:0;">
              Konsultasi WhatsApp CP Stamet Citeko
            </h4>
            <p style="font-size:11.5px;color:#94A3B8;margin:2px 0 0;">
              Nomor Resmi CP: +@{{ whatsappNumber }} &bull; Cisarua, Puncak Bogor
            </p>
          </div>
        </div>

        <form @submit.prevent="submitWhatsAppChat">
          <div style="margin-bottom:12px;">
            <label style="display:block;font-size:11.5px;font-weight:700;color:#CBD5E1;margin-bottom:6px;">Layanan yang Dituju</label>
            <select v-model="waForm.service" style="width:100%;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#fff;font-size:13px;outline:none;">
              <option v-for="s in services" :key="s.id" :value="s.short_title" style="background:#0a1834;color:#fff;">
                @{{ s.short_title }} (@{{ s.code }})
              </option>
            </select>
          </div>

          <div style="margin-bottom:12px;">
            <label style="display:block;font-size:11.5px;font-weight:700;color:#CBD5E1;margin-bottom:6px;">Nama Lengkap Pemohon</label>
            <input type="text" v-model="waForm.name" placeholder="Nama Anda" required style="width:100%;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#fff;font-size:13px;outline:none;">
          </div>

          <div style="margin-bottom:12px;">
            <label style="display:block;font-size:11.5px;font-weight:700;color:#CBD5E1;margin-bottom:6px;">Asal Instansi / Universitas / Perusahaan</label>
            <input type="text" v-model="waForm.agency" placeholder="Contoh: Universitas Indonesia / PT Sejahtera / Umum" required style="width:100%;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#fff;font-size:13px;outline:none;">
          </div>

          <div style="margin-bottom:16px;">
            <label style="display:block;font-size:11.5px;font-weight:700;color:#CBD5E1;margin-bottom:6px;">Pesan / Pertanyaan Berkas</label>
            <textarea v-model="waForm.message" rows="3" placeholder="Tuliskan kendala berkas atau permohonan Anda..." style="width:100%;padding:10px 14px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#fff;font-size:13px;outline:none;font-family:var(--font-main);"></textarea>
          </div>

          <div style="display:flex;gap:10px;">
            <button type="button" @click="showWaModal = false" style="flex:1;padding:12px;border-radius:12px;border:1px solid rgba(255,255,255,0.15);background:none;color:#CBD5E1;font-weight:700;cursor:pointer;">
              Batal
            </button>
            <button type="submit" class="btn-choose-package btn-choose-primary" style="background:#22C55E;flex:2;">
              <i class="fab fa-whatsapp"></i> Buka WhatsApp Resmi
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  const { createApp, ref, reactive } = Vue;

  createApp({
    setup() {
      const services = ref(@json($services));
      const whatsappNumber = ref('{{ $whatsappNumber }}');
      const stametName = ref('{{ $stametName }}');
      const officeHours = ref('{{ $officeHours }}');

      const selectedFilter = ref('all');
      const activeBentoModal = ref(null);
      const modalActiveTab = ref('requirements');
      const checkedItems = reactive({});

      const userQuery = ref('');
      const isSearching = ref(false);
      const autoResult = ref(null);
      const copySuccess = ref(false);
      const showWaModal = ref(false);

      const waForm = ref({
        service: services.value[0] ? services.value[0].short_title : '',
        name: '',
        agency: '',
        message: ''
      });

      // Testimonials State (Like reference design)
      const activeTestimonialIndex = ref(0);
      const testimonials = [
        {
          name: 'Dina Rahmawati, S.Si.',
          initials: 'DR',
          role: 'Alumni Departemen Geografi Universitas Indonesia',
          quote: 'Permohonan data curah hujan dan suhu harian 10 tahun untuk skripsi saya diproses sangat cepat (2 hari) dan benar-benar 100% GRATIS (Tarif Rp 0,-). Respon admin di WhatsApp CP Citeko sangat responsif dan ramah.'
        },
        {
          name: 'Capt. Hendra Wijaya',
          initials: 'HW',
          role: 'Flight Operations Officer (FOO) Aerodrome',
          quote: 'Briefing cuaca TAF dan pemodelan angin atas WAFS dari Stamet Citeko sangat presisi untuk keselamatan rute penerbangan kami di koridor Jawa Barat.'
        },
        {
          name: 'Budi Santoso',
          initials: 'BS',
          role: 'Ketua Panitia Festival Musik Puncak Outdoor',
          quote: 'Nowcasting radar cuaca per jam dari Stamet Citeko membantu kami mengatur jadwal panggung utama dan mitigasi perlengkapan tata suara dari ancaman hujan badai.'
        },
        {
          name: 'Arif Wicaksono, S.T.',
          initials: 'AW',
          role: 'Loss Adjuster Klaim Asuransi Bangunan Cisarua',
          quote: 'Surat Keterangan Kejadian Cuaca Ekstrem dan rekaman sambaran petir dari Kepala Stamet Citeko langsung diterima oleh perusahaan asuransi tanpa kendala.'
        }
      ];

      const nextTestimonial = () => {
        activeTestimonialIndex.value = (activeTestimonialIndex.value + 1) % testimonials.length;
      };
      const prevTestimonial = () => {
        activeTestimonialIndex.value = (activeTestimonialIndex.value - 1 + testimonials.length) % testimonials.length;
      };

      const openBentoModal = (svc) => {
        activeBentoModal.value = svc;
        modalActiveTab.value = 'requirements';
        document.body.style.overflow = 'hidden';
      };

      const closeBentoModal = () => {
        activeBentoModal.value = null;
        document.body.style.overflow = '';
      };

      const toggleCheck = (key) => {
        checkedItems[key] = !checkedItems[key];
      };

      const handleAutoAnswer = async () => {
        const q = userQuery.value.trim();
        if (!q) return;

        isSearching.value = true;
        try {
          const res = await fetch(`/api/stamet/auto-answer?query=${encodeURIComponent(q)}`);
          const data = await res.json();
          if (data && data.success) {
            autoResult.value = data;
          } else {
            autoResult.value = {
              matched: false,
              data: {
                question: q,
                answer: 'Pertanyaan ini memerlukan verifikasi khusus oleh Petugas Forecaster Stasiun Meteorologi Citeko BMKG. Silakan klik tombol di bawah untuk konsultasi via WhatsApp.',
                service: 'Layanan Stamet Citeko'
              }
            };
          }
        } catch (err) {
          console.error(err);
        } finally {
          isSearching.value = false;
        }
      };

      const copyTemplateText = (text) => {
        navigator.clipboard.writeText(text).then(() => {
          copySuccess.value = true;
          setTimeout(() => { copySuccess.value = false; }, 2500);
        });
      };

      const openWhatsAppModal = (serviceName, customQuery = '') => {
        waForm.value.service = serviceName || 'Layanan Stamet Citeko Puncak';
        if (customQuery) waForm.value.message = customQuery;
        showWaModal.value = true;
      };

      const submitWhatsAppChat = () => {
        const text = `Halo Petugas Pelayanan PTSP Stamet Citeko Puncak Bogor (BMKG),\n\nSaya ingin mengajukan permohonan/konsultasi layanan:\n- Layanan: ${waForm.value.service}\n- Nama Pemohon: ${waForm.value.name}\n- Asal Instansi/Kampus: ${waForm.value.agency}\n- Keperluan/Pertanyaan: ${waForm.value.message || 'Mohon arahan berkas dan alur layanannya.'}\n\n(Diajukan via Portal Resmi WeatherLive-Grid Stamet Citeko Puncak Bogor)`;
        const url = `https://wa.me/${whatsappNumber.value}?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
        showWaModal.value = false;
      };

      return {
        services,
        whatsappNumber,
        stametName,
        officeHours,
        selectedFilter,
        activeBentoModal,
        modalActiveTab,
        checkedItems,
        testimonials,
        activeTestimonialIndex,
        nextTestimonial,
        prevTestimonial,
        openBentoModal,
        closeBentoModal,
        toggleCheck,
        userQuery,
        isSearching,
        autoResult,
        handleAutoAnswer,
        copyTemplateText,
        copySuccess,
        showWaModal,
        waForm,
        openWhatsAppModal,
        submitWhatsAppChat
      };
    }
  }).mount('#stamet-bento-v5');
</script>
@endsection

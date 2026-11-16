<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="WeatherLive-Grid — Sistem Informasi Cuaca Jawa Barat kelas dunia. Prakiraan cuaca real-time, peta interaktif, peringatan dini bencana, kualitas udara, dan analitik cuaca akurat untuk 27 kabupaten/kota di Jawa Barat.">
<meta name="keywords" content="cuaca jawa barat, cuaca bandung, prakiraan cuaca, weather live jabar, suhu, hujan, angin, peringatan dini, kualitas udara, radar, satelit">
<meta name="theme-color" content="#081A2F">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'WeatherLive-Grid') - Cuaca Indonesia #1">
<meta property="og:description" content="Sistem Informasi Cuaca Jawa Barat kelas dunia. Prakiraan cuaca real-time, radar hujan, kualitas udara, dan peringatan dini bencana BMKG.">
<meta property="og:image" content="{{ asset('icon-192.png') }}">
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@yield('title', 'WeatherLive-Grid') - Cuaca Indonesia #1">
<meta property="twitter:description" content="Sistem Informasi Cuaca Jawa Barat kelas dunia. Prakiraan cuaca real-time, radar hujan, kualitas udara, dan peringatan dini bencana BMKG.">
<meta property="twitter:image" content="{{ asset('icon-192.png') }}">
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="/icon-192.png">
<title>@yield('title', 'WeatherLive-Grid') - Cuaca Indonesia #1</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
<link rel="dns-prefetch" href="https://unpkg.com">
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|space+grotesk:500,600,700&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Exo+2:wght@300;400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script defer src="https://unpkg.com/gsap@3.12.5/dist/gsap.min.js"></script>
<script defer src="https://unpkg.com/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@yield('styles')
@stack('styles')
<style>
/* ========================================================
   WEATHERLIVE-GRID v3.0 — HYPER-DYNAMIC DESIGN SYSTEM
   5D/6D PARALLAX • 3D HOLOGRAPHIC • QUANTUM PARTICLES
   ======================================================== */
:root{
  --primary:#2563EB;--secondary:#3B82F6;--accent:#38BDF8;--bg:#060d1a;
  --glass:rgba(255,255,255,0.06);--glass-strong:rgba(255,255,255,0.12);
  --success:#22C55E;--warning:#F59E0B;--danger:#EF4444;
  --card:#ffffff;--text:#0B1B33;--muted:#5B6B85;--border:#E2E8F0;
  --shadow:0 8px 32px rgba(8,26,47,0.10);--glow:0 0 40px rgba(56,189,248,0.12);
  --radius:22px;--trans:0.45s cubic-bezier(.175,.885,.32,1.275);
  --bmkg-light:#38BDF8;--bmkg-primary:#2563EB;--bmkg-accent:#7C3AED;
  --bmkg-card:var(--card);--bmkg-border:var(--border);--bmkg-text:var(--text);
  --bmkg-blue:#1e88e5;--bmkg-red:#e53935;--bmkg-green:#43a047;
  --bmkg-muted:var(--muted);
  /* ---- NEW HYPER TOKENS ---- */
  --neon-cyan:#00FFE7;--neon-blue:#0080FF;--neon-violet:#BF00FF;
  --neon-green:#39FF14;--neon-gold:#FFD700;
  --holo-a:rgba(0,255,231,0.12);--holo-b:rgba(0,128,255,0.1);--holo-c:rgba(191,0,255,0.08);
  --depth-1:translateZ(0px);--depth-2:translateZ(20px);--depth-3:translateZ(40px);
  --depth-4:translateZ(80px);--depth-5:translateZ(120px);--depth-6:translateZ(200px);
  --perspective:1000px;
  --chromatic-r:rgba(255,0,0,0.15);--chromatic-g:rgba(0,255,0,0.1);--chromatic-b:rgba(0,0,255,0.15);
}
.dark{--card:#080f1e;--text:#E8F1FF;--muted:#8FA3C4;--border:rgba(255,255,255,0.08);--shadow:0 8px 32px rgba(0,0,0,0.5)}

/* ===== RESET & BASE ===== */
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth;perspective:var(--perspective)}
body{
  font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
  background:var(--bg);color:var(--text);min-height:100vh;
  transition:background .5s,color .3s;overflow-x:hidden;
  -webkit-font-smoothing:antialiased;position:relative;letter-spacing:-0.01em;
}
.dark body,body{
  background:
    radial-gradient(ellipse at 15% 5%, rgba(0,128,255,0.18) 0%, transparent 45%),
    radial-gradient(ellipse at 85% 15%, rgba(56,189,248,0.12) 0%, transparent 40%),
    radial-gradient(ellipse at 50% 90%, rgba(124,58,237,0.15) 0%, transparent 50%),
    radial-gradient(ellipse at 80% 50%, rgba(37,99,235,0.08) 0%, transparent 45%),
    #060d1a;
}
[v-cloak]{display:none!important}
h1,h2,h3,h4,.font-display{font-family:'Space Grotesk','Inter',sans-serif;letter-spacing:-0.02em}
.font-orbitron{font-family:'Orbitron',monospace;letter-spacing:0.05em}

/* ===== ACCESSIBILITY ===== */
.skip-link{position:absolute;top:-100%;left:16px;background:var(--accent);color:#fff;padding:10px 18px;border-radius:10px;font-weight:700;z-index:100000;transition:top .2s}
.skip-link:focus{top:16px}
@media (prefers-reduced-motion: reduce){
  *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important;scroll-behavior:auto!important}
}
[draggable="true"]{cursor:grab}
[draggable="true"]:active{cursor:grabbing}

/* ========================================================
   CUSTOM CURSOR — PLASMA TRAIL
   ======================================================== */
.cursor-dot{position:fixed;top:0;left:0;width:10px;height:10px;border-radius:50%;background:var(--neon-cyan);transform:translate(-50%,-50%);pointer-events:none;z-index:999999;mix-blend-mode:screen;box-shadow:0 0 12px var(--neon-cyan),0 0 30px rgba(0,255,231,0.5);transition:transform .08s;will-change:transform}
.cursor-ring{position:fixed;top:0;left:0;width:38px;height:38px;border-radius:50%;border:1.5px solid rgba(56,189,248,0.5);transform:translate(-50%,-50%);pointer-events:none;z-index:999998;transition:width .22s,height .22s,border-color .22s,opacity .15s;will-change:transform}
.cursor-ring.hover{width:60px;height:60px;border-color:rgba(0,255,231,0.9);box-shadow:0 0 20px rgba(0,255,231,0.35)}
.cursor-ring.click{transform:translate(-50%,-50%) scale(0.8);border-color:#fff}
/* Plasma trail dots */
.cursor-trail{position:fixed;width:5px;height:5px;border-radius:50%;pointer-events:none;z-index:999997;transform:translate(-50%,-50%);transition:opacity .4s;will-change:transform}
@media(pointer:coarse){.cursor-dot,.cursor-ring,.cursor-trail{display:none!important}}
@media(prefers-reduced-motion:reduce){.cursor-dot,.cursor-ring,.cursor-trail{display:none!important}}

/* ========================================================
   QUANTUM BACKGROUND — MULTI-LAYER AURORA
   ======================================================== */
.aurora-bg{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none}
/* Layer 1 — Slow mega blobs */
.aurora-bg::before{content:'';position:absolute;width:80vw;height:80vw;border-radius:50%;filter:blur(100px);opacity:.35;animation:auroraDrift 22s ease-in-out infinite;background:radial-gradient(circle,rgba(37,99,235,0.9),rgba(56,189,248,0.3),transparent 65%);top:-25%;left:-20%}
.aurora-bg::after{content:'';position:absolute;width:70vw;height:70vw;border-radius:50%;filter:blur(90px);opacity:.3;animation:auroraDrift 28s ease-in-out infinite reverse;background:radial-gradient(circle,rgba(124,58,237,0.9),rgba(191,0,255,0.2),transparent 60%);bottom:-30%;right:-15%}
/* Layer 2 — Medium blobs */
.aurora-blob{position:absolute;border-radius:50%;filter:blur(70px);opacity:.2;animation:auroraDrift 32s ease-in-out infinite}
.aurora-1{width:55vw;height:55vw;background:radial-gradient(circle,#3B82F6,#38BDF8,transparent 60%);top:20%;left:35%;animation-delay:-8s}
.aurora-2{width:40vw;height:40vw;background:radial-gradient(circle,#22C55E,#38BDF8,transparent 60%);top:-5%;right:10%;animation-delay:-14s}
.aurora-3{width:35vw;height:35vw;background:radial-gradient(circle,#F59E0B,#EF4444,transparent 60%);bottom:10%;left:15%;animation-delay:-20s}
.aurora-4{width:28vw;height:28vw;background:radial-gradient(circle,#EC4899,#7C3AED,transparent 60%);top:50%;right:5%;animation-delay:-5s}
/* Layer 3 — Animated grid */
.aurora-grid{position:absolute;inset:0;
  background-image:
    linear-gradient(rgba(56,189,248,0.06) 1px,transparent 1px),
    linear-gradient(90deg,rgba(56,189,248,0.06) 1px,transparent 1px);
  background-size:80px 80px;
  mask-image:radial-gradient(ellipse at center,black 30%,transparent 70%);
  -webkit-mask-image:radial-gradient(ellipse at center,black 30%,transparent 70%);
  animation:gridPulse 8s ease-in-out infinite}
@keyframes gridPulse{0%,100%{opacity:.6;background-size:80px 80px}50%{opacity:1;background-size:82px 82px}}
/* Layer 4 — Scanlines */
.aurora-scan{position:absolute;inset:0;pointer-events:none;
  background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(56,189,248,0.018) 2px,rgba(56,189,248,0.018) 4px);
  animation:scanlineMove 20s linear infinite}
@keyframes scanlineMove{0%{background-position:0 0}100%{background-position:0 400px}}
/* Layer 5 — Holographic shimmer overlay */
.aurora-holo{position:absolute;inset:0;pointer-events:none;
  background:linear-gradient(135deg,transparent 30%,rgba(0,255,231,0.03) 50%,transparent 70%),
             linear-gradient(45deg,transparent 30%,rgba(191,0,255,0.03) 50%,transparent 70%);
  animation:holoShimmer 6s ease-in-out infinite;opacity:.8}
@keyframes holoShimmer{0%,100%{opacity:.4;transform:rotate(0deg)}50%{opacity:.9;transform:rotate(1deg)}}

@keyframes auroraDrift{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(5%,-5%) scale(1.06)}50%{transform:translate(8%,3%) scale(1.1)}75%{transform:translate(-4%,6%) scale(0.97)}}
.light .aurora-bg{background:linear-gradient(160deg,#EAF2FF,#F0F8FF,#EAF6FF)}

/* ===== LAYOUT HELPERS ===== */
.page-wrap{max-width:1280px;margin:0 auto;padding:0 22px 60px;position:relative;z-index:2;color:var(--text)}
.text-center{text-align:center}

/* ========================================================
   3D TILT SYSTEM — TRUE 3D PERSPECTIVE
   ======================================================== */
.tilt-3d{
  transition:transform .5s cubic-bezier(.23,1,.32,1),box-shadow .5s;
  transform-style:preserve-3d;will-change:transform;
  transform-origin:center center;
}
.tilt-3d:hover{transform:translateY(-8px) rotateX(4deg) rotateY(-4deg) scale(1.02);box-shadow:0 30px 80px rgba(0,0,0,0.5)}

/* ========================================================
   GLASS SYSTEM — ULTRA PREMIUM
   ======================================================== */
.glass{
  background:rgba(8,20,42,0.55);
  backdrop-filter:blur(28px) saturate(180%) brightness(1.1);
  -webkit-backdrop-filter:blur(28px) saturate(180%) brightness(1.1);
  border:1px solid rgba(255,255,255,0.12);
  border-radius:var(--radius);box-shadow:var(--shadow);
}
.glass-strong{
  background:rgba(8,20,42,0.72);
  backdrop-filter:blur(36px) saturate(200%);
  -webkit-backdrop-filter:blur(36px) saturate(200%);
  border:1px solid rgba(255,255,255,0.16);
  border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,0.4);
}
.glass-card{
  position:relative;overflow:hidden;
  background:rgba(255,255,255,0.75);
  backdrop-filter:blur(28px) saturate(180%);
  -webkit-backdrop-filter:blur(28px) saturate(180%);
  border:1px solid rgba(255,255,255,0.45);
  border-radius:var(--radius);box-shadow:var(--shadow);
  transition:all .5s cubic-bezier(.23,1,.32,1);
}
/* Holographic shimmer on cards */
.glass-card::before{
  content:'';position:absolute;inset:0;border-radius:inherit;pointer-events:none;z-index:1;
  background:linear-gradient(135deg,rgba(255,255,255,0.22) 0%,transparent 50%,rgba(56,189,248,0.06) 100%);
  opacity:.7;transition:opacity .4s,transform .4s;
}
.glass-card::after{
  content:'';position:absolute;inset:-2px;border-radius:calc(var(--radius) + 2px);pointer-events:none;z-index:0;
  background:linear-gradient(135deg,rgba(56,189,248,0.3),transparent,rgba(124,58,237,0.2));
  opacity:0;transition:opacity .4s;
}
.glass-card:hover::before{opacity:1;transform:scale(1.02)}
.glass-card:hover::after{opacity:1}
.glass-card:hover{transform:translateY(-6px) scale(1.01);box-shadow:0 24px 60px rgba(8,26,47,0.2),0 0 0 1px rgba(56,189,248,0.25)}
.dark .glass-card{background:rgba(10,18,36,0.78);border-color:rgba(56,189,248,0.15)}
.dark .glass-card::before{background:linear-gradient(135deg,rgba(56,189,248,0.08),transparent 50%,rgba(124,58,237,0.05) 100%)}

/* ========================================================
   TYPOGRAPHY — GRADIENT & NEON
   ======================================================== */
.gradient-text{background:linear-gradient(120deg,#38BDF8,#2563EB,#7C3AED);-webkit-background-clip:text;background-clip:text;color:transparent}
.gradient-text-anim{background:linear-gradient(120deg,#38BDF8,#2563EB,#7C3AED,#38BDF8);background-size:300% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:gradShift 5s linear infinite}
.neon-text{color:var(--neon-cyan);text-shadow:0 0 10px var(--neon-cyan),0 0 30px rgba(0,255,231,0.5),0 0 60px rgba(0,255,231,0.2)}
.neon-text-blue{color:var(--neon-blue);text-shadow:0 0 10px var(--neon-blue),0 0 30px rgba(0,128,255,0.5)}
.neon-text-violet{color:var(--neon-violet);text-shadow:0 0 10px var(--neon-violet),0 0 30px rgba(191,0,255,0.5)}
.holo-text{
  background:linear-gradient(90deg,#00FFE7,#0080FF,#BF00FF,#FF00A0,#FFD700,#00FFE7);
  background-size:400% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;
  animation:holoText 4s linear infinite;filter:drop-shadow(0 0 8px rgba(0,255,231,0.4))
}
@keyframes holoText{0%{background-position:0%}100%{background-position:400%}}
@keyframes gradShift{0%{background-position:0% 50%}100%{background-position:300% 50%}}

.gradient-border{position:relative;background:linear-gradient(var(--card),var(--card)) padding-box,linear-gradient(135deg,#38BDF8,#2563EB,#7C3AED) border-box;border:1px solid transparent}

/* ========================================================
   PILLS & BADGES
   ======================================================== */
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.16);transition:all .25s}
.pill:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,0.2)}
.pill.live{background:rgba(34,197,94,0.15);border-color:rgba(34,197,94,0.4);color:#4ADE80;animation:pillGlow 2s ease-in-out infinite}
@keyframes pillGlow{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,0.3)}50%{box-shadow:0 0 12px 4px rgba(34,197,94,0.15)}}
.pill.ai{background:rgba(124,58,237,0.18);border-color:rgba(124,58,237,0.4);color:#C4B5FD}
.pill.blue{background:rgba(37,99,235,0.15);border-color:rgba(37,99,235,0.4);color:#93C5FD}
.pill.warn{background:rgba(245,158,11,0.15);border-color:rgba(245,158,11,0.4);color:#FCD34D}
.pill.neon-pill{background:rgba(0,255,231,0.08);border-color:rgba(0,255,231,0.4);color:var(--neon-cyan);text-shadow:0 0 8px var(--neon-cyan)}

/* ========================================================
   MEGA ANIMATION LIBRARY
   ======================================================== */

/* — Basic motion — */
@keyframes float3d{0%,100%{transform:translateY(0) rotateX(0) rotateZ(0)}33%{transform:translateY(-10px) rotateX(2deg) rotateZ(1deg)}66%{transform:translateY(-5px) rotateX(-1deg) rotateZ(-1deg)}}
@keyframes floatDeep{0%,100%{transform:translateY(0) translateZ(0) scale(1)}50%{transform:translateY(-16px) translateZ(20px) scale(1.02)}}
@keyframes pulseGlow{0%,100%{box-shadow:0 0 20px rgba(56,189,248,0.2)}50%{box-shadow:0 0 50px rgba(56,189,248,0.5),0 0 100px rgba(56,189,248,0.1)}}
@keyframes slideUp{from{opacity:0;transform:translateY(40px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes slideDown{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes scaleIn{from{transform:scale(.85);opacity:0}to{transform:scale(1);opacity:1}}
@keyframes spinSlow{to{transform:rotate(360deg)}}
@keyframes navSlideIn{from{opacity:0;transform:translateY(-14px)}to{opacity:1;transform:translateY(0)}}
@keyframes pageIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

/* — Live/pulse — */
@keyframes livePulse{0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(34,197,94,.6)}50%{opacity:.75;box-shadow:0 0 0 10px rgba(34,197,94,0)}}
@keyframes neonPulse{0%,100%{box-shadow:0 0 5px var(--neon-cyan),0 0 20px rgba(0,255,231,0.3)}50%{box-shadow:0 0 20px var(--neon-cyan),0 0 60px rgba(0,255,231,0.6),0 0 100px rgba(0,255,231,0.2)}}
@keyframes holoPulse{0%{opacity:.6;filter:hue-rotate(0deg)}50%{opacity:1;filter:hue-rotate(30deg)}100%{opacity:.6;filter:hue-rotate(0deg)}}

/* — Border flows — */
@keyframes borderFlow{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
@keyframes rainbowBorder{0%{border-color:#38BDF8}16%{border-color:#2563EB}33%{border-color:#7C3AED}50%{border-color:#EC4899}66%{border-color:#F59E0B}83%{border-color:#22C55E}100%{border-color:#38BDF8}}

/* — Particles & particles — */
@keyframes riseUp{0%{transform:translateY(0) scale(1) rotate(0);opacity:0}10%{opacity:.8}90%{opacity:.3}100%{transform:translateY(-110vh) scale(.3) rotate(360deg);opacity:0}}
@keyframes sparkle{0%,100%{opacity:0;transform:scale(0)}50%{opacity:1;transform:scale(1)}}
@keyframes orbiting{0%{transform:rotate(0) translateX(60px) rotate(0)}100%{transform:rotate(360deg) translateX(60px) rotate(-360deg)}}
@keyframes quantumJitter{0%,100%{transform:translate(0,0)}25%{transform:translate(1px,-1px)}50%{transform:translate(-1px,1px)}75%{transform:translate(1px,1px)}}

/* — Loading — */
@keyframes loaderBar{0%{transform:translateX(-100%)}100%{transform:translateX(350%)}}
@keyframes pulseCore{0%,100%{opacity:.5;transform:scale(1)}50%{opacity:1;transform:scale(1.14)}}

/* — 3D / Dimensional — */
@keyframes rotate3d{0%{transform:rotateX(0) rotateY(0)}100%{transform:rotateX(360deg) rotateY(360deg)}}
@keyframes warpSpeed{0%{transform:scaleX(1) scaleY(1)}50%{transform:scaleX(1.02) scaleY(.98)}100%{transform:scaleX(1) scaleY(1)}}
@keyframes depthPulse{0%,100%{transform:translateZ(0) scale(1)}50%{transform:translateZ(30px) scale(1.03)}}
@keyframes prismSpin{0%{filter:hue-rotate(0deg) saturate(1.5)}100%{filter:hue-rotate(360deg) saturate(2)}}

/* — Shimmer & skeleton — */
@keyframes shimmer{0%{background-position:-400% 0}100%{background-position:400% 0}}
@keyframes skShimmer{100%{transform:translateX(200%)}}
@keyframes chipFloat{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-10px) scale(1.02)}}
@keyframes raysSway{0%,100%{transform:translateX(-6%) rotate(-2deg)}50%{transform:translateX(6%) rotate(2deg)}}

/* — Reveal — */
@keyframes revealUp{from{opacity:0;transform:translateY(50px)}to{opacity:1;transform:translateY(0)}}
@keyframes revealScale{from{opacity:0;transform:scale(.88) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
@keyframes revealLeft{from{opacity:0;transform:translateX(-50px)}to{opacity:1;transform:translateX(0)}}
@keyframes revealRight{from{opacity:0;transform:translateX(50px)}to{opacity:1;transform:translateX(0)}}

/* — Special — */
@keyframes matrixRain{0%{top:-20px;opacity:1}100%{top:100vh;opacity:0}}
@keyframes wormhole{0%{transform:scale(0) rotate(0) translateZ(0);opacity:1}100%{transform:scale(4) rotate(720deg) translateZ(200px);opacity:0}}
@keyframes electricArc{0%,100%{clip-path:polygon(0 50%,100% 50%,100% 51%,0 51%)}25%{clip-path:polygon(0 45%,30% 50%,60% 43%,100% 48%,100% 53%,60% 58%,30% 55%,0 50%)}75%{clip-path:polygon(0 52%,40% 47%,70% 54%,100% 49%,100% 54%,70% 59%,40% 52%,0 57%)}}

/* ========================================================
   UTILITY ANIMATION CLASSES
   ======================================================== */
.animate-float{animation:float3d 4s ease-in-out infinite}
.animate-float-deep{animation:floatDeep 5s ease-in-out infinite}
.animate-pulse-glow{animation:pulseGlow 3s ease-in-out infinite}
.animate-neon-pulse{animation:neonPulse 2s ease-in-out infinite}
.animate-holo-pulse{animation:holoPulse 4s ease-in-out infinite}
.animate-slide-up{animation:slideUp .6s cubic-bezier(.23,1,.32,1) forwards}
.animate-slide-down{animation:slideDown .4s ease-out}
.animate-fade-in{animation:fadeIn .5s ease-out}
.animate-scale-in{animation:scaleIn .4s cubic-bezier(.23,1,.32,1)}
.animate-live{animation:livePulse 2s ease-in-out infinite;width:8px;height:8px;border-radius:50%;background:#22C55E;display:inline-block;margin-right:6px;box-shadow:0 0 0 0 rgba(34,197,94,.5)}
.animate-shimmer{background:linear-gradient(90deg,transparent,rgba(255,255,255,0.1),transparent);background-size:400% 100%;animation:shimmer 3s infinite}
.animate-prism{animation:prismSpin 8s linear infinite}
.animate-orbiting{animation:orbiting 6s linear infinite}
.animate-3d-rotate{animation:rotate3d 20s linear infinite;transform-style:preserve-3d}
.animate-quantum{animation:quantumJitter .15s infinite}

/* Reveal classes */
.reveal{opacity:0;transform:translateY(50px);transition:opacity .8s cubic-bezier(.23,1,.32,1),transform .8s cubic-bezier(.23,1,.32,1)}
.reveal.visible{opacity:1;transform:translateY(0)}
.reveal-left{opacity:0;transform:translateX(-50px);transition:opacity .8s cubic-bezier(.23,1,.32,1),transform .8s cubic-bezier(.23,1,.32,1)}
.reveal-left.visible{opacity:1;transform:translateX(0)}
.reveal-right{opacity:0;transform:translateX(50px);transition:opacity .8s,transform .8s cubic-bezier(.23,1,.32,1)}
.reveal-right.visible{opacity:1;transform:translateX(0)}
.reveal-scale{opacity:0;transform:scale(.9);transition:opacity .7s,transform .7s cubic-bezier(.23,1,.32,1)}
.reveal-scale.visible{opacity:1;transform:scale(1)}
.reveal-delay-1{transition-delay:.1s}
.reveal-delay-2{transition-delay:.2s}
.reveal-delay-3{transition-delay:.3s}
.reveal-delay-4{transition-delay:.4s}
.reveal-delay-5{transition-delay:.5s}
.reveal-delay-6{transition-delay:.6s}

/* ========================================================
   5D / 6D PARALLAX DEPTH LAYERS
   ======================================================== */
.depth-scene{perspective:1200px;perspective-origin:50% 50%;transform-style:preserve-3d}
.depth-l1{transform:var(--depth-1);transition:transform .1s linear}
.depth-l2{transform:var(--depth-2)}
.depth-l3{transform:var(--depth-3)}
.depth-l4{transform:var(--depth-4)}
.depth-l5{transform:var(--depth-5)}
.depth-l6{transform:var(--depth-6)}

/* Parallax wrapper for 5D effect */
.parallax-wrap{overflow:hidden;position:relative}
.parallax-inner{will-change:transform;transform:translateZ(0)}

/* Holographic card — 5D/6D depth illusion */
.holo-card{
  position:relative;border-radius:28px;overflow:hidden;
  transform-style:preserve-3d;perspective:800px;
  background:linear-gradient(135deg,rgba(8,20,42,0.9),rgba(14,30,58,0.85));
  border:1px solid transparent;
  background-clip:padding-box;
  transition:all .5s cubic-bezier(.23,1,.32,1);
}
.holo-card::before{
  content:'';position:absolute;inset:-1px;border-radius:29px;z-index:-1;
  background:linear-gradient(135deg,rgba(0,255,231,0.5),rgba(0,128,255,0.4),rgba(191,0,255,0.4),rgba(255,0,160,0.3));
  background-size:400% 400%;animation:borderFlow 5s ease infinite;
}
.holo-card::after{
  content:'';position:absolute;inset:0;z-index:3;pointer-events:none;border-radius:inherit;
  background:linear-gradient(105deg,rgba(255,255,255,0) 30%,rgba(255,255,255,0.07) 50%,rgba(255,255,255,0) 70%);
  animation:holoShimmer 4s ease infinite;
}
.holo-card:hover{transform:translateY(-10px) rotateX(5deg) scale(1.02);box-shadow:0 40px 100px rgba(0,0,0,0.7),0 0 40px rgba(0,255,231,0.2)}

/* Chromatic aberration effect */
.chromatic{
  position:relative;
}
.chromatic::before{
  content:attr(data-text);position:absolute;inset:0;
  color:rgba(255,0,0,0.25);transform:translateX(-2px) translateY(1px);
  pointer-events:none;z-index:2;
}
.chromatic::after{
  content:attr(data-text);position:absolute;inset:0;
  color:rgba(0,0,255,0.25);transform:translateX(2px) translateY(-1px);
  pointer-events:none;z-index:2;
}

/* ========================================================
   SCROLLBAR — NEON STYLE
   ======================================================== */
::-webkit-scrollbar{width:6px;height:6px}
::-webkit-scrollbar-track{background:rgba(6,13,26,0.8)}
::-webkit-scrollbar-thumb{
  background:linear-gradient(180deg,var(--neon-cyan),#2563EB,var(--neon-violet));
  border-radius:6px;box-shadow:0 0 8px rgba(0,255,231,0.4)
}
::-webkit-scrollbar-thumb:hover{background:linear-gradient(180deg,#fff,var(--neon-cyan));box-shadow:0 0 16px rgba(0,255,231,0.6)}

/* ===== FOCUS RING ===== */
:focus-visible{outline:2px solid var(--neon-cyan);outline-offset:3px;border-radius:6px;box-shadow:0 0 12px rgba(0,255,231,0.3)}

/* ========================================================
   READING PROGRESS — HOLOGRAPHIC
   ======================================================== */
.reading-progress{
  position:fixed;top:0;left:0;height:3px;
  background:linear-gradient(90deg,var(--neon-cyan),#2563EB,var(--neon-violet),#EC4899,var(--neon-cyan));
  background-size:300% 100%;animation:borderFlow 3s linear infinite;
  z-index:100001;transition:width .05s linear;
  box-shadow:0 0 12px rgba(0,255,231,0.6),0 0 24px rgba(0,128,255,0.4)
}

/* ========================================================
   BACK TO TOP — NEON
   ======================================================== */
.back-to-top{
  position:fixed;bottom:88px;right:22px;width:46px;height:46px;border-radius:16px;
  background:rgba(8,20,42,0.8);border:1px solid rgba(0,255,231,0.3);color:var(--neon-cyan);
  cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;
  z-index:9998;opacity:0;transform:translateY(14px) scale(.9);
  transition:all .4s cubic-bezier(.23,1,.32,1);backdrop-filter:blur(16px);
  box-shadow:0 0 20px rgba(0,255,231,0.15)
}
.back-to-top.visible{opacity:1;transform:translateY(0) scale(1)}
.back-to-top:hover{
  transform:translateY(-4px) scale(1.12);
  box-shadow:0 0 30px rgba(0,255,231,0.5),0 12px 30px rgba(0,0,0,0.4);
  border-color:var(--neon-cyan);color:#fff;
}
.back-to-top::after{
  content:'';position:absolute;inset:-3px;border-radius:18px;
  background:linear-gradient(135deg,var(--neon-cyan),#2563EB,var(--neon-violet));
  background-size:300% 300%;animation:borderFlow 3s linear infinite;
  z-index:-1;opacity:0;transition:opacity .3s
}
.back-to-top:hover::after{opacity:1}



/* ========================================================
   FLOATING NAVBAR — HYPER GLASS
   ======================================================== */
.floating-nav{
  position:sticky;top:14px;z-index:1000;margin:14px auto 18px;
  max-width:1280px;width:calc(100% - 28px);
  background:rgba(6,13,26,0.6);
  backdrop-filter:blur(30px) saturate(200%) brightness(1.1);
  -webkit-backdrop-filter:blur(30px) saturate(200%) brightness(1.1);
  border:1px solid rgba(255,255,255,0.1);
  border-radius:22px;
  box-shadow:0 10px 40px rgba(0,0,0,0.5),0 0 0 1px rgba(0,255,231,0.06),inset 0 1px 0 rgba(255,255,255,0.08);
  display:flex;align-items:center;gap:14px;padding:10px 16px;
  transition:all .5s cubic-bezier(.23,1,.32,1);animation:navSlideIn .6s ease-out;
}
.floating-nav:hover{
  border-color:rgba(0,255,231,0.2);
  box-shadow:0 16px 60px rgba(0,0,0,0.6),0 0 40px rgba(0,255,231,0.08),inset 0 1px 0 rgba(255,255,255,0.12);
}
/* Animated top border on navbar */
.floating-nav::before{
  content:'';position:absolute;top:0;left:10%;right:10%;height:1px;border-radius:1px;
  background:linear-gradient(90deg,transparent,rgba(0,255,231,0.6),rgba(0,128,255,0.6),rgba(191,0,255,0.5),transparent);
  background-size:300% 100%;animation:borderFlow 4s linear infinite;opacity:.8;
}
.nav-shadow{box-shadow:0 20px 60px rgba(0,0,0,0.7),0 0 40px rgba(0,255,231,0.1)}
.nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--text);flex-shrink:0;transition:transform .3s}
.nav-brand:hover{transform:scale(1.03)}
.nav-brand .brand-icon{
  width:40px;height:40px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;
  background:linear-gradient(135deg,#2563EB,#38BDF8,#00FFE7);
  box-shadow:0 6px 20px rgba(37,99,235,0.5),0 0 20px rgba(0,255,231,0.2);
  transition:all .3s
}
.nav-brand:hover .brand-icon{box-shadow:0 8px 30px rgba(37,99,235,0.7),0 0 40px rgba(0,255,231,0.35);transform:rotate(-6deg) scale(1.08)}
.nav-brand-text h1{font-size:17px;font-weight:800;letter-spacing:-0.5px;color:var(--text);transition:color .3s}
.nav-brand-text p{font-size:10px;opacity:.6;letter-spacing:.3px;color:var(--muted);display:block}
.nav-nav{display:flex;align-items:center;gap:2px;flex:1;justify-content:center;flex-wrap:nowrap}
.nav-nav a{
  color:rgba(255,255,255,0.55);text-decoration:none;padding:9px 13px;border-radius:12px;
  font-size:13px;font-weight:600;transition:all .25s;display:flex;align-items:center;gap:6px;
  position:relative;white-space:nowrap;
}
.nav-nav a:hover{color:#fff;background:rgba(0,255,231,0.1);transform:translateY(-2px);text-shadow:0 0 12px rgba(0,255,231,0.5)}
.nav-nav a.active{color:#fff;background:rgba(56,189,248,0.14);text-shadow:0 0 8px rgba(56,189,248,0.5)}
.nav-nav a.active::after{content:'';position:absolute;bottom:-2px;left:50%;transform:translateX(-50%);width:20px;height:3px;border-radius:3px;background:linear-gradient(90deg,var(--neon-cyan),#2563EB);box-shadow:0 0 8px rgba(0,255,231,0.6)}
.nav-right{display:flex;align-items:center;gap:8px;flex-shrink:0}
.nav-btn{
  width:40px;height:40px;border-radius:13px;
  border:1px solid rgba(255,255,255,0.1);
  background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.7);
  cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;
  transition:all .25s;position:relative;backdrop-filter:blur(8px)
}
.nav-btn:hover{
  background:rgba(0,255,231,0.12);transform:translateY(-2px) scale(1.06);
  box-shadow:0 4px 16px rgba(0,255,231,0.2),0 0 0 1px rgba(0,255,231,0.2);
  color:var(--neon-cyan);border-color:rgba(0,255,231,0.3)
}
.nav-btn .notif-dot{position:absolute;top:8px;right:9px;width:8px;height:8px;border-radius:50%;background:var(--danger);box-shadow:0 0 0 3px rgba(239,68,68,0.3),0 0 12px rgba(239,68,68,0.5);animation:neonPulse 1.5s infinite}
.nav-btn.badgeable{width:auto;padding:0 12px;gap:6px;font-size:12px;font-weight:700}
.nav-dropdown-wrap{position:relative}
.nav-toggle{color:rgba(255,255,255,0.55);text-decoration:none;padding:9px 13px;border-radius:12px;font-size:13px;font-weight:600;transition:all .2s;display:flex;align-items:center;gap:6px;cursor:pointer;white-space:nowrap}
.nav-toggle:hover,.nav-toggle.active{color:#fff;background:rgba(0,255,231,0.1)}
.nav-dropdown{
  position:absolute;top:calc(100% + 12px);right:0;
  background:rgba(6,13,26,0.95);border-radius:20px;
  border:1px solid rgba(255,255,255,0.1);
  box-shadow:0 30px 80px rgba(0,0,0,0.6),0 0 40px rgba(0,255,231,0.05);
  padding:20px;min-width:360px;display:none;z-index:300;color:#fff;
  animation:slideUp .25s cubic-bezier(.23,1,.32,1);
  backdrop-filter:blur(28px);overflow:hidden
}
.nav-dropdown::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,rgba(0,255,231,0.5),rgba(0,128,255,0.5),transparent);
}
.nav-dropdown.show{display:block}
.nav-dropdown-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:rgba(0,255,231,0.5);margin-bottom:12px}
.nav-dropdown-grid{display:grid;grid-template-columns:1fr 1fr;gap:4px}
.nav-dropdown-item{display:flex;align-items:center;gap:9px;padding:10px 12px;border-radius:12px;text-decoration:none;color:rgba(255,255,255,0.7);font-size:13px;font-weight:500;transition:all .22s}
.nav-dropdown-item:hover{background:rgba(0,255,231,0.1);transform:translateX(4px);color:#fff;box-shadow:inset 1px 0 0 rgba(0,255,231,0.5)}
.nav-dropdown-item i{width:18px;text-align:center;color:var(--neon-cyan);font-size:14px;text-shadow:0 0 8px rgba(0,255,231,0.5)}

/* ===== MOBILE MENU ===== */
.mobile-menu{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(3,8,19,0.7);z-index:2000;backdrop-filter:blur(8px);display:none;opacity:0;transition:opacity .3s}
.mobile-menu.active{display:block;opacity:1}
.mobile-menu-content{position:absolute;top:0;left:0;bottom:0;width:310px;background:rgba(6,13,26,0.98);padding:20px;transform:translateX(-100%);transition:transform .35s cubic-bezier(.23,1,.32,1);overflow-y:auto;color:#fff;box-shadow:4px 0 40px rgba(0,0,0,0.6);border-right:1px solid rgba(0,255,231,0.1)}
.mobile-menu.active .mobile-menu-content{transform:translateX(0)}
.mobile-menu-item{display:flex;align-items:center;gap:12px;padding:13px 14px;border-radius:12px;text-decoration:none;color:rgba(255,255,255,0.7);font-weight:500;font-size:14px;transition:all .22s}
.mobile-menu-item:hover,.mobile-menu-item.active{background:rgba(0,255,231,0.08);color:#fff;box-shadow:inset 2px 0 0 var(--neon-cyan)}
.mobile-menu-item i{width:22px;text-align:center;color:var(--neon-cyan)}
.mobile-menu-close{position:absolute;top:14px;right:14px;width:34px;height:34px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);font-size:18px;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center}
.mobile-menu-close:hover{background:rgba(239,68,68,0.2);color:#EF4444;transform:rotate(90deg);border-color:rgba(239,68,68,0.3)}

/* ===== SEARCH ===== */
.search-box{width:100%;padding:14px 18px 14px 46px;border-radius:16px;border:1px solid rgba(255,255,255,0.1);background:rgba(6,13,26,0.6);color:#fff;font-size:14px;outline:none;transition:all .3s;backdrop-filter:blur(16px)}
.search-box:focus{border-color:rgba(0,255,231,0.5);box-shadow:0 0 0 3px rgba(0,255,231,0.1),0 0 20px rgba(0,255,231,0.15)}
.search-box::placeholder{color:rgba(255,255,255,0.3)}
.search-dropdown{position:absolute;top:calc(100% + 8px);left:0;right:0;background:rgba(6,13,26,0.98);border-radius:18px;border:1px solid rgba(255,255,255,0.1);box-shadow:0 30px 80px rgba(0,0,0,0.6);max-height:460px;overflow-y:auto;z-index:1500;color:#fff;animation:slideUp .22s ease-out;backdrop-filter:blur(28px)}
.sr-item{display:flex;align-items:center;gap:14px;padding:12px 16px;cursor:pointer;transition:all .15s}
.sr-item:hover,.sr-item.highlight{background:rgba(0,255,231,0.08)}
.sr-icon{width:40px;height:40px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;background:linear-gradient(135deg,rgba(0,255,231,0.15),rgba(0,128,255,0.15));color:var(--neon-cyan)}
.sr-name{font-weight:600;font-size:14px;color:#fff}
.sr-sub{font-size:12px;color:rgba(255,255,255,0.4);margin-top:1px}

/* ========================================================
   CARD SYSTEM — ULTRA 3D
   ======================================================== */
.w-card{
  background:rgba(255,255,255,0.9);
  border-radius:var(--radius);border:1px solid rgba(255,255,255,0.5);
  box-shadow:0 8px 30px rgba(0,0,0,0.08);transition:all .5s cubic-bezier(.23,1,.32,1);color:var(--text);
  position:relative;overflow:hidden;
}
.w-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,rgba(56,189,248,0.5),rgba(37,99,235,0.5),transparent);
  opacity:0;transition:opacity .3s
}
.w-card:hover{box-shadow:0 24px 60px rgba(8,26,47,0.2);transform:translateY(-6px) scale(1.01)}
.w-card:hover::before{opacity:1}
.dark .w-card{background:rgba(8,18,36,0.8);border-color:rgba(255,255,255,0.07)}
.p-6{padding:24px}
.stat-card{background:rgba(255,255,255,0.9);border-radius:18px;border:1px solid rgba(255,255,255,0.5);padding:16px;text-align:center;transition:all .4s cubic-bezier(.23,1,.32,1);color:var(--text);position:relative;overflow:hidden}
.stat-card:hover{transform:translateY(-6px) scale(1.03);box-shadow:0 20px 50px rgba(8,26,47,0.18)}
.dark .stat-card{background:rgba(8,18,36,0.8);border-color:rgba(255,255,255,0.07)}
.stat-icon{font-size:28px;margin-bottom:6px}.stat-value{font-size:26px;font-weight:800;line-height:1.2}
.stat-label{font-size:12px;color:var(--muted);margin-top:2px}

/* ========================================================
   FILTER / LAYER CONTROLS
   ======================================================== */
.filter-select{padding:10px 14px;border-radius:13px;border:1px solid rgba(255,255,255,0.12);background:rgba(6,13,26,0.6);color:#fff;font-size:13px;outline:none;transition:all .22s;min-width:140px;cursor:pointer;backdrop-filter:blur(12px)}
.filter-select:focus{border-color:rgba(0,255,231,0.5);box-shadow:0 0 0 3px rgba(0,255,231,0.1)}
.layer-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:12px;border:1px solid rgba(255,255,255,0.1);background:rgba(6,13,26,0.6);cursor:pointer;font-size:13px;font-weight:500;color:rgba(255,255,255,0.7);transition:all .22s;backdrop-filter:blur(8px)}
.layer-btn:hover{background:rgba(0,255,231,0.1);border-color:rgba(0,255,231,0.4);color:#fff}
.layer-btn.active{background:rgba(0,255,231,0.12);border-color:rgba(0,255,231,0.5);color:var(--neon-cyan);box-shadow:0 0 12px rgba(0,255,231,0.2)}

/* ========================================================
   BADGES
   ======================================================== */
.badge{display:inline-flex;align-items:center;gap:6px;padding:4px 14px;border-radius:20px;font-size:11px;font-weight:600}
.badge-live{background:rgba(34,197,94,0.14);color:#22C55E;border:1px solid rgba(34,197,94,0.3)}
.badge-blue{background:rgba(37,99,235,0.14);color:#60A5FA;border:1px solid rgba(37,99,235,0.3)}
.badge-danger{background:rgba(239,68,68,0.14);color:#F87171;border:1px solid rgba(239,68,68,0.3)}
.badge-warning{background:rgba(245,158,11,0.14);color:#FCD34D;border:1px solid rgba(245,158,11,0.3)}
.badge-purple{background:rgba(124,58,237,0.14);color:#A78BFA;border:1px solid rgba(124,58,237,0.3)}
.badge-neon{background:rgba(0,255,231,0.1);color:var(--neon-cyan);border:1px solid rgba(0,255,231,0.4);box-shadow:0 0 8px rgba(0,255,231,0.15)}

/* ========================================================
   TOAST SYSTEM
   ======================================================== */
.toast-card{background:rgba(6,13,26,0.92);border-radius:18px;padding:14px 18px;box-shadow:0 20px 60px rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.1);border-left:3px solid var(--neon-cyan);color:#fff;display:flex;align-items:flex-start;gap:12px;animation:slideUp .35s cubic-bezier(.23,1,.32,1);backdrop-filter:blur(20px)}

/* ========================================================
   BUTTONS — PREMIUM
   ======================================================== */
.btn-grad{
  background:linear-gradient(135deg,#2563EB,#38BDF8,#00FFE7);
  background-size:200% 100%;color:#fff;border:none;padding:12px 24px;border-radius:14px;
  font-weight:700;font-size:14px;cursor:pointer;
  transition:all .3s cubic-bezier(.23,1,.32,1);
  box-shadow:0 8px 24px rgba(37,99,235,0.4),0 0 0 1px rgba(56,189,248,0.3);
  position:relative;overflow:hidden
}
.btn-grad::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,0.2),transparent);
  opacity:0;transition:opacity .25s
}
.btn-grad:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(37,99,235,0.55),0 0 30px rgba(0,255,231,0.2);background-position:100%}
.btn-grad:hover::before{opacity:1}
.btn-ghost{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.8);border:1px solid rgba(255,255,255,0.14);padding:12px 22px;border-radius:14px;font-weight:600;font-size:14px;cursor:pointer;transition:all .25s;backdrop-filter:blur(8px)}
.btn-ghost:hover{background:rgba(0,255,231,0.1);border-color:rgba(0,255,231,0.4);color:#fff;box-shadow:0 0 20px rgba(0,255,231,0.15)}
.btn-neon{
  background:transparent;color:var(--neon-cyan);border:1px solid rgba(0,255,231,0.5);
  padding:12px 24px;border-radius:14px;font-weight:700;font-size:14px;cursor:pointer;
  transition:all .3s;text-shadow:0 0 10px rgba(0,255,231,0.5);
  box-shadow:0 0 15px rgba(0,255,231,0.1),inset 0 0 15px rgba(0,255,231,0.05);
  position:relative;overflow:hidden
}
.btn-neon:hover{
  background:rgba(0,255,231,0.1);
  box-shadow:0 0 30px rgba(0,255,231,0.4),0 0 60px rgba(0,255,231,0.15),inset 0 0 30px rgba(0,255,231,0.08);
  transform:translateY(-2px)
}

/* ===== RESIZE HANDLE ===== */
.resize-handle{position:absolute;bottom:0;right:0;width:18px;height:18px;cursor:se-resize;z-index:5}
.resize-handle::after{content:'';position:absolute;right:4px;bottom:4px;width:8px;height:8px;border-right:2px solid var(--neon-cyan);border-bottom:2px solid var(--neon-cyan);opacity:.6;border-radius:0 0 3px 0}

/* ========================================================
   PREMIUM GLOBAL FX
   ======================================================== */
body::before{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:0;
  background:
    radial-gradient(1400px 700px at 90% -5%,rgba(0,255,231,0.05),transparent 55%),
    radial-gradient(1000px 600px at 0% 100%,rgba(124,58,237,0.07),transparent 55%);
  opacity:.8
}
.neon{box-shadow:0 0 24px rgba(0,255,231,0.25),0 0 60px rgba(0,255,231,0.08)}
.glow-cyan{box-shadow:0 0 30px rgba(0,255,231,0.4),0 0 60px rgba(0,255,231,0.1)}
.glow-blue{box-shadow:0 0 30px rgba(37,99,235,0.5),0 0 60px rgba(37,99,235,0.1)}
.glow-violet{box-shadow:0 0 30px rgba(124,58,237,0.5),0 0 60px rgba(124,58,237,0.1)}
.glow-gold{box-shadow:0 0 30px rgba(255,215,0,0.4)}

/* Float chips */
.float-chip{
  position:absolute;z-index:6;display:flex;align-items:center;gap:8px;
  background:rgba(6,13,26,0.7);backdrop-filter:blur(20px) saturate(180%);
  -webkit-backdrop-filter:blur(20px) saturate(180%);
  border:1px solid rgba(0,255,231,0.3);border-radius:18px;padding:10px 16px;
  font-size:12px;font-weight:700;color:#fff;
  box-shadow:0 14px 40px rgba(0,0,0,0.4),0 0 20px rgba(0,255,231,0.1);
  animation:chipFloat 5s ease-in-out infinite;white-space:nowrap;transition:all .3s
}
.float-chip:hover{transform:translateY(-5px) scale(1.06);box-shadow:0 20px 50px rgba(0,0,0,0.5),0 0 30px rgba(0,255,231,0.25)}

/* Particle effects */
.fx-particles{position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:1}
.fx-particles span{
  position:absolute;bottom:-10px;border-radius:50%;
  background:radial-gradient(circle,rgba(0,255,231,0.9),rgba(0,128,255,0.5),transparent 70%);
  animation:riseUp linear infinite;box-shadow:0 0 6px rgba(0,255,231,0.4)
}

/* Light rays */
.light-rays{position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:0;opacity:.4}
.light-rays::before{
  content:'';position:absolute;top:-20%;left:50%;width:60vw;height:200%;
  background:conic-gradient(from 180deg at 50% 0%,transparent 0deg,rgba(0,255,231,0.04) 8deg,transparent 18deg,rgba(0,128,255,0.03) 32deg,transparent 48deg,rgba(191,0,255,0.04) 65deg,transparent 82deg,rgba(255,255,255,0.025) 95deg,transparent 112deg);
  animation:raysSway 16s ease-in-out infinite;transform-origin:50% 0
}

/* Skeleton */
.skeleton{position:relative;overflow:hidden;background:rgba(255,255,255,0.05)}
.skeleton::after{content:'';position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(0,255,231,0.07),transparent);transform:translateX(-100%);animation:skShimmer 2s infinite}
.num-up{font-variant-numeric:tabular-nums}

/* Matrix rain effect element */
.matrix-char{position:absolute;font-family:monospace;font-size:12px;color:rgba(34,197,94,0.6);animation:matrixRain linear infinite;pointer-events:none;text-shadow:0 0 8px rgba(34,197,94,0.4)}

/* Orb decorations */
.deco-orb{
  position:absolute;border-radius:50%;pointer-events:none;
  background:radial-gradient(circle,var(--orb-color,rgba(56,189,248,0.4)),transparent 70%);
  filter:blur(var(--orb-blur,40px));opacity:var(--orb-opacity,.25);
  animation:auroraDrift var(--orb-duration,20s) ease-in-out infinite var(--orb-delay,0s)
}

/* Neon dividers */
.neon-divider{
  height:1px;border:none;
  background:linear-gradient(90deg,transparent,rgba(0,255,231,0.5),rgba(0,128,255,0.5),rgba(191,0,255,0.4),transparent);
  box-shadow:0 0 8px rgba(0,255,231,0.3);margin:24px 0
}

/* ========================================================
   COMMAND PALETTE — ULTRA DARK
   ======================================================== */
.cmd-overlay{position:fixed;inset:0;background:rgba(3,8,19,0.6);z-index:100000;display:none;align-items:flex-start;justify-content:center;padding-top:min(18vh,140px);backdrop-filter:blur(6px);opacity:0;transition:opacity .25s}
.cmd-overlay.open{display:flex;opacity:1}
.cmd-box{width:min(720px,calc(100% - 32px));background:rgba(6,13,26,0.97);border-radius:22px;border:1px solid rgba(255,255,255,0.1);box-shadow:0 40px 100px rgba(0,0,0,0.7),0 0 40px rgba(0,255,231,0.05);overflow:hidden;transform:translateY(-10px) scale(.97);transition:transform .3s cubic-bezier(.23,1,.32,1);color:#fff;backdrop-filter:blur(30px)}
.cmd-box::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(0,255,231,0.5),transparent)}
.cmd-overlay.open .cmd-box{transform:translateY(0) scale(1)}
.cmd-input-wrap{display:flex;align-items:center;gap:12px;padding:18px 20px;border-bottom:1px solid rgba(255,255,255,0.06)}
.cmd-input-wrap i{color:rgba(0,255,231,0.6);font-size:16px}
.cmd-input{flex:1;background:transparent;border:none;outline:none;color:#fff;font-size:15px;font-weight:500}
.cmd-input::placeholder{color:rgba(255,255,255,0.25)}
.cmd-kbd{margin-left:auto;font-size:11px;font-weight:700;color:rgba(255,255,255,0.3);background:rgba(255,255,255,0.06);padding:3px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.1)}
.cmd-list{max-height:50vh;overflow-y:auto;padding:8px}
.cmd-item{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:13px;cursor:pointer;transition:all .15s;text-decoration:none;color:rgba(255,255,255,0.7)}
.cmd-item:hover,.cmd-item.hl{background:rgba(0,255,231,0.08);color:#fff}
.cmd-item i{width:18px;text-align:center;color:var(--neon-cyan);text-shadow:0 0 8px rgba(0,255,231,0.4)}
.cmd-item .cmd-label{font-size:13px;font-weight:600;flex:1}
.cmd-item .cmd-shortcut{font-size:11px;color:rgba(255,255,255,0.25);font-weight:700;background:rgba(255,255,255,0.06);padding:2px 7px;border-radius:5px}

/* ========================================================
   BOTTOM NAV (MOBILE)
   ======================================================== */
.bottom-nav{position:fixed;bottom:0;left:0;right:0;height:64px;background:rgba(6,13,26,0.92);border-top:1px solid rgba(255,255,255,0.08);display:none;z-index:150;padding-bottom:env(safe-area-inset-bottom);backdrop-filter:blur(28px)}
.bottom-nav::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(0,255,231,0.4),rgba(0,128,255,0.3),transparent)}
.bottom-nav a{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;text-decoration:none;color:rgba(255,255,255,0.4);font-size:10px;font-weight:600;position:relative;transition:all .25s}
.bottom-nav a:hover{color:var(--neon-cyan);background:rgba(0,255,231,0.06)}
.bottom-nav a.active{color:var(--neon-cyan);text-shadow:0 0 10px rgba(0,255,231,0.5)}
.bottom-nav a.active::before{content:'';position:absolute;top:-1px;left:20%;right:20%;height:2px;border-radius:0 0 2px 2px;background:linear-gradient(90deg,var(--neon-cyan),#2563EB);box-shadow:0 0 8px rgba(0,255,231,0.6)}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
  .floating-nav{padding:8px 12px;margin:10px auto 12px}
  .nav-brand-text p{display:none}
  .nav-nav{display:none}
  .nav-toggle{display:none}
  .search-wrap{display:none}
  .p-6{padding:16px}
}
@media(max-width:640px){
  .floating-nav{gap:8px;padding:8px 10px}
  .nav-btn{width:36px;height:36px;font-size:14px}
  .nav-brand .brand-icon{width:34px;height:34px;font-size:17px}
  .nav-brand-text h1{font-size:14px}
  .stat-value{font-size:20px}
  .page-wrap{padding:0 14px 40px}
}
</style>
</head>
<body>
<a href="#main-content" class="skip-link">Lewati ke konten utama</a>

<!-- Custom Cursor -->
<div class="cursor-dot" id="cursorDot" aria-hidden="true"></div>
<div class="cursor-ring" id="cursorRing" aria-hidden="true"></div>

<!-- Aurora Background — Multi-Layer Quantum Field -->
<div class="aurora-bg" aria-hidden="true">
<div class="aurora-blob aurora-1"></div>
<div class="aurora-blob aurora-2"></div>
<div class="aurora-blob aurora-3"></div>
<div class="aurora-blob aurora-4"></div>
<div class="aurora-grid"></div>
<div class="aurora-scan"></div>
<div class="aurora-holo"></div>
<canvas id="aurora-canvas" style="position:absolute;inset:0;width:100%;height:100%;opacity:.55;pointer-events:none;"></canvas>
<!-- 3D WebGL atmosphere canvas -->
<canvas id="three-canvas" style="position:absolute;inset:0;width:100%;height:100%;opacity:.35;pointer-events:none;"></canvas>
</div>

<!-- Plasma Cursor Trails Container -->
<div id="cursor-trails" aria-hidden="true"></div>

<!-- Reading Progress -->
<div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

<!-- Back to Top -->
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas" title="Kembali ke atas">
<i class="fas fa-arrow-up"></i>
</button>

<div style="position:relative;z-index:1">
@php
$currentPath = request()->path();
$isAuth = in_array($currentPath, ['login','register']);
$navItems = [
    ['href'=>route('dashboard'), 'icon'=>'fa-home', 'label'=>'Dashboard', 'active'=>$currentPath==='dashboard'],
    ['href'=>route('forecast'), 'icon'=>'fa-calendar-alt', 'label'=>'Prakiraan', 'active'=>$currentPath==='prakiraan'],
    ['href'=>route('analytics'), 'icon'=>'fa-chart-line', 'label'=>'Analisis', 'active'=>$currentPath==='analitik'],
    ['href'=>route('compare'), 'icon'=>'fa-scale-balanced', 'label'=>'Bandingkan', 'active'=>$currentPath==='bandingkan'],
];
$proItems = [
    ['href'=>'javascript:void(0)', 'icon'=>'fa-wand-magic-sparkles', 'label'=>'AI Assistant (Chat)', 'is_ai'=>true],
    ['href'=>route('map'), 'icon'=>'fa-map', 'label'=>'Peta Interaktif'],
    ['href'=>route('alerts'), 'icon'=>'fa-triangle-exclamation', 'label'=>'Peringatan Dini'],
    ['href'=>route('airquality'), 'icon'=>'fa-smog', 'label'=>'Kualitas Udara'],
    ['href'=>route('maritime'), 'icon'=>'fa-ship', 'label'=>'Maritim & Kelautan'],
    ['href'=>route('aviation'), 'icon'=>'fa-plane-departure', 'label'=>'Penerbangan'],
    ['href'=>route('earthquake'), 'icon'=>'fa-house-crack', 'label'=>'Gempa BMKG'],
    ['href'=>route('hiking'), 'icon'=>'fa-mountain', 'label'=>'Pendakian Gunung'],
    ['href'=>route('driving'), 'icon'=>'fa-car', 'label'=>'Berkendara Aman'],
    ['href'=>route('outdoor'), 'icon'=>'fa-person-hiking', 'label'=>'Outdoor Index'],
    ['href'=>route('pollen'), 'icon'=>'fa-seedling', 'label'=>'Serbuk Sari'],
    ['href'=>route('history'), 'icon'=>'fa-clock-rotate-left', 'label'=>'Histori Cuaca'],
    ['href'=>route('notifications'), 'icon'=>'fa-bell', 'label'=>'Pusat Notifikasi'],
    ['href'=>route('widget'), 'icon'=>'fa-window-maximize', 'label'=>'Widget Web Studio'],
    ['href'=>route('services'), 'icon'=>'fa-handshake-angle', 'label'=>'Layanan PTSP Stamet'],
    ['href'=>route('developer'), 'icon'=>'fa-code', 'label'=>'Developer API'],
];
$activeLabel = '';
foreach($navItems as $ni){ if($ni['active']){ $activeLabel = $ni['label']; } }
@endphp

@if(!$isAuth)
<!-- ===== FLOATING GLASS NAVBAR ===== -->
<header class="floating-nav" id="floatingNav">
<a href="{{ route('dashboard') }}" class="nav-brand">
<div class="brand-icon"><i class="fas fa-cloud-sun"></i></div>
<div class="nav-brand-text"><h1>WeatherLive<span class="gradient-text">-Grid</span></h1><p>Cuaca Jawa Barat · Kelas Dunia</p></div>
</a>
<nav class="nav-nav">
@foreach($navItems as $item)
<a href="{{ $item['href'] }}" class="{{ $item['active'] ? 'active' : '' }}"><i class="fas {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
@endforeach
<div class="nav-dropdown-wrap">
<a href="#" class="nav-toggle" data-nav-dropdown><i class="fas fa-th-large"></i> Fitur <i class="fas fa-chevron-down" style="font-size:9px;"></i></a>
<div class="nav-dropdown">
<div class="nav-dropdown-title">Fitur Lengkap</div>
<div class="nav-dropdown-grid">
@foreach($proItems as $item)
<a href="{{ $item['href'] }}" class="nav-dropdown-item" @if(!empty($item['is_ai'])) onclick="window.openWeatherAi(event)" @endif><i class="fas {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
@endforeach
</div>
</div>
</div>
</nav>
<div class="nav-right">
<span class="pill live"><span class="animate-live"></span>LIVE</span>
<div id="lang-app" class="nav-dropdown-wrap" style="position:relative;">
<button class="nav-btn" data-lang-toggle aria-label="Language" style="font-size:15px;width:auto;padding:0 12px;"><span data-lang-flag>🇮🇩</span></button>
<div class="nav-dropdown" data-lang-dropdown style="min-width:200px;right:0;left:auto;">
<div class="nav-dropdown-title">Pilih Bahasa / Choose Language</div>
<div class="nav-dropdown-grid" style="grid-template-columns:1fr 1fr;">
<div v-for="lang in wlLanguages" :key="lang.code" class="nav-dropdown-item" style="cursor:pointer;" @click="wlSetLang(lang.code)">
<span v-text="lang.flag"></span> <span v-text="lang.name"></span>
</div>
</div>
</div>
</div>
<button class="nav-btn" data-toggle-dark aria-label="Toggle Dark Mode"><i class="fas fa-moon"></i></button>

<!-- In-Profile Quick Login & User Account Studio Trigger Button -->
<button class="nav-btn nav-profile-btn" onclick="window.openProfileAuth()" aria-label="Profil & Masuk Akun" title="Masuk Akun / Profil" style="position:relative;width:auto;padding:0 12px;display:flex;align-items:center;gap:8px;font-size:14px;">
  <span class="profile-avatar-icon" id="wlProfileAvatar"><i class="fas fa-user-circle"></i></span>
  <span style="font-size:12px;font-weight:700;">Akun</span>
  <span id="wlProfileDot" style="display:none;position:absolute;top:6px;right:6px;width:8px;height:8px;border-radius:50%;background:#22c55e;border:1.5px solid #0a1628;box-shadow:0 0 6px #22c55e;"></span>
</button>

<button class="nav-btn nav-toggle-mobile" data-open-menu aria-label="Menu"><i class="fas fa-bars"></i></button>
</div>
</header>

<!-- ===== GLOBAL MOBILE MENU ===== -->
<div class="mobile-menu" id="global-mobile-menu">
<div class="mobile-menu-content">
<button class="mobile-menu-close" data-close-menu>&times;</button>
<div style="display:flex;align-items:center;gap:10px;padding:6px 16px 20px;border-bottom:1px solid var(--border);margin-bottom:12px;">
<div style="width:40px;height:40px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;background:linear-gradient(135deg,#2563EB,#38BDF8);color:#fff;"><i class="fas fa-cloud-sun"></i></div>
<div><div style="font-weight:800;font-size:15px;">WeatherLive-Grid</div><div style="font-size:11px;color:var(--muted);">@if($activeLabel) {{ $activeLabel }} @else Menu @endif</div></div>
</div>
@foreach($navItems as $item)
<a href="{{ $item['href'] }}" class="mobile-menu-item {{ $item['active'] ? 'active' : '' }}"><i class="fas {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
@endforeach
<div style="padding:10px 16px 4px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--muted);">Fitur Lengkap</div>
@foreach($proItems as $item)
<a href="{{ $item['href'] }}" class="mobile-menu-item" @if(!empty($item['is_ai'])) onclick="window.openWeatherAi(event); document.getElementById('global-mobile-menu')?.classList.remove('open');" @endif><i class="fas {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
@endforeach
<hr style="border-color:var(--border);margin:12px 0;">
<a href="javascript:void(0)" onclick="window.openProfileAuth(); document.getElementById('global-mobile-menu')?.classList.remove('open');" class="mobile-menu-item"><i class="fas fa-user-circle"></i> Masuk / Profil Akun</a>
<a href="{{ route('dashboard') }}" class="mobile-menu-item"><i class="fas fa-home"></i> Dashboard Utama</a>
</div>
</div>
@endif

<main id="main-content">
@yield('content')
</main>

@if(!$isAuth)
<!-- ===== MEGA FOOTER ===== -->
<footer class="glass" style="margin:48px 14px 96px;border-radius:28px;overflow:hidden;position:relative;">
<div class="fx-particles footer-particles" aria-hidden="true" style="z-index:1;"></div>
<div style="position:absolute;top:-120px;right:-80px;width:420px;height:420px;border-radius:50%;pointer-events:none;z-index:0;" aria-hidden="true">
<div style="position:absolute;inset:0;border-radius:50%;background:radial-gradient(circle,rgba(56,189,248,0.18),transparent 65%);animation:pulseGlow 6s ease-in-out infinite;"></div>
<div style="position:absolute;inset:30px;border-radius:50%;border:1px dashed rgba(56,189,248,0.25);animation:spinSlow 30s linear infinite;"></div>
<div style="position:absolute;inset:70px;border-radius:50%;border:1px dashed rgba(124,58,237,0.2);animation:spinSlow 22s linear infinite reverse;"></div>
<div style="position:absolute;inset:110px;border-radius:50%;background:radial-gradient(circle,#38BDF8,transparent 70%);opacity:.5;filter:blur(6px);"></div>
</div>
<div style="background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(56,189,248,0.08),rgba(124,58,237,0.1));padding:44px 36px 36px;position:relative;z-index:2;">
<div style="max-width:1240px;margin:0 auto;">
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:30px;margin-bottom:36px;">
<div style="grid-column:span 2;min-width:260px;">
<div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
<div style="width:42px;height:42px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;background:linear-gradient(135deg,#2563EB,#38BDF8);box-shadow:0 8px 24px rgba(37,99,235,0.4);"><i class="fas fa-cloud-sun"></i></div>
<div><div style="font-weight:800;font-size:18px;color:var(--text);font-family:'Space Grotesk'">WeatherLive<span class="gradient-text-anim">-Grid</span></div><div style="font-size:11px;color:var(--muted);">Intelligent Weather Visualization Platform</div></div>
</div>
<p style="font-size:13px;color:var(--muted);line-height:1.7;max-width:340px;">Prakiraan cuaca real-time, peta interaktif, peringatan dini bencana, kualitas udara, dan analitik cuaca akurat untuk 27 kabupaten/kota di Jawa Barat. Data dari Open-Meteo.</p>
<div style="display:flex;gap:10px;margin-top:16px;">
<a href="#" class="nav-btn" style="text-decoration:none;" aria-label="X"><i class="fab fa-x-twitter"></i></a>
<a href="#" class="nav-btn" style="text-decoration:none;" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
<a href="#" class="nav-btn" style="text-decoration:none;" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
<a href="#" class="nav-btn" style="text-decoration:none;" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
</div>
</div>
<div>
<div class="nav-dropdown-title">Weather Products</div>
<div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
<a href="/dashboard" style="color:var(--muted);text-decoration:none;transition:all .2s;">Dashboard</a>
<a href="/prakiraan" style="color:var(--muted);text-decoration:none;transition:all .2s;">Prakiraan Cuaca</a>
<a href="/peringatan" style="color:var(--muted);text-decoration:none;transition:all .2s;">Peringatan Dini</a>
<a href="/analitik" style="color:var(--muted);text-decoration:none;transition:all .2s;">Analitik</a>
</div>
</div>
<div>
<div class="nav-dropdown-title">Climate & Radar</div>
<div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
<a href="/peta" style="color:var(--muted);text-decoration:none;transition:all .2s;">Radar Interaktif</a>
<a href="/histori" style="color:var(--muted);text-decoration:none;transition:all .2s;">Arsip & Histori</a>
</div>
</div>
<div>
<div class="nav-dropdown-title">Developer & Data</div>
<div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
<a href="/developer" style="color:var(--muted);text-decoration:none;transition:all .2s;">Developer API</a>
<a href="/widget" style="color:var(--muted);text-decoration:none;transition:all .2s;">Widget</a>
<a href="/bandingkan" style="color:var(--muted);text-decoration:none;transition:all .2s;">Bandingkan</a>
<a href="/notifikasi" style="color:var(--muted);text-decoration:none;transition:all .2s;">Notifikasi</a>
</div>
</div>
<div>
<div class="nav-dropdown-title">Company & Legal</div>
<div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
<a href="#" style="color:var(--muted);text-decoration:none;transition:all .2s;">Blog</a>
<a href="#" style="color:var(--muted);text-decoration:none;transition:all .2s;">Education</a>
<a href="#" style="color:var(--muted);text-decoration:none;transition:all .2s;">FAQ</a>
<a href="#" style="color:var(--muted);text-decoration:none;transition:all .2s;">Privacy</a>
<a href="#" style="color:var(--muted);text-decoration:none;transition:all .2s;">Terms</a>
</div>
</div>
</div>
<div style="border-top:1px solid var(--border);padding-top:22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
<div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--muted);">
<span class="pill live"><span class="animate-live"></span>Real-time Server Status</span>
<span style="opacity:.8;">© {{ date('Y') }} WeatherLive-Grid. All rights reserved.</span>
</div>
<div style="display:flex;gap:14px;font-size:11px;color:var(--muted);">
<a href="#" style="color:var(--muted);text-decoration:none;"><i class="fas fa-cookie-bite"></i> Cookie</a>
<a href="#" style="color:var(--muted);text-decoration:none;"><i class="fas fa-heartbeat"></i> Status System</a>
</div>
</div>
</div>
</div>
</footer>
<script>
(function(){
  var fp=document.querySelector('.footer-particles');
  if(fp){var colors=['#38BDF8','#2563EB','#7C3AED','#22C55E'];for(var i=0;i<26;i++){
    var s=document.createElement('span');var size=3+Math.random()*6;var dur=8+Math.random()*12;
    s.style.cssText='left:'+(Math.random()*100)+'%;width:'+size+'px;height:'+size+'px;animation-duration:'+dur+'s;animation-delay:'+(-Math.random()*dur)+'s;background:'+(colors[i%colors.length]);
    fp.appendChild(s);
  }}
})();
</script>

<!-- ===== BOTTOM NAV (MOBILE) ===== -->
<nav class="bottom-nav" aria-label="Navigasi bawah" style="position:fixed;bottom:0;left:0;right:0;height:64px;background:var(--card);border-top:1px solid var(--border);display:none;z-index:150;box-shadow:0 -4px 20px rgba(0,0,0,0.1);padding-bottom:env(safe-area-inset-bottom);">
@foreach($navItems as $item)
<a href="{{ $item['href'] }}" class="{{ $item['active'] ? 'active' : '' }}" style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;text-decoration:none;color:var(--muted);font-size:10px;font-weight:600;position:relative;"><i class="fas {{ $item['icon'] }}" style="font-size:18px;color:{{ $item['active'] ? 'var(--accent)':'inherit' }}"></i><span>{{ $item['label'] }}</span></a>
@endforeach
</nav>
<style>@media(max-width:900px){.bottom-nav{display:flex!important}}@media(min-width:901px){.bottom-nav{display:none!important}}</style>
@endif

<!-- ===== TOAST ===== -->
<div id="toast-container" class="fixed top-20 right-4 z-[99999] flex flex-col gap-2" style="max-width:380px;width:calc(100% - 32px);"></div>

<!-- Command Palette -->
<div class="cmd-overlay" id="cmdOverlay">
<div class="cmd-box">
<div class="cmd-input-wrap">
<i class="fas fa-search"></i>
<input class="cmd-input" id="cmdInput" type="text" placeholder="Cari halaman, fitur, atau aksi..." autocomplete="off">
<span class="cmd-kbd">ESC</span>
</div>
<div class="cmd-list" id="cmdList"></div>
</div>
</div>

</div>

<script>
// ===== CUSTOM CURSOR (Ultra-smooth throttled) =====
(function(){
  var dot=document.getElementById('cursorDot'),ring=document.getElementById('cursorRing');
  if(!dot||!ring)return;
  var mx=-100,my=-100,rx=-100,ry=-100,ticking=false;
  document.addEventListener('mousemove',function(e){
    mx=e.clientX;my=e.clientY;
    if(!ticking){
      requestAnimationFrame(function(){
        dot.style.transform='translate3d('+mx+'px,'+my+'px,0) translate(-50%,-50%)';
        ticking=false;
      });
      ticking=true;
    }
  },{passive:true});
  function animRing(){
    rx+=(mx-rx)*.18;ry+=(my-ry)*.18;
    ring.style.transform='translate3d('+rx+'px,'+ry+'px,0) translate(-50%,-50%)';
    requestAnimationFrame(animRing);
  }
  animRing();
  document.querySelectorAll('a,button,.glass-card,.w-card,.stat-card,.sr-item,.nav-dropdown-item,.mobile-menu-item,.layer-btn,.btn-grad,.btn-ghost').forEach(function(el){
    el.addEventListener('mouseenter',function(){ring.classList.add('hover')},{passive:true});
    el.addEventListener('mouseleave',function(){ring.classList.remove('hover')},{passive:true});
  });
  document.addEventListener('mousedown',function(){ring.classList.add('click')},{passive:true});
  document.addEventListener('mouseup',function(){ring.classList.remove('click')},{passive:true});
})();

// ===== AURORA CANVAS (Lightweight, GPU-friendly) =====
(function(){
  var canvas=document.getElementById('aurora-canvas');
  if(!canvas)return;
  var ctx=canvas.getContext('2d');
  var w,ht,particles=[];
  function resize(){w=canvas.width=window.innerWidth;ht=canvas.height=window.innerHeight;}
  resize();window.addEventListener('resize',resize,{passive:true});
  var mx=w/2,my=ht/2;
  document.addEventListener('mousemove',function(e){mx=e.clientX;my=e.clientY;},{passive:true});
  var count = window.innerWidth < 768 ? 12 : 22;
  for(var i=0;i<count;i++){particles.push({x:Math.random()*w,y:Math.random()*ht,r:1.5+Math.random()*2.5,vx:(Math.random()-.5)*.3,vy:(Math.random()-.5)*.3,a:.15+Math.random()*.25});}
  var lastDraw = 0;
  function draw(now){
    requestAnimationFrame(draw);
    if(document.hidden) return;
    if(now - lastDraw < 28) return; // Cap at ~35 FPS to save 60% CPU cycles
    lastDraw = now;
    ctx.clearRect(0,0,w,ht);
    var len = particles.length;
    for(var i=0;i<len;i++){
      var p=particles[i];
      var dx=mx-p.x,dy=my-p.y,dist=Math.sqrt(dx*dx+dy*dy);
      if(dist<180){p.vx+=dx*.00003;p.vy+=dy*.00003;}
      p.x+=p.vx;p.y+=p.vy;
      if(p.x<-20)p.x=w+20;if(p.x>w+20)p.x=-20;if(p.y<-20)p.y=ht+20;if(p.y>ht+20)p.y=-20;
      ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
      ctx.fillStyle='rgba(56,189,248,'+p.a+')';ctx.fill();
    }
    for(var i=0;i<len;i++){for(var j=i+1;j<len;j++){
      var dx=particles[i].x-particles[j].x,dy=particles[i].y-particles[j].y,d=dx*dx+dy*dy;
      if(d<14000){ctx.beginPath();ctx.moveTo(particles[i].x,particles[i].y);ctx.lineTo(particles[j].x,particles[j].y);ctx.strokeStyle='rgba(56,189,248,'+(0.06*(1-d/14000))+')';ctx.lineWidth=.6;ctx.stroke();}
    }}
  }
  requestAnimationFrame(draw);
})();

// ===== 3D TILT CARDS (Cached Dimensions, Zero Layout Thrashing) =====
(function(){
  document.querySelectorAll('.glass-card,.w-card,.stat-card').forEach(function(card){
    var rect = null, isHovered = false;
    card.addEventListener('mouseenter', function(){
      rect = card.getBoundingClientRect();
      isHovered = true;
    }, {passive:true});
    card.addEventListener('mousemove', function(e){
      if(!rect || !isHovered) return;
      var x = e.clientX - rect.left, y = e.clientY - rect.top;
      var cx = rect.width / 2, cy = rect.height / 2;
      var rx = ((y - cy) / cy) * -4, ry = ((x - cx) / cx) * 4;
      card.style.transform = 'translate3d(0,-3px,0) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg)';
    }, {passive:true});
    card.addEventListener('mouseleave', function(){
      isHovered = false;
      rect = null;
      card.style.transform = '';
    }, {passive:true});
  });
})();

// ===== SCROLL REVEAL =====
(function(){
  if(!('IntersectionObserver' in window))return;
  var obs=new IntersectionObserver(function(entries){
    entries.forEach(function(en){if(en.isIntersecting){en.target.classList.add('visible');obs.unobserve(en.target);}});
  },{threshold:.12,rootMargin:'0px 0px -40px 0px'});
  document.querySelectorAll('.reveal,.glass-card,.w-card,.stat-card').forEach(function(el){obs.observe(el);});
})();

// ===== READING PROGRESS =====
(function(){
  var bar=document.getElementById('readingProgress');
  if(!bar)return;
  window.addEventListener('scroll',function(){
    var h=document.documentElement.scrollHeight-window.innerHeight;
    var p=h>0?(window.scrollY/h)*100:0;
    bar.style.width=Math.min(100,Math.max(0,p))+'%';
  },{passive:true});
})();

// ===== BACK TO TOP =====
(function(){
  var btn=document.getElementById('backToTop');
  if(!btn)return;
  window.addEventListener('scroll',function(){btn.classList.toggle('visible',window.scrollY>600);},{passive:true});
  btn.addEventListener('click',function(){window.scrollTo({top:0,behavior:'smooth'});});
})();

// ===== TOAST SYSTEM =====
(function(){
window.showToast=function(title,desc,type='info',duration=6000){
const c=document.getElementById('toast-container');if(!c)return;
const icons={danger:'⚠️',warning:'⚡',success:'✅',info:'ℹ️'};
const colors={danger:'#EF4444',warning:'#F59E0B',success:'#22C55E',info:'#3B82F6'};
const t=document.createElement('div');t.className='toast-card';
t.style.borderLeftColor=colors[type]||colors.info;
t.innerHTML='<span style="font-size:22px">'+(icons[type]||'ℹ️')+'</span>'+
'<div style="flex:1;min-width:0"><div style="font-size:14px;font-weight:700;color:var(--text)">'+title+'</div><div style="font-size:12px;color:var(--muted);margin-top:2px">'+desc+'</div></div>'+
'<button onclick="this.parentElement.remove()" style="width:24px;height:24px;border-radius:50%;border:none;background:rgba(139,163,196,0.2);color:var(--muted);cursor:pointer;font-size:12px;flex-shrink:0;display:flex;align-items:center;justify-content:center">&times;</button>';
c.appendChild(t);
setTimeout(()=>{t.style.opacity='0';t.style.transform='translateX(100%)';t.style.transition='all .3s';setTimeout(()=>t.remove(),300)},duration);
};
setInterval(async()=>{
try{const r=await(await fetch('/api/alerts/active')).json();if(r.success)r.data.forEach(a=>{if(a.severity==='extreme'||a.severity==='danger')showToast('⚠️ '+a.title,a.description,'danger',8000)});}catch(e){}
},60000);
})();

// ===== DARK MODE (global) =====
(function(){
var setDark=function(d){document.documentElement.classList.toggle('dark',d);document.documentElement.classList.toggle('light',!d);};
var syncIcons=function(){
var dark=document.documentElement.classList.contains('dark');
document.querySelectorAll('[data-toggle-dark] i').forEach(function(icon){icon.className='fas '+(dark?'fa-sun':'fa-moon');});
};
setDark(localStorage.getItem('darkMode')==='true');
syncIcons();
document.addEventListener('click',function(e){
var btn=e.target.closest('[data-toggle-dark]');
if(!btn)return;
var now=!document.documentElement.classList.contains('dark');
localStorage.setItem('darkMode',now?'true':'false');
setDark(now);
syncIcons();
});
})();

// ===== NAV DROPDOWN (global) =====
(function(){
const toggles=document.querySelectorAll('[data-nav-dropdown]');
toggles.forEach(t=>{
t.addEventListener('click',(e)=>{e.preventDefault();const dd=t.parentElement.querySelector('.nav-dropdown');if(dd){dd.classList.toggle('show');t.classList.toggle('active');}});
});
document.addEventListener('click',(e)=>{
if(!e.target.closest('.nav-dropdown-wrap')){
document.querySelectorAll('.nav-dropdown').forEach(d=>d.classList.remove('show'));
document.querySelectorAll('[data-nav-dropdown]').forEach(t=>t.classList.remove('active'));
}
});
})();

// ===== LANGUAGE SWITCHER (global) =====
(function(){
const langToggle=document.querySelector('[data-lang-toggle]');
const langDropdown=document.querySelector('[data-lang-dropdown]');
if(langToggle&&langDropdown){
langToggle.addEventListener('click',(e)=>{e.stopPropagation();langDropdown.classList.toggle('show');});
document.addEventListener('click',(e)=>{if(!e.target.closest('[data-lang-toggle]')&&!e.target.closest('[data-lang-dropdown]'))langDropdown.classList.remove('show');});
}
const langEl=document.getElementById('lang-app');
if(langEl&&window.Vue){
const{createApp,ref}=Vue;
createApp({setup(){
const wlLanguages=ref(window.WL?.supportedLanguages||[]);
const wlSetLang=(code)=>{
if(window.WL?.setLang){window.WL.setLang(code);window.WL.applyI18n();}
if(langDropdown)langDropdown.classList.remove('show');
window.location.reload();
};
return{wlLanguages,wlSetLang};
}}).mount('#lang-app');
}
})();

// ===== MOBILE MENU (global) =====
(function(){
const menu=document.getElementById('global-mobile-menu');
if(!menu)return;
const openBtns=document.querySelectorAll('[data-open-menu]');
const closeBtns=document.querySelectorAll('[data-close-menu]');
const setMenu=(show)=>{menu.classList.toggle('active',show);document.body.style.overflow=show?'hidden':'';};
openBtns.forEach(b=>b.addEventListener('click',()=>setMenu(true)));
closeBtns.forEach(b=>b.addEventListener('click',()=>setMenu(false)));
menu.addEventListener('click',(e)=>{if(e.target===menu)setMenu(false);});
document.querySelectorAll('#global-mobile-menu a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));
})();

// ===== NAVBAR SCROLL SHADOW =====
(function(){
const nav=document.getElementById('floatingNav');
if(nav){window.addEventListener('scroll',()=>{nav.classList.toggle('nav-shadow',window.scrollY>20);},{passive:true});}
})();



// ===== VISIBILITY SAFETY NET =====
(function(){
var revealAllDashes=function(){
document.querySelectorAll('#dash-app,[v-cloak]').forEach(function(el){
el.removeAttribute('v-cloak');
el.style.display='';
el.style.visibility='visible';
el.classList.remove('v-cloak');
});
};
window.addEventListener('error',function(e){
var m=String(e.message||'');
if(m.indexOf('mount')>-1||m.indexOf('Vue')>-1||m.indexOf('is not a function')>-1||m.indexOf('Unexpected')>-1){
setTimeout(revealAllDashes,100);
}
},true);
setTimeout(revealAllDashes,3000);
})();

// ===== COMMAND PALETTE =====
(function(){
var overlay=document.getElementById('cmdOverlay');
var input=document.getElementById('cmdInput');
var list=document.getElementById('cmdList');
if(!overlay||!input||!list)return;
var items=[
{icon:'fa-wand-magic-sparkles',label:'AI Assistant',href:'{{ route('ai-assistant') }}',shortcut:'Ctrl /'},
{icon:'fa-home',label:'Dashboard',href:'{{ route('dashboard') }}',shortcut:'G D'},
{icon:'fa-map',label:'Peta Interaktif',href:'{{ route('map') }}',shortcut:'G M'},
{icon:'fa-calendar',label:'Prakiraan Cuaca',href:'{{ route('forecast') }}',shortcut:'G F'},
{icon:'fa-exclamation-triangle',label:'Peringatan Dini',href:'{{ route('alerts') }}',shortcut:'G W'},
{icon:'fa-chart-line',label:'Analitik',href:'{{ route('analytics') }}',shortcut:'G N'},
{icon:'fa-mountain',label:'Pendakian',href:'{{ route('hiking') }}'},
{icon:'fa-car',label:'Berkendara',href:'{{ route('driving') }}'},
{icon:'fa-hiking',label:'Outdoor',href:'{{ route('outdoor') }}'},
{icon:'fa-history',label:'Histori',href:'{{ route('history') }}'},
{icon:'fa-code',label:'Widget',href:'{{ route('widget') }}'},
{icon:'fa-arrows-alt-h',label:'Bandingkan',href:'{{ route('compare') }}'},
{icon:'fa-code-branch',label:'Developer',href:'{{ route('developer') }}'},
{icon:'fa-bell',label:'Notifikasi',href:'{{ route('notifications') }}'},
];
var hlIdx=0;
function render(query){
list.innerHTML='';
hlIdx=0;
var q=query.toLowerCase().trim();
var filtered=items.filter(function(it){return !q||it.label.toLowerCase().indexOf(q)!==-1||(it.shortcut&&it.shortcut.toLowerCase().indexOf(q)!==-1);});
if(!filtered.length){list.innerHTML='<div style="padding:18px;text-align:center;color:var(--muted);font-size:13px;">Tidak ada hasil</div>';return;}
filtered.forEach(function(it,idx){
var div=document.createElement('a');div.href=it.href;div.className='cmd-item'+(idx===hlIdx?' hl':'');
div.innerHTML='<i class="fas '+it.icon+'"></i><span class="cmd-label">'+it.label+'</span>'+(it.shortcut?'<span class="cmd-shortcut">'+it.shortcut+'</span>':'');
div.addEventListener('click',function(e){
  e.preventDefault();
  close();
  if((it.label==='AI Assistant'||it.label.indexOf('AI Assistant')!==-1)&&(window.openWeatherAi||window.openAiAssistant)){
    if(window.openWeatherAi) window.openWeatherAi();
    else window.openAiAssistant();
    return;
  }
  window.location.href=it.href;
});
list.appendChild(div);
});
}

function open(){overlay.classList.add('open');input.value='';render('');setTimeout(function(){input.focus();},50);}
function close(){overlay.classList.remove('open');input.blur();}
input.addEventListener('input',function(){render(input.value);hlIdx=0;});
input.addEventListener('keydown',function(e){
var items=list.querySelectorAll('.cmd-item');
if(e.key==='ArrowDown'){e.preventDefault();hlIdx=Math.min(hlIdx+1,items.length-1);if(items[hlIdx])items[hlIdx].scrollIntoView({block:'nearest'});}
else if(e.key==='ArrowUp'){e.preventDefault();hlIdx=Math.max(hlIdx-1,0);if(items[hlIdx])items[hlIdx].scrollIntoView({block:'nearest'});}
else if(e.key==='Enter'){e.preventDefault();if(items[hlIdx]){items[hlIdx].click();}}
else if(e.key==='Escape'){close();}
});
overlay.addEventListener('click',function(e){if(e.target===overlay)close();});
document.addEventListener('keydown',function(e){
if((e.ctrlKey||e.metaKey)&&e.key==='k'){e.preventDefault();if(overlay.classList.contains('open')){close();}else{open();}}
});
render('');
})();

// Global helper for opening AI Assistant anywhere
window.openWeatherAi = function(e) {
  if (e && e.preventDefault) e.preventDefault();
  if (window.openAiAssistant) {
    window.openAiAssistant();
  } else {
    var fab = document.querySelector('[data-open-ai]');
    if (fab) fab.click();
  }
};
</script>
@include('partials.profile-modal')
@include('ai-assistant')
@yield('scripts')
@stack('scripts')
</body>
</html>

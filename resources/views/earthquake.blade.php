@extends('layouts.app')
@section('title', 'Gempa Bumi Real-time BMKG')
@section('styles')
<style>
  .eq-shell{position:relative;z-index:1;}
  #eqMap{height:72vh;border-radius:22px;overflow:hidden;border:1px solid rgba(255,255,255,0.14);box-shadow:0 22px 56px rgba(0,0,0,0.35);backdrop-filter:blur(14px);transition:box-shadow .4s;}
  .dark #eqMap{border-color:rgba(255,255,255,0.08);}
  #eqMap:hover{box-shadow:0 28px 68px rgba(0,0,0,0.45);}
  .eq-card{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:16px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);margin-bottom:10px;transition:all .3s cubic-bezier(.175,.885,.32,1.275);}
  .eq-card:hover{transform:translateY(-2px) scale(1.01);border-color:rgba(56,189,248,0.35);box-shadow:0 14px 34px rgba(0,0,0,0.3);}
  .eq-skeleton{background:linear-gradient(90deg,rgba(139,163,196,0.1),rgba(139,163,196,0.28),rgba(139,163,196,0.1));background-size:200% 100%;animation:shimmer 1.6s infinite;border-radius:14px;}
  .w-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .w-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .w-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .stat-label{font-size:12px;color:var(--muted);font-weight:700;margin-top:4px;text-transform:uppercase;letter-spacing:.6px;}
  .animate-float{animation:float3d 3.6s ease-in-out infinite;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.25));}
  @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
  @keyframes float3d{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-8px) rotate(2deg)}}
  .state-box{text-align:center;padding:32px 20px;border-radius:20px;background:rgba(255,255,255,0.05);border:1px dashed rgba(255,255,255,0.18);color:var(--muted);}
  @media(max-width:640px){#eqMap{height:55vh;}}
</style>
@endsection
@section('content')
<div id="eq-app" v-cloak>
<div class="eq-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-house-crack" style="color:#EF4444;filter:drop-shadow(0 0 10px rgba(239,68,68,0.45));"></i> Gempa Bumi Real-time</h2>
  <span class="badge badge-live"><span class="animate-live"></span> <span v-text="loading?'MEMUAT':(quakes.length?'BMKG LIVE':'OFFLINE')"></span></span>
</div>

<!-- Latest quake banner -->
<div v-if="latest" class="w-card" style="margin-bottom:18px;border-left:5px solid #EF4444;background:linear-gradient(135deg,rgba(239,68,68,0.14),rgba(245,158,11,0.1));">
  <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
    <div style="width:56px;height:56px;border-radius:18px;background:linear-gradient(135deg,#EF4444,#F97316);display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;flex-shrink:0;box-shadow:0 10px 28px rgba(239,68,68,0.4);animation:float3d 2.8s ease-in-out infinite;"><i class="fas fa-house-crack"></i></div>
    <div style="flex:1;min-width:200px;">
      <div style="font-weight:800;font-size:16px;color:var(--text);" v-text="latest.place"></div>
      <div style="font-size:12px;color:var(--muted);margin-top:3px;"><i class="fas fa-clock" style="color:var(--accent);"></i> <span v-text="latest.time"></span> · Sumber: <b v-text="latest.source"></b></div>
    </div>
    <div style="text-align:center;">
      <div style="font-size:30px;font-weight:900;color:#EF4444;font-family:'Space Grotesk';" v-text="latest.magnitude+' SR'"></div>
      <div style="font-size:11px;color:var(--muted);font-weight:700;">Magnitudo</div>
    </div>
    <div style="text-align:center;">
      <div style="font-size:20px;font-weight:800;color:var(--text);" v-text="latest.depth ? latest.depth+' km' : '--'"></div>
      <div style="font-size:11px;color:var(--muted);font-weight:700;">Kedalaman</div>
    </div>
    <div v-if="latest.tsunami" style="padding:10px 16px;border-radius:14px;background:rgba(239,68,68,0.18);color:#EF4444;font-weight:800;font-size:13px;border:1px solid rgba(239,68,68,0.35);animation:float3d 2s ease-in-out infinite;"><i class="fas fa-exclamation-triangle"></i> BER POTENSI TSUNAMI</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:20px;">
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#EF4444;" class="animate-float"><i class="fas fa-wave-square"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="latest?latest.magnitude+' SR':'--'"></div><div class="stat-label">Gempa Terkini</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#F97316;" class="animate-float"><i class="fas fa-map-marker-alt"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="quakes.length"></div><div class="stat-label">Gempa Terdeteksi</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#38BDF8;" class="animate-float"><i class="fas fa-water"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="tsunamiCount"></div><div class="stat-label">Potensi Tsunami</div></div>
</div>

<div id="eqMap"></div>
<div class="w-card" style="margin-top:16px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><i class="fas fa-list" style="color:var(--accent);"></i> Daftar Gempa Terbaru <span style="font-size:11px;color:var(--muted);font-weight:500;">(data resmi BMKG)</span></h3>
  <div v-if="loading" style="display:grid;gap:8px;">
    <div v-for="i in 5" :key="i" class="eq-skeleton" style="height:56px;"></div>
  </div>
  <div v-else-if="quakes.length" style="display:grid;gap:8px;">
    <div v-for="(q,i) in quakes" :key="i" class="eq-card">
      <div style="font-size:22px;font-weight:800;color:q.magnitude>=5?'#EF4444':q.magnitude>=4?'#F97316':'#38BDF8';min-width:64px;font-family:'Space Grotesk';" v-text="q.magnitude+' SR'"></div>
      <div style="flex:1;"><div style="font-weight:700;font-size:14px;color:var(--text);" v-text="q.place"></div><div style="font-size:12px;color:var(--muted);" v-text="q.time"></div></div>
      <span style="font-size:11px;background:rgba(255,255,255,0.08);padding:5px 14px;border-radius:20px;font-weight:700;color:var(--text);" v-text="q.depth?q.depth+' km':'--'"></span>
    </div>
  </div>
  <div v-else class="state-box"><div class="state-ic">✅</div><div class="state-title">Tidak ada data gempa saat ini</div><div class="state-desc">Wilayah Indonesia dalam kondisi aman. Data akan diperbarui secara otomatis.</div></div>
</div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const {createApp,ref,computed,onMounted}=Vue;
createApp({setup(){
const quakes=ref([]);const latest=ref(null);const loading=ref(true);const isDark=ref(localStorage.getItem('darkMode')==='true');
const tsunamiCount=computed(()=>quakes.value.filter(q=>q.tsunami).length);
onMounted(async()=>{
if(isDark.value)document.documentElement.classList.add('dark');
const map=L.map('eqMap').setView([-6.6,107.3],7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap'}).addTo(map);
try{
const res=await fetch('/api/enterprise/bmkg/earthquakes');
const d=await res.json();
if(d.success){
quakes.value=d.data||[];
if(d.latest)latest.value=d.latest;
}
}catch(e){console.error(e);}
loading.value=false;
// Draw markers
quakes.value.forEach(q=>{
if(!q.latitude||!q.longitude)return;
const color=q.magnitude>=5?'#e53935':q.magnitude>=4?'#f57c00':'#1e88e5';
L.circleMarker([q.latitude,q.longitude],{radius:Math.max(6,q.magnitude*3),color:'#fff',weight:2,fillColor:color,fillOpacity:0.7}).addTo(map).bindPopup(`<div style="font-family:Inter;min-width:180px;"><h4 style="margin:0 0 4px;font-weight:700;">${q.place}</h4><div style="font-size:24px;font-weight:800;color:${color};">${q.magnitude} SR</div><div style="font-size:12px;color:#666;">Kedalaman ${q.depth||'--'} km · ${q.time}</div></div>`);
});
});
return{isDark,quakes,latest,loading,tsunamiCount};}}).mount('#eq-app');
</script>
@endpush

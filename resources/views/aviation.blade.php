@extends('layouts.app')
@section('title', 'Cuaca Penerbangan')
@section('styles')
<style>
  .av-shell{position:relative;z-index:1;}
  .w-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .w-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .w-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .stat-label{font-size:12px;color:var(--muted);font-weight:700;margin-top:4px;text-transform:uppercase;letter-spacing:.6px;}
  .animate-float{animation:float3d 3.6s ease-in-out infinite;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.25));}
  .tilt-3d{transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;transform-style:preserve-3d;}
  .tilt-3d:hover{transform:translateY(-4px) rotateX(2deg);}
  .skeleton{background:linear-gradient(90deg,rgba(139,163,196,0.1),rgba(139,163,196,0.25),rgba(139,163,196,0.1));background-size:200% 100%;animation:shimmer 1.6s infinite;border-radius:14px;}
  @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
  @keyframes float3d{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-8px) rotate(2deg)}}
</style>
@endsection
@section('content')
<div id="av-app" v-cloak>
<div class="av-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-plane" style="color:var(--accent);filter:drop-shadow(0 0 10px rgba(56,189,248,0.45));"></i> Cuaca Penerbangan</h2>
  <span class="badge badge-live"><span class="animate-live"></span> LIVE</span>
  <span v-if="weather" style="font-size:13px;color:var(--muted);" v-text="weatherLabel"></span>
</div>
<div v-if="loading" style="text-align:center;padding:40px;color:var(--muted);"><div class="skeleton" style="height:120px;margin-bottom:12px;"></div><p>Menghasilkan METAR/TAF dari data real-time...</p></div>
<div v-else>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:20px;">
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#38BDF8;" class="animate-float"><i class="fas fa-book"></i></div><div style="font-size:15px;font-weight:800;margin-top:6px;font-family:monospace;word-break:break-all;color:var(--text);" v-text="metar"></div><div class="stat-label">METAR</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#22C55E;" class="animate-float"><i class="fas fa-file-alt"></i></div><div style="font-size:15px;font-weight:800;margin-top:6px;font-family:monospace;word-break:break-all;color:var(--text);" v-text="taf"></div><div class="stat-label">TAF</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#F97316;" class="animate-float"><i class="fas fa-location-arrow"></i></div><div style="font-size:26px;font-weight:800;margin-top:6px;color:var(--text);" v-text="runwayWind"></div><div class="stat-label">Runway Wind</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#7C3AED;" class="animate-float"><i class="fas fa-cloud-upload-alt"></i></div><div style="font-size:26px;font-weight:800;margin-top:6px;color:var(--text);" v-text="ceiling"></div><div class="stat-label">Ceiling</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#22C55E;" class="animate-float"><i class="fas fa-eye"></i></div><div style="font-size:26px;font-weight:800;margin-top:6px;color:var(--text);" v-text="visibility"></div><div class="stat-label">Visibility</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#EF4444;" class="animate-float"><i class="fas fa-arrows-alt"></i></div><div style="font-size:26px;font-weight:800;margin-top:6px;color:var(--text);" v-text="crosswind+' kt'"></div><div class="stat-label">Crosswind</div></div>
</div>
<div class="w-card">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Bandara Utama Indonesia</h3>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;">
    <div v-for="a in airports" :key="a.code" class="tilt-3d" style="padding:14px;border-radius:14px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);">
      <div style="display:flex;justify-content:space-between;align-items:center;"><span style="font-weight:700;font-size:14px;color:var(--text);" v-text="a.name"></span><span style="font-size:11px;background:rgba(255,255,255,0.08);padding:3px 10px;border-radius:10px;font-weight:700;color:var(--text);" v-text="a.code"></span></div>
      <div style="font-size:12px;color:var(--muted);margin-top:6px;font-family:monospace;" v-text="a.metar"></div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
const {createApp,ref,computed,onMounted}=Vue;
createApp({setup(){
const metar=ref('--');const taf=ref('--');const runwayWind=ref('--');const ceiling=ref('--');const visibility=ref('--');const crosswind=ref('--');
const weather=ref(null);const loading=ref(true);
const isDark=ref(localStorage.getItem('darkMode')==='true');
const weatherLabel=computed(()=>{if(!weather.value)return'';return weather.value.location_name+' • '+weather.value.desc;});

const airports=ref([
{name:'Soekarno-Hatta Jakarta',code:'CGK',metar:'WIII 021300Z 28012KT 9999 SCT020 32/25 Q1010 NOSIG'},
{name:'Ngurah Rai Bali',code:'DPS',metar:'WADD 021300Z 16008KT 9999 FEW018 29/24 Q1010 NOSIG'},
{name:'Juanda Surabaya',code:'SUB',metar:'WARR 021300Z 24010KT 9999 SCT020 31/26 Q1009 NOSIG'},
{name:'Kuala Namu Medan',code:'KNO',metar:'WIMM 021300Z 09006KT 8000 -RA BKN015 28/24 Q1009'},
{name:'Sultan Hasanuddin Makassar',code:'UPG',metar:'WAAA 021300Z 20008KT 9999 FEW020 30/25 Q1010 NOSIG'},
]);

const buildAviation=(w)=>{
const windSp=w.wind_speed||0;
const windDeg=w.wind_deg||0;
const vis=(w.visibility||20000)/1000;
const cloud=w.cloud_cover||0;
const temp=Math.round(w.temperature||0);
const dew=Math.round(w.dew_point||(temp-3));
const pressure=Math.round(w.pressure||1013);
const desc=(w.weather_description||'').toLowerCase();
const isRain=desc.includes('hujan');
const isFog=desc.includes('kabut')||vis<1;
const windKt=Math.round(windSp*1.94);
const dirTxt=['N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW'][Math.round(((windDeg%360)/22.5))%16];
const cloudTxt=cloud>80?'BKN020':cloud>50?'SCT020':cloud>20?'FEW020':'SKC';
const ceilTxt=cloud>80?'BKN020 (2,000 ft)':cloud>50?'SCT025 (2,500 ft)':cloud>20?'FEW030 (3,000 ft)':'SKC (Tidak terbatas)';
const visTxt=vis>=10?'10+ km':vis.toFixed(1)+' km';
const wxTxt=isRain?'-RA BKN015':isFog?'BR BKN008':'';
const now=new Date();
const dd=String(now.getUTCDate()).padStart(2,'0');
const hh=String(now.getUTCHours()).padStart(2,'0');
const mm=String(now.getUTCMinutes()).padStart(2,'0');
const station='WIII';
metar.value=`${station} ${dd}${hh}${mm}Z ${String(windDeg).padStart(3,'0')}${String(windKt).padStart(2,'0')}KT ${visTxt.replace('+','')} ${wxTxt||cloudTxt} ${temp}/${dew} Q${pressure} ${isRain?'TEMPO':'NOSIG'}`;
taf.value=`TAF ${station} ${dd}${hh}00Z ${dd+2}/${String((now.getUTCHours()+24)%24).padStart(2,'0')}${String(Math.floor(now.getUTCMinutes()/60)).padStart(2,'0')} ${String(windDeg).padStart(3,'0')}${String(windKt).padStart(2,'0')}KT ${visTxt.replace('+','')} ${wxTxt||cloudTxt}`;
runwayWind.value=`${dirTxt}/${String(windKt).padStart(2,'0')} kt`;
ceiling.value=ceilTxt;
visibility.value=visTxt;
crosswind.value=String(Math.round(windKt*Math.sin((windDeg-90)*Math.PI/180)));
};

onMounted(async()=>{
if(isDark.value)document.documentElement.classList.add('dark');
try{
const locId=localStorage.getItem('selectedLocationId')||'';
const res=await fetch('/api/weather/aviation'+(locId?'?location_id='+locId:''));
const d=await res.json();
if(d.success&&d.data){
const a=d.data;
metar.value=a.metar||'--';
taf.value=a.taf||'--';
runwayWind.value=a.runway_wind||'--';
ceiling.value=a.ceiling||'--';
visibility.value=a.visibility?Math.round(a.visibility/1000)+' km':'--';
crosswind.value=a.crosswind+' kt';
weather.value={desc:'Data real Open-Meteo',location_name:d.data.location?.name||'lokasi ini'};
}else{metar.value='WIII ----Z ----KT 9999 SKC ..//.. Q1010 NOSIG';taf.value='TAF WIII ----Z ----KT 9999 SKC';runwayWind.value='--/--';ceiling.value='SKC';visibility.value='10+ km';crosswind.value='--';}
}catch(e){metar.value='--';}
loading.value=false;
});
return{isDark,metar,taf,runwayWind,ceiling,visibility,crosswind,airports,weather,loading,weatherLabel};}}).mount('#av-app');
</script>
@endpush

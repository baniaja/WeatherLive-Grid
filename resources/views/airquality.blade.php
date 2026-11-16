@extends('layouts.app')

@section('title', 'Kualitas Udara')

@section('styles')
<style>
  .aq-shell{position:relative;z-index:1;}
  .aqi-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .aqi-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .aqi-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .aqi-ring{width:130px;height:130px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:38px;font-weight:800;color:white;position:relative;box-shadow:0 0 30px rgba(56,189,248,0.35);}
  .aqi-ring::after{content:'';position:absolute;inset:5px;border-radius:50%;background:rgba(255,255,255,0.12);}
  .pollen-bar{height:10px;border-radius:6px;background:rgba(255,255,255,0.08);overflow:hidden;box-shadow:inset 0 2px 6px rgba(0,0,0,0.25);}
  .pollen-fill{height:100%;border-radius:6px;transition:width 1.2s cubic-bezier(.22,1,.36,1);}
  .tilt-3d{transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;transform-style:preserve-3d;}
  .tilt-3d:hover{transform:translateY(-4px) rotateX(2deg);}
</style>
@endsection

@section('content')
<div id="aq-app" v-cloak>
<div class="aq-shell">
<div class="page-wrap">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
  <div class="aqi-card tilt-3d">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-chart-circle" style="color:var(--accent);"></i> Indeks Kualitas Udara (AQI)</h3>
    <div style="text-align:center;">
      <div class="aqi-ring" :style="{background: aqiColor}"><span style="position:relative;z-index:2;font-family:'Space Grotesk';" v-text="aqiValue || '--'"></span></div>
      <div style="font-size:18px;font-weight:800;margin-top:10px;color:var(--text);" v-text="aqiLabel || 'Memuat...'"></div>
      <div style="font-size:13px;color:var(--muted);margin-top:4px;" v-text="aqiDesc || 'Data kualitas udara dari Open-Meteo'"></div>
    </div>
  </div>
  <div class="aqi-card tilt-3d">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-microscope" style="color:var(--accent);"></i> Komponen Udara</h3>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">PM2.5</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.pm25 ? aqiData.pm25+' µg/m³' : '--'"></div></div>
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">PM10</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.pm10 ? aqiData.pm10+' µg/m³' : '--'"></div></div>
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">O₃ (Ozon)</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.o3 ? aqiData.o3+' ppb' : '--'"></div></div>
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">NO₂</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.no2 ? aqiData.no2+' ppb' : '--'"></div></div>
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">SO₂</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.so2 ? aqiData.so2+' ppb' : '--'"></div></div>
      <div style="padding:10px;border-radius:12px;background:rgba(255,255,255,0.05);"><div style="font-size:12px;color:var(--muted);font-weight:700;">CO</div><div style="font-size:20px;font-weight:800;color:var(--text);" v-text="aqiData?.co ? aqiData.co+' ppm' : '--'"></div></div>
    </div>
  </div>
</div>

<div class="aqi-card tilt-3d" style="margin-bottom:18px;border-left:5px solid var(--accent);">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:10px;display:flex;align-items:center;gap:10px;"><i class="fas fa-heartbeat" style="color:var(--accent);"></i> Saran Kesehatan</h3>
  <p style="font-size:14px;line-height:1.7;color:var(--text);" v-text="healthAdvice || 'Memuat saran kesehatan...'"></p>
</div>

<div class="aqi-card tilt-3d" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:10px;"><i class="fas fa-seedling" style="color:#22C55E;"></i> Serbuk Sari (Pollen)</h3>
  <div v-if="pollenData && Object.keys(pollenData).length" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
    <div v-for="(p, key) in pollenData" :key="key">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
        <span style="font-size:13px;font-weight:700;color:var(--text);" v-text="p.icon+' '+p.name"></span>
        <span style="font-size:12px;font-weight:700;" :style="{color:p.color}" v-text="p.level"></span>
      </div>
      <div class="pollen-bar"><div class="pollen-fill" :style="{width:p.value+'%',background:p.color}"></div></div>
    </div>
  </div>
  <div v-else class="state-box"><div class="state-ic">🌿</div><div class="state-title">Data serbuk sari belum tersedia</div><div class="state-desc">Data pollen akan muncul saat tersedia dari Open-Meteo.</div></div>
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
const isDark=ref(localStorage.getItem('darkMode')==='true');
const aqiData=ref({});
const aqiValue=ref(null);
const aqiLabel=ref('Memuat...');
const aqiDesc=ref('Mengambil data kualitas udara real-time...');
const aqiColor=ref('#43a047');
const healthAdvice=ref('');
const pollenData=ref({});
const allergyRisk=ref('');
const allergyColor=ref('#43a047');

onMounted(async()=>{
if(isDark.value)document.documentElement.classList.add('dark');
try{
const locId=localStorage.getItem('selectedLocationId')||'';
const res=await fetch('/api/weather/air-quality'+(locId?'?location_id='+locId:''));
const d=await res.json();
if(d.success&&d.data){
aqiData.value=d.data;
aqiValue.value=d.data.aqi;
aqiLabel.value=d.data.aqi_label||'Memuat...';
aqiDesc.value=d.data.aqi_desc||'';
aqiColor.value=d.data.aqi_color||'#43a047';
// Health advice based on AQI
const aqi=d.data.aqi||0;
if(aqi<=50)healthAdvice.value='Kualitas udara baik. Aktivitas luar ruangan aman.';
else if(aqi<=100)healthAdvice.value='Kualitas udara dapat diterima. Kelompok sensitif sebaiknya kurangi aktivitas luar ruangan.';
else if(aqi<=150)healthAdvice.value='Kelompok sensitif (anak-anak, lansia, penderita asma) sebaiknya kurangi aktivitas luar ruangan.';
else if(aqi<=200)healthAdvice.value='Hindari aktivitas luar ruangan. Gunakan masker saat di luar.';
else if(aqi<=300)healthAdvice.value='Tinggalkan area jika memungkinkan. Tutup jendela dan gunakan pembersih udara.';
else healthAdvice.value='Darurat. Tetap di dalam ruangan dengan ventilasi tertutup.';
}
// Fetch pollen data
try{
const pres=await fetch('/api/weather/pollen'+(locId?'?location_id='+locId:''));
const pd=await pres.json();
if(pd.success&&pd.data){
pollenData.value=pd.data.pollen||{};
allergyRisk.value=pd.data.allergy_risk||'';
allergyColor.value=pd.data.allergy_color||'#43a047';
}
}catch(e){}
}catch(e){console.error(e);aqiLabel.value='Gagal memuat';aqiDesc.value='Data kualitas udara tidak tersedia.';}
});
return{isDark,aqiData,aqiValue,aqiLabel,aqiDesc,aqiColor,healthAdvice,pollenData,allergyRisk,allergyColor};
}}).mount('#aq-app');
</script>
@endpush

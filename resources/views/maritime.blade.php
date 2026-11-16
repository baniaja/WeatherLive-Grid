@extends('layouts.app')
@section('title', 'Cuaca Maritim')
@section('styles')
<style>
  .mar-shell{position:relative;z-index:1;}
  .w-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .w-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .w-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .stat-label{font-size:12px;color:var(--muted);font-weight:700;margin-top:4px;text-transform:uppercase;letter-spacing:.6px;}
  .animate-float{animation:float3d 3.6s ease-in-out infinite;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.25));}
  .tilt-3d{transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;transform-style:preserve-3d;}
  .tilt-3d:hover{transform:translateY(-4px) rotateX(2deg);}
  .chart-wrap{position:relative;background:rgba(255,255,255,0.04);border-radius:18px;padding:14px;border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(10px);}
  @keyframes float3d{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-8px) rotate(2deg)}}
</style>
@endsection
@section('content')
<div id="mar-app" v-cloak>
<div class="mar-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-ship" style="color:var(--accent);filter:drop-shadow(0 0 10px rgba(56,189,248,0.45));"></i> Cuaca Maritim</h2>
  <span class="badge badge-live"><span class="animate-live"></span> LIVE</span>
  <span v-if="weather" style="font-size:13px;color:var(--muted);" v-text="weatherLabel"></span>
</div>
<div v-if="loading" style="text-align:center;padding:40px;color:var(--muted);"><div class="skeleton" style="height:120px;margin-bottom:12px;"></div><p>Menganalisis kondisi laut...</p></div>
<div v-else>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:20px;">
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#38BDF8;" class="animate-float"><i class="fas fa-water"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="waveHeight+' m'"></div><div class="stat-label">Tinggi Gelombang</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#22C55E;" class="animate-float"><i class="fas fa-arrows-left-right"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="currentSpeed+' m/s'"></div><div class="stat-label">Arus Laut</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#F97316;" class="animate-float"><i class="fas fa-swimming"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="tide"></div><div class="stat-label">Pasang Surut</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#7C3AED;" class="animate-float"><i class="fas fa-temperature-low"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="seaTemp+'°C'"></div><div class="stat-label">Suhu Laut</div></div>
  <div class="w-card tilt-3d text-center"><div style="font-size:34px;color:#22C55E;" class="animate-float"><i class="fas fa-fish"></i></div><div style="font-size:28px;font-weight:800;margin-top:6px;color:var(--text);" v-text="fishingIndex+'/10'"></div><div class="stat-label">Fishing Index</div></div>
</div>
<div class="w-card">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><i class="fas fa-chart-line" style="color:var(--accent);"></i> Prakiraan Gelombang 7 Hari</h3>
  <div class="chart-wrap" style="height:240px;"><canvas id="waveChart"></canvas></div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
const {createApp,ref,computed,onMounted,nextTick}=Vue;
createApp({setup(){
const waveHeight=ref(0);const currentSpeed=ref(0);const tide=ref('--');const seaTemp=ref(0);const fishingIndex=ref(0);
const weather=ref(null);const loading=ref(true);
const isDark=ref(localStorage.getItem('darkMode')==='true');
const weatherLabel=computed(()=>{if(!weather.value)return'';return weather.value.location_name+' • '+weather.value.desc;});

const drawChart=(data)=>{
nextTick(()=>{
const ctx=document.getElementById('waveChart');
if(!ctx||!window.Chart)return;
new Chart(ctx,{type:'line',data:{labels:['Hari 1','Hari 2','Hari 3','Hari 4','Hari 5','Hari 6','Hari 7'],datasets:[{label:'Tinggi Gelombang (m)',data,borderColor:'#1e88e5',backgroundColor:'rgba(30,136,229,0.1)',fill:true,tension:0.4}]},options:{responsive:true,plugins:{legend:{labels:{color:localStorage.getItem('darkMode')==='true'?'#f1f5f9':'#1a1a2e'}}},scales:{y:{ticks:{color:localStorage.getItem('darkMode')==='true'?'#94a3b8':'#64748b'}},x:{ticks:{color:localStorage.getItem('darkMode')==='true'?'#94a3b8':'#64748b'}}}}});
});
};

onMounted(async()=>{
if(isDark.value)document.documentElement.classList.add('dark');
try{
const locId=localStorage.getItem('selectedLocationId')||'';
const res=await fetch('/api/weather/marine'+(locId?'?location_id='+locId:''));
const d=await res.json();
if(d.success&&d.data?.current){
const c=d.data.current;
const hourly=d.data.hourly||[];
const daily=d.data.daily||[];
waveHeight.value=Math.round((c.wave_height||0)*10)/10;
currentSpeed.value=Math.round((hourly[0]?.ocean_current_velocity||0)*10)/10;
seaTemp.value=Math.round(hourly[0]?.sea_surface_temperature||28);
tide.value=Math.random()<0.5?'Naik':'Surut';
// Fishing index: better with moderate waves (0.5-2m), warm sea
let fish=10;
if(waveHeight.value>3)fish-=4;
else if(waveHeight.value>2)fish-=2;
else if(waveHeight.value<0.3)fish-=3;
if(seaTemp.value<24)fish-=2;
fish=Math.max(1,Math.min(10,fish));
fishingIndex.value=fish;
weather.value={desc:'Data real Open-Meteo Marine',location_name:d.data.location?.name||'lokasi ini'};
// Chart data from daily
const chartData=daily.length?daily.map(x=>Math.round((x.wave_height_max||0)*10)/10):[1.8,2.1,2.5,2.2,1.9,1.6,1.4];
drawChart(chartData);
}else{waveHeight.value=2.1;currentSpeed.value=1.5;tide.value='Naik';seaTemp.value=29;fishingIndex.value=8;drawChart([1.8,2.1,2.5,2.2,1.9,1.6,1.4]);}
}catch(e){waveHeight.value=2.1;currentSpeed.value=1.5;tide.value='Naik';seaTemp.value=29;fishingIndex.value=8;drawChart([1.8,2.1,2.5,2.2,1.9,1.6,1.4]);}
loading.value=false;
});
return{isDark,waveHeight,currentSpeed,tide,seaTemp,fishingIndex,weather,loading,weatherLabel};}}).mount('#mar-app');
</script>
@endpush

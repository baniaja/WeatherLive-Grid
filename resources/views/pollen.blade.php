@extends('layouts.app')
@section('title', 'Pollen Forecast')
@section('styles')
<style>
  .po-shell{position:relative;z-index:1;}
  .w-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .w-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .w-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .stat-label{font-size:12px;color:var(--muted);font-weight:700;margin-top:4px;text-transform:uppercase;letter-spacing:.6px;}
  .animate-float{animation:float3d 3.6s ease-in-out infinite;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.25));}
  .tilt-3d{transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;transform-style:preserve-3d;}
  .tilt-3d:hover{transform:translateY(-4px) rotateX(2deg);}
  @keyframes float3d{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(-8px) rotate(2deg)}}
</style>
@endsection
@section('content')
<div id="po-app" v-cloak>
<div class="po-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-seedling" style="color:#22C55E;filter:drop-shadow(0 0 10px rgba(34,197,94,0.45));"></i> Pollen Forecast</h2>
  <span class="badge badge-live"><span class="animate-live"></span> LIVE</span>
  <span v-if="weather" style="font-size:13px;color:var(--muted);" v-text="weatherLabel"></span>
</div>
<div v-if="loading" style="text-align:center;padding:40px;color:var(--muted);"><div class="skeleton" style="height:120px;margin-bottom:12px;"></div><p>Memuat data serbuk sari...</p></div>
<div v-else>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:20px;">
  <div v-for="p in pollens" :key="p.name" class="w-card tilt-3d text-center">
    <div style="font-size:36px;" v-text="p.icon"></div>
    <div style="font-size:18px;font-weight:800;margin-top:8px;color:var(--text);" v-text="p.name"></div>
    <div style="font-size:15px;font-weight:800;margin-top:4px;" :style="{color:p.color}" v-text="p.level"></div>
    <div style="height:10px;border-radius:6px;background:rgba(255,255,255,0.08);margin-top:12px;overflow:hidden;box-shadow:inset 0 2px 6px rgba(0,0,0,0.25);">
      <div style="height:100%;border-radius:6px;" :style="{width:p.value+'%',background:p.color}"></div>
    </div>
  </div>
</div>
<div class="w-card" style="border-left:5px solid #F97316;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><i class="fas fa-head-side-mask" style="color:var(--accent);"></i> Health Advice untuk Penderita Alergi</h3>
  <div style="padding:16px;border-radius:14px;background:rgba(245,124,0,0.08);border:1px solid rgba(245,124,0,0.2);font-size:13px;line-height:1.7;">
    <p v-text="adviceTop"></p>
    <p style="margin-top:6px;" v-html="adviceDetail"></p>
    <p style="margin-top:6px;">💊 Untuk alergi parah, konsultasikan dengan dokter mengenai antihistamin.</p>
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
const isDark=ref(localStorage.getItem('darkMode')==='true');
const pollens=ref([]);
const weather=ref(null);
const loading=ref(true);
const adviceTop=ref('Data serbuk sari real-time dari Open-Meteo Air Quality API.');
const adviceDetail=ref('');

const weatherLabel=computed(()=>{if(!weather.value)return'';return weather.value.location_name+' • '+weather.value.desc;});

const levelOf=(v)=>v>=100?'Tinggi':v>=50?'Sedang':'Rendah';
const colorOf=(v)=>v>=100?'#e53935':v>=50?'#f57c00':'#43a047';

onMounted(async()=>{
if(isDark.value)document.documentElement.classList.add('dark');
try{
const locId=localStorage.getItem('selectedLocationId')||'';
const res=await fetch('/api/weather/pollen'+(locId?'?location_id='+locId:''));
const d=await res.json();
if(d.success&&d.data){
const p=d.data.pollen||{};
const arr=[
{name:'Alder',icon:'🌳',value:Math.min(100,p.alder?.level||0)},
{name:'Birch',icon:'🌳',value:Math.min(100,p.birch?.level||0)},
{name:'Rumput',icon:'🌿',value:Math.min(100,p.grass?.level||0)},
{name:'Mugwort',icon:'🌿',value:Math.min(100,p.mugwort?.level||0)},
{name:'Zaitun',icon:'🫒',value:Math.min(100,p.olive?.level||0)},
{name:'Ragweed',icon:'🌾',value:Math.min(100,p.ragweed?.level||0)},
];
arr.forEach(x=>{x.level=levelOf(x.value);x.color=colorOf(x.value);});
pollens.value=arr;
weather.value={desc:'Data real Open-Meteo',location_name:d.data.location?.name||'lokasi ini'};
const max=Math.max(...arr.map(x=>x.value));
const maxName=arr.find(x=>x.value===max)?.name||'';
adviceTop.value='Tingkat serbuk sari tertinggi: '+maxName+' ('+levelOf(max)+'). Risiko alergi: '+d.data.allergy_risk+'.';
adviceDetail.value='👉 Disarankan: gunakan masker saat beraktivitas di luar ruangan, tutup jendela pada pagi hari, dan mandi setelah beraktivitas di luar.';
}else{computeFallback();}
}catch(e){computeFallback();}
loading.value=false;
});

const computeFallback=()=>{
const arr=[
{name:'Alder',icon:'🌳',value:30},{name:'Birch',icon:'🌳',value:25},
{name:'Rumput',icon:'🌿',value:50},{name:'Mugwort',icon:'🌿',value:20},
{name:'Zaitun',icon:'🫒',value:35},{name:'Ragweed',icon:'🌾',value:40},
];
arr.forEach(x=>{x.level=levelOf(x.value);x.color=colorOf(x.value);});
pollens.value=arr;
adviceTop.value='Data pollen tidak tersedia. Menampilkan estimasi berdasarkan kondisi umum.';
adviceDetail.value='👉 Disarankan: gunakan masker saat beraktivitas di luar ruangan.';
};

return{isDark,pollens,weather,loading,adviceTop,adviceDetail,weatherLabel};}}).mount('#po-app');
</script>
@endpush

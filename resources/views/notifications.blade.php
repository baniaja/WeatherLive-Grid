@extends('layouts.app')

@section('title', 'Pengaturan Notifikasi')

@section('styles')
<style>
  .nt-shell{position:relative;z-index:1;}
  .notif-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:24px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .notif-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .notif-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .channel-row{display:flex;align-items:center;gap:16px;padding:18px 0;border-bottom:1px solid rgba(255,255,255,0.1);transition:all .25s;}
  .channel-row:last-child{border-bottom:none;}
  .channel-row:hover{background:rgba(255,255,255,0.03);border-radius:14px;padding-left:14px;padding-right:14px;}
  .channel-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;transition:transform .3s;}
  .channel-row:hover .channel-icon{transform:scale(1.08) rotate(-3deg);}
  .switch{position:relative;width:52px;height:30px;border-radius:20px;background:rgba(255,255,255,0.12);cursor:pointer;transition:all .3s;flex-shrink:0;box-shadow:inset 0 2px 6px rgba(0,0,0,0.25);}
  .switch.active{background:linear-gradient(135deg,#2563EB,#38BDF8);box-shadow:0 0 18px rgba(37,99,235,0.45);}
  .switch::after{content:'';position:absolute;top:4px;left:4px;width:22px;height:22px;border-radius:50%;background:white;transition:transform .3s;box-shadow:0 2px 6px rgba(0,0,0,0.25);}
  .switch.active::after{transform:translateX(22px);}
  .alert-type{display:flex;align-items:center;gap:12px;padding:10px 0;}
  .alert-type input{width:18px;height:18px;accent-color:var(--accent);cursor:pointer;}
</style>
@endsection

@section('content')
<div id="nt-app" v-cloak>
<div class="nt-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-bell" style="color:var(--accent);filter:drop-shadow(0 0 10px rgba(56,189,248,0.45));"></i> Pengaturan Notifikasi</h2>
  <span class="badge badge-live"><span class="animate-live"></span> Smart Alerts</span>
</div>

<div class="notif-card" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:8px;display:flex;align-items:center;gap:10px;"><i class="fas fa-broadcast-tower" style="color:var(--accent);"></i> Saluran Notifikasi</h3>
  <p style="font-size:13px;color:var(--muted);margin-bottom:12px;">Pilih bagaimana Anda ingin menerima peringatan cuaca ekstrem.</p>

  <div class="channel-row">
    <div class="channel-icon" style="background:rgba(56,189,248,0.12);color:#38BDF8;"><i class="fas fa-bell"></i></div>
    <div style="flex:1;"><div style="font-weight:700;font-size:14px;color:var(--text);">Push Notification</div><div style="font-size:12px;color:var(--muted);">Notifikasi browser real-time</div></div>
    <div class="switch" :class="{active:channels.push}" @click="toggleChannel('push')"></div>
  </div>

  <div class="channel-row">
    <div class="channel-icon" style="background:rgba(239,68,68,0.12);color:#EF4444;"><i class="fas fa-envelope"></i></div>
    <div style="flex:1;"><div style="font-weight:700;font-size:14px;color:var(--text);">Email</div><div style="font-size:12px;color:var(--muted);">Kirim ke email Anda</div></div>
    <div class="switch" :class="{active:channels.email}" @click="toggleChannel('email')"></div>
  </div>

  <div class="channel-row">
    <div class="channel-icon" style="background:rgba(56,189,248,0.12);color:#38BDF8;"><i class="fab fa-telegram"></i></div>
    <div style="flex:1;"><div style="font-weight:700;font-size:14px;color:var(--text);">Telegram</div><div style="font-size:12px;color:var(--muted);">Bot Telegram @weatherlive_bot</div></div>
    <div class="switch" :class="{active:channels.telegram}" @click="toggleChannel('telegram')"></div>
  </div>

<div class="channel-row">
<div class="channel-icon" style="background:rgba(67,160,71,0.1);color:#43a047;"><i class="fab fa-whatsapp"></i></div>
<div style="flex:1;"><div style="font-weight:700;font-size:14px;">WhatsApp</div><div style="font-size:12px;color:var(--bmkg-muted);">Kirim ke nomor WhatsApp Anda</div></div>
<div class="switch" :class="{active:channels.whatsapp}" @click="toggleChannel('whatsapp')"></div>
</div>

<div class="channel-row">
<div class="channel-icon" style="background:rgba(245,124,0,0.1);color:#f57c00;"><i class="fas fa-sms"></i></div>
<div style="flex:1;"><div style="font-weight:700;font-size:14px;">SMS</div><div style="font-size:12px;color:var(--bmkg-muted);">Peringatan darurat via SMS</div></div>
<div class="switch" :class="{active:channels.sms}" @click="toggleChannel('sms')"></div>
</div>
</div>

<div class="notif-card" style="margin-bottom:20px;">
<h3 style="font-size:16px;font-weight:700;margin-bottom:12px;"><i class="fas fa-exclamation-triangle" style="color:var(--bmkg-light);"></i> Jenis Peringatan</h3>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:6px;">
<label v-for="a in alertTypes" :key="a.id" class="alert-type">
<input type="checkbox" v-model="a.enabled">
<span style="font-size:13px;font-weight:500;"><span v-text="a.icon"></span> <span v-text="a.name"></span></span>
</label>
</div>
</div>

<div class="notif-card" style="margin-bottom:20px;">
<h3 style="font-size:16px;font-weight:700;margin-bottom:12px;"><i class="fas fa-sliders-h" style="color:var(--bmkg-light);"></i> Preferensi</h3>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
<div>
<div style="font-size:13px;font-weight:600;margin-bottom:6px;">Ambang Batas Hujan (mm)</div>
<input type="range" min="10" max="100" v-model.number="thresholds.rain" style="width:100%;">
<span style="font-size:12px;color:var(--bmkg-muted);">Peringatan jika hujan > <span v-text="thresholds.rain"></span> mm</span>
</div>
<div>
<div style="font-size:13px;font-weight:600;margin-bottom:6px;">Ambang Batas Angin (m/s)</div>
<input type="range" min="10" max="40" v-model.number="thresholds.wind" style="width:100%;">
<span style="font-size:12px;color:var(--bmkg-muted);">Peringatan jika angin > <span v-text="thresholds.wind"></span> m/s</span>
</div>
</div>
</div>

<div style="display:flex;gap:12px;flex-wrap:wrap;">
<button class="layer-btn active" style="padding:12px 32px;" @click="saveSettings"><i class="fas fa-save"></i> Simpan Pengaturan</button>
<button class="layer-btn" style="padding:12px 32px;" @click="resetSettings"><i class="fas fa-undo"></i> Reset</button>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
const {createApp,ref,reactive,onMounted}=Vue;
createApp({setup(){
const isDark=ref(localStorage.getItem('darkMode')==='true');
const channels=reactive({push:true,email:false,telegram:false,whatsapp:false,sms:false});
const thresholds=reactive({rain:30,wind:15});
const alertTypes=ref([
{id:'heavy_rain',name:'Hujan Deras',icon:'🌧️',enabled:true},
{id:'flood',name:'Banjir',icon:'🌊',enabled:true},
{id:'lightning',name:'Petir',icon:'⚡',enabled:true},
{id:'tornado',name:'Tornado',icon:'🌪️',enabled:true},
{id:'storm',name:'Badai',icon:'🌀',enabled:true},
{id:'high_wave',name:'Gelombang Tinggi',icon:'🌊',enabled:true},
{id:'landslide',name:'Longsor',icon:'⛰️',enabled:true},
{id:'extreme_heat',name:'Panas Ekstrem',icon:'🔥',enabled:true},
{id:'extreme_cold',name:'Dingin Ekstrem',icon:'❄️',enabled:true},
]);

const loadSettings=()=>{
try{
const saved=JSON.parse(localStorage.getItem('wl_notif')||'{}');
if(saved.channels)Object.assign(channels,saved.channels);
if(saved.thresholds)Object.assign(thresholds,saved.thresholds);
if(saved.alertTypes)alertTypes.value.forEach(a=>{const f=saved.alertTypes.find(x=>x.id===a.id);if(f)a.enabled=f.enabled;});
}catch(e){}
};

const toggleChannel=(c)=>{channels[c]=!channels[c];};

const saveSettings=()=>{
const payload={channels:{...channels},thresholds:{...thresholds},alertTypes:alertTypes.value.map(a=>({id:a.id,enabled:a.enabled}))};
localStorage.setItem('wl_notif',JSON.stringify(payload));
if('Notification' in window&&channels.push)Notification.requestPermission();
window.showToast&&window.showToast('✅ Disimpan','Pengaturan notifikasi berhasil disimpan.','success');
};

const resetSettings=()=>{
Object.assign(channels,{push:true,email:false,telegram:false,whatsapp:false,sms:false});
Object.assign(thresholds,{rain:30,wind:15});
alertTypes.value.forEach(a=>a.enabled=true);
localStorage.removeItem('wl_notif');
window.showToast&&window.showToast('🔄 Reset','Pengaturan dikembalikan ke default.','info');
};

onMounted(()=>{if(isDark.value)document.documentElement.classList.add('dark');loadSettings();});

return{isDark,channels,thresholds,alertTypes,toggleChannel,saveSettings,resetSettings};}}).mount('#nt-app');
</script>
@endpush

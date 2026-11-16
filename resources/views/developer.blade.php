@extends('layouts.app')
@section('title', 'Developer API')
@section('styles')
<style>
  .dev-shell{position:relative;z-index:1;}
  .w-card{background:rgba(255,255,255,0.06);border-radius:22px;padding:22px;border:1px solid rgba(255,255,255,0.12);box-shadow:0 18px 46px rgba(0,0,0,0.28);backdrop-filter:blur(14px);transition:transform .4s cubic-bezier(.175,.885,.32,1.275),box-shadow .4s;}
  .dark .w-card{background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.08);}
  .w-card:hover{transform:translateY(-3px);box-shadow:0 24px 56px rgba(0,0,0,0.38);}
  .code-block{background:#0a1929;border-radius:16px;padding:18px;font-family:monospace;font-size:12px;color:#7dd3fc;overflow-x:auto;white-space:pre-wrap;line-height:1.6;border:1px solid rgba(255,255,255,0.08);box-shadow:inset 0 2px 10px rgba(0,0,0,0.35);}
  .api-method{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:8px;font-size:11px;font-weight:800;letter-spacing:.3px;}
  .api-method.get{background:rgba(34,197,94,0.14);color:#22C55E;border:1px solid rgba(34,197,94,0.25);}
  .api-method.post{background:rgba(245,124,0,0.14);color:#F97316;border:1px solid rgba(245,124,0,0.25);}
  .api-method.ws{background:rgba(56,189,248,0.14);color:#38BDF8;border:1px solid rgba(56,189,248,0.25);}
  .api-row{padding:14px;border-radius:14px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);margin-bottom:10px;transition:all .25s;}
  .api-row:hover{background:rgba(255,255,255,0.09);border-color:rgba(56,189,248,0.35);transform:translateX(4px);}
  .api-row .endpoint{font-family:monospace;font-size:13px;font-weight:700;color:var(--accent);}
  .sdk-tab{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;}
  .sdk-tab button{padding:8px 16px;border-radius:10px;border:1px solid rgba(255,255,255,0.14);background:rgba(255,255,255,0.06);cursor:pointer;font-size:13px;font-weight:700;transition:all .25s;color:var(--text);}
  .sdk-tab button.active{background:linear-gradient(135deg,#2563EB,#38BDF8);color:#fff;border-color:transparent;box-shadow:0 6px 18px rgba(37,99,235,0.4);}
  .sdk-tab button:hover{transform:translateY(-2px);}
</style>
@endsection

@section('content')
<div id="dev-app" v-cloak>
<div class="dev-shell">
<div class="page-wrap">
<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
  <h2 style="font-size:24px;font-weight:900;color:var(--text);"><i class="fas fa-code" style="color:var(--accent);filter:drop-shadow(0 0 10px rgba(56,189,248,0.45));"></i> API Developer</h2>
  <span class="badge badge-bmkg"><i class="fas fa-globe"></i> REST · GraphQL · WebSocket</span>
</div>

<div class="w-card" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:10px;"><i class="fas fa-rocket" style="color:var(--accent);"></i> Quick Start</h3>
  <p style="font-size:14px;color:var(--muted);line-height:1.7;margin-bottom:16px;">Dapatkan data cuaca real-time untuk seluruh Indonesia dengan API publik WeatherLive. Semua endpoint gratis tanpa API key untuk data publik.</p>
  <div class="code-block"># Base URL
https://weatherlive-id.com/api

# Contoh: Cuaca saat ini untuk Jakarta
curl "https://weatherlive-id.com/api/weather/current?location_id=1"

# Contoh: Prakiraan 7 hari
curl "https://weatherlive-id.com/api/weather/forecast/daily?days=7"

# Contoh: Kualitas udara
curl "https://weatherlive-id.com/api/weather/air-quality"</div>
</div>

<div class="w-card" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-exchange-alt" style="color:var(--accent);"></i> REST API Endpoints</h3>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/current</span> <span style="font-size:12px;color:var(--muted);">— Cuaca saat ini (suhu, kelembapan, angin, tekanan, UV, visibility)</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/forecast/hourly</span> <span style="font-size:12px;color:var(--muted);">— Prakiraan per jam (24-72 jam)</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/forecast/daily</span> <span style="font-size:12px;color:var(--muted);">— Prakiraan harian (7-30 hari)</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/air-quality</span> <span style="font-size:12px;color:var(--muted);">— AQI, PM2.5, PM10, NO2, SO2, CO, O3</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/marine</span> <span style="font-size:12px;color:var(--muted);">— Gelombang, arus, pasang surut, suhu laut</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/pollen</span> <span style="font-size:12px;color:var(--muted);">— Serbuk sari (alder, birch, grass, ragweed)</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/aviation</span> <span style="font-size:12px;color:var(--muted);">— METAR, TAF, runway wind, crosswind</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/hiking</span> <span style="font-size:12px;color:var(--muted);">— Kondisi pendakian, avalanche risk</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/weather/surf</span> <span style="font-size:12px;color:var(--muted);">— Surf forecast, swell, rating</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/search/suggestions?q=jakarta</span> <span style="font-size:12px;color:var(--muted);">— Pencarian instan lokasi</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/dashboard/overview</span> <span style="font-size:12px;color:var(--muted);">— Ringkasan dashboard lengkap</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/alerts/active</span> <span style="font-size:12px;color:var(--muted);">— Peringatan dini cuaca ekstrem</span></div>
  <div class="api-row"><span class="api-method get">GET</span> <span class="endpoint">/api/predictions/accuracy/stats</span> <span style="font-size:12px;color:var(--muted);">— Statistik akurasi prediksi AI</span></div>
</div>

<div class="w-card" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-code" style="color:var(--accent);"></i> SDK Examples</h3>
  <div class="sdk-tab">
    <button v-for="sdk in sdks" :key="sdk.id" :class="{active:activeSdk===sdk.id}" @click="activeSdk=sdk.id"><i :class="sdk.icon"></i> @{{ sdk.name }}</button>
  </div>
  <div class="code-block" v-html="activeSdkCode"></div>
</div>

<div class="w-card" style="margin-bottom:18px;">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-bolt" style="color:var(--accent);"></i> GraphQL</h3>
  <div class="code-block"># Query contoh
query {
  weather(location: "jakarta") {
    temperature
    humidity
    windSpeed
    airQuality { aqi pm25 }
    forecast(days: 7) { date tempMax tempMin }
  }
}

# Endpoint
POST /graphql
Content-Type: application/json</div>
</div>

<div class="w-card">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px;"><i class="fas fa-satellite-dish" style="color:var(--accent);"></i> WebSocket Realtime</h3>
  <div class="code-block">// Update cuaca real-time untuk lokasi tertentu
const ws = new WebSocket("wss://weatherlive-id.com/ws/weather?location_id=1");

ws.onmessage = (event) => {
  const data = JSON.parse(event.data);
  console.log("Update cuaca:", data.temperature, data.weather);
};

// Event: weather.update, alert.new, aqi.change</div>
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
const activeSdk=ref('js');
const sdks=ref([
{id:'js',name:'JavaScript',icon:'fab fa-js',code:`// JavaScript SDK
import { WeatherClient } from '@weatherlive/sdk';

const client = new WeatherClient({ apiKey: 'YOUR_API_KEY' });

// Cuaca saat ini
const weather = await client.current('jakarta');
console.log(weather.temperature, weather.weather);

// Prakiraan 7 hari
const forecast = await client.forecast('jakarta', { days: 7 });
console.log(forecast);

// Subscribe realtime
const unsub = client.subscribe('jakarta', (update) => {
  console.log('Update:', update.temperature);
});`},
{id:'python',name:'Python',icon:'fab fa-python',code:`# Python SDK
from weatherlive import WeatherClient

client = WeatherClient(api_key="YOUR_API_KEY")

# Cuaca saat ini
weather = client.current("jakarta")
print(weather.temperature, weather.weather)

# Prakiraan
forecast = client.forecast("jakarta", days=7)
for day in forecast:
    print(day.date, day.temp_max, day.temp_min)

# Kualitas udara
aqi = client.air_quality("jakarta")
print(aqi.aqi, aqi.pm25)`},
{id:'flutter',name:'Flutter',icon:'fab fa-flutter',code:`// Flutter SDK
import 'package:weatherlive/weatherlive.dart';

final client = WeatherClient(apiKey: 'YOUR_API_KEY');

// Cuaca saat ini
final weather = await client.current('jakarta');
print('\${weather.temperature}°C - \${weather.weather}');

// Prakiraan 7 hari
final forecast = await client.forecast('jakarta', days: 7);
forecast.forEach((d) => print('\${d.date}: \${d.tempMax}°C'));

// Widget bawaan
WeatherCard(location: 'jakarta', type: WeatherType.detailed);`},
{id:'kotlin',name:'Kotlin',icon:'fab fa-kotlin',code:`// Kotlin SDK
import com.weatherlive.sdk.WeatherClient

val client = WeatherClient(apiKey = "YOUR_API_KEY")

// Cuaca saat ini
val weather = client.current("jakarta")
println("\${weather.temperature}°C - \${weather.weather}")

// Prakiraan 7 hari
val forecast = client.forecast("jakarta", days = 7)
forecast.forEach { println("\${it.date}: \${it.tempMax}°C") }

// Realtime
client.subscribe("jakarta") { update ->
    println("Update: \${update.temperature}")
}`},
{id:'swift',name:'Swift',icon:'fab fa-swift',code:`// Swift SDK
import WeatherLive

let client = WeatherClient(apiKey: "YOUR_API_KEY")

// Cuaca saat ini
let weather = try await client.current("jakarta")
print("\\(weather.temperature)°C - \\(weather.weather)")

// Prakiraan 7 hari
let forecast = try await client.forecast("jakarta", days: 7)
forecast.forEach { print("\\($0.date): \\($0.tempMax)°C") }

// Subscribe realtime
client.subscribe("jakarta") { update in
    print("Update: \\(update.temperature)")
}`},
]);
const activeSdkName=computed(()=>{const s=sdks.value.find(x=>x.id===activeSdk.value);return s?s.name:'';});
const activeSdkCode=computed(()=>{const s=sdks.value.find(x=>x.id===activeSdk.value);return s?s.code:'';});
onMounted(()=>{if(isDark.value)document.documentElement.classList.add('dark');});
return{isDark,activeSdk,sdks,activeSdkName,activeSdkCode};}}).mount('#dev-app');
</script>
@endpush

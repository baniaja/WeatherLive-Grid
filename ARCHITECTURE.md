# WeatherLive-Grid — Enterprise Architecture (v2.0)

> **Role:** Software Architect
> **Vision:** Platform cuaca nasional Indonesia kelas dunia melampaui Apple Weather, Windy, Ventusky, Weather.com, AccuWeather, Meteoblue, Zoom Earth, BMKG, dan lainnya.
> **Prinsip:** Production-grade. Tidak ada dummy. Tidak ada placeholder. Tidak ada section kosong. Semua widget berfungsi nyata. Jika data tidak tersedia → fallback provider. Tidak pernah menghapus fitur lama — selalu menambah.

---

## 1. Arsitektur Aplikasi (Folder, Modul, Dependency)

### 1.1 Stack Utama
| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.3) + MySQL/PostgreSQL |
| Frontend | React 18 + TypeScript + Tailwind CSS v4 + Shadcn UI |
| State/Data | TanStack Query + Zustand |
| Animasi | GSAP + Framer Motion (Motion) + Lottie + Three.js + Canvas/WebGL |
| Map | Leaflet + Mapbox GL + Three.js (Globe) |
| Chart | ECharts + Chart.js |
| Realtime | SSE + WebSocket + Redis (pub/sub) |
| Cache | Redis Cache + IndexedDB (offline) |
| PWA | Service Worker + manifest + offline mode |
| Build | Vite + Laravel Mix/inertia |

### 1.2 Struktur Folder Backend (Laravel)
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Web/                    # Blade/SSR controllers
│   │   └── Api/
│   │       ├── DashboardController.php
│   │       ├── WeatherController.php
│   │       ├── ForecastController.php
│   │       ├── MapController.php
│   │       ├── SearchController.php
│   │       ├── RadarController.php
│   │       ├── SatelliteController.php
│   │       ├── MarineController.php
│   │       ├── AviationController.php
│   │       ├── DisasterController.php
│   │       ├── ClimateController.php
│   │       ├── AIAssistantController.php
│   │       ├── AnalyticsController.php
│   │       └── WidgetController.php
│   └── Middleware/
├── Services/
│   ├── Providers/
│   │   ├── OpenMeteoService.php
│   │   ├── BMKGService.php
│   │   ├── ECMWFService.php
│   │   ├── NOAAService.php
│   │   ├── NASAService.php          # NASA POWER, EarthData
│   │   ├── RainViewerService.php
│   │   ├── OpenAQService.php
│   │   ├── USGSGDACSService.php     # Gempa, tsunami, GDACS
│   │   ├── EMSCVolcanoService.php
│   │   ├── GlobalForestWatchService.php
│   │   ├── WindyTilesService.php
│   │   ├── AviationService.php
│   │   ├── MarineTrafficService.php
│   │   └── AbstractProvider.php      # Fallback chain
│   ├── Search/
│   │   ├── SearchIndexService.php
│   │   ├── GeocoderService.php
│   │   ├── FuzzyMatcher.php
│   │   └── Ranker.php
│   ├── Analytics/
│   │   ├── MLTrendService.php
│   │   └── EnsembleForecastService.php
│   └── AI/
│       ├── CopilotEngine.php
│       └── RecommendationEngine.php
├── Events/ + Listeners/
├── Jobs/                          # FetchWeatherData, SyncProviders
├── Console/Commands/              # provider:sync, widget:crawl
└── Models/
```

### 1.3 Struktur Folder Frontend (React)
```
resources/react/
├── src/
│   ├── app/                       # Routing, providers, layout
│   ├── components/
│   │   ├── ui/                    # Shadcn primitives (Button, Card, Dialog...)
│   │   ├── widgets/               # 100+ individual widgets
│   │   ├── charts/                # ECharts/Chart.js wrappers
│   │   ├── maps/                  # Mapbox GL, Leaflet, Globe
│   │   └── motion/                # GSAP, Framer Motion helpers
│   ├── features/
│   │   ├── dashboard/
│   │   ├── maps/
│   │   ├── forecast/
│   │   ├── search/
│   │   ├── analytics/
│   │   ├── ai-copilot/
│   │   ├── marine/
│   │   ├── aviation/
│   │   └── disaster/
│   ├── hooks/
│   ├── lib/                       # api client, utils
│   ├── store/                     # Zustand stores
│   └── styles/
├── package.json
└── vite.config.ts
```

---

## 2. Daftar Halaman & Modul

### 2.1 Halaman Utama
| Route | Halaman | Modul |
|-------|---------|-------|
| `/dashboard` | Dashboard 80+ widget | Dashboard |
| `/maps` | Peta interaktif setara Windy | Maps |
| `/forecast` | Prakiraan (hourly/daily/weekly) | Forecast |
| `/analytics` | Analytics lengkap | Analytics |
| `/search` | Search engine enterprise | Search |
| `/ai-copilot` | AI Weather Copilot | AI |
| `/radar` | Live Radar | Radar |
| `/satellite` | Live Satellite | Satellite |
| `/marine` | Marine Dashboard | Marine |
| `/aviation` | Aviation Dashboard | Aviation |
| `/disaster` | Gempa/Volcano/Banjir/Tsunami | Disaster |
| `/climate` | Climate/ENSO/IOD | Climate |
| `/airquality` | Kualitas Udara/AQI | AirQuality |
| `/astronomy` | Sun/Moon/Aurora calendar | Astronomy |
| `/history` | Historical weather | History |
| `/developer` | API docs | Developer |
| `/settings` | Customization | Settings |

### 2.2 Modul Data Provider (Fallback Chain)
1. **BMKG** — gempa, prakiraan resmi Indonesia, peringatan dini
2. **Open-Meteo** — current/hourly/daily, marine, air quality, pollen
3. **ECMWF** — global reanalysis, ensemble
4. **NOAA/NASA POWER** — solar radiation, historical climate
5. **RainViewer** — live radar tiles
6. **OpenAQ / WAQI** — AQI realtime
7. **USGS / GDACS / EMSC** — gempa, tsunami, volcano
8. **Global Forest Watch** — wildfire/fires
9. **Windy Tiles** — wind/cloud map layers
10. **Aviation Weather Center** — METAR/TAF
11. **MarineTraffic / ADS-B** — ship/aircraft

---

## 3. Desain Sistem & Database

### 3.1 Database (tables)
```
- provinces, cities, districts, villages, locations
- weather_history, weather_predictions, weather_alerts
- weather_accuracy, weather_stations, weather_sensors
- widgets                    (user widget config)
- widget_layouts             (dashboard layout grid)
- search_suggestions         (cached search)
- user preferences, favorites
- aqi_snapshots, marine_snapshots, aviation_snapshots
- disaster_events            (gempa/volcano/flood/tsunami)
- climate_indices            (ENSO, IOD, SOI)
- ai_conversations, ai_cache
- api_calls_log              (monitoring)
- provider_status            (health check)
```

### 3.2 Caching & Realtime
- **Redis** untuk API responses, search index, live widgets
- **SSE (Server-Sent Events)** untuk push live updates ke dashboard
- **WebSocket** untuk chat copilot & map realtime
- **IndexedDB** untuk offline mode & cache widget

---

## 4. UI Design System

### 4.1 Warna
```
--primary: #2563EB (blue)
--secondary: #38BDF8 (sky)
--accent: #7C3AED (violet)
--success: #22C55E
--warning: #F59E0B
--danger: #EF4444
--info: #06B6D4
--bg-dark: #081A2F
--glass: rgba(255,255,255,0.08)
--gradient: linear-gradient(135deg,#38BDF8,#2563EB,#7C3AED)
```

### 4.2 Typography
```
Display: 'Space Grotesk' — headings, hero numbers
Body:    'Inter'         — UI, text
Mono:    'JetBrains Mono'— data, METAR, coordinates
```

### 4.3 Komponen (Shadcn)
`Button, Card, Dialog, Dropdown, Tooltip, Tabs, Sheet, Toast, Switch, Slider, Select, Input, Badge, Skeleton, Progress, Accordion, Collapsible, Resizable, ContextMenu, ScrollArea`

---

## 5. Layout Dashboard (Widget Grid)

- **Grid System:** 12-col draggable + resizable (react-grid-layout)
- **Kontrol per widget:** drag handle, resize, collapse, fullscreen, export (PNG/PDF/CSV), refresh
- **Add Widget Panel:** katalog 100+ widget, seret ke grid
- **Layout Persist:** simpan ke server (per user) + IndexedDB
- **Live Badge:** setiap widget punya status realtime (SSE push)

---

## 6. Roadmap Implementasi (per Modul)

### Phase 1 — Foundation
1. Setup Laravel 12 + React + TS + Tailwind v4 + Shadcn
2. Provider abstraction + fallback chain (`AbstractProvider`)
3. Database migration (widgets, ais, snapshots, disaster)
4. Design system (tokens, components, motion libs)

### Phase 2 — Dashboard Core
5. Widget grid (drag/resize/collapse/fullscreen/export)
6. 80+ widget dari data Open-Meteo + fallback
7. SSE realtime refresh + animated counters

### Phase 3 — Maps (Windy-level)
8. Mapbox GL + layers (radar, satellite, wind, cloud, rain, AQI, temp, pressure, humidity, wildfire, volcano, earthquake, cyclone, ocean, wave, swell, lightning, marine, flight, 3D globe)
9. Timeline + heatmap + night/aurora

### Phase 4 — Search Engine
10. Autocomplete, fuzzy, typo, ranking, AI recommend, voice, image/OCR, coordinate, postal, airport, harbor, mountain, volcano, river, island, station, marine, flight, disaster, multi-language

### Phase 5 — AI Copilot
11. Chat engine (read radar, satellite, recommend travel/camping/fishing/hiking/flight/driving/agriculture/marine/health/fashion/sports/photography/event/disaster)

### Phase 6 — Analytics & Climate
12. Temperature/humidity/pressure/rain/wind/lightning/AQI/cloud/visibility/UV/pollen/heat index/storm/cyclone/volcano/earthquake/flood/tsunami/climate/ENSO/IOD/seasonal/historical/prediction/AI forecast/ML trend

### Phase 7 — Advanced Widgets
13. Live Radar, Satellite, Wind Rose, Aurora, Lightning, Wave, Tide, Ocean Current, Fishing/Running/Farming Index, Aviation, Marine, Earthquake/Volcano/Flood/Tsunami/Wildfire Feed, ENSO/El Nino/La Nina, Climate, Historical, Camera/CCTV, AQI Ranking, Solar Radiation, Dew Point, Freezing Level, CAPE, Lifted/Convective Index, Jet Stream, Snow Depth, Soil Moisture/Temp, Leaf Wetness, Evapotranspiration, UV Exposure, Moon/Sun Calendar, Golden/Blue Hour

### Phase 8 — Production
14. PWA + offline + SSR + lazy load + virtualization + Redis + SSE/WebSocket + monitoring + CI/CD

---

## 7. Widget Katalog (100+)

Live Radar · Live Satellite · Wind Rose · Aurora Forecast · Lightning · Wave Height · Tide · Ocean Current · Fishing Index · Running Index · Farming Index · Aviation Dashboard · Marine Dashboard · Earthquake Feed · Volcano Feed · Flood Feed · Tsunami Feed · Wildfire Feed · ENSO Dashboard · El-Nino · La-Nina · Climate Dashboard · Historical Weather · Weather Camera · CCTV · AQI Ranking · Solar Radiation · Dew Point · Freezing Level · CAPE · Lifted Index · Convective Index · Jet Stream · Snow Depth · Soil Moisture · Soil Temperature · Leaf Wetness · Evapotranspiration · UV Exposure · Moon Calendar · Sun Calendar · Golden Hour · Blue Hour · Current Temp · Feels Like · Humidity · Pressure · Wind Speed · Wind Gust · Wind Direction · Cloud Cover · Visibility · Rain 1h · Rain Prob · Snow · Heat Index · Comfort Index · UV Index · Pollen · Air Quality (PM2.5/PM10/O3/NO2/SO2/CO) · Weather Icon · Sunrise · Sunset · Moonrise · Moonset · Moon Phase · ISS Tracker · Planet Position · Meteor Shower · Marine Wave · Marine Swell · Sea Temp · Tide · Fishing Index · Aviation METAR · Aviation TAF · Crosswind · Cloud Base · Freezing Level · Flight Risk · Jet Stream · Earthquake Alert · Volcano Alert · Flood Alert · Tsunami Alert · Wildfire Alert · Cyclone Track · Storm Radar · Seasonal Forecast · Climate Index · ENSO · IOD · Historical Trend · AI Forecast · ML Prediction · Rainfall Accumulation · Temperature Anomaly · Precipitation Probability · Satellite RGB · Cloud Temp · IR Band · Water Vapor · Lightning Count · Storm Cell ·

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\PortalFeature;
use App\Models\WeatherBulletin;
use Illuminate\Support\Str;

class CmsAndFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings
        $settings = [
            'site_name' => 'WeatherLive Grid Enterprise',
            'site_announcement' => '🔴 [LIVE BMKG] Monitoring Real-time 38 Provinsi: Siklon tropis terpantau menjauhi perairan selatan. Waspada gelombang tinggi di perairan Samudera Hindia.',
            'hero_headline' => 'Sistem Intelijen Cuaca & Iklim Nasional Berbasis AI',
            'hero_subheadline' => 'Platform meteorologi terintegrasi yang menyatukan 18 Stasiun BMKG, 108 Sensor IoT real-time, citra radar satelit, dan prediksi cuaca presisi tinggi untuk seluruh Indonesia.',
            'bulletin_title' => 'Analisis Peralihan Musim (Pancaroba) & Potensi Cuaca Ekstrem',
            'bulletin_desc' => 'BMKG Pusat mengimbau seluruh masyarakat dan pemangku kepentingan untuk meningkatkan kesiapsiagaan menghadapi potensi cuaca ekstrem seperti hujan lebat sesaat disertai kilat/petir dan angin kencang puting beliung.',
            'emergency_status' => 'normal', // normal, alert, critical
            'primary_theme' => 'cyber_glass',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'general', 'label' => ucwords(str_replace('_', ' ', $key))]
            );
        }

        // 2. Portal Features for Users
        $features = [
            [
                'title' => 'Radar Himawari-9 HD',
                'description' => 'Citra satelit awan inframerah & uap air resolusi tinggi diperbarui setiap 10 menit.',
                'icon' => 'ri-radar-line',
                'badge' => 'LIVE HD',
                'url' => '/peta',
                'category' => 'Observasi',
                'order_index' => 1
            ],
            [
                'title' => 'Prakiraan Cuaca 7 Hari',
                'description' => 'Model ensemble ECMWF + GFS resolusi kecamatan dengan probabilitas presipitasi.',
                'icon' => 'ri-sun-cloudy-line',
                'badge' => 'PREDIKSI',
                'url' => '/prakiraan',
                'category' => 'Prakiraan',
                'order_index' => 2
            ],
            [
                'title' => 'Kualitas Udara & Indeks Polusi',
                'description' => 'Pemantauan konsentrasi PM2.5, PM10, AQI serta rekomendasi kesehatan aktivitas luar ruang.',
                'icon' => 'ri-bubble-chart-line',
                'badge' => 'AQI REAL-TIME',
                'url' => '/kualitas-udara',
                'category' => 'Lingkungan',
                'order_index' => 3
            ],
            [
                'title' => 'Peringatan Gempa & Tsunami',
                'description' => 'Telemetri seismik M 5.0+, kedalaman pusat gempa, dan estimasi waktu gelombang.',
                'icon' => 'ri-pulse-line',
                'badge' => 'BMKG RESMI',
                'url' => '/gempa',
                'category' => 'Geofisika',
                'order_index' => 4
            ],
            [
                'title' => 'Navigasi Maritim & Gelombang',
                'description' => 'Peta tinggi gelombang signifikan, arus permukaan, dan peringatan pelayaran.',
                'icon' => 'ri-ship-line',
                'badge' => 'PELAYARAN',
                'url' => '/maritim',
                'category' => 'Sektoral',
                'order_index' => 5
            ],
            [
                'title' => 'Meteorologi Penerbangan',
                'description' => 'Feed data METAR/TAF bandara internasional, wind shear, dan ketinggian awan dasar.',
                'icon' => 'ri-flight-takeoff-line',
                'badge' => 'AVIASI',
                'url' => '/penerbangan',
                'category' => 'Sektoral',
                'order_index' => 6
            ],
            [
                'title' => 'Rute Pendakian Gunung',
                'description' => 'Monitoring kondisi puncak gunung, suhu chilling factor, dan indeks risiko hipotermia.',
                'icon' => 'ri-landscape-line',
                'badge' => 'OUTDOOR',
                'url' => '/pendakian',
                'category' => 'Outdoor',
                'order_index' => 7
            ],
            [
                'title' => 'Analitik Iklim & Tren Big Data',
                'description' => 'Visualisasi komparatif curah hujan historis, anomali suhu, dan model pembelajaran mesin.',
                'icon' => 'ri-line-chart-line',
                'badge' => 'AI ANALYTICS',
                'url' => '/analitik',
                'category' => 'Analitik',
                'order_index' => 8
            ]
        ];

        foreach ($features as $feat) {
            PortalFeature::updateOrCreate(
                ['slug' => Str::slug($feat['title'])],
                array_merge($feat, [
                    'slug' => Str::slug($feat['title']),
                    'is_active' => true,
                    'target_role' => 'all'
                ])
            );
        }

        // 3. Bulletins
        $bulletins = [
            [
                'title' => 'Peringatan Gelombang Tinggi 2.5 - 4.0 Meter di Samudera Hindia',
                'category' => 'Maritim',
                'summary' => 'Pola angin di wilayah Indonesia bagian utara umumnya bergerak dari Timur Laut ke Timur dengan kecepatan 6 - 20 knot.',
                'content' => 'Masyarakat pesisir dan operator perahu nelayan, kapal tongkang, serta kapal ferry diimbau untuk memperhatikan risiko tinggi terhadap keselamatan pelayaran.',
                'author' => 'Pusat Meteorologi Maritim BMKG',
                'severity' => 'warning',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Aktivitas Monsun Asia Aktif: Peningkatan Potensi Hujan di Pulau Jawa',
                'category' => 'Cuaca Ekstrem',
                'summary' => 'Bibit siklon tropis memicu konvergensi angin sepanjang selat Sunda hingga Laut Jawa bagian barat.',
                'content' => 'Waspadai potensi banjir kilat, tanah longsor di area lereng curam, serta pohon tumbang akibat hembusan angin kencang mendadak.',
                'author' => 'Deputi Bidang Meteorologi',
                'severity' => 'danger',
                'is_published' => true,
                'published_at' => now()->subHours(2),
            ]
        ];

        foreach ($bulletins as $bulletin) {
            WeatherBulletin::updateOrCreate(
                ['title' => $bulletin['title']],
                $bulletin
            );
        }
    }
}

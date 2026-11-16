<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\WeatherStation;
use App\Models\WeatherSensor;
use App\Models\ApiLog;
use Illuminate\Database\Seeder;

class WeatherStationAndSensorSeeder extends Seeder
{
    public function run(): void
    {
        $defaultLoc = Location::first();
        $defaultLocId = $defaultLoc ? $defaultLoc->id : 1;

        $stationsData = [
            [
                'name' => 'Stasiun Geofisika Bandung',
                'code' => 'STG-BDG-01',
                'latitude' => -6.8833,
                'longitude' => 107.5972,
                'elevation' => 791,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG Wilayah II',
                'metadata' => ['installed_year' => 2018, 'contact' => 'stageof.bandung@bmkg.go.id']
            ],
            [
                'name' => 'Stasiun Klimatologi Jawa Barat (Bogor)',
                'code' => 'STK-BGR-02',
                'latitude' => -6.5433,
                'longitude' => 106.7547,
                'elevation' => 260,
                'type' => 'SYNOP',
                'status' => 'active',
                'provider' => 'BMKG Wilayah II',
                'metadata' => ['installed_year' => 2015, 'contact' => 'staklim.bogor@bmkg.go.id']
            ],
            [
                'name' => 'Stasiun Meteorologi Kertajati Majalengka',
                'code' => 'STM-KJT-03',
                'latitude' => -6.6575,
                'longitude' => 108.1994,
                'elevation' => 38,
                'type' => 'AEROLOGI',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2019, 'contact' => 'stameteo.kertajati@bmkg.go.id']
            ],
            [
                'name' => 'Stasiun Meteorologi Maritim Cirebon',
                'code' => 'SMM-CRB-04',
                'latitude' => -6.7125,
                'longitude' => 108.5714,
                'elevation' => 4,
                'type' => 'MARITIM',
                'status' => 'active',
                'provider' => 'BMKG Maritim',
                'metadata' => ['installed_year' => 2016, 'contact' => 'stamar.cirebon@bmkg.go.id']
            ],
            [
                'name' => 'Stasiun Geofisika Palabuhanratu Sukabumi',
                'code' => 'STG-SKB-05',
                'latitude' => -6.9872,
                'longitude' => 106.5489,
                'elevation' => 15,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG Wilayah II',
                'metadata' => ['installed_year' => 2020, 'contact' => 'stageof.sukabumi@bmkg.go.id']
            ],
            [
                'name' => 'AWS Margahayu Bandung Selatan',
                'code' => 'AWS-MGH-06',
                'latitude' => -6.9754,
                'longitude' => 107.6789,
                'elevation' => 670,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2021]
            ],
            [
                'name' => 'AWS Lembang Geofisika',
                'code' => 'AWS-LBG-07',
                'latitude' => -6.8167,
                'longitude' => 107.6167,
                'elevation' => 1250,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2020]
            ],
            [
                'name' => 'AWS Telukjambe Karawang',
                'code' => 'AWS-KRW-08',
                'latitude' => -6.3267,
                'longitude' => 107.3114,
                'elevation' => 28,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2022]
            ],
            [
                'name' => 'AWS Pantai Pangandaran',
                'code' => 'AWS-PGD-09',
                'latitude' => -7.7011,
                'longitude' => 108.4947,
                'elevation' => 5,
                'type' => 'MARITIM',
                'status' => 'active',
                'provider' => 'BMKG Maritim',
                'metadata' => ['installed_year' => 2021]
            ],
            [
                'name' => 'AWS Tarogong Kaler Garut',
                'code' => 'AWS-GRT-10',
                'latitude' => -7.1856,
                'longitude' => 107.8923,
                'elevation' => 715,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2021]
            ],
            [
                'name' => 'AWS Margonda Raya Depok',
                'code' => 'AWS-DPK-11',
                'latitude' => -6.3725,
                'longitude' => 106.8319,
                'elevation' => 95,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2022]
            ],
            [
                'name' => 'AWS Tambun Selatan Bekasi',
                'code' => 'AWS-BKS-12',
                'latitude' => -6.2628,
                'longitude' => 107.0583,
                'elevation' => 22,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2021]
            ],
            [
                'name' => 'AWS Puncak Pass Cianjur',
                'code' => 'AWS-CJR-13',
                'latitude' => -6.7025,
                'longitude' => 106.9856,
                'elevation' => 1450,
                'type' => 'AWS',
                'status' => 'maintenance',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2019]
            ],
            [
                'name' => 'AWS Patimban Deepsea Port Subang',
                'code' => 'AWS-SBG-14',
                'latitude' => -6.2367,
                'longitude' => 107.9042,
                'elevation' => 2,
                'type' => 'MARITIM',
                'status' => 'active',
                'provider' => 'BMKG Maritim',
                'metadata' => ['installed_year' => 2022]
            ],
            [
                'name' => 'AWS Gunung Ciremai Kuningan',
                'code' => 'AWS-KNG-15',
                'latitude' => -6.9014,
                'longitude' => 108.4089,
                'elevation' => 1100,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2020]
            ],
            [
                'name' => 'AWS Jatinangor Sumedang',
                'code' => 'AWS-SMD-16',
                'latitude' => -6.9283,
                'longitude' => 107.7719,
                'elevation' => 760,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2021]
            ],
            [
                'name' => 'AWS Indihiang Tasikmalaya',
                'code' => 'AWS-TSK-17',
                'latitude' => -7.2956,
                'longitude' => 108.2014,
                'elevation' => 350,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2020]
            ],
            [
                'name' => 'AWS Ciamis Kota',
                'code' => 'AWS-CMS-18',
                'latitude' => -7.3256,
                'longitude' => 108.3531,
                'elevation' => 210,
                'type' => 'AWS',
                'status' => 'active',
                'provider' => 'BMKG',
                'metadata' => ['installed_year' => 2023]
            ],
        ];

        foreach ($stationsData as $data) {
            $data['location_id'] = $defaultLocId;
            WeatherStation::updateOrCreate(['code' => $data['code']], $data);
        }

        // Seed Sensors
        $sensorTypes = [
            ['type' => 'temperature_humidity', 'model' => 'Sensirion SHT35 Precision Temp/RH', 'prefix' => 'TH'],
            ['type' => 'ultrasonic_wind', 'model' => 'Gill WindSonic 2D Anemometer', 'prefix' => 'WS'],
            ['type' => 'tipping_rain_gauge', 'model' => 'Davis Aerocon Rain Collector 0.2mm', 'prefix' => 'RG'],
            ['type' => 'barometric_pressure', 'model' => 'Bosch Sensortec BMP390 Baro', 'prefix' => 'BP'],
            ['type' => 'solar_uv_radiation', 'model' => 'Kipp & Zonen CMP3 Pyranometer', 'prefix' => 'UV'],
            ['type' => 'air_quality_particulate', 'model' => 'Plantower PMS5003 Optical PM2.5/PM10', 'prefix' => 'AQ'],
        ];

        $allStations = WeatherStation::all();
        $idx = 100;
        foreach ($allStations as $st) {
            foreach ($sensorTypes as $stype) {
                WeatherSensor::updateOrCreate(
                    ['sensor_id' => $stype['prefix'] . '-' . $st->code],
                    [
                        'name' => 'Sensor ' . ucwords(str_replace('_', ' ', $stype['type'])) . ' — ' . $st->name,
                        'location_id' => $defaultLocId,
                        'type' => $stype['type'],
                        'model' => $stype['model'],
                        'status' => ($st->status === 'active') ? 'active' : 'maintenance',
                        'config' => ['sampling_rate_sec' => 60, 'calibrated_at' => '2026-01-15'],
                        'last_reading_at' => now(),
                    ]
                );
            }
        }

        // Seed API Logs for real monitoring
        $endpoints = [
            ['/api/weather/current', 'GET', 1420, 38.4, 112.0],
            ['/api/alerts/active', 'GET', 980, 24.1, 85.0],
            ['/api/dashboard/overview', 'GET', 860, 42.6, 145.0],
            ['/api/ai/chat', 'POST', 540, 120.2, 380.0],
            ['/api/weather/forecast/hourly', 'GET', 490, 32.5, 96.0],
            ['/api/enterprise/earthquakes', 'GET', 320, 55.1, 180.0],
            ['/api/jabar/overview', 'GET', 280, 48.0, 130.0],
            ['/api/admin/recap', 'GET', 190, 65.2, 195.0],
        ];

        foreach ($endpoints as $ep) {
            for ($i = 0; $i < 4; $i++) {
                ApiLog::create([
                    'endpoint' => $ep[0],
                    'method' => $ep[1],
                    'response_code' => 200,
                    'response_time' => $ep[3] + rand(-5, 12),
                    'status' => 'success',
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subMinutes(rand(1, 180)),
                ]);
            }
        }

        echo "Seeded " . count($stationsData) . " weather stations, " . WeatherSensor::count() . " IoT sensors, and sample API logs successfully!\n";
    }
}

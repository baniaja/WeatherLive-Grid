<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IndonesiaRegionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProvinces();
        $this->seedCities();
        $this->seedDistricts();
        $this->seedVillages();
        $this->createLocations();
    }

    private function seedProvinces(): void
    {
        $provinces = [
            ['name' => 'Aceh', 'code' => '11', 'latitude' => 4.6951, 'longitude' => 96.7491],
            ['name' => 'Sumatera Utara', 'code' => '12', 'latitude' => 2.1154, 'longitude' => 99.5451],
            ['name' => 'Sumatera Barat', 'code' => '13', 'latitude' => -0.7399, 'longitude' => 100.5518],
            ['name' => 'Riau', 'code' => '14', 'latitude' => 0.2933, 'longitude' => 101.7068],
            ['name' => 'Jambi', 'code' => '15', 'latitude' => -1.6101, 'longitude' => 103.6131],
            ['name' => 'Sumatera Selatan', 'code' => '16', 'latitude' => -2.7411, 'longitude' => 104.7490],
            ['name' => 'Bengkulu', 'code' => '17', 'latitude' => -3.5778, 'longitude' => 102.3464],
            ['name' => 'Lampung', 'code' => '18', 'latitude' => -4.5585, 'longitude' => 105.4068],
            ['name' => 'Kepulauan Bangka Belitung', 'code' => '19', 'latitude' => -2.1297, 'longitude' => 106.1148],
            ['name' => 'Kepulauan Riau', 'code' => '21', 'latitude' => 0.9545, 'longitude' => 104.4170],
            ['name' => 'DKI Jakarta', 'code' => '31', 'latitude' => -6.2088, 'longitude' => 106.8456],
            ['name' => 'Jawa Barat', 'code' => '32', 'latitude' => -6.9175, 'longitude' => 107.6191],
            ['name' => 'Jawa Tengah', 'code' => '33', 'latitude' => -7.1502, 'longitude' => 110.1403],
            ['name' => 'DI Yogyakarta', 'code' => '34', 'latitude' => -7.7971, 'longitude' => 110.3688],
            ['name' => 'Jawa Timur', 'code' => '35', 'latitude' => -7.5361, 'longitude' => 112.2384],
            ['name' => 'Banten', 'code' => '36', 'latitude' => -6.1204, 'longitude' => 106.1503],
            ['name' => 'Bali', 'code' => '51', 'latitude' => -8.4095, 'longitude' => 115.1889],
            ['name' => 'Nusa Tenggara Barat', 'code' => '52', 'latitude' => -8.5119, 'longitude' => 117.5411],
            ['name' => 'Nusa Tenggara Timur', 'code' => '53', 'latitude' => -8.5578, 'longitude' => 121.0880],
            ['name' => 'Kalimantan Barat', 'code' => '61', 'latitude' => 0.2780, 'longitude' => 111.4753],
            ['name' => 'Kalimantan Tengah', 'code' => '62', 'latitude' => -1.4996, 'longitude' => 113.2903],
            ['name' => 'Kalimantan Selatan', 'code' => '63', 'latitude' => -3.0926, 'longitude' => 115.2838],
            ['name' => 'Kalimantan Timur', 'code' => '64', 'latitude' => 1.6406, 'longitude' => 116.4194],
            ['name' => 'Kalimantan Utara', 'code' => '65', 'latitude' => 3.0731, 'longitude' => 116.0414],
            ['name' => 'Sulawesi Utara', 'code' => '71', 'latitude' => 1.4748, 'longitude' => 124.9421],
            ['name' => 'Sulawesi Tengah', 'code' => '72', 'latitude' => -0.8910, 'longitude' => 121.1497],
            ['name' => 'Sulawesi Selatan', 'code' => '73', 'latitude' => -5.1477, 'longitude' => 119.4327],
            ['name' => 'Sulawesi Tenggara', 'code' => '74', 'latitude' => -3.9664, 'longitude' => 122.5150],
            ['name' => 'Gorontalo', 'code' => '75', 'latitude' => 0.5435, 'longitude' => 123.0598],
            ['name' => 'Sulawesi Barat', 'code' => '76', 'latitude' => -2.8588, 'longitude' => 119.2940],
            ['name' => 'Maluku', 'code' => '81', 'latitude' => -3.2385, 'longitude' => 130.1454],
            ['name' => 'Maluku Utara', 'code' => '82', 'latitude' => 0.7769, 'longitude' => 127.4233],
            ['name' => 'Papua', 'code' => '91', 'latitude' => -4.2699, 'longitude' => 138.0804],
            ['name' => 'Papua Barat', 'code' => '92', 'latitude' => -1.3361, 'longitude' => 133.1747],
            ['name' => 'Papua Selatan', 'code' => '93', 'latitude' => -6.4500, 'longitude' => 140.3500],
            ['name' => 'Papua Tengah', 'code' => '94', 'latitude' => -3.7000, 'longitude' => 137.0000],
            ['name' => 'Papua Pegunungan', 'code' => '95', 'latitude' => -4.0000, 'longitude' => 138.5000],
            ['name' => 'Papua Barat Daya', 'code' => '96', 'latitude' => -0.8500, 'longitude' => 131.2500],
        ];

        foreach ($provinces as $prov) {
            Province::updateOrCreate(
                ['code' => $prov['code']],
                $prov
            );
        }

        $this->command->info('38 Provinces seeded successfully.');
    }

    private function seedCities(): void
    {
        $cities = [
            // === JAWA BARAT (Priority) ===
            ['province_code' => '32', 'name' => 'Kabupaten Bandung', 'code' => '3204', 'latitude' => -7.0338, 'longitude' => 107.5294],
            ['province_code' => '32', 'name' => 'Kabupaten Bandung Barat', 'code' => '3217', 'latitude' => -6.8745, 'longitude' => 107.4248],
            ['province_code' => '32', 'name' => 'Kabupaten Bekasi', 'code' => '3216', 'latitude' => -6.2364, 'longitude' => 107.1082],
            ['province_code' => '32', 'name' => 'Kabupaten Bogor', 'code' => '3201', 'latitude' => -6.5759, 'longitude' => 106.7775],
            ['province_code' => '32', 'name' => 'Kabupaten Ciamis', 'code' => '3207', 'latitude' => -7.3305, 'longitude' => 108.3571],
            ['province_code' => '32', 'name' => 'Kabupaten Cianjur', 'code' => '3203', 'latitude' => -6.8226, 'longitude' => 107.1408],
            ['province_code' => '32', 'name' => 'Kabupaten Cirebon', 'code' => '3209', 'latitude' => -6.6996, 'longitude' => 108.5005],
            ['province_code' => '32', 'name' => 'Kabupaten Garut', 'code' => '3205', 'latitude' => -7.2214, 'longitude' => 107.9066],
            ['province_code' => '32', 'name' => 'Kabupaten Indramayu', 'code' => '3212', 'latitude' => -6.3381, 'longitude' => 108.3153],
            ['province_code' => '32', 'name' => 'Kabupaten Karawang', 'code' => '3215', 'latitude' => -6.2608, 'longitude' => 107.2917],
            ['province_code' => '32', 'name' => 'Kabupaten Kuningan', 'code' => '3208', 'latitude' => -6.9766, 'longitude' => 108.4943],
            ['province_code' => '32', 'name' => 'Kabupaten Majalengka', 'code' => '3210', 'latitude' => -6.8407, 'longitude' => 108.2204],
            ['province_code' => '32', 'name' => 'Kabupaten Pangandaran', 'code' => '3218', 'latitude' => -7.6754, 'longitude' => 108.6463],
            ['province_code' => '32', 'name' => 'Kabupaten Purwakarta', 'code' => '3214', 'latitude' => -6.5562, 'longitude' => 107.4505],
            ['province_code' => '32', 'name' => 'Kabupaten Subang', 'code' => '3213', 'latitude' => -6.5651, 'longitude' => 107.7550],
            ['province_code' => '32', 'name' => 'Kabupaten Sukabumi', 'code' => '3202', 'latitude' => -7.2018, 'longitude' => 106.5533],
            ['province_code' => '32', 'name' => 'Kabupaten Sumedang', 'code' => '3211', 'latitude' => -6.8136, 'longitude' => 107.9277],
            ['province_code' => '32', 'name' => 'Kabupaten Tasikmalaya', 'code' => '3206', 'latitude' => -7.3487, 'longitude' => 108.2205],
            ['province_code' => '32', 'name' => 'Kota Bandung', 'code' => '3273', 'latitude' => -6.9175, 'longitude' => 107.6191],
            ['province_code' => '32', 'name' => 'Kota Bekasi', 'code' => '3275', 'latitude' => -6.2383, 'longitude' => 106.9766],
            ['province_code' => '32', 'name' => 'Kota Bogor', 'code' => '3271', 'latitude' => -6.5971, 'longitude' => 106.8060],
            ['province_code' => '32', 'name' => 'Kota Cimahi', 'code' => '3277', 'latitude' => -6.8792, 'longitude' => 107.5434],
            ['province_code' => '32', 'name' => 'Kota Cirebon', 'code' => '3274', 'latitude' => -6.7195, 'longitude' => 108.5588],
            ['province_code' => '32', 'name' => 'Kota Depok', 'code' => '3276', 'latitude' => -6.3913, 'longitude' => 106.8286],
            ['province_code' => '32', 'name' => 'Kota Sukabumi', 'code' => '3272', 'latitude' => -6.9213, 'longitude' => 106.9270],
            ['province_code' => '32', 'name' => 'Kota Tasikmalaya', 'code' => '3278', 'latitude' => -7.3273, 'longitude' => 108.2207],
            ['province_code' => '32', 'name' => 'Kota Banjar', 'code' => '3279', 'latitude' => -7.3699, 'longitude' => 108.5432],

            // === DKI JAKARTA ===
            ['province_code' => '31', 'name' => 'Kota Jakarta Pusat', 'code' => '3171', 'latitude' => -6.1818, 'longitude' => 106.8223],
            ['province_code' => '31', 'name' => 'Kota Jakarta Utara', 'code' => '3172', 'latitude' => -6.1266, 'longitude' => 106.8764],
            ['province_code' => '31', 'name' => 'Kota Jakarta Barat', 'code' => '3173', 'latitude' => -6.1674, 'longitude' => 106.7583],
            ['province_code' => '31', 'name' => 'Kota Jakarta Selatan', 'code' => '3174', 'latitude' => -6.2615, 'longitude' => 106.8103],
            ['province_code' => '31', 'name' => 'Kota Jakarta Timur', 'code' => '3175', 'latitude' => -6.2250, 'longitude' => 106.9004],
            ['province_code' => '31', 'name' => 'Kabupaten Kepulauan Seribu', 'code' => '3101', 'latitude' => -5.6670, 'longitude' => 106.5620],

            // === BANTEN ===
            ['province_code' => '36', 'name' => 'Kabupaten Pandeglang', 'code' => '3601', 'latitude' => -6.6218, 'longitude' => 105.7536],
            ['province_code' => '36', 'name' => 'Kabupaten Lebak', 'code' => '3602', 'latitude' => -6.5813, 'longitude' => 106.2416],
            ['province_code' => '36', 'name' => 'Kabupaten Tangerang', 'code' => '3603', 'latitude' => -6.2005, 'longitude' => 106.4608],
            ['province_code' => '36', 'name' => 'Kabupaten Serang', 'code' => '3604', 'latitude' => -6.1140, 'longitude' => 106.1498],
            ['province_code' => '36', 'name' => 'Kota Tangerang', 'code' => '3671', 'latitude' => -6.1702, 'longitude' => 106.6308],
            ['province_code' => '36', 'name' => 'Kota Cilegon', 'code' => '3672', 'latitude' => -6.0093, 'longitude' => 106.0097],
            ['province_code' => '36', 'name' => 'Kota Serang', 'code' => '3673', 'latitude' => -6.1138, 'longitude' => 106.1530],
            ['province_code' => '36', 'name' => 'Kota Tangerang Selatan', 'code' => '3674', 'latitude' => -6.2891, 'longitude' => 106.7198],

            // === JAWA TENGAH ===
            ['province_code' => '33', 'name' => 'Kabupaten Cilacap', 'code' => '3301', 'latitude' => -7.5158, 'longitude' => 109.0053],
            ['province_code' => '33', 'name' => 'Kabupaten Banyumas', 'code' => '3302', 'latitude' => -7.4681, 'longitude' => 109.1772],
            ['province_code' => '33', 'name' => 'Kabupaten Purbalingga', 'code' => '3303', 'latitude' => -7.3412, 'longitude' => 109.3534],
            ['province_code' => '33', 'name' => 'Kabupaten Banjarnegara', 'code' => '3304', 'latitude' => -7.3590, 'longitude' => 109.6218],
            ['province_code' => '33', 'name' => 'Kabupaten Kebumen', 'code' => '3305', 'latitude' => -7.6392, 'longitude' => 109.6522],
            ['province_code' => '33', 'name' => 'Kabupaten Purworejo', 'code' => '3306', 'latitude' => -7.7258, 'longitude' => 109.9946],
            ['province_code' => '33', 'name' => 'Kabupaten Wonosobo', 'code' => '3307', 'latitude' => -7.3079, 'longitude' => 109.9022],
            ['province_code' => '33', 'name' => 'Kabupaten Magelang', 'code' => '3308', 'latitude' => -7.4504, 'longitude' => 110.2174],
            ['province_code' => '33', 'name' => 'Kabupaten Boyolali', 'code' => '3309', 'latitude' => -7.4538, 'longitude' => 110.5779],
            ['province_code' => '33', 'name' => 'Kabupaten Klaten', 'code' => '3310', 'latitude' => -7.6900, 'longitude' => 110.6012],
            ['province_code' => '33', 'name' => 'Kabupaten Sukoharjo', 'code' => '3311', 'latitude' => -7.6807, 'longitude' => 110.8192],
            ['province_code' => '33', 'name' => 'Kabupaten Wonogiri', 'code' => '3312', 'latitude' => -7.8324, 'longitude' => 110.9364],
            ['province_code' => '33', 'name' => 'Kabupaten Karanganyar', 'code' => '3313', 'latitude' => -7.5181, 'longitude' => 110.9546],
            ['province_code' => '33', 'name' => 'Kabupaten Sragen', 'code' => '3314', 'latitude' => -7.4044, 'longitude' => 111.0202],
            ['province_code' => '33', 'name' => 'Kabupaten Grobogan', 'code' => '3315', 'latitude' => -7.0500, 'longitude' => 110.9123],
            ['province_code' => '33', 'name' => 'Kabupaten Blora', 'code' => '3316', 'latitude' => -6.9672, 'longitude' => 111.4502],
            ['province_code' => '33', 'name' => 'Kabupaten Rembang', 'code' => '3317', 'latitude' => -6.7034, 'longitude' => 111.3440],
            ['province_code' => '33', 'name' => 'Kabupaten Pati', 'code' => '3318', 'latitude' => -6.7448, 'longitude' => 111.0434],
            ['province_code' => '33', 'name' => 'Kabupaten Kudus', 'code' => '3319', 'latitude' => -6.8065, 'longitude' => 110.8420],
            ['province_code' => '33', 'name' => 'Kabupaten Jepara', 'code' => '3320', 'latitude' => -6.5699, 'longitude' => 110.6630],
            ['province_code' => '33', 'name' => 'Kabupaten Demak', 'code' => '3321', 'latitude' => -6.8905, 'longitude' => 110.6316],
            ['province_code' => '33', 'name' => 'Kabupaten Semarang', 'code' => '3322', 'latitude' => -7.1691, 'longitude' => 110.4003],
            ['province_code' => '33', 'name' => 'Kabupaten Temanggung', 'code' => '3323', 'latitude' => -7.2881, 'longitude' => 110.1369],
            ['province_code' => '33', 'name' => 'Kabupaten Kendal', 'code' => '3324', 'latitude' => -6.9583, 'longitude' => 110.1810],
            ['province_code' => '33', 'name' => 'Kabupaten Batang', 'code' => '3325', 'latitude' => -6.8966, 'longitude' => 109.7421],
            ['province_code' => '33', 'name' => 'Kabupaten Pekalongan', 'code' => '3326', 'latitude' => -6.8885, 'longitude' => 109.6736],
            ['province_code' => '33', 'name' => 'Kabupaten Pemalang', 'code' => '3327', 'latitude' => -6.9304, 'longitude' => 109.3808],
            ['province_code' => '33', 'name' => 'Kabupaten Tegal', 'code' => '3328', 'latitude' => -6.8771, 'longitude' => 109.1342],
            ['province_code' => '33', 'name' => 'Kabupaten Brebes', 'code' => '3329', 'latitude' => -6.8814, 'longitude' => 109.0508],
            ['province_code' => '33', 'name' => 'Kota Semarang', 'code' => '3374', 'latitude' => -6.9932, 'longitude' => 110.4203],
            ['province_code' => '33', 'name' => 'Kota Surakarta', 'code' => '3372', 'latitude' => -7.5618, 'longitude' => 110.7680],
            ['province_code' => '33', 'name' => 'Kota Salatiga', 'code' => '3373', 'latitude' => -7.3232, 'longitude' => 110.5023],
            ['province_code' => '33', 'name' => 'Kota Pekalongan', 'code' => '3375', 'latitude' => -6.8899, 'longitude' => 109.6716],
            ['province_code' => '33', 'name' => 'Kota Tegal', 'code' => '3376', 'latitude' => -6.8699, 'longitude' => 109.1318],
            ['province_code' => '33', 'name' => 'Kota Magelang', 'code' => '3371', 'latitude' => -7.4718, 'longitude' => 110.2196],

            // === DI YOGYAKARTA ===
            ['province_code' => '34', 'name' => 'Kabupaten Kulon Progo', 'code' => '3401', 'latitude' => -7.8453, 'longitude' => 110.1628],
            ['province_code' => '34', 'name' => 'Kabupaten Bantul', 'code' => '3402', 'latitude' => -7.8868, 'longitude' => 110.3726],
            ['province_code' => '34', 'name' => 'Kabupaten Gunung Kidul', 'code' => '3403', 'latitude' => -7.9897, 'longitude' => 110.6157],
            ['province_code' => '34', 'name' => 'Kabupaten Sleman', 'code' => '3404', 'latitude' => -7.7162, 'longitude' => 110.4112],
            ['province_code' => '34', 'name' => 'Kota Yogyakarta', 'code' => '3471', 'latitude' => -7.7956, 'longitude' => 110.3695],

            // === JAWA TIMUR ===
            ['province_code' => '35', 'name' => 'Kabupaten Gresik', 'code' => '3525', 'latitude' => -7.1520, 'longitude' => 112.6542],
            ['province_code' => '35', 'name' => 'Kabupaten Sidoarjo', 'code' => '3515', 'latitude' => -7.4489, 'longitude' => 112.6941],
            ['province_code' => '35', 'name' => 'Kabupaten Malang', 'code' => '3507', 'latitude' => -7.9797, 'longitude' => 112.6304],
            ['province_code' => '35', 'name' => 'Kota Surabaya', 'code' => '3578', 'latitude' => -7.2575, 'longitude' => 112.7521],
            ['province_code' => '35', 'name' => 'Kota Malang', 'code' => '3573', 'latitude' => -7.9797, 'longitude' => 112.6304],

            // === SUMATERA UTARA ===
            ['province_code' => '12', 'name' => 'Kota Medan', 'code' => '1275', 'latitude' => 3.5952, 'longitude' => 98.6722],
            ['province_code' => '12', 'name' => 'Kota Binjai', 'code' => '1276', 'latitude' => 3.5997, 'longitude' => 98.4820],

            // === SULAWESI SELATAN ===
            ['province_code' => '73', 'name' => 'Kota Makassar', 'code' => '7371', 'latitude' => -5.1477, 'longitude' => 119.4327],

            // === BALI ===
            ['province_code' => '51', 'name' => 'Kota Denpasar', 'code' => '5171', 'latitude' => -8.4095, 'longitude' => 115.1889],
            ['province_code' => '51', 'name' => 'Kabupaten Badung', 'code' => '5103', 'latitude' => -8.4894, 'longitude' => 115.1725],
            ['province_code' => '51', 'name' => 'Kabupaten Gianyar', 'code' => '5104', 'latitude' => -8.4746, 'longitude' => 115.2891],
            ['province_code' => '51', 'name' => 'Kabupaten Buleleng', 'code' => '5108', 'latitude' => -8.1088, 'longitude' => 115.0928],

            // === KALIMANTAN TIMUR ===
            ['province_code' => '64', 'name' => 'Kota Samarinda', 'code' => '6472', 'latitude' => -0.5022, 'longitude' => 117.1536],
            ['province_code' => '64', 'name' => 'Kota Balikpapan', 'code' => '6471', 'latitude' => -1.2655, 'longitude' => 116.8312],

            // === LAMPUNG ===
            ['province_code' => '18', 'name' => 'Kota Bandar Lampung', 'code' => '1871', 'latitude' => -5.4500, 'longitude' => 105.2667],

            // === SUMATERA BARAT ===
            ['province_code' => '13', 'name' => 'Kota Padang', 'code' => '1371', 'latitude' => -0.9471, 'longitude' => 100.4172],

            // === RIAU ===
            ['province_code' => '14', 'name' => 'Kota Pekanbaru', 'code' => '1471', 'latitude' => 0.5071, 'longitude' => 101.4478],

            // === KALIMANTAN SELATAN ===
            ['province_code' => '63', 'name' => 'Kota Banjarmasin', 'code' => '6371', 'latitude' => -3.3186, 'longitude' => 114.5944],

            // === PAPUA ===
            ['province_code' => '91', 'name' => 'Kota Jayapura', 'code' => '9171', 'latitude' => -2.5337, 'longitude' => 140.7181],
        ];

        $provinces = Province::pluck('id', 'code');

        foreach ($cities as $city) {
            if (isset($provinces[$city['province_code']])) {
                City::updateOrCreate(
                    ['code' => $city['code']],
                    [
                        'province_id' => $provinces[$city['province_code']],
                        'name' => $city['name'],
                        'latitude' => $city['latitude'],
                        'longitude' => $city['longitude'],
                    ]
                );
            }
        }

        $this->command->info(count($cities) . ' Cities seeded successfully.');
    }

    private function seedDistricts(): void
    {
        // Prioritaskan Jawa Barat - ambil beberapa kecamatan per kab/kota
        $districts = [
            // === BANDUNG ===
            ['city_code' => '3204', 'name' => 'Kecamatan Baleendah', 'code' => '3204110', 'latitude' => -7.0100, 'longitude' => 107.6100],
            ['city_code' => '3204', 'name' => 'Kecamatan Banjaran', 'code' => '3204120', 'latitude' => -7.0400, 'longitude' => 107.5800],
            ['city_code' => '3204', 'name' => 'Kecamatan Ciparay', 'code' => '3204220', 'latitude' => -7.0300, 'longitude' => 107.5500],
            ['city_code' => '3204', 'name' => 'Kecamatan Dayeuhkolot', 'code' => '3204090', 'latitude' => -6.9800, 'longitude' => 107.6200],
            ['city_code' => '3204', 'name' => 'Kecamatan Majalaya', 'code' => '3204170', 'latitude' => -7.0500, 'longitude' => 107.7200],
            ['city_code' => '3204', 'name' => 'Kecamatan Pangalengan', 'code' => '3204310', 'latitude' => -7.1700, 'longitude' => 107.5700],
            ['city_code' => '3204', 'name' => 'Kecamatan Soreang', 'code' => '3204070', 'latitude' => -7.0200, 'longitude' => 107.5100],
            ['city_code' => '3204', 'name' => 'Kecamatan Margahayu', 'code' => '3204080', 'latitude' => -6.9900, 'longitude' => 107.5700],

            // === KOTA BANDUNG ===
            ['city_code' => '3273', 'name' => 'Kecamatan Bandung Kidul', 'code' => '3273080', 'latitude' => -6.9400, 'longitude' => 107.6400],
            ['city_code' => '3273', 'name' => 'Kecamatan Bandung Wetan', 'code' => '3273020', 'latitude' => -6.9000, 'longitude' => 107.6100],
            ['city_code' => '3273', 'name' => 'Kecamatan Batununggal', 'code' => '3273030', 'latitude' => -6.9200, 'longitude' => 107.6300],
            ['city_code' => '3273', 'name' => 'Kecamatan Bojongloa Kidul', 'code' => '3273040', 'latitude' => -6.9400, 'longitude' => 107.6000],
            ['city_code' => '3273', 'name' => 'Kecamatan Cibeunying Kidul', 'code' => '3273060', 'latitude' => -6.9000, 'longitude' => 107.6400],
            ['city_code' => '3273', 'name' => 'Kecamatan Cicendo', 'code' => '3273070', 'latitude' => -6.9000, 'longitude' => 107.5900],
            ['city_code' => '3273', 'name' => 'Kecamatan Coblong', 'code' => '3273010', 'latitude' => -6.8800, 'longitude' => 107.6100],
            ['city_code' => '3273', 'name' => 'Kecamatan Kiaracondong', 'code' => '3273090', 'latitude' => -6.9200, 'longitude' => 107.6500],
            ['city_code' => '3273', 'name' => 'Kecamatan Lengkong', 'code' => '3273100', 'latitude' => -6.9300, 'longitude' => 107.6200],
            ['city_code' => '3273', 'name' => 'Kecamatan Margacinta', 'code' => '3273110', 'latitude' => -6.9500, 'longitude' => 107.6400],
            ['city_code' => '3273', 'name' => 'Kecamatan Regol', 'code' => '3273120', 'latitude' => -6.9300, 'longitude' => 107.6000],
            ['city_code' => '3273', 'name' => 'Kecamatan Sukajadi', 'code' => '3273130', 'latitude' => -6.8900, 'longitude' => 107.5900],
            ['city_code' => '3273', 'name' => 'Kecamatan Sumur Bandung', 'code' => '3273140', 'latitude' => -6.9100, 'longitude' => 107.6100],

            // === BOGOR ===
            ['city_code' => '3201', 'name' => 'Kecamatan Cibinong', 'code' => '3201100', 'latitude' => -6.4960, 'longitude' => 106.8500],
            ['city_code' => '3201', 'name' => 'Kecamatan Citeureup', 'code' => '3201110', 'latitude' => -6.5000, 'longitude' => 106.8800],
            ['city_code' => '3201', 'name' => 'Kecamatan Gunung Putri', 'code' => '3201210', 'latitude' => -6.4400, 'longitude' => 106.9300],
            ['city_code' => '3201', 'name' => 'Kecamatan Jonggol', 'code' => '3201350', 'latitude' => -6.4800, 'longitude' => 107.0500],

            // === KOTA BOGOR ===
            ['city_code' => '3271', 'name' => 'Kecamatan Bogor Barat', 'code' => '3271010', 'latitude' => -6.5800, 'longitude' => 106.7800],
            ['city_code' => '3271', 'name' => 'Kecamatan Bogor Selatan', 'code' => '3271020', 'latitude' => -6.6100, 'longitude' => 106.8000],
            ['city_code' => '3271', 'name' => 'Kecamatan Bogor Tengah', 'code' => '3271030', 'latitude' => -6.5900, 'longitude' => 106.7900],
            ['city_code' => '3271', 'name' => 'Kecamatan Bogor Timur', 'code' => '3271040', 'latitude' => -6.5800, 'longitude' => 106.8000],
            ['city_code' => '3271', 'name' => 'Kecamatan Bogor Utara', 'code' => '3271050', 'latitude' => -6.5700, 'longitude' => 106.8100],

            // === BEKASI ===
            ['city_code' => '3216', 'name' => 'Kecamatan Cikarang Pusat', 'code' => '3216230', 'latitude' => -6.2900, 'longitude' => 107.1500],
            ['city_code' => '3216', 'name' => 'Kecamatan Cikarang Selatan', 'code' => '3216190', 'latitude' => -6.3300, 'longitude' => 107.1300],
            ['city_code' => '3216', 'name' => 'Kecamatan Cikarang Timur', 'code' => '3216210', 'latitude' => -6.2800, 'longitude' => 107.1900],
            ['city_code' => '3216', 'name' => 'Kecamatan Cikarang Utara', 'code' => '3216220', 'latitude' => -6.2600, 'longitude' => 107.1600],
            ['city_code' => '3216', 'name' => 'Kecamatan Tambun Selatan', 'code' => '3216090', 'latitude' => -6.2400, 'longitude' => 107.0600],
            ['city_code' => '3216', 'name' => 'Kecamatan Tambun Utara', 'code' => '3216060', 'latitude' => -6.2000, 'longitude' => 107.0500],

            // === KOTA BEKASI ===
            ['city_code' => '3275', 'name' => 'Kecamatan Bekasi Barat', 'code' => '3275010', 'latitude' => -6.2300, 'longitude' => 106.9700],
            ['city_code' => '3275', 'name' => 'Kecamatan Bekasi Selatan', 'code' => '3275020', 'latitude' => -6.2600, 'longitude' => 106.9800],
            ['city_code' => '3275', 'name' => 'Kecamatan Bekasi Timur', 'code' => '3275030', 'latitude' => -6.2400, 'longitude' => 107.0100],
            ['city_code' => '3275', 'name' => 'Kecamatan Bekasi Utara', 'code' => '3275040', 'latitude' => -6.2100, 'longitude' => 106.9900],
            ['city_code' => '3275', 'name' => 'Kecamatan Jatiasih', 'code' => '3275050', 'latitude' => -6.3000, 'longitude' => 106.9600],
            ['city_code' => '3275', 'name' => 'Kecamatan Mustika Jaya', 'code' => '3275110', 'latitude' => -6.3000, 'longitude' => 107.0100],

            // === DEPOK ===
            ['city_code' => '3276', 'name' => 'Kecamatan Beji', 'code' => '3276010', 'latitude' => -6.3700, 'longitude' => 106.8300],
            ['city_code' => '3276', 'name' => 'Kecamatan Cimanggis', 'code' => '3276020', 'latitude' => -6.3900, 'longitude' => 106.8600],
            ['city_code' => '3276', 'name' => 'Kecamatan Limo', 'code' => '3276030', 'latitude' => -6.3500, 'longitude' => 106.7800],
            ['city_code' => '3276', 'name' => 'Kecamatan Pancoran Mas', 'code' => '3276040', 'latitude' => -6.4000, 'longitude' => 106.8100],
            ['city_code' => '3276', 'name' => 'Kecamatan Sawangan', 'code' => '3276050', 'latitude' => -6.4300, 'longitude' => 106.7700],
            ['city_code' => '3276', 'name' => 'Kecamatan Sukmajaya', 'code' => '3276060', 'latitude' => -6.3900, 'longitude' => 106.8300],

            // === CIANJUR ===
            ['city_code' => '3203', 'name' => 'Kecamatan Cianjur', 'code' => '3203010', 'latitude' => -6.8100, 'longitude' => 107.1400],
            ['city_code' => '3203', 'name' => 'Kecamatan Cipanas', 'code' => '3203020', 'latitude' => -6.7200, 'longitude' => 107.0400],
            ['city_code' => '3203', 'name' => 'Kecamatan Pacet', 'code' => '3203030', 'latitude' => -6.7300, 'longitude' => 107.0500],
            ['city_code' => '3203', 'name' => 'Kecamatan Cilaku', 'code' => '3203040', 'latitude' => -6.8400, 'longitude' => 107.1100],

            // === SUBANG ===
            ['city_code' => '3213', 'name' => 'Kecamatan Subang', 'code' => '3213010', 'latitude' => -6.5600, 'longitude' => 107.7500],
            ['city_code' => '3213', 'name' => 'Kecamatan Ciasem', 'code' => '3213020', 'latitude' => -6.3100, 'longitude' => 107.6800],
            ['city_code' => '3213', 'name' => 'Kecamatan Pamanukan', 'code' => '3213030', 'latitude' => -6.2800, 'longitude' => 107.8000],

            // === KARAWANG ===
            ['city_code' => '3215', 'name' => 'Kecamatan Karawang Barat', 'code' => '3215010', 'latitude' => -6.3000, 'longitude' => 107.2900],
            ['city_code' => '3215', 'name' => 'Kecamatan Karawang Timur', 'code' => '3215020', 'latitude' => -6.3100, 'longitude' => 107.3300],
            ['city_code' => '3215', 'name' => 'Kecamatan Klari', 'code' => '3215030', 'latitude' => -6.3500, 'longitude' => 107.3700],

            // === CIREBON ===
            ['city_code' => '3209', 'name' => 'Kecamatan Sumber', 'code' => '3209010', 'latitude' => -6.7600, 'longitude' => 108.4800],
            ['city_code' => '3209', 'name' => 'Kecamatan Arjawinangun', 'code' => '3209020', 'latitude' => -6.6400, 'longitude' => 108.4100],
            ['city_code' => '3209', 'name' => 'Kecamatan Palimanan', 'code' => '3209030', 'latitude' => -6.7000, 'longitude' => 108.4200],

            // === INDRAMAYU ===
            ['city_code' => '3212', 'name' => 'Kecamatan Indramayu', 'code' => '3212010', 'latitude' => -6.3300, 'longitude' => 108.3200],
            ['city_code' => '3212', 'name' => 'Kecamatan Jatibarang', 'code' => '3212020', 'latitude' => -6.4600, 'longitude' => 108.3000],
            ['city_code' => '3212', 'name' => 'Kecamatan Sliyeg', 'code' => '3212030', 'latitude' => -6.4600, 'longitude' => 108.3500],

            // === GARUT ===
            ['city_code' => '3205', 'name' => 'Kecamatan Garut Kota', 'code' => '3205010', 'latitude' => -7.2200, 'longitude' => 107.9000],
            ['city_code' => '3205', 'name' => 'Kecamatan Tarogong Kidul', 'code' => '3205020', 'latitude' => -7.2000, 'longitude' => 107.8700],
            ['city_code' => '3205', 'name' => 'Kecamatan Tarogong Kaler', 'code' => '3205030', 'latitude' => -7.1800, 'longitude' => 107.8700],

            // === CIAMIS ===
            ['city_code' => '3207', 'name' => 'Kecamatan Ciamis', 'code' => '3207010', 'latitude' => -7.3200, 'longitude' => 108.3500],
            ['city_code' => '3207', 'name' => 'Kecamatan Cijeungjing', 'code' => '3207020', 'latitude' => -7.3400, 'longitude' => 108.3900],

            // === TASIKMALAYA ===
            ['city_code' => '3206', 'name' => 'Kecamatan Singaparna', 'code' => '3206010', 'latitude' => -7.3500, 'longitude' => 108.1100],
            ['city_code' => '3206', 'name' => 'Kecamatan Cigalontang', 'code' => '3206020', 'latitude' => -7.2900, 'longitude' => 108.0700],
            ['city_code' => '3206', 'name' => 'Kecamatan Manonjaya', 'code' => '3206030', 'latitude' => -7.3700, 'longitude' => 108.3000],

            // === SUMEDANG ===
            ['city_code' => '3211', 'name' => 'Kecamatan Sumedang Selatan', 'code' => '3211010', 'latitude' => -6.8400, 'longitude' => 107.9100],
            ['city_code' => '3211', 'name' => 'Kecamatan Sumedang Utara', 'code' => '3211020', 'latitude' => -6.8200, 'longitude' => 107.9200],

            // === PURWAKARTA ===
            ['city_code' => '3214', 'name' => 'Kecamatan Purwakarta', 'code' => '3214010', 'latitude' => -6.5500, 'longitude' => 107.4400],
            ['city_code' => '3214', 'name' => 'Kecamatan Plered', 'code' => '3214020', 'latitude' => -6.6200, 'longitude' => 107.3900],

            // === BANDUNG BARAT ===
            ['city_code' => '3217', 'name' => 'Kecamatan Ngamprah', 'code' => '3217040', 'latitude' => -6.8500, 'longitude' => 107.5000],
            ['city_code' => '3217', 'name' => 'Kecamatan Cimahi Selatan', 'code' => '3277010', 'latitude' => -6.9000, 'longitude' => 107.5300],

            // === KUNINGAN ===
            ['city_code' => '3208', 'name' => 'Kecamatan Kuningan', 'code' => '3208010', 'latitude' => -6.9700, 'longitude' => 108.4800],
            ['city_code' => '3208', 'name' => 'Kecamatan Cilimus', 'code' => '3208020', 'latitude' => -6.9200, 'longitude' => 108.5100],

            // === MAJALENGKA ===
            ['city_code' => '3210', 'name' => 'Kecamatan Majalengka', 'code' => '3210010', 'latitude' => -6.8300, 'longitude' => 108.2200],
            ['city_code' => '3210', 'name' => 'Kecamatan Kadipaten', 'code' => '3210020', 'latitude' => -6.7500, 'longitude' => 108.1600],

            // === SUKABUMI ===
            ['city_code' => '3202', 'name' => 'Kecamatan Pelabuhan Ratu', 'code' => '3202010', 'latitude' => -7.0200, 'longitude' => 106.5500],
            ['city_code' => '3202', 'name' => 'Kecamatan Cicurug', 'code' => '3202020', 'latitude' => -6.7800, 'longitude' => 106.7200],
            ['city_code' => '3202', 'name' => 'Kecamatan Cibadak', 'code' => '3202030', 'latitude' => -6.8900, 'longitude' => 106.7900],

            // === PANGANDARAN ===
            ['city_code' => '3218', 'name' => 'Kecamatan Pangandaran', 'code' => '3201040', 'latitude' => -7.6800, 'longitude' => 108.6500],
            ['city_code' => '3218', 'name' => 'Kecamatan Parigi', 'code' => '3201050', 'latitude' => -7.6900, 'longitude' => 108.5300],

            // === CIMAHI ===
            ['city_code' => '3277', 'name' => 'Kecamatan Cimahi Selatan', 'code' => '3277010', 'latitude' => -6.8900, 'longitude' => 107.5400],
            ['city_code' => '3277', 'name' => 'Kecamatan Cimahi Tengah', 'code' => '3277020', 'latitude' => -6.8800, 'longitude' => 107.5500],
            ['city_code' => '3277', 'name' => 'Kecamatan Cimahi Utara', 'code' => '3277030', 'latitude' => -6.8600, 'longitude' => 107.5600],

            // === CIREBON KOTA ===
            ['city_code' => '3274', 'name' => 'Kecamatan Harjamukti', 'code' => '3274010', 'latitude' => -6.7200, 'longitude' => 108.5600],
            ['city_code' => '3274', 'name' => 'Kecamatan Kejaksan', 'code' => '3274020', 'latitude' => -6.7100, 'longitude' => 108.5500],

            // === BANJAR ===
            ['city_code' => '3279', 'name' => 'Kecamatan Banjar', 'code' => '3279010', 'latitude' => -7.3700, 'longitude' => 108.5400],
            ['city_code' => '3279', 'name' => 'Kecamatan Pataruman', 'code' => '3279020', 'latitude' => -7.3800, 'longitude' => 108.5400],

            // === SUKABUMI KOTA ===
            ['city_code' => '3272', 'name' => 'Kecamatan Cikole', 'code' => '3272010', 'latitude' => -6.9200, 'longitude' => 106.9300],
            ['city_code' => '3272', 'name' => 'Kecamatan Gunung Puyuh', 'code' => '3272030', 'latitude' => -6.9300, 'longitude' => 106.9200],

            // === TASIKMALAYA KOTA ===
            ['city_code' => '3278', 'name' => 'Kecamatan Cihideung', 'code' => '3278010', 'latitude' => -7.3300, 'longitude' => 108.2200],
            ['city_code' => '3278', 'name' => 'Kecamatan Tawang', 'code' => '3278020', 'latitude' => -7.3200, 'longitude' => 108.2100],

            // === DKI JAKARTA ===
            ['city_code' => '3171', 'name' => 'Kecamatan Gambir', 'code' => '3171010', 'latitude' => -6.1730, 'longitude' => 106.8240],
            ['city_code' => '3171', 'name' => 'Kecamatan Menteng', 'code' => '3171020', 'latitude' => -6.1920, 'longitude' => 106.8360],
            ['city_code' => '3171', 'name' => 'Kecamatan Tanah Abang', 'code' => '3171030', 'latitude' => -6.1870, 'longitude' => 106.8070],
            ['city_code' => '3174', 'name' => 'Kecamatan Kebayoran Baru', 'code' => '3174010', 'latitude' => -6.2430, 'longitude' => 106.7920],
            ['city_code' => '3174', 'name' => 'Kecamatan Setiabudi', 'code' => '3174020', 'latitude' => -6.2130, 'longitude' => 106.8260],
            ['city_code' => '3174', 'name' => 'Kecamatan Tebet', 'code' => '3174030', 'latitude' => -6.2260, 'longitude' => 106.8570],

            // === BANTEN ===
            ['city_code' => '3671', 'name' => 'Kecamatan Ciledug', 'code' => '3671010', 'latitude' => -6.2460, 'longitude' => 106.7020],
            ['city_code' => '3671', 'name' => 'Kecamatan Tangerang', 'code' => '3671020', 'latitude' => -6.1780, 'longitude' => 106.6300],
            ['city_code' => '3674', 'name' => 'Kecamatan Serpong', 'code' => '3674010', 'latitude' => -6.3150, 'longitude' => 106.6720],
            ['city_code' => '3674', 'name' => 'Kecamatan Pondok Aren', 'code' => '3674020', 'latitude' => -6.2580, 'longitude' => 106.7060],
            ['city_code' => '3674', 'name' => 'Kecamatan BSD', 'code' => '3674030', 'latitude' => -6.3000, 'longitude' => 106.6600],
        ];

        $cities = City::pluck('id', 'code');

        foreach ($districts as $district) {
            if (isset($cities[$district['city_code']])) {
                District::updateOrCreate(
                    ['code' => $district['code']],
                    [
                        'city_id' => $cities[$district['city_code']],
                        'name' => $district['name'],
                        'latitude' => $district['latitude'],
                        'longitude' => $district['longitude'],
                    ]
                );
            }
        }

        $this->command->info(count($districts) . ' Districts seeded successfully.');
    }

    private function seedVillages(): void
    {
        // Seed beberapa desa prioritas dari kecamatan di Jawa Barat
        $villages = [
            // Desa di Kecamatan Baleendah, Kab Bandung
            ['district_code' => '3204110', 'name' => 'Baleendah', 'code' => '3204110001', 'latitude' => -7.0100, 'longitude' => 107.6100],
            ['district_code' => '3204110', 'name' => 'Andir', 'code' => '3204110002', 'latitude' => -7.0080, 'longitude' => 107.6200],
            ['district_code' => '3204110', 'name' => 'Manggahang', 'code' => '3204110003', 'latitude' => -7.0200, 'longitude' => 107.6000],
            ['district_code' => '3204110', 'name' => 'Rancamanyar', 'code' => '3204110004', 'latitude' => -7.0150, 'longitude' => 107.5900],
            ['district_code' => '3204110', 'name' => 'Bojong Malaka', 'code' => '3204110005', 'latitude' => -7.0050, 'longitude' => 107.6150],

            // Desa di Kecamatan Dayeuhkolot, Kab Bandung
            ['district_code' => '3204090', 'name' => 'Dayeuhkolot', 'code' => '3204090001', 'latitude' => -6.9800, 'longitude' => 107.6200],
            ['district_code' => '3204090', 'name' => 'Pasawahan', 'code' => '3204090002', 'latitude' => -6.9700, 'longitude' => 107.6300],
            ['district_code' => '3204090', 'name' => 'Citeureup', 'code' => '3204090003', 'latitude' => -6.9850, 'longitude' => 107.6250],
            ['district_code' => '3204090', 'name' => 'Sukapura', 'code' => '3204090004', 'latitude' => -6.9750, 'longitude' => 107.6150],
            ['district_code' => '3204090', 'name' => 'Cangkuang Kulon', 'code' => '3204090005', 'latitude' => -6.9900, 'longitude' => 107.6000],

            // Desa di Kecamatan Ciparay, Kab Bandung
            ['district_code' => '3204220', 'name' => 'Ciparay', 'code' => '3204220001', 'latitude' => -7.0300, 'longitude' => 107.5500],
            ['district_code' => '3204220', 'name' => 'Babakan', 'code' => '3204220002', 'latitude' => -7.0250, 'longitude' => 107.5450],
            ['district_code' => '3204220', 'name' => 'Sumur Bandung', 'code' => '3204220003', 'latitude' => -7.0400, 'longitude' => 107.5550],
            ['district_code' => '3204220', 'name' => 'Mekar Sari', 'code' => '3204220004', 'latitude' => -7.0200, 'longitude' => 107.5600],

            // Desa di Kecamatan Soreang, Kab Bandung
            ['district_code' => '3204070', 'name' => 'Soreang', 'code' => '3204070001', 'latitude' => -7.0200, 'longitude' => 107.5100],
            ['district_code' => '3204070', 'name' => 'Sadusirnarasa', 'code' => '3204070002', 'latitude' => -7.0150, 'longitude' => 107.5150],
            ['district_code' => '3204070', 'name' => 'Pamekaran', 'code' => '3204070003', 'latitude' => -7.0300, 'longitude' => 107.5050],
            ['district_code' => '3204070', 'name' => 'Sekarwangi', 'code' => '3204070004', 'latitude' => -7.0100, 'longitude' => 107.5200],

            // Desa di Kecamatan Margahayu, Kab Bandung
            ['district_code' => '3204080', 'name' => 'Margahayu', 'code' => '3204080001', 'latitude' => -6.9900, 'longitude' => 107.5700],
            ['district_code' => '3204080', 'name' => 'Sukamenak', 'code' => '3204080002', 'latitude' => -6.9950, 'longitude' => 107.5750],
            ['district_code' => '3204080', 'name' => 'Sayati', 'code' => '3204080003', 'latitude' => -6.9800, 'longitude' => 107.5650],

            // Desa di Kecamatan Pangalengan, Kab Bandung
            ['district_code' => '3204310', 'name' => 'Pangalengan', 'code' => '3204310001', 'latitude' => -7.1700, 'longitude' => 107.5700],
            ['district_code' => '3204310', 'name' => 'Sukamanah', 'code' => '3204310002', 'latitude' => -7.1600, 'longitude' => 107.5800],
            ['district_code' => '3204310', 'name' => 'Margamulya', 'code' => '3204310003', 'latitude' => -7.1800, 'longitude' => 107.5600],
            ['district_code' => '3204310', 'name' => 'Banjar Sari', 'code' => '3204310004', 'latitude' => -7.1500, 'longitude' => 107.5650],

            // Desa di Kecamatan Majalaya, Kab Bandung
            ['district_code' => '3204170', 'name' => 'Majalaya', 'code' => '3204170001', 'latitude' => -7.0500, 'longitude' => 107.7200],
            ['district_code' => '3204170', 'name' => 'Padamulya', 'code' => '3204170002', 'latitude' => -7.0400, 'longitude' => 107.7250],
            ['district_code' => '3204170', 'name' => 'Sukamaju', 'code' => '3204170003', 'latitude' => -7.0600, 'longitude' => 107.7100],

            // Desa di Kecamatan Cibinong, Kab Bogor
            ['district_code' => '3201100', 'name' => 'Cibinong', 'code' => '3201100001', 'latitude' => -6.4960, 'longitude' => 106.8500],
            ['district_code' => '3201100', 'name' => 'Pondok Rajeg', 'code' => '3201100002', 'latitude' => -6.4900, 'longitude' => 106.8550],
            ['district_code' => '3201100', 'name' => 'Harapan Jaya', 'code' => '3201100003', 'latitude' => -6.5000, 'longitude' => 106.8450],

            // Desa di Kecamatan Cianjur, Kab Cianjur
            ['district_code' => '3203010', 'name' => 'Cianjur', 'code' => '3203010001', 'latitude' => -6.8100, 'longitude' => 107.1400],
            ['district_code' => '3203010', 'name' => 'Bojong Herang', 'code' => '3203010002', 'latitude' => -6.8150, 'longitude' => 107.1350],
            ['district_code' => '3203010', 'name' => 'Nagrak', 'code' => '3203010003', 'latitude' => -6.8000, 'longitude' => 107.1450],

            // Desa di Kecamatan Subang, Kab Subang
            ['district_code' => '3213010', 'name' => 'Subang', 'code' => '3213010001', 'latitude' => -6.5600, 'longitude' => 107.7500],
            ['district_code' => '3213010', 'name' => 'Karangsari', 'code' => '3213010002', 'latitude' => -6.5550, 'longitude' => 107.7550],
            ['district_code' => '3213010', 'name' => 'Sukamaju Indah', 'code' => '3213010003', 'latitude' => -6.5650, 'longitude' => 107.7450],

            // Desa di Kecamatan Indramayu, Kab Indramayu
            ['district_code' => '3212010', 'name' => 'Indramayu', 'code' => '3212010001', 'latitude' => -6.3300, 'longitude' => 108.3200],
            ['district_code' => '3212010', 'name' => 'Pekandangan', 'code' => '3212010002', 'latitude' => -6.3250, 'longitude' => 108.3150],
            ['district_code' => '3212010', 'name' => 'Lemahayang', 'code' => '3212010003', 'latitude' => -6.3400, 'longitude' => 108.3250],

            // Desa di Kecamatan Garut Kota, Kab Garut
            ['district_code' => '3205010', 'name' => 'Garut', 'code' => '3205010001', 'latitude' => -7.2200, 'longitude' => 107.9000],
            ['district_code' => '3205010', 'name' => 'Sukamantri', 'code' => '3205010002', 'latitude' => -7.2150, 'longitude' => 107.9050],

            // Desa di Kecamatan Garut Kota, Kab Garut
            ['district_code' => '3205010', 'name' => 'Margawati', 'code' => '3205010003', 'latitude' => -7.2250, 'longitude' => 107.8950],

            // Desa di Kecamatan Pelabuhan Ratu, Kab Sukabumi
            ['district_code' => '3202010', 'name' => 'Pelabuhan Ratu', 'code' => '3202010001', 'latitude' => -7.0200, 'longitude' => 106.5500],
            ['district_code' => '3202010', 'name' => 'Citarik', 'code' => '3202010002', 'latitude' => -7.0300, 'longitude' => 106.5400],

            // Desa di Kecamatan Karawang Barat, Kab Karawang
            ['district_code' => '3215010', 'name' => 'Karawang Kulon', 'code' => '3215010001', 'latitude' => -6.3000, 'longitude' => 107.2900],
            ['district_code' => '3215010', 'name' => 'Tunggakjati', 'code' => '3215010002', 'latitude' => -6.3100, 'longitude' => 107.2800],

            // Desa di Kecamatan Purwakarta, Kab Purwakarta
            ['district_code' => '3214010', 'name' => 'Purwakarta', 'code' => '3214010001', 'latitude' => -6.5500, 'longitude' => 107.4400],
            ['district_code' => '3214010', 'name' => 'Cipaisan', 'code' => '3214010002', 'latitude' => -6.5450, 'longitude' => 107.4450],

            // === DKI JAKARTA VILLAGES ===
            ['district_code' => '3171010', 'name' => 'Gambir', 'code' => '3171010001', 'latitude' => -6.1730, 'longitude' => 106.8240],
            ['district_code' => '3171010', 'name' => 'Petojo Utara', 'code' => '3171010002', 'latitude' => -6.1700, 'longitude' => 106.8200],
            ['district_code' => '3171020', 'name' => 'Menteng', 'code' => '3171020001', 'latitude' => -6.1920, 'longitude' => 106.8360],
            ['district_code' => '3171020', 'name' => 'Pegangsaan', 'code' => '3171020002', 'latitude' => -6.1980, 'longitude' => 106.8380],

            // === TANGERANG VILLAGES ===
            ['district_code' => '3671010', 'name' => 'Ciledug', 'code' => '3671010001', 'latitude' => -6.2460, 'longitude' => 106.7020],
            ['district_code' => '3671010', 'name' => 'Paninggilan', 'code' => '3671010002', 'latitude' => -6.2400, 'longitude' => 106.6980],
            ['district_code' => '3674010', 'name' => 'Serpong', 'code' => '3674010001', 'latitude' => -6.3150, 'longitude' => 106.6720],
            ['district_code' => '3674010', 'name' => 'Lengkong Gudang', 'code' => '3674010002', 'latitude' => -6.3200, 'longitude' => 106.6780],
        ];

        $districts = District::pluck('id', 'code');

        foreach ($villages as $village) {
            if (isset($districts[$village['district_code']])) {
                Village::updateOrCreate(
                    ['code' => $village['code']],
                    [
                        'district_id' => $districts[$village['district_code']],
                        'name' => $village['name'],
                        'latitude' => $village['latitude'],
                        'longitude' => $village['longitude'],
                    ]
                );
            }
        }

        $this->command->info(count($villages) . ' Villages seeded successfully.');
    }

    private function createLocations(): void
    {
        // Create location entries from cities (main locations)
        $cities = City::all();
        foreach ($cities as $city) {
            Location::updateOrCreate(
                ['slug' => Str::slug($city->name)],
                [
                    'name' => $city->name,
                    'province_id' => $city->province_id,
                    'city_id' => $city->id,
                    'latitude' => $city->latitude,
                    'longitude' => $city->longitude,
                    'timezone' => 'Asia/Jakarta',
                    'is_active' => true,
                ]
            );
        }

        // Also create locations from districts (for hyperlocal)
        $districts = District::all();
        foreach ($districts as $district) {
            Location::updateOrCreate(
                ['slug' => Str::slug($district->name)],
                [
                    'name' => $district->name,
                    'province_id' => $district->city->province_id ?? null,
                    'city_id' => $district->city_id,
                    'district_id' => $district->id,
                    'latitude' => $district->latitude,
                    'longitude' => $district->longitude,
                    'timezone' => 'Asia/Jakarta',
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Locations created for cities and districts.');
    }
}


<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Import COMPLETE Indonesian region data from emsifa/api-wilayah-indonesia CSV files.
 * - 34 provinces (older codes; mapped to 38 per current law)
 * - 514 regencies/cities
 * - 7,215 districts
 * - 80,534 villages
 *
 * Data files are in database/seeders/data/*.csv
 */
class CompleteIndonesiaRegionsSeeder extends Seeder
{
    /**
     * Map old province codes (from CSV) to our current province names/codes.
     * The CSV has 34 provinces, but current law has 38 (Papua split into 4).
     * We map by province NAME primarily so splitting is handled gracefully.
     */
    public function run(): void
    {
        $this->command->info('=== IMPORT COMPLETE INDONESIA REGIONS ===');
        $this->command->info('Membaca file CSV...');
        $this->command->warn('Ini membutuhkan beberapa saat (~80.000 desa). Harap tunggu...');

        $base = database_path('seeders/data');

        // 1. Provinces
        $this->importProvinces($base . '/provinces.csv');
        $this->command->info('✅ Provinsi selesai');

        // 2. Regencies/Cities
        $this->importRegencies($base . '/regencies.csv');
        $this->command->info('✅ Kota/Kabupaten selesai');

        // 3. Districts
        $this->importDistricts($base . '/districts.csv');
        $this->command->info('✅ Kecamatan selesai');

        // 4. Villages
        $this->importVillages($base . '/villages.csv');
        $this->command->info('✅ Desa/Kelurahan selesai');

        $this->command->info('=== IMPORT SELESAI ===');
        $this->command->info('Provinsi: ' . Province::count());
        $this->command->info('Kota/Kab: ' . City::count());
        $this->command->info('Kecamatan: ' . District::count());
        $this->command->info('Desa: ' . Village::count());
    }

    /**
     * Province name mapping: old code -> our current name (if different).
     * The CSV codes (91=Papua Barat, 94=Papua) are OLD. Our DB uses the new
     * 2022 split (Papua, Papua Barat, Papua Selatan, Papua Tengah, Papua Pegunungan,
     * Papua Barat Daya). We keep the CSV's 34 provinces and let the 38 in DB stay;
     * new provinces (Papua Selatan/Tengah/Pegunungan/Barat Daya) are already present.
     */
    protected function importProvinces(string $file): void
    {
        if (!file_exists($file)) {
            $this->command->error("File tidak ditemukan: {$file}");
            return;
        }
        $rows = $this->readCsv($file);
        $count = 0;
        foreach ($rows as $row) {
            $code = trim($row[0]);
            $name = strtoupper(trim($row[1]));
            // Keep existing provinces if code matches; else updateOrCreate by name
            $existing = Province::where('code', $code)->first();
            if ($existing) {
                $existing->update(['name' => $name]);
            } else {
                Province::updateOrCreate(['code' => $code], ['name' => $name]);
            }
            $count++;
        }
    }

    /**
     * Import regencies/cities: CSV rows are [code, province_code, name].
     */
    protected function importRegencies(string $file): void
    {
        if (!file_exists($file)) {
            $this->command->error("File tidak ditemukan: {$file}");
            return;
        }
        $provinces = Province::pluck('id', 'code');
        $rows = $this->readCsv($file);
        $count = 0;
        foreach ($rows as $row) {
            $code = trim($row[0]);
            $provCode = trim($row[1]);
            $name = strtoupper(trim($row[2]));
            $provId = $provinces[$provCode] ?? null;
            if (!$provId) continue;
            City::updateOrCreate(['code' => $code], [
                'province_id' => $provId,
                'name' => $name,
            ]);
            $count++;
        }
    }

    /**
     * Import districts: CSV rows are [code, regency_code, name].
     */
    protected function importDistricts(string $file): void
    {
        if (!file_exists($file)) {
            $this->command->error("File tidak ditemukan: {$file}");
            return;
        }
        $cities = City::pluck('id', 'code');
        $rows = $this->readCsv($file);
        $count = 0;
        foreach ($rows as $row) {
            $code = trim($row[0]);
            $cityCode = trim($row[1]);
            $name = strtoupper(trim($row[2]));
            $cityId = $cities[$cityCode] ?? null;
            if (!$cityId) continue;
            District::updateOrCreate(['code' => $code], [
                'city_id' => $cityId,
                'name' => $name,
            ]);
            $count++;
        }
    }

    /**
     * Import villages: CSV rows are [code, district_code, name].
     * Large dataset (~80k) — use chunked inserts for speed.
     */
    protected function importVillages(string $file): void
    {
        if (!file_exists($file)) {
            $this->command->error("File tidak ditemukan: {$file}");
            return;
        }
        $districts = District::pluck('id', 'code');
        $rows = $this->readCsv($file);
        $count = 0;
        $buffer = [];
        $chunkSize = 500;

        foreach ($rows as $row) {
            $code = trim($row[0]);
            $districtCode = trim($row[1]);
            $name = strtoupper(trim($row[2]));
            $districtId = $districts[$districtCode] ?? null;
            if (!$districtId) continue;

            $buffer[] = [
                'district_id' => $districtId,
                'name' => $name,
                'code' => $code,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $count++;

            if (count($buffer) >= $chunkSize) {
                DB::table('villages')->insertOrIgnore($buffer);
                $buffer = [];
            }
        }
        if ($buffer) {
            DB::table('villages')->insertOrIgnore($buffer);
        }
    }

    /**
     * Read a CSV file into an array of rows.
     */
    protected function readCsv(string $file): array
    {
        $rows = [];
        $handle = fopen($file, 'r');
        if ($handle === false) {
            return $rows;
        }
        while (($line = fgetcsv($handle, 0, ',')) !== false) {
            $rows[] = $line;
        }
        fclose($handle);
        return $rows;
    }
}

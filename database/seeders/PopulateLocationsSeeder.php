<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Create Location rows for ALL cities & districts so every region
 * in the search index maps to a valid locations.id (for weather lookup).
 *
 * Coordinate fallback chain:
 *   city   -> own coords ?? province coords
 *   district -> own coords (non-zero) ?? city coords ?? province coords
 */
class PopulateLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== POPULATE LOCATIONS FOR ALL REGIONS ===');

        $created = 0;
        $updated = 0;

        // 1. Cities -> Location
        foreach (City::with('province')->get() as $city) {
            $lat = $city->latitude ?: $city->province?->latitude;
            $lng = $city->longitude ?: $city->province?->longitude;

            $loc = Location::updateOrCreate(
                ['city_id' => $city->id, 'district_id' => null],
                [
                    'name' => $city->name,
                    'slug' => Str::slug($city->name) . '-' . $city->id,
                    'province_id' => $city->province_id,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'timezone' => 'Asia/Jakarta',
                    'is_active' => true,
                ]
            );
            if ($loc->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }
        $this->command->info("✅ Kota/Kab: created={$created}, updated={$updated}");

        // 2. Districts -> Location
        $created = 0;
        $updated = 0;
        foreach (District::with('city.province')->get() as $d) {
            $city = $d->city;
            $lat = ($d->latitude && $d->latitude != 0) ? $d->latitude : ($city?->latitude ?? $city?->province?->latitude);
            $lng = ($d->longitude && $d->longitude != 0) ? $d->longitude : ($city?->longitude ?? $city?->province?->longitude);

            $loc = Location::updateOrCreate(
                ['city_id' => $d->city_id, 'district_id' => $d->id],
                [
                    'name' => $d->name,
                    'slug' => Str::slug($d->name) . '-' . $d->id,
                    'province_id' => $city?->province_id,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'timezone' => 'Asia/Jakarta',
                    'is_active' => true,
                ]
            );
            if ($loc->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }
        $this->command->info("✅ Kecamatan: created={$created}, updated={$updated}");

        $this->command->info('Total Locations: ' . Location::count());
        $this->command->info('=== POPULATE LOCATIONS SELESAI ===');
    }
}

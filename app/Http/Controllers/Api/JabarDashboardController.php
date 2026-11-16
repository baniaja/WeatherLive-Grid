<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * JabarDashboardController
 * Provides West Java (Jawa Barat) focused data for the main dashboard.
 * The map stays Indonesia-wide for climate reference, but all primary
 * widgets (cities, districts, villages, search suggestions) are scoped
 * to Jawa Barat.
 */
class JabarDashboardController extends Controller
{
    protected const JABAR = 'JAWA BARAT';

    protected static ?Province $cachedJabarProvince = null;

    protected function jabarProvince(): ?Province
    {
        if (self::$cachedJabarProvince === null) {
            self::$cachedJabarProvince = \Illuminate\Support\Facades\Cache::remember('jabar_province_model', 86400, function () {
                return Province::where('name', 'LIKE', '%' . self::JABAR . '%')->first();
            });
        }
        return self::$cachedJabarProvince;
    }

    /**
     * GET /api/jabar/regions
     * Returns all West Java provinces/cities/districts for the region picker.
     */
    public function regions(): JsonResponse
    {
        $prov = $this->jabarProvince();
        if (!$prov) {
            return response()->json(['success' => false, 'message' => 'Provinsi Jawa Barat tidak ditemukan.'], 404);
        }

        $payload = \Illuminate\Support\Facades\Cache::remember('jabar_regions_payload', 3600, function () use ($prov) {
            $cities = City::where('province_id', $prov->id)
                ->orderBy('name')
                ->get(['id', 'name', 'latitude', 'longitude'])
                ->map(fn($c) => [
                    'id' => $c->id,
                    'province_id' => $prov->id,
                    'province_name' => $prov->name,
                    'name' => $this->cleanName($c->name),
                    'full_name' => $c->name,
                    'latitude' => (float) $c->latitude,
                    'longitude' => (float) $c->longitude,
                ]);

            return [
                'province' => [
                    'id' => $prov->id,
                    'name' => $prov->name,
                    'code' => $prov->code,
                    'latitude' => (float) $prov->latitude,
                    'longitude' => (float) $prov->longitude,
                ],
                'cities' => $cities,
                'city_count' => $cities->count(),
                'district_count' => District::whereHas('city', fn($q) => $q->where('province_id', $prov->id))->count(),
                'location_count' => Location::where('province_id', $prov->id)->where('is_active', true)->count(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $payload,
        ]);
    }

    /**
     * GET /api/jabar/districts?city_id=...
     * Returns districts for a given West Java city.
     */
    public function districts(Request $request): JsonResponse
    {
        $request->validate(['city_id' => 'required|exists:cities,id']);

        $districts = District::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get(['id', 'city_id', 'name', 'latitude', 'longitude'])
            ->map(fn($d) => [
                'id' => $d->id,
                'city_id' => $d->city_id,
                'name' => $this->cleanName($d->name),
                'full_name' => $d->name,
                'latitude' => (float) $d->latitude,
                'longitude' => (float) $d->longitude,
            ]);

        return response()->json(['success' => true, 'data' => $districts]);
    }

    /**
     * GET /api/jabar/locations?city_id=&district_id=&q=
     * Returns West Java locations (villages/areas) for a city/district.
     */
    public function locations(Request $request): JsonResponse
    {
        $request->validate([
            'city_id' => 'nullable|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'q' => 'nullable|string',
        ]);

        $prov = $this->jabarProvince();
        if (!$prov) return response()->json(['success' => false, 'message' => 'Provinsi tidak ditemukan.'], 404);

        $query = Location::where('province_id', $prov->id)
            ->where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($request->city_id) $query->where('city_id', $request->city_id);
        if ($request->district_id) $query->where('district_id', $request->district_id);
        if ($request->q) $query->where('name', 'LIKE', '%' . $request->q . '%');

        $locations = $query->with(['city:id,name', 'district:id,name'])
            ->orderBy('name')
            ->limit(200)
            ->get(['id', 'name', 'city_id', 'district_id', 'latitude', 'longitude'])
            ->map(fn($l) => [
                'id' => $l->id,
                'city_id' => $l->city_id,
                'district_id' => $l->district_id,
                'name' => $this->cleanName($l->name),
                'full_name' => $l->name,
                'city' => $l->city?->name,
                'district' => $l->district?->name,
                'latitude' => (float) $l->latitude,
                'longitude' => (float) $l->longitude,
            ]);

        return response()->json(['success' => true, 'data' => $locations]);
    }

    /**
     * GET /api/jabar/search?q=
     * Search across West Java cities, districts, and locations.
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:1']);

        $q = trim($request->q);
        $limit = $request->limit ?? 12;
        $prov = $this->jabarProvince();
        if (!$prov) return response()->json(['success' => false, 'data' => [], 'message' => 'Provinsi tidak ditemukan.']);

        $results = [];

        // Cities
        City::where('province_id', $prov->id)->where('name', 'LIKE', "%{$q}%")
            ->orderBy('name')->limit($limit)->get()
            ->each(function ($c) use (&$results) {
                // Resolve a real, selectable Location id for this city so the
                // frontend can pass it straight to weather APIs (locations.id).
                $locId = $this->resolveLocationIdForCity($c->id, $c->name, $c->latitude, $c->longitude);
                $results[] = [
                    'type' => 'kota',
                    'id' => $locId,
                    'city_id' => $c->id,
                    'name' => $this->cleanName($c->name),
                    'full_name' => $c->name,
                    'sub' => 'Jawa Barat',
                    'latitude' => (float) $c->latitude,
                    'longitude' => (float) $c->longitude,
                ];
            });

        // Districts
        District::whereHas('city', fn($cc) => $cc->where('province_id', $prov->id))
            ->where('name', 'LIKE', "%{$q}%")
            ->with('city')
            ->orderBy('name')->limit($limit)->get()
            ->each(function ($d) use (&$results) {
                // Resolve a real, selectable Location id for this district.
                $locId = $this->resolveLocationIdForDistrict($d->id, $d->city_id);
                $results[] = [
                    'type' => 'kecamatan',
                    'id' => $locId,
                    'district_id' => $d->id,
                    'name' => $this->cleanName($d->name),
                    'full_name' => $d->name,
                    'sub' => ($d->city?->name ?? '') . ', Jawa Barat',
                    'latitude' => (float) $d->latitude,
                    'longitude' => (float) $d->longitude,
                ];
            });

        // Locations (villages/areas)
        Location::where('province_id', $prov->id)->where('is_active', true)
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->where('name', 'LIKE', "%{$q}%")
            ->with(['city:id,name', 'district:id,name'])
            ->orderBy('name')->limit($limit)->get()
            ->each(function ($l) use (&$results) {
                $sub = $l->district?->name ?? $l->city?->name ?? 'Jawa Barat';
                if ($l->city && $l->district && $l->district->name !== $l->city->name) {
                    $sub = $l->district->name . ', ' . $l->city->name;
                }
                $results[] = [
                    'type' => 'lokasi',
                    'id' => $l->id,
                    'name' => $this->cleanName($l->name),
                    'full_name' => $l->name,
                    'sub' => $sub . ', Jawa Barat',
                    'latitude' => (float) $l->latitude,
                    'longitude' => (float) $l->longitude,
                ];
            });

        // Dedupe by name+type
        $seen = [];
        $results = array_values(array_filter($results, function ($r) use (&$seen) {
            $k = $r['name'] . '|' . $r['type'];
            if (isset($seen[$k])) return false;
            $seen[$k] = true;
            return true;
        }));

        return response()->json([
            'success' => true,
            'query' => $q,
            'count' => count($results),
            'region' => 'Jawa Barat',
            'data' => array_slice($results, 0, $limit),
        ]);
    }

    /**
     * GET /api/jabar/overview
     * West Java region weather overview (aggregate of major cities).
     */
    public function overview(): JsonResponse
    {
        $prov = $this->jabarProvince();
        if (!$prov) return response()->json(['success' => false, 'message' => 'Provinsi tidak ditemukan.'], 404);

        $cities = City::where('province_id', $prov->id)->orderBy('name')->get(['id', 'name', 'latitude', 'longitude']);

        $stats = [
            'provinces' => 1,
            'cities' => $cities->count(),
            'districts' => District::whereHas('city', fn($q) => $q->where('province_id', $prov->id))->count(),
            'locations' => Location::where('province_id', $prov->id)->where('is_active', true)->count(),
        ];

        return response()->json(['success' => true, 'data' => $stats]);
    }

/**
     * Resolve a real, selectable Location id for a city (Jawa Barat).
     * Prefers an active, geolocated Location whose name equals the city; falls
     * back to the first active geolocated Location in that city_id.
     */
    protected function resolveLocationIdForCity(int $cityId, string $cityName, $lat = null, $lng = null): int
    {
        $clean = $this->cleanName($cityName);
        $q = Location::where('city_id', $cityId)
            ->where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        $exact = (clone $q)->where('name', $clean)->orderBy('id')->value('id');
        if ($exact) return (int) $exact;

        $first = (clone $q)->orderBy('id')->value('id');
        if ($first) return (int) $first;

        // Last resort: a location matching the city name within the province.
        $fallback = Location::where('province_id', $this->jabarProvince()?->id)
            ->where('name', $clean)
            ->where('is_active', true)
            ->orderBy('id')
            ->value('id');

        return $fallback ? (int) $fallback : (int) $cityId;
    }

    /**
     * Resolve a real, selectable Location id for a district (Jawa Barat).
     * Prefers an active, geolocated Location whose name equals or is inside the
     * district; falls back to the first active geolocated Location in that district.
     */
    protected function resolveLocationIdForDistrict(int $districtId, ?int $cityId = null): int
    {
        $q = Location::where('district_id', $districtId)
            ->where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        $first = $q->orderBy('id')->value('id');
        if ($first) return (int) $first;

        // Fallback: first active geolocated location in the parent city.
        if ($cityId) {
            $cityFallback = Location::where('city_id', $cityId)
                ->where('is_active', true)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('id')
                ->value('id');
            if ($cityFallback) return (int) $cityFallback;
        }

        return (int) $districtId;
    }

    /**
     * Strip Kabupaten/Kota/Kecamatan prefixes for cleaner display.
     */
    protected function cleanName(string $name): string
    {
        return trim(preg_replace('/^(Kabupaten|KOTA|Kota|Kecamatan|Desa|Kelurahan)\s+/i', '', $name));
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\AccuracyController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\FastSearchController;
use App\Http\Controllers\Api\JabarDashboardController;
use App\Http\Controllers\Api\EnterpriseDashboardController;
use App\Http\Controllers\Api\AiAssistantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// System Health Check
Route::get('health', function () {
    $dbOk = false;
    $dbError = null;
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbOk = true;
    } catch (\Throwable $e) {
        $dbError = $e->getMessage();
    }

    $cacheOk = false;
    try {
        \Illuminate\Support\Facades\Cache::put('health_ping', 'ok', 10);
        $cacheOk = (\Illuminate\Support\Facades\Cache::get('health_ping') === 'ok');
    } catch (\Throwable $e) {
        // Cache error
    }

    $status = ($dbOk && $cacheOk) ? 200 : 503;

    return response()->json([
        'status' => ($status === 200) ? 'healthy' : 'degraded',
        'timestamp' => now()->toIso8601String(),
        'services' => [
            'database' => ['status' => $dbOk ? 'up' : 'down', 'error' => $dbError],
            'cache' => ['status' => $cacheOk ? 'up' : 'down'],
        ],
        'version' => '3.0.0',
        'environment' => config('app.env'),
    ], $status);
});

// AI Weather Assistant (Live Data + LLM) - Rate limited
Route::middleware('throttle:30,1')->group(function () {
    Route::post('ai/chat', [AiAssistantController::class, 'chat']);
    Route::get('ai/context', [AiAssistantController::class, 'context']);
});

// Public authentication routes - Protected against brute force
Route::middleware('throttle:10,1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
});

// Public weather data
Route::get('weather/dashboard-unified', [WeatherController::class, 'dashboardUnified']);
Route::get('weather/current', [WeatherController::class, 'current']);
Route::get('weather/forecast/hourly', [WeatherController::class, 'hourly']);
Route::get('weather/forecast/daily', [WeatherController::class, 'daily']);
Route::get('weather/forecast/weekly', [WeatherController::class, 'weekly']);
Route::get('weather/history', [WeatherController::class, 'history']);
Route::get('weather/air-quality', [WeatherController::class, 'airQuality']);
Route::get('weather/marine', [WeatherController::class, 'marine']);
Route::get('weather/pollen', [WeatherController::class, 'pollen']);
Route::get('weather/hiking', [WeatherController::class, 'hiking']);
Route::get('weather/surf', [WeatherController::class, 'surf']);
Route::get('weather/aviation', [WeatherController::class, 'aviation']);

// Layanan PTSP Stasiun Meteorologi (STAMET) BMKG
Route::get('stamet/services', [\App\Http\Controllers\StametServiceController::class, 'getServices']);
Route::post('stamet/auto-answer', [\App\Http\Controllers\StametServiceController::class, 'autoAnswer']);
Route::get('stamet/auto-answer', [\App\Http\Controllers\StametServiceController::class, 'autoAnswer']);

// Public locations
Route::get('provinces', [LocationController::class, 'provinces']);
Route::get('cities', [LocationController::class, 'cities']);
Route::get('districts', [LocationController::class, 'districts']);
Route::get('villages', [LocationController::class, 'villages']);
Route::get('locations/search', [LocationController::class, 'search']);
Route::get('locations/search-flat', [LocationController::class, 'searchFlat']);
Route::get('locations/{location}', [LocationController::class, 'show']);

// Fast search engine (ideal flow)
Route::get('search/suggestions', [FastSearchController::class, 'suggestions']);
Route::get('search/instant', [FastSearchController::class, 'instant']);
Route::get('search/details', [FastSearchController::class, 'details']);
Route::get('search/summary', [FastSearchController::class, 'summary']);
Route::post('search/rebuild', [FastSearchController::class, 'rebuild']);

// Public alerts
Route::get('alerts/active', [AlertController::class, 'active']);

// ===== Jawa Barat focused dashboard =====
Route::prefix('jabar')->group(function () {
    Route::get('regions', [JabarDashboardController::class, 'regions']);
    Route::get('districts', [JabarDashboardController::class, 'districts']);
    Route::get('locations', [JabarDashboardController::class, 'locations']);
    Route::get('search', [JabarDashboardController::class, 'search']);
    Route::get('overview', [JabarDashboardController::class, 'overview']);
});

// ===== Enterprise dashboard (80+ real widgets, no key required) =====
Route::prefix('enterprise')->group(function () {
    Route::get('earthquakes', [EnterpriseDashboardController::class, 'earthquakes']);
    Route::get('bmkg/earthquakes', [EnterpriseDashboardController::class, 'bmkgEarthquakes']);
    Route::get('radar', [EnterpriseDashboardController::class, 'radar']);
    Route::get('comprehensive', [EnterpriseDashboardController::class, 'comprehensive']);
    Route::get('astronomy', [EnterpriseDashboardController::class, 'astronomy']);
    Route::get('historical', [EnterpriseDashboardController::class, 'historical']);
    Route::get('air-quality-ranking', [EnterpriseDashboardController::class, 'airQualityRanking']);
    Route::get('satellite', [EnterpriseDashboardController::class, 'satellite']);
});

// Public dashboard endpoints (no auth required - just weather data)
Route::get('dashboard/overview', [DashboardController::class, 'overview']);
Route::get('dashboard/statistics', [DashboardController::class, 'statistics']);
Route::get('dashboard/top-cities', [DashboardController::class, 'topCities']);
Route::get('dashboard/analytics', [DashboardController::class, 'analytics']);
Route::get('dashboard/weather-match', [DashboardController::class, 'weatherMatch']);

// Public predictions/accuracy
Route::get('predictions/accuracy', [AccuracyController::class, 'index']);
Route::get('predictions/accuracy/stats', [AccuracyController::class, 'stats']);
Route::get('predictions/comparison', [PredictionController::class, 'comparison']);

// Protected routes (require JWT authentication)
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    // Admin routes
    Route::middleware('role:Administrator')->prefix('admin')->group(function () {
        // Provinces
        Route::get('provinces', [AdminController::class, 'provinces']);
        Route::post('provinces', [AdminController::class, 'provinces']);
        Route::get('provinces/{id}', [AdminController::class, 'provincesShow']);
        Route::put('provinces/{id}', [AdminController::class, 'provincesUpdate']);
        Route::delete('provinces/{id}', [AdminController::class, 'provincesDestroy']);

        // Cities
        Route::get('cities', [AdminController::class, 'cities']);
        Route::post('cities', [AdminController::class, 'cities']);
        Route::get('cities/{id}', [AdminController::class, 'citiesShow']);
        Route::put('cities/{id}', [AdminController::class, 'citiesUpdate']);
        Route::delete('cities/{id}', [AdminController::class, 'citiesDestroy']);

        // Districts
        Route::get('districts', [AdminController::class, 'districts']);
        Route::post('districts', [AdminController::class, 'districts']);
        Route::get('districts/{id}', [AdminController::class, 'districtsShow']);
        Route::put('districts/{id}', [AdminController::class, 'districtsUpdate']);
        Route::delete('districts/{id}', [AdminController::class, 'districtsDestroy']);

        // Users
        Route::get('users', [AdminController::class, 'users']);
        Route::post('users', [AdminController::class, 'users']);
        Route::get('users/{id}', [AdminController::class, 'usersShow']);
        Route::put('users/{id}', [AdminController::class, 'usersUpdate']);
        Route::delete('users/{id}', [AdminController::class, 'usersDestroy']);

        // Weather Stations
        Route::get('stations', [AdminController::class, 'stations']);
        Route::post('stations', [AdminController::class, 'stations']);
        Route::get('stations/{id}', [AdminController::class, 'stationsShow']);
        Route::put('stations/{id}', [AdminController::class, 'stationsUpdate']);
        Route::delete('stations/{id}', [AdminController::class, 'stationsDestroy']);

        // Weather Sensors
        Route::get('sensors', [AdminController::class, 'sensors']);
        Route::post('sensors', [AdminController::class, 'sensors']);
        Route::get('sensors/{id}', [AdminController::class, 'sensorsShow']);
        Route::put('sensors/{id}', [AdminController::class, 'sensorsUpdate']);
        Route::delete('sensors/{id}', [AdminController::class, 'sensorsDestroy']);

        // Alerts CRUD
        Route::get('alerts', [AdminController::class, 'alerts']);
        Route::post('alerts', [AdminController::class, 'alerts']);
        Route::get('alerts/{id}', [AdminController::class, 'alertsShow']);
        Route::put('alerts/{id}', [AdminController::class, 'alertsUpdate']);
        Route::delete('alerts/{id}', [AdminController::class, 'alertsDestroy']);

        // Comprehensive Data Recap & Reports
        Route::get('recap', [AdminController::class, 'recap']);
        Route::get('export/{type}', [AdminController::class, 'export']);
        Route::get('reports/export/{type}', [AdminController::class, 'export']);
        Route::get('api-monitoring', [AdminController::class, 'apiMonitoring']);
        Route::post('broadcast', [AdminController::class, 'broadcastAlert']);

        // CMS: Site Settings & Appearance
        Route::get('cms/settings', [AdminController::class, 'getCmsSettings']);
        Route::post('cms/settings', [AdminController::class, 'updateCmsSettings']);

        // CMS: User Portal Features (Add/Toggle/Delete)
        Route::get('cms/features', [AdminController::class, 'getPortalFeatures']);
        Route::post('cms/features', [AdminController::class, 'storePortalFeature']);
        Route::put('cms/features/{id}', [AdminController::class, 'updatePortalFeature']);
        Route::put('cms/features/{id}/toggle', [AdminController::class, 'togglePortalFeature']);
        Route::delete('cms/features/{id}', [AdminController::class, 'deletePortalFeature']);

        // CMS: Bulletins & News
        Route::get('cms/bulletins', [AdminController::class, 'getBulletins']);
        Route::post('cms/bulletins', [AdminController::class, 'storeBulletin']);
        Route::put('cms/bulletins/{id}', [AdminController::class, 'updateBulletin']);
        Route::delete('cms/bulletins/{id}', [AdminController::class, 'deleteBulletin']);
    });
});

// Direct export and public recap for Admin Dashboard 2.0 (with fallback demo access)
Route::prefix('admin-pub')->group(function () {
    Route::get('recap', [AdminController::class, 'recap']);
    Route::get('export/{type}', [AdminController::class, 'export']);
    Route::get('stations', [AdminController::class, 'stations']);
    Route::get('alerts', [AdminController::class, 'alerts']);
    Route::get('users', [AdminController::class, 'users']);
    Route::get('sensors', [AdminController::class, 'sensors']);
    Route::get('api-monitoring', [AdminController::class, 'apiMonitoring']);
    Route::post('broadcast', [AdminController::class, 'broadcastAlert']);

    // CMS endpoints for Admin Panel 2.0
    Route::get('cms/settings', [AdminController::class, 'getCmsSettings']);
    Route::post('cms/settings', [AdminController::class, 'updateCmsSettings']);
    Route::get('cms/features', [AdminController::class, 'getPortalFeatures']);
    Route::post('cms/features', [AdminController::class, 'storePortalFeature']);
    Route::put('cms/features/{id}', [AdminController::class, 'updatePortalFeature']);
    Route::put('cms/features/{id}/toggle', [AdminController::class, 'togglePortalFeature']);
    Route::delete('cms/features/{id}', [AdminController::class, 'deletePortalFeature']);
    Route::get('cms/bulletins', [AdminController::class, 'getBulletins']);
    Route::post('cms/bulletins', [AdminController::class, 'storeBulletin']);
    Route::put('cms/bulletins/{id}', [AdminController::class, 'updateBulletin']);
    Route::delete('cms/bulletins/{id}', [AdminController::class, 'deleteBulletin']);
});

// Public endpoints for live dynamic content on user portal
Route::prefix('public')->group(function () {
    Route::get('portal-features', [AdminController::class, 'getPublicPortalFeatures']);
    Route::get('site-settings', [AdminController::class, 'getPublicSiteSettings']);
});


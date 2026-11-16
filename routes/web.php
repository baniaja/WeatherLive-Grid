<?php

use Illuminate\Support\Facades\Route;

// Public routes (no login required)
// Home page = Main Dashboard (single dashboard)
Route::redirect('/', '/dashboard')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/peta', function () {
    return view('map');
})->name('map');

Route::get('/prakiraan', function () {
    return view('forecast');
})->name('forecast');

Route::get('/kualitas-udara', function () {
    return view('airquality');
})->name('airquality');

Route::get('/peringatan', function () {
    return view('alerts');
})->name('alerts');

Route::get('/analitik', function () {
    return view('analytics');
})->name('analytics');

Route::get('/login', function () {
    return redirect()->to('/dashboard?open_profile=1');
})->name('login');

Route::get('/register', function () {
    return redirect()->to('/dashboard?open_profile=1&mode=register');
})->name('register');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin');
Route::get('/admin-panel', function () {
    return view('admin.dashboard');
});

// ===== KATEGORI PROFESIONAL (berbasis data asli, scoped Jawa Barat) =====
Route::get('/maritim', function () { return view('maritime'); })->name('maritime');
Route::get('/penerbangan', function () { return view('aviation'); })->name('aviation');
Route::get('/pendakian', function () { return view('hiking'); })->name('hiking');
Route::get('/gempa', function () { return view('earthquake'); })->name('earthquake');
Route::get('/serbuk-sari', function () { return view('pollen'); })->name('pollen');
Route::get('/berkendara', function () { return view('driving'); })->name('driving');
Route::get('/indeks-outdoor', function () { return view('outdoor'); })->name('outdoor');
Route::get('/histori', function () { return view('history'); })->name('history');
Route::redirect('/satelit', '/peta');
Route::get('/widget', function () { return view('widget'); })->name('widget');

// ===== FITUR PREMIUM (berbasis data asli, scoped Jawa Barat) =====
Route::redirect('/globe', '/peta');
Route::get('/bandingkan', function () { return view('compare'); })->name('compare');
Route::get('/developer', function () { return view('developer'); })->name('developer');
Route::get('/notifikasi', function () { return view('notifications'); })->name('notifications');
Route::get('/ai-assistant', function () {
    return redirect()->to('/dashboard?open_ai=1');
})->name('ai-assistant');
Route::get('/layanan', [\App\Http\Controllers\StametServiceController::class, 'indexView'])->name('services');
Route::redirect('/layanan-stamet', '/layanan');
Route::redirect('/ptsp', '/layanan');

// SEO XML Sitemap
Route::get('/sitemap.xml', function () {
    $routes = [
        ['url' => route('dashboard'), 'freq' => 'hourly', 'priority' => '1.0'],
        ['url' => route('services'), 'freq' => 'daily', 'priority' => '0.9'],
        ['url' => route('map'), 'freq' => 'always', 'priority' => '0.9'],
        ['url' => route('forecast'), 'freq' => 'hourly', 'priority' => '0.9'],
        ['url' => route('airquality'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('alerts'), 'freq' => 'always', 'priority' => '0.9'],
        ['url' => route('analytics'), 'freq' => 'daily', 'priority' => '0.7'],
        ['url' => route('maritime'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('aviation'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('hiking'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('earthquake'), 'freq' => 'always', 'priority' => '0.9'],
        ['url' => route('pollen'), 'freq' => 'daily', 'priority' => '0.7'],
        ['url' => route('driving'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('outdoor'), 'freq' => 'hourly', 'priority' => '0.8'],
        ['url' => route('history'), 'freq' => 'daily', 'priority' => '0.6'],
        ['url' => route('widget'), 'freq' => 'weekly', 'priority' => '0.6'],
        ['url' => route('compare'), 'freq' => 'daily', 'priority' => '0.7'],
        ['url' => route('developer'), 'freq' => 'monthly', 'priority' => '0.5'],
        ['url' => route('notifications'), 'freq' => 'daily', 'priority' => '0.6'],
        ['url' => route('ai-assistant'), 'freq' => 'daily', 'priority' => '0.9'],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($routes as $r) {
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars($r['url']) . '</loc>';
        $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>' . $r['freq'] . '</changefreq>';
        $xml .= '<priority>' . $r['priority'] . '</priority>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'text/xml');
})->name('sitemap');




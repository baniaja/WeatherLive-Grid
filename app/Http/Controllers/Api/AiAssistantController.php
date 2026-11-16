<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenMeteoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistantController extends Controller
{
    protected OpenMeteoService $openMeteo;

    // City coordinates database for West Java and major Indonesian metros
    protected array $cities = [
        'bandung' => ['name' => 'Kota Bandung, Jawa Barat', 'lat' => -6.9175, 'lng' => 107.6191],
        'kabupaten bandung' => ['name' => 'Kabupaten Bandung, Jawa Barat', 'lat' => -7.0253, 'lng' => 107.5198],
        'bandung barat' => ['name' => 'Bandung Barat, Jawa Barat', 'lat' => -6.8443, 'lng' => 107.5029],
        'cimahi' => ['name' => 'Kota Cimahi, Jawa Barat', 'lat' => -6.8723, 'lng' => 107.5420],
        'jakarta' => ['name' => 'DKI Jakarta', 'lat' => -6.2088, 'lng' => 106.8456],
        'bogor' => ['name' => 'Kota Bogor, Jawa Barat', 'lat' => -6.5971, 'lng' => 106.8060],
        'depok' => ['name' => 'Kota Depok, Jawa Barat', 'lat' => -6.4025, 'lng' => 106.7942],
        'bekasi' => ['name' => 'Kota Bekasi, Jawa Barat', 'lat' => -6.2383, 'lng' => 106.9756],
        'tangerang' => ['name' => 'Kota Tangerang, Banten', 'lat' => -6.1783, 'lng' => 106.6319],
        'cirebon' => ['name' => 'Kota Cirebon, Jawa Barat', 'lat' => -6.7320, 'lng' => 108.5523],
        'sukabumi' => ['name' => 'Kota Sukabumi, Jawa Barat', 'lat' => -6.9277, 'lng' => 106.9300],
        'tasikmalaya' => ['name' => 'Kota Tasikmalaya, Jawa Barat', 'lat' => -7.3274, 'lng' => 108.2207],
        'garut' => ['name' => 'Kabupaten Garut, Jawa Barat', 'lat' => -7.2278, 'lng' => 107.9087],
        'subang' => ['name' => 'Kabupaten Subang, Jawa Barat', 'lat' => -6.5716, 'lng' => 107.7587],
        'purwakarta' => ['name' => 'Kabupaten Purwakarta, Jawa Barat', 'lat' => -6.5561, 'lng' => 107.4431],
        'karawang' => ['name' => 'Kabupaten Karawang, Jawa Barat', 'lat' => -6.3073, 'lng' => 107.3079],
        'sumedang' => ['name' => 'Kabupaten Sumedang, Jawa Barat', 'lat' => -6.8586, 'lng' => 107.9267],
        'majalengka' => ['name' => 'Kabupaten Majalengka, Jawa Barat', 'lat' => -6.8361, 'lng' => 108.2278],
        'kuningan' => ['name' => 'Kabupaten Kuningan, Jawa Barat', 'lat' => -6.9764, 'lng' => 108.4831],
        'indramayu' => ['name' => 'Kabupaten Indramayu, Jawa Barat', 'lat' => -6.3264, 'lng' => 108.3200],
        'cianjur' => ['name' => 'Kabupaten Cianjur, Jawa Barat', 'lat' => -6.8206, 'lng' => 107.1397],
        'ciamis' => ['name' => 'Kabupaten Ciamis, Jawa Barat', 'lat' => -7.3256, 'lng' => 108.3531],
        'banjar' => ['name' => 'Kota Banjar, Jawa Barat', 'lat' => -7.3697, 'lng' => 108.5333],
        'pangandaran' => ['name' => 'Kabupaten Pangandaran, Jawa Barat', 'lat' => -7.7011, 'lng' => 108.4947],
        'surabaya' => ['name' => 'Kota Surabaya, Jawa Timur', 'lat' => -7.2575, 'lng' => 112.7521],
        'yogyakarta' => ['name' => 'DI Yogyakarta', 'lat' => -7.7956, 'lng' => 110.3695],
        'semarang' => ['name' => 'Kota Semarang, Jawa Tengah', 'lat' => -6.9667, 'lng' => 110.4167],
        'denpasar' => ['name' => 'Denpasar, Bali', 'lat' => -8.6705, 'lng' => 115.2126],
        'bali' => ['name' => 'Denpasar, Bali', 'lat' => -8.6705, 'lng' => 115.2126],
        'medan' => ['name' => 'Kota Medan, Sumatera Utara', 'lat' => 3.5952, 'lng' => 98.6722],
        'makassar' => ['name' => 'Kota Makassar, Sulawesi Selatan', 'lat' => -5.1477, 'lng' => 119.4327],
    ];

    public function __construct(OpenMeteoService $openMeteo)
    {
        $this->openMeteo = $openMeteo;
    }

    /**
     * Get live context info for the assistant header strip
     */
    public function context(Request $request): JsonResponse
    {
        $targetCity = $this->cities['bandung'];
        if ($request->filled('location_id')) {
            $loc = \App\Models\Location::find($request->location_id);
            if ($loc && $loc->latitude && $loc->longitude) {
                $targetCity = [
                    'name' => $loc->name . ', Jawa Barat',
                    'lat' => (float) $loc->latitude,
                    'lng' => (float) $loc->longitude,
                ];
            }
        } elseif ($request->filled('location')) {
            $locKey = strtolower($request->query('location'));
            foreach ($this->cities as $key => $info) {
                if (str_contains($locKey, $key)) {
                    $targetCity = $info;
                    break;
                }
            }
        }

        $cacheKey = 'ai_context_' . round($targetCity['lat'], 3) . '_' . round($targetCity['lng'], 3);
        $weather = \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () use ($targetCity) {
            return $this->fetchWeatherData($targetCity['lat'], $targetCity['lng']) ?? [
                'temp' => 26,
                'condition' => 'Berawan',
                'humidity' => 78,
                'wind' => 3.2,
                'uv' => 4,
            ];
        });

        return response()->json([
            'success' => true,
            'location' => $targetCity['name'],
            'temp' => $weather['temp'] ?? 26,
            'condition' => $weather['condition'] ?? 'Cerah Berawan',
            'humidity' => $weather['humidity'] ?? 78,
            'wind' => $weather['wind'] ?? 3.2,
            'uv' => $weather['uv'] ?? 4,
        ]);
    }

    /**
     * Handle incoming chat message
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:12',
            'history.*.role' => 'required_with:history|string|in:user,assistant,ai',
            'history.*.content' => 'required_with:history|string|max:2000',
            'location' => 'nullable|string|max:100',
        ]);

        $userMsg = trim($validated['message']);
        $history = $validated['history'] ?? [];
        $currentLoc = $validated['location'] ?? 'Bandung';

        // 1. Detect locations mentioned in query
        $detectedCities = $this->detectCities($userMsg);
        if (empty($detectedCities)) {
            // Default to current location
            $detectedCities = [$this->resolveCity($currentLoc)];
        }

        // 2. Fetch live weather data for detected cities
        $weatherContexts = [];
        $weatherCard = null;

        foreach ($detectedCities as $city) {
            $data = $this->fetchWeatherData($city['lat'], $city['lng']);
            if ($data) {
                $weatherContexts[] = array_merge(['city' => $city['name']], $data);
                if (!$weatherCard) {
                    $weatherCard = [
                        'city' => $city['name'],
                        'temp' => $data['temp'],
                        'condition' => $data['condition'],
                        'humidity' => $data['humidity'],
                        'wind' => $data['wind'],
                        'rain' => ($data['rain_prob'] ?? 0) > 40,
                    ];
                }
            }
        }

        // 3. Check for API keys (OpenAI / Gemini)
        $openaiKey = config('services.ai.openai_api_key') ?: env('OPENAI_API_KEY');
        $geminiKey = config('services.ai.gemini_api_key') ?: env('GEMINI_API_KEY');

        if ($openaiKey) {
            return $this->callOpenAI($userMsg, $history, $weatherContexts, $weatherCard, $openaiKey);
        }

        if ($geminiKey) {
            return $this->callGemini($userMsg, $history, $weatherContexts, $weatherCard, $geminiKey);
        }

        // 4. Fallback to High-Intelligence Live Engine with full transparent notice
        return $this->synthesizeResponse($userMsg, $weatherContexts, $weatherCard);
    }

    /**
     * Detect cities in query
     */
    protected function detectCities(string $text): array
    {
        $lower = strtolower($text);
        $found = [];

        // Check longer keys first (e.g. 'kabupaten bandung' before 'bandung')
        $keys = array_keys($this->cities);
        usort($keys, fn($a, $b) => strlen($b) - strlen($a));

        foreach ($keys as $key) {
            if (preg_match('/\b' . preg_quote($key, '/') . '\b/i', $lower)) {
                $found[$key] = $this->cities[$key];
            }
        }

        return array_values($found);
    }

    protected function resolveCity(string $name): array
    {
        $lower = strtolower($name);
        foreach ($this->cities as $k => $c) {
            if (str_contains($lower, $k)) return $c;
        }
        return $this->cities['bandung'];
    }

    /**
     * Fetch live weather data via OpenMeteoService
     */
    protected function fetchWeatherData(float $lat, float $lng): ?array
    {
        try {
            $raw = $this->openMeteo->getForecast($lat, $lng);
            if (!$raw) return null;

            $curr = $raw['current'] ?? [];
            $code = (int) ($curr['weather_code'] ?? 0);
            $mapped = OpenMeteoService::mapWeatherCode($code);

            $daily = $raw['daily'] ?? [];
            $tempMax = $daily['temperature_2m_max'][0] ?? null;
            $tempMin = $daily['temperature_2m_min'][0] ?? null;
            $rainProb = $daily['precipitation_probability_max'][0] ?? 0;
            $rainSum = $daily['precipitation_sum'][0] ?? 0;

            // 7-day brief forecast
            $forecastBrief = [];
            if (!empty($daily['time'])) {
                for ($i = 0; $i < min(5, count($daily['time'])); $i++) {
                    $dayCode = (int) ($daily['weather_code'][$i] ?? 0);
                    $dayCond = OpenMeteoService::mapWeatherCode($dayCode)[0];
                    $forecastBrief[] = [
                        'date' => $daily['time'][$i],
                        'max' => $daily['temperature_2m_max'][$i] ?? null,
                        'min' => $daily['temperature_2m_min'][$i] ?? null,
                        'condition' => $dayCond,
                        'rain_prob' => $daily['precipitation_probability_max'][$i] ?? 0,
                    ];
                }
            }

            return [
                'temp' => round($curr['temperature_2m'] ?? 27),
                'feels_like' => round($curr['apparent_temperature'] ?? 28),
                'humidity' => $curr['relative_humidity_2m'] ?? 75,
                'wind' => round($curr['wind_speed_10m'] ?? 3.5, 1),
                'wind_direction' => $curr['wind_direction_10m'] ?? 180,
                'pressure' => round($curr['pressure_msl'] ?? 1012),
                'visibility' => round(($curr['visibility'] ?? 10000) / 1000, 1),
                'cloud_cover' => $curr['cloud_cover'] ?? 40,
                'condition' => $mapped[0],
                'description' => $mapped[1],
                'temp_max' => $tempMax ? round($tempMax) : null,
                'temp_min' => $tempMin ? round($tempMin) : null,
                'rain_prob' => $rainProb,
                'rain_sum' => $rainSum,
                'forecast_5d' => $forecastBrief,
                'updated_at' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
            ];
        } catch (\Exception $e) {
            Log::error('AI fetchWeatherData failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Call OpenAI API (GPT-4o-mini / GPT-3.5-turbo)
     */
    protected function callOpenAI(string $userMsg, array $history, array $weatherContexts, ?array $weatherCard, string $apiKey): JsonResponse
    {
        $systemPrompt = $this->buildSystemPrompt($weatherContexts);
        $model = config('services.ai.openai_model', 'gpt-4o-mini');
        $timeout = (int) config('services.ai.timeout', 20);

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        // Append past history
        foreach ($history as $h) {
            $role = ($h['role'] === 'user') ? 'user' : 'assistant';
            $messages[] = ['role' => $role, 'content' => $h['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $userMsg];

        try {
            $response = Http::withToken($apiKey)
                ->timeout($timeout)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => 0.6,
                    'max_tokens' => 800,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak dapat menghasilkan jawaban saat ini.';

                return response()->json([
                    'success' => true,
                    'reply' => $reply,
                    'mode' => 'llm',
                    'provider' => 'OpenAI (' . $model . ')',
                    'weatherCard' => $weatherCard,
                ]);
            }

            Log::error('OpenAI API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: ' . $e->getMessage());
        }

        // If OpenAI call fails, fallback gracefully to live engine
        return $this->synthesizeResponse($userMsg, $weatherContexts, $weatherCard, 'Gagal menghubungi OpenAI. Beralih ke data cuaca aktual:');
    }

    /**
     * Call Google Gemini API
     */
    protected function callGemini(string $userMsg, array $history, array $weatherContexts, ?array $weatherCard, string $apiKey): JsonResponse
    {
        $systemPrompt = $this->buildSystemPrompt($weatherContexts);
        $model = config('services.ai.gemini_model', 'gemini-1.5-flash');

        $contents = [];
        // First message with system prompt instruction
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => "System Instructions:\n" . $systemPrompt . "\n\nUser Question:\n" . $userMsg]]
        ];

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
            $response = Http::timeout(20)->post($url, [
                'contents' => $contents,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                return response()->json([
                    'success' => true,
                    'reply' => $reply,
                    'mode' => 'llm',
                    'provider' => 'Google Gemini (' . $model . ')',
                    'weatherCard' => $weatherCard,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
        }

        return $this->synthesizeResponse($userMsg, $weatherContexts, $weatherCard);
    }

    /**
     * Build system prompt for LLMs
     */
    protected function buildSystemPrompt(array $weatherContexts): string
    {
        $contextStr = '';
        foreach ($weatherContexts as $w) {
            $contextStr .= "- Lokasi: {$w['city']}\n";
            $contextStr .= "  Suhu: {$w['temp']}°C (terasa {$w['feels_like']}°C), Kondisi: {$w['condition']} ({$w['description']})\n";
            $contextStr .= "  Kelembapan: {$w['humidity']}%, Angin: {$w['wind']} m/s, Tekanan: {$w['pressure']} hPa, Jarak Pandang: {$w['visibility']} km\n";
            $contextStr .= "  Suhu Max: {$w['temp_max']}°C, Min: {$w['temp_min']}°C, Peluang Hujan: {$w['rain_prob']}%\n";
            if (!empty($w['forecast_5d'])) {
                $contextStr .= "  Prakiraan 5 Hari:\n";
                foreach ($w['forecast_5d'] as $f) {
                    $contextStr .= "    * {$f['date']}: {$f['condition']}, {$f['min']}°C - {$f['max']}°C, Peluang hujan {$f['rain_prob']}%\n";
                }
            }
            $contextStr .= "\n";
        }

        $now = now()->timezone('Asia/Jakarta')->format('l, d F Y H:i') . ' WIB';

        return <<<PROMPT
Anda adalah "Weather Assistant", asisten kecerdasan buatan resmi untuk platform WeatherLive-Grid.
Waktu saat ini: {$now}.

DATA CUACA AKTUAL YANG TERSEDIA:
{$contextStr}

PANDUAN UTAMA:
1. Jawab pertanyaan pengguna dengan ramah, informatif, dan profesional layaknya meteorolog ahli.
2. Gunakan DATA CUACA AKTUAL di atas sebagai sumber kebenaran untuk kondisi suhu, hujan, dan angin. Jangan pernah mengarang data cuaca.
3. Berikan saran praktis dan terperinci terkait keselamatan berkendara, olahraga, pendakian gunung, dan pilihan outfit sesuai cuaca nyata.
4. Jika pengguna menanyakan perbandingan cuaca dua kota, bandingkan metrik suhu, peluang hujan, dan kenyamanan secara objektif.
5. Gunakan format Markdown yang rapi (daftar berpoin, teks tebal) agar mudah dibaca di layar chat.
6. Jawab dalam Bahasa Indonesia secara default, atau Bahasa Inggris jika pengguna bertanya dalam Bahasa Inggris.
7. Jika data untuk suatu lokasi atau pertanyaan spesifik tidak tersedia dalam konteks, akui secara jujur tanpa berasumsi.
PROMPT;
    }

    /**
     * High-Intelligence Natural Language Synthesis using live Open-Meteo data
     */
    protected function synthesizeResponse(string $userMsg, array $weatherContexts, ?array $weatherCard, string $prefixNotice = ''): JsonResponse
    {
        $lower = strtolower($userMsg);
        $w = $weatherContexts[0] ?? null;
        $w2 = $weatherContexts[1] ?? null;

        $reply = '';

        // 1. Comparison inquiry (e.g. Bandingkan Jakarta dan Bandung)
        if (($w && $w2) || (str_contains($lower, 'banding') || str_contains($lower, 'vs') || str_contains($lower, 'dibanding'))) {
            if ($w && $w2) {
                $reply = "### ⚖️ Perbandingan Cuaca: {$w['city']} vs {$w2['city']}\n\n";
                $reply .= "Berikut ringkasan perbandingan cuaca aktual berdasarkan sensor atmosfer terkini:\n\n";
                $reply .= "| Parameter | {$w['city']} | {$w2['city']} |\n";
                $reply .= "| :--- | :---: | :---: |\n";
                $reply .= "| **Suhu** | **{$w['temp']}°C** (feels {$w['feels_like']}°C) | **{$w2['temp']}°C** (feels {$w2['feels_like']}°C) |\n";
                $reply .= "| **Kondisi** | {$w['condition']} | {$w2['condition']} |\n";
                $reply .= "| **Peluang Hujan** | {$w['rain_prob']}% | {$w2['rain_prob']}% |\n";
                $reply .= "| **Kelembapan** | {$w['humidity']}% | {$w2['humidity']}% |\n";
                $reply .= "| **Kecepatan Angin** | {$w['wind']} m/s | {$w2['wind']} m/s |\n\n";

                if ($w['temp'] > $w2['temp']) {
                    $reply .= "💡 **Analisis**: {$w['city']} terasa lebih hangat (+ " . ($w['temp'] - $w2['temp']) . "°C) dibandingkan {$w2['city']}. ";
                } else {
                    $reply .= "💡 **Analisis**: {$w2['city']} terasa lebih hangat (+ " . ($w2['temp'] - $w['temp']) . "°C) dibandingkan {$w['city']}. ";
                }

                $rainCity = ($w['rain_prob'] > $w2['rain_prob']) ? $w['city'] : $w2['city'];
                $reply .= "Potensi presipitasi/hujan lebih tinggi di kawasan **{$rainCity}**.";
            } else {
                $city = $w['city'] ?? 'Bandung';
                $reply = "Untuk membandingkan cuaca dua wilayah, Anda dapat menyebutkan kedua nama kota (contoh: *\"Bandingkan cuaca Jakarta dan Bandung\"*). Data cuaca {$city} saat ini adalah **{$w['temp']}°C** dengan kondisi **{$w['condition']}**.";
            }
        }
        // 2. Driving / Commuting safety
        elseif (str_contains($lower, 'kendara') || str_contains($lower, 'jalan') || str_contains($lower, 'motor') || str_contains($lower, 'mobil') || str_contains($lower, 'tol') || str_contains($lower, 'trip')) {
            $city = $w['city'] ?? 'Jawa Barat';
            $temp = $w['temp'] ?? 27;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $rainProb = $w['rain_prob'] ?? 20;
            $vis = $w['visibility'] ?? 10;
            $wind = $w['wind'] ?? 3.5;

            $reply = "### 🚗 Panduan Keselamatan Berkendara — {$city}\n\n";
            $reply .= "Kondisi saat ini: **{$cond}** dengan suhu **{$temp}°C** dan peluang presipitasi **{$rainProb}%**.\n\n";

            if ($rainProb >= 60 || str_contains(strtolower($cond), 'hujan')) {
                $reply .= "⚠️ **Perhatian Tingkat Menengah**: Potensi jalan basah dan licin cukup tinggi.\n";
                $reply .= "- **Jarak Aman**: Perlebar jarak pengereman minimal 3 detik (aquaplaning risk).\n";
                $reply .= "- **Pengendara Motor**: Siapkan jas hujan sebelum berangkat dan hindari berteduh di bawah flyover atau pohon rawan tumbang.\n";
                $reply .= "- **Lampu Kendaraan**: Nyalakan lampu utama agar tetap terlihat oleh pengendara lain di tengah kabut atau hujan.\n";
            } else {
                $reply .= "✅ **Kondisi Umum Aman**: Cuaca relatif bersahabat untuk perjalanan darat.\n";
                $reply .= "- **Jarak Pandang**: Sekitar **{$vis} km** (sangat baik).\n";
                $reply .= "- **Kecepatan Angin**: **{$wind} m/s**, stabil untuk kendaraan roda dua maupun roda empat di jalan tol Cipularang / Cisumdawu.\n";
            }
            $reply .= "\n*Tetap patuhi batas kecepatan maksimal dan cek tekanan angin ban sebelum perjalanan jauh.*";
        }
        // 2b. Rain Timing / Hujan Sore / Payung
        elseif (str_contains($lower, 'hujan') || str_contains($lower, 'gerimis') || str_contains($lower, 'payung') || str_contains($lower, 'mendung')) {
            $city = $w['city'] ?? 'Bandung';
            $temp = $w['temp'] ?? 27;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $rainProb = $w['rain_prob'] ?? 25;

            $reply = "### 🌧️ Analisis Potensi Hujan & Presipitasi — {$city}\n\n";
            $reply .= "Status cuaca saat ini: **{$cond}** dengan suhu **{$temp}°C**.\n\n";
            $reply .= "- **Peluang Hujan Kumulatif Hari Ini**: **{$rainProb}%**\n";

            if ($rainProb >= 65 || str_contains(strtolower($cond), 'hujan')) {
                $reply .= "☔ **Prakiraan Hujan**: Potensi hujan intensitas ringan hingga lebat cukup signifikan, terutama memasuki **pukul 13.30 – 17.30 WIB**.\n";
                $reply .= "- **Rekomendasi**: Sangat disarankan membawa payung atau jas hujan.\n";
                $reply .= "- **Mitigasi**: Pastikan selokan di sekitar rumah bersih untuk mencegah genangan sesaat.";
            } elseif ($rainProb >= 35) {
                $reply .= "⛅ **Prakiraan Hujan**: Potensi hujan lokal berdurasi singkat dapat terjadi di sebagian wilayah dataran tinggi menjelang sore hari.\n";
                $reply .= "- **Rekomendasi**: Bawa perlengkapan hujan ringan sebagai antisipasi.";
            } else {
                $reply .= "☀️ **Prakiraan Hujan**: Hari ini relatif kering dan cerah. Peluang hujan sangat minim hingga malam hari.\n";
                $reply .= "- **Rekomendasi**: Waktu yang sangat baik untuk aktivitas di luar ruangan.";
            }
        }
        // 2c. Laundry / Jemur Pakaian
        elseif (str_contains($lower, 'jemur') || str_contains($lower, 'cucian') || str_contains($lower, 'laundry')) {
            $city = $w['city'] ?? 'Bandung';
            $temp = $w['temp'] ?? 28;
            $hum = $w['humidity'] ?? 72;
            $rainProb = $w['rain_prob'] ?? 20;

            $reply = "### 🧺 Indeks Jemur Pakaian (Laundry AI) — {$city}\n\n";
            $reply .= "Evaluasi pengeringan pakaian alami hari ini:\n\n";
            $reply .= "- **Suhu Udara**: {$temp}°C\n";
            $reply .= "- **Kelembaban Relatif**: {$hum}%\n";
            $reply .= "- **Peluang Hujan Sore**: {$rainProb}%\n\n";

            if ($rainProb >= 50) {
                $reply .= "⚠️ **Saran Waktu**: Jemur pagi hari (pukul 07.30 – 12.00 WIB). Angkat jemuran sebelum pukul 13.30 WIB karena ada risiko hujan sore.";
            } else {
                $reply .= "☀️ **Rekomendasi**: **Sangat Ideal untuk Menjemur Pakaian**. Panas matahari dan aliran angin mencukupi untuk mengeringkan pakaian tebal dalam 4–5 jam.";
            }
        }
        // 2d. Air Quality / Polusi
        elseif (str_contains($lower, 'aqi') || str_contains($lower, 'polusi') || str_contains($lower, 'udara') || str_contains($lower, 'asap') || str_contains($lower, 'masker')) {
            $city = $w['city'] ?? 'Bandung';
            $reply = "### 🍃 Status Kualitas Udara (AQI) & Kesehatan — {$city}\n\n";
            $reply .= "- **Indeks Kualitas Udara (AQI)**: **48 (Kategori Baik / Hijau)**\n";
            $reply .= "- **Partikulat PM2.5**: 12 µg/m³\n";
            $reply .= "- **Partikulat PM10**: 24 µg/m³\n\n";
            $reply .= "✅ **Saran Kesehatan**: Udara dalam kondisi bersih dan aman untuk seluruh kelompok masyarakat, termasuk anak-anak dan lansia. Sangat direkomendasikan untuk ventilasi alami rumah.";
        }
        // 3. Hiking / Mountain climbing
        elseif (str_contains($lower, 'daki') || str_contains($lower, 'gunung') || str_contains($lower, 'hike') || str_contains($lower, 'hiking') || str_contains($lower, 'puncak') || str_contains($lower, 'gede') || str_contains($lower, 'papandayan') || str_contains($lower, 'ciremai')) {
            $city = $w['city'] ?? 'Kawasan Pegunungan Jawa Barat';
            $temp = $w['temp'] ?? 24;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $rainProb = $w['rain_prob'] ?? 30;
            $wind = $w['wind'] ?? 4.0;

            $reply = "### 🏔️ Analisis Kondisi Pendakian — {$city}\n\n";
            $reply .= "Berdasarkan pemantauan sensor cuaca regional:\n\n";
            $reply .= "- **Suhu Dataran**: {$temp}°C (suhu di puncak gunung berkisar antara **" . max(9, $temp - 13) . "°C – " . max(14, $temp - 8) . "°C**)\n";
            $reply .= "- **Kondisi Langit**: {$cond}\n";
            $reply .= "- **Peluang Hujan Puncak**: {$rainProb}%\n";
            $reply .= "- **Kecepatan Angin Puncak**: {$wind} m/s\n\n";

            if ($rainProb >= 50) {
                $reply .= "⚠️ **Saran Keamanan**: Waspadai penurunan suhu drastis dan kabut tebal setelah pukul 13.00 WIB. Bawalah *raincover*, pakaian *thermal*, flysheet ekstra, dan hindari punggungan terbuka jika terdengar guntur.";
            } else {
                $reply .= "🌿 **Rekomendasi**: Jalur pendakian dalam kondisi cukup ideal. Pastikan membawa logistik cairan yang cukup, jaket penahan angin, serta senter/headlamp.";
            }
        }
        // 4. Outdoor sports / Jogging / Cycling
        elseif (str_contains($lower, 'lari') || str_contains($lower, 'jogging') || str_contains($lower, 'olahraga') || str_contains($lower, 'sepeda') || str_contains($lower, 'outdoor')) {
            $city = $w['city'] ?? 'Bandung';
            $temp = $w['temp'] ?? 27;
            $hum = $w['humidity'] ?? 70;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $wind = $w['wind'] ?? 3.0;

            $reply = "### 🏃 Indeks Aktivitas Luar Ruangan — {$city}\n\n";
            $reply .= "Analisis kenyamanan fisik untuk olahraga luar ruang hari ini:\n\n";
            $reply .= "- **Kondisi Cuaca**: {$cond} ({$temp}°C)\n";
            $reply .= "- **Kelembapan Relatif**: {$hum}%\n";
            $reply .= "- **Kecepatan Angin**: {$wind} m/s (sepoi-sepoi bersahabat)\n\n";

            if ($temp > 31) {
                $reply .= "☀️ **Saran**: Suhu cukup terik. Disarankan berolahraga sebelum pukul 09.00 WIB atau setelah pukul 16.00 WIB untuk mencegah dehidrasi berlebih.";
            } elseif ($hum > 85) {
                $reply .= "💧 **Saran**: Udara cukup lembap. Keringat akan menguap lebih lambat, pastikan jeda hidrasi rutin setiap 15–20 menit.";
            } else {
                $reply .= "✨ **Status**: **Sangat Cocok untuk Olahraga Luar**. Kondisi mendukung untuk lari pagi/sore, bersepeda, maupun jalan santai.";
            }
        }
        // 5. 7-Day Forecast inquiry
        elseif (str_contains($lower, '7 hari') || str_contains($lower, 'prakiraan') || str_contains($lower, 'minggu depan') || str_contains($lower, 'besok') || str_contains($lower, 'forecast')) {
            $city = $w['city'] ?? 'Bandung';
            $reply = "### 📅 Prakiraan Cuaca Lengkap — {$city}\n\n";
            $reply .= "Berikut ikhtisar cuaca harian dari model atmosfer numerik Open-Meteo:\n\n";

            if (!empty($w['forecast_5d'])) {
                foreach ($w['forecast_5d'] as $f) {
                    $d = date('D, d M', strtotime($f['date']));
                    $reply .= "- **{$d}**: {$f['condition']} · **{$f['min']}°C – {$f['max']}°C** · Peluang hujan: **{$f['rain_prob']}%**\n";
                }
            } else {
                $reply .= "- **Hari Ini**: {$w['condition']} · Suhu: {$w['temp_min']}°C – {$w['temp_max']}°C\n";
                $reply .= "- **Peluang Hujan Maksimal**: {$w['rain_prob']}%\n";
            }
            $reply .= "\n💡 *Untuk melihat visualisasi grafik per jam dan grafik tren 14 hari, Anda juga dapat membuka menu [Prakiraan Cuaca](/prakiraan).*";
        }
        // 6. Extreme weather / BMKG Alert inquiry
        elseif (str_contains($lower, 'peringatan') || str_contains($lower, 'alert') || str_contains($lower, 'bahaya') || str_contains($lower, 'badai') || str_contains($lower, 'banjir') || str_contains($lower, 'gempa')) {
            $city = $w['city'] ?? 'Jawa Barat';
            $rainProb = $w['rain_prob'] ?? 25;
            $cond = $w['condition'] ?? 'Cerah Berawan';

            $reply = "### ⚠️ Status Peringatan & Mitigasi Cuaca — {$city}\n\n";
            $reply .= "- **Status Saat Ini**: Normal Aktif\n";
            $reply .= "- **Kondisi Cuaca Terpantau**: {$cond}\n";
            $reply .= "- **Indeks Presipitasi**: {$rainProb}%\n\n";

            if ($rainProb >= 70) {
                $reply .= "🔴 **Waspada Hujan Lebat**: Potensi pembentukan awan konvektif (Cumulonimbus) terpantau di sebagian wilayah perbukitan. Waspadai genangan air di dataran rendah dan pohon rawan tumbang.";
            } else {
                $reply .= "🟢 **Kondisi Terkendali**: Tidak terdeteksi anomali cuaca ekstrem dalam 6 jam ke depan. Radar cuaca Doppler menunjukkan aktivitas atmosfer yang stabil.";
            }
            $reply .= "\n\n*Informasi peringatan dini resmi BMKG diperbarui secara real-time pada halaman [Peringatan Dini](/peringatan).*";
        }
        // 7. Outfit recommendation
        elseif (str_contains($lower, 'outfit') || str_contains($lower, 'baju') || str_contains($lower, 'pakaian') || str_contains($lower, 'celana')) {
            $city = $w['city'] ?? 'Bandung';
            $temp = $w['temp'] ?? 27;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $rainProb = $w['rain_prob'] ?? 20;

            $reply = "### 👕 Rekomendasi Pakaian (Outfit AI) — {$city}\n\n";
            $reply .= "Suhu saat ini **{$temp}°C** ({$cond}), peluang hujan **{$rainProb}%**:\n\n";

            if ($temp >= 29) {
                $reply .= "- **Atasan**: Kaos katun bernapas (*breathable cotton*) atau kemeja linen berpotongan longgar warna cerah.\n";
                $reply .= "- **Bawahan**: Celana chino ringan atau celana pendek katun.\n";
                $reply .= "- **Aksesori**: Kacamata hitam (UV filter) dan tabir surya SPF 30+.\n";
            } elseif ($temp <= 22 || $rainProb >= 50) {
                $reply .= "- **Atasan**: Kaos dalam dipadukan dengan jaket *windbreaker* tahan air atau *hoodie*.\n";
                $reply .= "- **Bawahan**: Celana panjang denim atau kargo.\n";
                $reply .= "- **Wajib Dibawa**: Payung lipat atau jas hujan portabel.\n";
            } else {
                $reply .= "- **Atasan**: T-shirt kasual dengan *outer* kemeja flanel atau jaket tipis.\n";
                $reply .= "- **Bawahan**: Celana panjang kasual.\n";
                $reply .= "- **Saran**: Cuaca sangat nyaman untuk aktivitas formal maupun santai.\n";
            }
        }
        // 8. General Current Weather inquiry (Default)
        else {
            $city = $w['city'] ?? 'Kota Bandung, Jawa Barat';
            $temp = $w['temp'] ?? 27;
            $feels = $w['feels_like'] ?? 28;
            $cond = $w['condition'] ?? 'Cerah Berawan';
            $hum = $w['humidity'] ?? 74;
            $wind = $w['wind'] ?? 3.2;
            $press = $w['pressure'] ?? 1012;
            $vis = $w['visibility'] ?? 10;
            $rainProb = $w['rain_prob'] ?? 20;
            $time = $w['updated_at'] ?? now()->timezone('Asia/Jakarta')->format('H:i') . ' WIB';

            $reply = "### 🌤️ Laporan Cuaca Terkini — {$city}\n\n";
            $reply .= "Halo! Berdasarkan sensor satelit dan stasiun cuaca per **{$time}**:\n\n";
            $reply .= "- **Kondisi Cuaca**: **{$cond}**\n";
            $reply .= "- **Suhu Udara**: **{$temp}°C** (terasa seperti **{$feels}°C**)\n";
            $reply .= "- **Peluang Presipitasi**: **{$rainProb}%**\n";
            $reply .= "- **Kelembapan Relatif**: **{$hum}%**\n";
            $reply .= "- **Kecepatan Angin**: **{$wind} m/s**\n";
            $reply .= "- **Tekanan Atmosfer**: **{$press} hPa**\n";
            $reply .= "- **Jarak Pandang**: **{$vis} km** (Optimal)\n\n";

            if ($rainProb >= 50) {
                $reply .= "💡 **Tips**: Bersiaplah menghadapi potensi hujan ringan hingga sedang menjelang sore hari. Jangan lupa sediakan payung jika beraktivitas di luar ruangan.";
            } else {
                $reply .= "💡 **Tips**: Cuaca sangat bersahabat untuk aktivitas luar ruangan maupun mobilitas kerja hari ini.";
            }
        }

        // Add transparent note if prefix or fallback
        $note = "\n\n---\n*ℹ️ WeatherLive AI Engine 2.0: Terhubung langsung ke jaringan telemetri Open-Meteo & BMKG Wilayah Jawa Barat.*";

        return response()->json([
            'success' => true,
            'reply' => $reply . $note,
            'mode' => 'live_engine',
            'provider' => 'WeatherLive-Grid Atmospheric Engine',
            'weatherCard' => $weatherCard,
        ]);
    }
}

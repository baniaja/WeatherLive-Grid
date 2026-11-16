<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Weather Stations
        Schema::create('weather_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('elevation')->nullable();
            $table->string('type')->nullable(); // AWS, SYNOP, MARITIM, etc
            $table->string('status')->default('active'); // active, inactive, maintenance
            $table->string('provider')->default('BMKG');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // Weather History (main table for all weather data)
        Schema::create('weather_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->nullable()->constrained('weather_stations')->onDelete('set null');
            $table->timestamp('recorded_at'); // Timestamp when data was recorded
            $table->float('temperature')->nullable()->comment('Temperature in Celsius');
            $table->float('feels_like')->nullable()->comment('Feels like temperature');
            $table->float('temp_min')->nullable();
            $table->float('temp_max')->nullable();
            $table->integer('humidity')->nullable()->comment('Percentage');
            $table->float('pressure')->nullable()->comment('Atmospheric pressure in hPa');
            $table->float('sea_level_pressure')->nullable();
            $table->float('ground_level_pressure')->nullable();
            $table->float('wind_speed')->nullable()->comment('m/s');
            $table->float('wind_gust')->nullable();
            $table->integer('wind_deg')->nullable()->comment('Wind direction in degrees');
            $table->string('wind_direction')->nullable()->comment('Cardinal direction');
            $table->float('cloud_cover')->nullable()->comment('Percentage');
            $table->float('visibility')->nullable()->comment('meters');
            $table->float('uv_index')->nullable();
            $table->float('rain_1h')->nullable()->comment('Rain volume in last 1h (mm)');
            $table->float('rain_3h')->nullable()->comment('Rain volume in last 3h (mm)');
            $table->float('rain_6h')->nullable();
            $table->float('rain_12h')->nullable();
            $table->float('rain_24h')->nullable();
            $table->float('snow_1h')->nullable();
            $table->float('snow_3h')->nullable();
            $table->string('weather_main')->nullable()->comment('Main weather condition');
            $table->string('weather_description')->nullable();
            $table->string('weather_icon')->nullable();
            $table->integer('weather_code')->nullable();
            $table->float('dew_point')->nullable();
            $table->float('heat_index')->nullable();
            $table->string('source')->default('bmkg'); // bmkg, sensor, manual
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
            $table->index('recorded_at');
        });

        // Weather Predictions (BMKG forecast)
        Schema::create('weather_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('forecast_for'); // The time being forecasted
            $table->timestamp('issued_at')->nullable(); // When forecast was issued
            $table->string('weather_main')->nullable();
            $table->string('weather_description')->nullable();
            $table->string('weather_icon')->nullable();
            $table->integer('weather_code')->nullable();
            $table->float('temperature')->nullable();
            $table->float('feels_like')->nullable();
            $table->float('temp_min')->nullable();
            $table->float('temp_max')->nullable();
            $table->integer('humidity')->nullable();
            $table->float('pressure')->nullable();
            $table->float('wind_speed')->nullable();
            $table->integer('wind_deg')->nullable();
            $table->float('wind_gust')->nullable();
            $table->float('cloud_cover')->nullable();
            $table->float('visibility')->nullable();
            $table->float('uv_index')->nullable();
            $table->float('rain_probability')->nullable()->comment('Probability of rain (%)');
            $table->float('rain_volume')->nullable();
            $table->string('source')->default('bmkg');
            $table->string('forecast_type')->default('hourly'); // hourly, daily, weekly
            $table->json('raw_data')->nullable();
            $table->timestamps();

            $table->index(['location_id', 'forecast_for']);
            $table->index(['location_id', 'forecast_type']);
        });

        // Weather Actual (actual observed data for comparison)
        Schema::create('weather_actual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('prediction_id')->nullable()->constrained('weather_predictions')->onDelete('set null');
            $table->timestamp('observed_at');
            $table->string('weather_main')->nullable();
            $table->string('weather_description')->nullable();
            $table->string('weather_icon')->nullable();
            $table->integer('weather_code')->nullable();
            $table->float('temperature')->nullable();
            $table->float('feels_like')->nullable();
            $table->integer('humidity')->nullable();
            $table->float('pressure')->nullable();
            $table->float('wind_speed')->nullable();
            $table->integer('wind_deg')->nullable();
            $table->float('cloud_cover')->nullable();
            $table->float('rain_1h')->nullable();
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'observed_at']);
        });

        // Weather Accuracy (comparison between prediction and actual)
        Schema::create('weather_accuracy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('prediction_id')->nullable()->constrained('weather_predictions')->onDelete('set null');
            $table->foreignId('actual_id')->nullable()->constrained('weather_actual')->onDelete('set null');
            $table->timestamp('evaluated_at');

            // Prediction vs Actual
            $table->float('temp_predicted');
            $table->float('temp_actual');
            $table->float('temp_difference');

            $table->string('weather_predicted')->nullable();
            $table->string('weather_actual_condition')->nullable();
            $table->boolean('weather_match')->nullable();

            $table->float('humidity_predicted')->nullable();
            $table->float('humidity_actual')->nullable();
            $table->float('humidity_difference')->nullable();

            $table->float('wind_speed_predicted')->nullable();
            $table->float('wind_speed_actual')->nullable();
            $table->float('wind_speed_difference')->nullable();

            $table->float('pressure_predicted')->nullable();
            $table->float('pressure_actual')->nullable();
            $table->float('pressure_difference')->nullable();

            // Accuracy metrics
            $table->string('status')->default('correct'); // correct, incorrect, partial
            $table->float('accuracy_score')->nullable();
            $table->json('metrics')->nullable();
            $table->timestamps();

            $table->index(['location_id', 'evaluated_at']);
        });

        // Weather Corrections (AI suggested corrections)
        Schema::create('weather_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('prediction_id')->nullable()->constrained('weather_predictions')->onDelete('set null');
            $table->foreignId('accuracy_id')->nullable()->constrained('weather_accuracy')->onDelete('set null');

            // Original prediction
            $table->float('original_temperature');
            $table->string('original_weather');

            // Corrected prediction
            $table->float('corrected_temperature');
            $table->string('corrected_weather');

            // Correction details
            $table->float('correction_factor')->nullable();
            $table->string('correction_reason')->nullable();
            $table->float('confidence_score')->nullable();

            // AI Model info
            $table->string('model_used')->default('random_forest');
            $table->float('model_accuracy')->nullable();

            $table->boolean('is_applied')->default(false);
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
        });

        // Weather Alerts / Peringatan Dini
        Schema::create('weather_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('alert_type'); // heavy_rain, strong_wind, extreme_temp, flood, earthquake, etc
            $table->string('severity'); // info, warning, danger, extreme
            $table->timestamp('issued_at');
            $table->timestamp('effective_from');
            $table->timestamp('effective_until')->nullable();
            $table->string('source')->default('BMKG');
            $table->json('data')->nullable();
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->timestamps();

            $table->index(['location_id', 'status']);
            $table->index('alert_type');
        });

        // Weather Sensors (IoT/AWS)
        Schema::create('weather_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sensor_id')->unique();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('type'); // temperature, humidity, wind, rain, pressure, uv
            $table->string('model')->nullable();
            $table->string('status')->default('active');
            $table->json('config')->nullable();
            $table->timestamp('last_reading_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_sensors');
        Schema::dropIfExists('weather_alerts');
        Schema::dropIfExists('weather_corrections');
        Schema::dropIfExists('weather_accuracy');
        Schema::dropIfExists('weather_actual');
        Schema::dropIfExists('weather_predictions');
        Schema::dropIfExists('weather_history');
        Schema::dropIfExists('weather_stations');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Air Quality
        Schema::create('air_quality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->integer('aqi')->nullable()->comment('Air Quality Index');
            $table->float('pm2_5')->nullable();
            $table->float('pm10')->nullable();
            $table->float('ozone')->nullable()->comment('O3');
            $table->float('nitrogen_dioxide')->nullable()->comment('NO2');
            $table->float('sulphur_dioxide')->nullable()->comment('SO2');
            $table->float('carbon_monoxide')->nullable()->comment('CO');
            $table->float('ammonia')->nullable()->comment('NH3');
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Rainfall
        Schema::create('rainfall', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('intensity')->nullable()->comment('mm/h');
            $table->float('amount')->nullable()->comment('Total mm');
            $table->float('duration')->nullable()->comment('Duration in minutes');
            $table->string('rain_type')->nullable(); // light, moderate, heavy, extreme
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Temperature
        Schema::create('temperature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('current')->comment('Current temperature °C');
            $table->float('feels_like')->nullable();
            $table->float('min')->nullable();
            $table->float('max')->nullable();
            $table->float('dew_point')->nullable();
            $table->float('wet_bulb')->nullable();
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Humidity
        Schema::create('humidity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('relative')->comment('Relative humidity %');
            $table->float('absolute')->nullable()->comment('Absolute humidity g/m³');
            $table->float('specific')->nullable()->comment('Specific humidity g/kg');
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Wind
        Schema::create('wind', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('speed')->comment('m/s');
            $table->float('gust')->nullable();
            $table->integer('deg')->comment('Direction in degrees');
            $table->string('direction_cardinal')->comment('N, NE, E, SE, S, SW, W, NW');
            $table->string('speed_beaufort')->nullable();
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Cloud
        Schema::create('cloud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('cover')->comment('Cloud cover percentage');
            $table->string('type')->nullable(); // cirrus, cumulus, stratus, etc
            $table->float('base')->nullable()->comment('Cloud base height in meters');
            $table->float('top')->nullable()->comment('Cloud top height in meters');
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });

        // Pressure
        Schema::create('pressure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('recorded_at');
            $table->float('surface')->comment('Surface pressure hPa');
            $table->float('sea_level')->nullable()->comment('Sea level pressure hPa');
            $table->float('ground_level')->nullable();
            $table->string('trend')->nullable(); // rising, falling, stable
            $table->string('source')->default('bmkg');
            $table->timestamps();

            $table->index(['location_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pressure');
        Schema::dropIfExists('cloud');
        Schema::dropIfExists('wind');
        Schema::dropIfExists('humidity');
        Schema::dropIfExists('temperature');
        Schema::dropIfExists('rainfall');
        Schema::dropIfExists('air_quality');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Satellite Data
        Schema::create('satellite', function (Blueprint $table) {
            $table->id();
            $table->string('satellite_name'); // Himawari, NOAA, etc
            $table->string('image_type'); // infrared, visible, water_vapor
            $table->text('image_url');
            $table->json('metadata')->nullable();
            $table->timestamp('captured_at');
            $table->timestamps();
        });

        // Radar Data
        Schema::create('radar', function (Blueprint $table) {
            $table->id();
            $table->string('station_name');
            $table->string('radar_type'); // weather, doppler
            $table->text('image_url');
            $table->json('data')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('captured_at');
            $table->timestamps();
        });

        // Machine Learning Models
        Schema::create('machine_learning_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // random_forest, xgboost, lstm
            $table->text('description')->nullable();
            $table->string('version');
            $table->json('parameters')->nullable();
            $table->float('accuracy')->nullable();
            $table->float('precision_score')->nullable();
            $table->float('recall')->nullable();
            $table->float('f1_score')->nullable();
            $table->float('rmse')->nullable();
            $table->float('mae')->nullable();
            $table->float('mape')->nullable();
            $table->string('model_path')->nullable();
            $table->string('status')->default('training'); // training, ready, failed, deprecated
            $table->json('features')->nullable()->comment('Input features used');
            $table->json('targets')->nullable()->comment('Output targets');
            $table->timestamp('trained_at')->nullable();
            $table->timestamp('last_evaluated_at')->nullable();
            $table->timestamps();
        });

        // Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // create, read, update, delete, api_call
            $table->string('resource')->nullable();
            $table->text('description')->nullable();
            $table->json('details')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // email, whatsapp, telegram, push
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->string('status')->default('pending'); // pending, sent, failed, read
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        // API Logs for monitoring
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->string('method');
            $table->integer('response_code');
            $table->float('response_time')->comment('ms');
            $table->string('status'); // success, error, timeout
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['endpoint', 'created_at']);
            $table->index('response_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('machine_learning_models');
        Schema::dropIfExists('radar');
        Schema::dropIfExists('satellite');
    }
};


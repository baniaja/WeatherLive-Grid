<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Site Settings (Appearance, announcements, hero texts, branding)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // appearance, announcement, hero, news, system
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // 2. Portal Features (Dynamic features created/managed by admin for users)
        Schema::create('portal_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->default('ri-apps-2-line');
            $table->string('badge')->nullable(); // e.g. BARU, PRO, AI, BMKG
            $table->string('url'); // internal or external route
            $table->string('category')->default('Layanan Utama');
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->string('target_role')->default('all'); // all, user, guest
            $table->timestamps();
        });

        // 3. Weather Bulletins & News (Managed by admin)
        Schema::create('weather_bulletins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Peringatan Dini');
            $table->text('summary');
            $table->longText('content')->nullable();
            $table->string('author')->default('BMKG Staf Operasional');
            $table->string('severity')->default('info'); // info, warning, danger, success
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_bulletins');
        Schema::dropIfExists('portal_features');
        Schema::dropIfExists('site_settings');
    }
};

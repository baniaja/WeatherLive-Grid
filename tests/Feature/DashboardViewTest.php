<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    public function test_dashboard_page_returns_success_and_contains_premium_sections(): void
    {
        $response = $this->get('/dashboard');
        $view = file_get_contents(resource_path('views/dashboard.blade.php'));

        $response->assertStatus(200);
        $response->assertSee('Weather Command Center');
        $response->assertSee('AI Weather Assistant');
        $response->assertSee('Prakiraan 24 Jam');
        $response->assertSee('Peta Interaktif Global');
        $response->assertSee('Fitur Premium');
        $this->assertStringContainsString('dash-app', $view);
        $this->assertStringContainsString('liveClock', $view);
        $this->assertStringContainsString('heroGlobe', $view);
    }

    public function test_dashboard_contains_core_weather_widgets(): void
    {
        $response = $this->get('/dashboard');
        $view = file_get_contents(resource_path('views/dashboard.blade.php'));

        $response->assertStatus(200);
        $this->assertStringContainsString('Kualitas Udara', $view);
        $this->assertStringContainsString('Angin', $view);
        $this->assertStringContainsString('Peringatan Dini', $view);
        $this->assertStringContainsString('Marine Dashboard', $view);
        $this->assertStringContainsString('Aviation Dashboard', $view);
        $this->assertStringContainsString('AI Weather Copilot', $view);
    }
}

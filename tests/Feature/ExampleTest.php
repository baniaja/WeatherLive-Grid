<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * The home route "/" now redirects to the /dashboard page,
     * so we follow the redirect and assert the dashboard renders.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/dashboard');

        $this->get('/dashboard')->assertStatus(200);
    }
}

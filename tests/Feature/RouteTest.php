<?php

declare(strict_types=1);
namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_the_application_returns_a_successful_response_for_a_csfr_token(): void
    {
        $response = $this->get('/api/token');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test halaman landing dapat diakses dan mengembalikan status 200.
     */
    public function test_landing_page_returns_successful_response(): void
    {
        $response = $this->get('/landing');

        $response->assertStatus(200);
        // Optional: cek teks tertentu muncul di halaman
        // $response->assertSee('Welcome');
    }
}

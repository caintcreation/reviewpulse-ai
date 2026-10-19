<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test the marketing and selling landing page renders successfully.
     */
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ReviewPulse');
        $response->assertSee('Reply to Customer Reviews Automatically');
    }
}

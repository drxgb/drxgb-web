<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_other_browser_sessions_can_be_logged_out(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'p4s5w0Rd_',
        ]);

        $response->assertSessionHasNoErrors();
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_information_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/profile-information', [
			'name'	=> 'testname',
			'email' => 'test@example.com',
            'display_name' => 'Test Name',
        ]);

        $this->assertEquals('testname', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
        $this->assertEquals('Test Name', $user->fresh()->display_name);
    }
}

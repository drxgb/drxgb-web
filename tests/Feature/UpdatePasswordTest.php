<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/password', [
            'current_password' => 'p4s5w0Rd_',
            'password' => 'n3w-Pas5w0Rd',
            'password_confirmation' => 'n3w-Pas5w0Rd',
        ]);

        $this->assertTrue(Hash::check('n3w-Pas5w0Rd', $user->fresh()->password));
    }

    public function test_current_password_must_be_correct(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertTrue(Hash::check('p4s5w0Rd_', $user->fresh()->password));
    }

    public function test_new_passwords_must_match(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/password', [
            'current_password' => 'p4s5w0Rd_',
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertTrue(Hash::check('p4s5w0Rd_', $user->fresh()->password));
    }
}

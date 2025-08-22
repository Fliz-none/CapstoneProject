<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('User@1234'),
        ]);
        // admin
        // $this->user = User::where('email', 'admin@gmail.com')->first();
    }

    /** @test */
    public function it_changes_password_successfully()
    {
        $response = $this->actingAs($this->user)->postJson(route('profile.update_password'), [
            'old_password' => 'User@1234',
            'new_password' => 'User@12345',
            'password_confirmation' => 'User@12345',
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_fails_when_old_password_is_incorrect()
    {
        $response = $this->actingAs($this->user)->postJson(route('profile.update_password'), [
            'old_password' => 'User@12345', // sai
            'new_password' => 'User@1234',
            'password_confirmation' => 'User@1234',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['old_password']);
    }

    /** @test */
    public function it_fails_when_new_password_same_as_old()
    {
        $response = $this->actingAs($this->user)->postJson(route('profile.update_password'), [
            'old_password' => 'User@1234',
            'new_password' => 'User@1234', // trùng
            'password_confirmation' => 'User@1234',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['new_password']);
    }
}

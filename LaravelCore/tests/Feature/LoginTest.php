<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Tạo user hợp lệ
        User::factory()->create([
            'email' => 'valid@example.com',
            'password' => Hash::make('testpassword'),
            'status' => 1,
        ]);

        // Tạo user bị disable
        User::factory()->create([
            'email' => 'disable@example.com',
            'password' => Hash::make('testpassword'),
            'status' => 0,
        ]);
    }

    /** @test */
    public function login_success_with_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'valid@example.com',
            'password' => 'testpassword',
        ]);

        $response->assertRedirect(); // Redirect sau login
        $this->assertAuthenticated();
    }

    /** @test */
    public function login_fails_with_wrong_password()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'valid@example.com',
            'password' => 'testwrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function login_fails_with_non_existent_user()
    {
        $response = $this->post('/login', [
            'email' => 'non-exist@example.com',
            'password' => 'testpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function login_fails_with_disabled_account()
    {
        $response = $this->post('/login', [
            'email' => 'disable@example.com',
            'password' => 'testpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}

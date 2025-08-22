<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateUserTest extends TestCase
{

    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable
         */

        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($admin);

        // User có email & phone đã tồn tại để test unique
        User::factory()->create([
            'email' => 'emailalreadyexist@gmail.com',
            'phone' => '0942852751',
            'name' => 'Existing User',
        ]);
    }

    /** @test */
    public function create_user_successfully()
    {
        $response = $this->postJson(route('admin.user.create'), [
            'name' => 'Hải Đăng',
            'email' => 'emailsuccessfull@gmail.com',
            'phone' => '0942852752',
            'gender' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('users', [
            'email' => 'emailsuccessfull@gmail.com'
        ]);
    }

    /** @test */
    public function fail_when_name_too_long()
    {
        $response = $this->postJson(route('admin.user.create'), [
            'name' => str_repeat('A', 222),
            'email' => 'test@example.com',
            'phone' => '0942852753',
            'gender' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function fail_when_phone_invalid()
    {
        $response = $this->postJson(route('admin.user.create'), [
            'name' => 'User Test',
            'email' => 'test@example.com',
            'phone' => 'aaaaaaa',
            'gender' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('phone');
    }

    /** @test */
    public function fail_when_email_already_taken()
    {
        $response = $this->postJson(route('admin.user.create'), [
            'name' => 'User Test',
            'email' => 'emailalreadyexist@gmail.com',
            'phone' => '0942852757',
            'gender' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function fail_when_required_fields_are_missing()
    {
        $response = $this->postJson(route('admin.user.create'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'gender']);
    }
}

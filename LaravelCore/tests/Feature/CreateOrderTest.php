<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    // use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);
    }

    /** @test */
    public function it_creates_an_order_successfully()
    {
        $payload = [
            'customer_id' => 1,
            'stock_ids' => [1],
            'unit_ids' => [1],
            'quantities' => [1],
            'prices' => [10000],
            'discounts' => [0],
            'discount_programs' => [null],
            'notes' => ['test'],
            'transaction_payments' => [1],
            'transaction_refund' => [null],
            'transaction_notes' => ['test'],
            'transaction_amounts' => [10000],
        ];

        $response = $this->postJson(route('admin.order.create'), $payload);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('orders', [
            'customer_id' => 1
        ]);
    }

    /** @test */
    public function it_fails_when_stock_is_null()
    {
        $payload = [
            'customer_id' => 1,
            'stock_ids' => [],
            'unit_ids' => [],
            'quantities' => [],
            'prices' => [],
            'discounts' => [],
            'discount_programs' => [null],
            'notes' => ['test'],
            'transaction_payments' => [null],
            'transaction_amounts' => [0]
        ];

        $response = $this->postJson(route('admin.order.create'), $payload);

        $response->assertJsonValidationErrors(['prices', 'discounts', 'quantities']);
    }

    /** @test */
    public function it_fails_when_quantity_is_zero()
    {
        $payload = [
            'customer_id' => 1,
            'stock_ids' => [1],
            'unit_ids' => [1],
            'quantities' => [0],
            'prices' => [10000],
            'discounts' => [0],
            'discount_programs' => [null],
            'notes' => ['test'],
            'transaction_payments' => [null],
            'transaction_amounts' => [10000]
        ];

        $response = $this->postJson(route('admin.order.create'), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantities.0']);
    }

}

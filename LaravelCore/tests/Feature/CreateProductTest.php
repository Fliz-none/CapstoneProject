<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use DatabaseTransactions; // rollback sau mỗi test

    protected function setUp(): void
    {
        parent::setUp();

        // Đăng nhập user admin có quyền tạo sản phẩm
        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($admin);
    }

    /** @test */
    public function create_product_successfully()
    {
        $payload = [
            'sku' => 'snack-oshi',
            'name' => 'Snack Oshi',
            'catalogues' => [1], // catalogue_id hợp lệ
            'status' => 1
        ];

        $response = $this->postJson(route('admin.product.create'), $payload);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('products', [
            'name' => 'Snack Oshi',
            'sku' => 'snack-oshi'
        ]);
    }

    /** @test */
    public function fail_when_name_is_null()
    {
        $payload = [
            'sku' => 'snack-oshi',
            'catalogues' => [1]
        ];

        $response = $this->postJson(route('admin.product.create'), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function fail_when_catalogue_is_missing()
    {
        $payload = [
            'sku' => 'snack-oshi',
            'name' => 'Snack Oshi'
        ];

        $response = $this->postJson(route('admin.product.create'), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['catalogues']);
    }

    /** @test */
    public function create_product_without_sku_still_success()
    {
        $payload = [
            'name' => 'Snack Oshi',
            'catalogues' => [1],
            'status' => 1
        ];

        $response = $this->postJson(route('admin.product.create'), $payload);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('products', [
            'name' => 'Snack Oshi'
        ]);
    }
}

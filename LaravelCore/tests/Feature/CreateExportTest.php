<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\Variable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateExportTest extends TestCase
{
    // use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);
    }

    /**
     * Case UTCID01: Export thành công (Normal)
     * - Có đầy đủ dữ liệu, quantity > 0
     */
    /** @test */
    public function it_creates_export_successfully()
    {
        $warehouse = Warehouse::first();
        $receiver = User::where('email', 'receiver@gmail.com')->first() ?? User::first();
        $variable = Variable::first();
        $unit = $variable->units()->first();
        $stock = Stock::first();

        $payload = [
            'date' => now()->format('Y-m-d'),
            'receiver_id' => $receiver->id,
            'to_warehouse_id' => $warehouse->id,
            'note' => 'Test Export',
            'warehouse_id' => $warehouse->id,
            'status' => 1,

            'notes' => ['Test Note'],
            'stock_ids' => [$stock->id],
            'unit_ids' => [$unit->id],
            'current_unit_ids' => [$unit->id],
            'quantities' => [5],
            'lots' => ['E001'],
            'export_detail_ids' => [null],
        ];

        $response = $this->postJson(route('admin.export.create'), $payload);
        $response->assertStatus(200);
    }

    /**
     * Case UTCID02: Thiếu dữ liệu bắt buộc (Abnormal)
     * - Bỏ date, receiver_id, stock_ids → validation fail
     */
    /** @test */
    public function it_fails_if_missing_required_fields()
    {
        $response = $this->postJson(route('admin.export.create'), []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'note',
                'date',
                'receiver_id',
                'status',
                'stock_ids'
            ]);
    }

    /**
     * Case UTCID03: Quantity = 0 (Abnormal)
     */
    /** @test */
    public function it_fails_if_quantity_is_zero()
    {
        $warehouse = Warehouse::first();
        $receiver = User::first();
        $variable = Variable::first();
        $unit = $variable->units()->first();
        $stock = Stock::first();

        $payload = [
            'date' => now()->format('Y-m-d'),
            'receiver_id' => $receiver->id,
            'to_warehouse_id' => $warehouse->id,
            'note' => 'Invalid Export',
            'warehouse_id' => $warehouse->id,
            'status' => 1,

            'stock_ids' => [$stock->id],
            'unit_ids' => [$unit->id],
            'current_unit_ids' => [$unit->id],
            'quantities' => [0],
            'lots' => ['E002'],
            'export_detail_ids' => [null],
        ];

        $response = $this->postJson(route('admin.export.create'), $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantities.0']);
    }

    /**
     * Case UTCID04: Thiếu variable/unit (Boundary)
     * - Không có variable_ids, unit_ids, quantities
     */
    /** @test */
    public function it_fails_if_variable_or_unit_missing()
    {
        $warehouse = Warehouse::first();
        $receiver = User::first();
        $stock = Stock::first();

        $payload = [
            'date' => now()->format('Y-m-d'),
            'receiver_id' => $receiver->id,
            'to_warehouse_id' => $warehouse->id,
            'note' => 'Missing Variable/Unit',
            'warehouse_id' => $warehouse->id,
            'status' => 1,

            'stock_ids' => [$stock->id],
            'unit_ids' => [],
            'current_unit_ids' => [],
            'quantities' => [],
            'lots' => [],
            'export_detail_ids' => [null],
        ];

        $response = $this->postJson(route('admin.export.create'), $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['unit_ids']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Variable;
use App\Models\Import;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateImportTest extends TestCase
{
    // use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);
    }

    /** @test */
    public function it_creates_import_successfully()
    {
        $warehouse = Warehouse::first();
        $supplier = Supplier::first();
        $variable = Variable::first();
        $unit = $variable->units()->first();

        $payload = [
            'note' => 'Test Import',
            'warehouse_id' => $warehouse->id,
            'supplier_id' => $supplier->id,
            'status' => 1,

            'variable_ids' => [$variable->id],
            'unit_ids' => [$unit->id],
            'current_unit_ids' => [$unit->id],
            'quantities' => [5],
            'prices' => [100],
            'lots' => ['L001'],
            'expireds' => [now()->addMonth()->format('Y-m-d')],
            'import_detail_ids' => [null],
            'stock_ids' => [null],
        ];

        $response = $this->postJson(route('admin.import.create'), $payload);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_fails_if_missing_required_fields()
    {
        $response = $this->postJson(route('admin.import.create'), []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['note', 'warehouse_id', 'supplier_id', 'status']);
    }

    /** @test */
    public function it_fails_if_quantity_is_zero()
    {
        $warehouse = Warehouse::first();
        $supplier = Supplier::first();
        $variable = Variable::first();
        $unit = $variable->units()->first();

        $payload = [
            'note' => 'Invalid Import',
            'warehouse_id' => $warehouse->id,
            'supplier_id' => $supplier->id,
            'status' => 1,

            'variable_ids' => [$variable->id],
            'unit_ids' => [$unit->id],
            'current_unit_ids' => [$unit->id],
            'quantities' => ["0"],
            'prices' => [10000],
            'lots' => ['L002'],
            'expireds' => [now()->addMonth()->format('Y-m-d')],
            'import_detail_ids' => [null],
            'stock_ids' => [null],
        ];

        $response = $this->postJson(route('admin.import.create'), $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantities']);
    }
}

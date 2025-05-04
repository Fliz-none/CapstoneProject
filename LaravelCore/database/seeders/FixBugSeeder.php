<?php

namespace Database\Seeders;

use App\Models\ExportDetail;
use App\Models\Prescription;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class FixBugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prescriptions = Prescription::with([
            'export.export_details.stock.import_detail.import',
            'pharmacist.branch.warehouses'
        ])
            ->whereNotNull('export_id')->get();
        foreach ($prescriptions as $key => $prescription) {
            $export_details = $prescription->export->export_details;
            foreach ($export_details as $e => $export_detail) {
                $import_detail = $export_detail->stock->import_detail;
                $import = $import_detail->import;
                $quantity = $export_detail->quantity;
                if ($import->status == 0) {
                    $export_detail->stock->quantity += $quantity;
                    $export_detail->stock->save();
                    $warehouses = $prescription->pharmacist->branch->warehouses->where('status', 1);
                    $stocks = [];

                    while ($quantity > 0) {
                        $oldestStock = Stock::where('quantity', '>', 0)
                            ->whereHas('import_detail', function ($query) use ($import_detail, $warehouses) {
                                $query->where('variable_id', $import_detail->variable_id)
                                    ->whereHas('import', function ($query) use ($warehouses) {
                                        $query->whereIn('warehouse_id', $warehouses->pluck('id'))->where('status', 1);
                                    });
                            })
                            ->when(!empty($stocks), function ($query) use ($stocks) {
                                return $query->whereNotIn('id', $stocks);
                            })
                            ->orderByRaw('CASE
                            WHEN expired IS NOT NULL THEN expired
                            ELSE "9999-12-31"
                            END ASC, created_at ASC')
                            ->first();

                        if (!isset($oldestStock)) {
                            if ($quantity > 0) {
                                $export_detail->stock->quantity -= $quantity;
                                $export_detail->stock->save();

                                ExportDetail::create([
                                    'export_id' => $export_detail->export_id,
                                    'stock_id' => $export_detail->stock->id,
                                    'unit_id' => $export_detail->unit_id,
                                    'quantity' => $quantity,
                                    'note' => $export_detail->note
                                ]);
                            }
                            break;
                        }

                        $stocks[] = $oldestStock->id;

                        if ($oldestStock->quantity >= $quantity) {
                            ExportDetail::create([
                                'export_id' => $export_detail->export_id,
                                'stock_id' => $oldestStock->id,
                                'unit_id' => $export_detail->unit_id,
                                'quantity' => $quantity,
                                'note' => $export_detail->note
                            ]);
                            $quantity = 0;
                        } else {
                            ExportDetail::create([
                                'export_id' => $export_detail->export_id,
                                'stock_id' => $oldestStock->id->id,
                                'unit_id' => $export_detail->unit_id,
                                'quantity' => $oldestStock->quantity,
                                'note' => $export_detail->note
                            ]);
                            $quantity -= $oldestStock->quantity;
                        }
                    }
                    $export_detail->delete();
                }
            }
        }
    }
}

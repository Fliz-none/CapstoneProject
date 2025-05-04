<?php

namespace Database\Seeders;

use App\Models\ExportDetail;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class FixBugExport_2024_11_21_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $export_details = ExportDetail::with(['stock.import_detail.import', 'export.prescription.pharmacist.branch.warehouses'])->whereBetween('created_at', [
            '2024-11-21 12:37:00',
            '2024-11-21 12:37:59'
        ])->get();
        foreach ($export_details as $export_detail) {
            $stock = $export_detail->stock;
            $quantity = $export_detail->quantity;
            if ($quantity <= $stock->quantity) {
                $stock->quantity = $stock->quantity - $quantity;
                $stock->save();
            } else {
                $warehouses = optional($export_detail->export->prescription)->pharmacist->branch->warehouses->where('status', 1);
                $import_detail = $stock->import_detail;

                $quantity -= $stock->quantity;
                $stock->quantity = 0;
                $stock->save();
                $current_stock = $stock;
                while ($quantity > 0) {
                    $oldestStock = Stock::where('quantity', '>', 0)
                        ->whereHas('import_detail', function ($query) use ($import_detail, $warehouses) {
                            $query->where('variable_id', $import_detail->variable_id)
                                ->whereHas('import', function ($query) use ($warehouses) {
                                    $query->whereIn('warehouse_id', $warehouses->pluck('id'))->where('status', 1);
                                });
                        })
                        ->orderByRaw('CASE
                        WHEN expired IS NOT NULL THEN expired
                        ELSE "9999-12-31"
                        END ASC, created_at ASC')
                        ->first();

                    if (!isset($oldestStock)) {
                        $current_stock->quantity = $current_stock->quantity - $quantity;
                        $current_stock->save();
                        break;
                    } else {
                        $current_stock = $oldestStock;
                        if ($oldestStock->quantity >= $quantity) {
                            $oldestStock->quantity = $oldestStock->quantity - $quantity;
                            $oldestStock->save();
                            $quantity = 0;
                        } else {
                            $quantity -= $oldestStock->quantity;
                            $oldestStock->quantity = 0;
                            $oldestStock->save();
                        }
                    }
                }
            }
        }
    }
}

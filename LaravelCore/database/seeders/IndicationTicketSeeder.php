<?php

namespace Database\Seeders;

use App\Models\Detail;
use App\Models\Indication;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndicationTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Indication::all()->each(function ($indication) {
            $indication->ticket = $indication->_detail->_service->ticket;
            $indication->save();
        });
        DB::beginTransaction();
        try {
            Detail::where('service_id', 586)->get()->each(function ($detail) {
                $prescription = Prescription::firstWhere('detail_id', $detail->id);
                if($prescription) {
                    $indication = Indication::create([
                        'detail_id' => $detail->id,
                        'info_id' => $prescription->info_id,
                        'ticket' => 'prescription'
                    ]);
        
                    $prescription->indication_id = $indication->id;
                    $prescription->save();
                }
            });
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
        }
    }
}

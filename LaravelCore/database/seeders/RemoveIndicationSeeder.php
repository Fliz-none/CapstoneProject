<?php

namespace Database\Seeders;

use App\Models\Biochemical;
use App\Models\Bloodcell;
use App\Models\Microscope;
use App\Models\Prescription;
use App\Models\Quicktest;
use App\Models\Surgery;
use App\Models\Ultrasound;
use App\Models\Xray;
use Illuminate\Database\Seeder;

class RemoveIndicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $biochemicals = Biochemical::with(['_indication'])->withTrashed()->get();
        foreach ($biochemicals as $key => $biochemical) {
            $indication = $biochemical->_indication;
            $biochemical->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $bloodcells = Bloodcell::with(['_indication'])->withTrashed()->get();
        foreach ($bloodcells as $key => $bloodcell) {
            $indication = $bloodcell->_indication;
            $bloodcell->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $microscopes = Microscope::with(['_indication'])->withTrashed()->get();
        foreach ($microscopes as $key => $microscope) {
            $indication = $microscope->_indication;
            $microscope->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $quicktests = Quicktest::with(['_indication'])->withTrashed()->get();
        foreach ($quicktests as $key => $quicktest) {
            $indication = $quicktest->_indication;
            $quicktest->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $surgeries = Surgery::with(['_indication'])->withTrashed()->get();
        foreach ($surgeries as $key => $surgery) {
            $indication = $surgery->_indication;
            $surgery->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $ultrasounds = Ultrasound::with(['_indication'])->withTrashed()->get();
        foreach ($ultrasounds as $key => $ultrasound) {
            $indication = $ultrasound->_indication;
            $ultrasound->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $xrays = Xray::with(['_indication'])->withTrashed()->get();
        foreach ($xrays as $key => $xray) {
            $indication = $xray->_indication;
            $xray->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }

        $prescriptions = Prescription::with(['_indication'])->withTrashed()->get();
        foreach ($prescriptions as $key => $prescription) {
            $indication = $prescription->_indication;
            $prescription->update([
                'detail_id' => $indication->detail_id,
                'info_id' => $indication->info_id,
            ]);
        }
    }
}

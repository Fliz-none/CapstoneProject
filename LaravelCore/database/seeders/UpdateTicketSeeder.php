<?php

namespace Database\Seeders;

use App\Models\Biochemical;
use App\Models\Bloodcell;
use App\Models\Ultrasound;
use App\Models\Xray;
use Illuminate\Database\Seeder;

class UpdateTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ultrasound
        $ultrasounds = Ultrasound::whereNotNull('details')->get();
        foreach ($ultrasounds as $ultrasound) {
            $new_detail = [];
            foreach (json_decode($ultrasound->details) as $detail) {
                $array_images = [];
                if (json_decode($detail->images)) {
                    foreach (json_decode($detail->images) as $image) {
                        $array_images[] = $image->name;
                    }
                }
                $new_detail[] = [
                    'id' => $detail->criterial_id,
                    'name' => $detail->criterial_name,
                    'note' => $detail->note,
                    'images' => $array_images
                ];
            }
            $ultrasound->update([
                'details' => $new_detail
            ]);
        };

        //xray
        $xrays = Xray::whereNotNull('details')->get();
        foreach ($xrays as $xray) {
            $new_detail = [];
            foreach (json_decode($xray->details) as $detail) {
                $array_images = [];
                if (json_decode($detail->images)) {
                    foreach (json_decode($detail->images) as $image) {
                        $array_images[] = $image->name;
                    }
                }
                $new_detail[] = [
                    'id' => $detail->criterial_id,
                    'name' => $detail->criterial_name,
                    'note' => $detail->note,
                    'images' => $array_images
                ];
            }
            $xray->update([
                'details' => $new_detail
            ]);
        };

        // Biochemical
        $biochemicals = Biochemical::whereNotNull('details')->get();
        foreach ($biochemicals as $biochemical) {
            $new_detail = [];
            foreach (json_decode($biochemical->details) as $detail) {
                $new_detail[] = [
                    'id' => $detail->criterial_id,
                    'normal_index' => $detail->criterial_normal_index,
                    'unit' => $detail->criterial_unit,
                    'name' => $detail->criterial_term,
                    'description' => $detail->criterial_description,
                    'result' => $detail->criterial_result,
                    'review' => $detail->criterial_review,
                ];
            }
            $biochemical->update([
                'details' => $new_detail
            ]);
        };

        // Bloodcell
        $bloodcells = Bloodcell::whereNotNull('details')->get();
        foreach ($bloodcells as $bloodcell) {
            $new_detail = [];
            foreach (json_decode($bloodcell->details) as $detail) {
                $new_detail[] = [
                    'id' => $detail->criterial_id,
                    'normal_index' => $detail->criterial_normal_index,
                    'unit' => $detail->criterial_unit,
                    'name' => $detail->criterial_term,
                    'description' => $detail->criterial_description,
                    'result' => $detail->criterial_result,
                    'review' => $detail->criterial_review,
                ];
            }
            $bloodcell->update([
                'details' => $new_detail
            ]);
        };
    }
}

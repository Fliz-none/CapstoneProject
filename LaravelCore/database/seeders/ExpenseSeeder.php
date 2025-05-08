<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $expenses = [
        //     [1, 2, 4629, 4216, 1, '20000.00', NULL, 'Chi Cà Phê của Dung', NULL, '2024-10-02 03:46:37', '2024-10-02 03:46:37']
        // ];

        // foreach ($expenses as $key => $expense) {
        //     Expense::create([
        //         'id' => $expense[1],
        //         'user_id' => $expense[2],
        //         'receiver_id' => $expense[3],
        //         'payment' => $expense[4],
        //         'amount' => $expense[5],
        //         'avatar' => $expense[6],
        //         'note' => $expense[7],
        //         'deleted_at' => $expense[8],
        //         'created_at' => $expense[9],
        //         'updated_at' => $expense[10]
        //     ]);
        // }
        Expense::with('user')->get()->each(function($expense) {
            $expense->branch_id = $expense->user->main_branch;
            $expense->group = 'Chi phí khác';
            $expense->save();
        });
    }
}

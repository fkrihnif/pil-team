<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array_simple = [
            ["1-0000", "Assets"],
            ["2-0000", "Liabilities"],
            ["3-0000", "Equity"],
            ["4-0000", "Income"],
            ["5-0000", "Cost Of Sales"],
            ["6-0000", "Expenses"],
            ["7-0000", "Other Cost"],
            ["8-0000", "Other Expenses"],
        ];

        for ($i=0; $i < 8; $i++) { 
            DB::table('classification_account_type')->insert([
                'code' => $array_simple[$i][0],
                'classification' => $array_simple[$i][1],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

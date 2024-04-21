<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array_simple = [
            ["1", "1-0001", "Kas", "0", "0"],
            ["1", "1-0002", "Dompet Digital", "0", "0"],
            ["1", "1-0010", "Piutang usaha", "0", "0"],
            ["1", "1-0011", "Piutang lain", "1", "0"],
            ["1", "1-0020", "Persediaan", "1", "0"],
            ["1", "1-0030", "Biaya Bayar Di Muka", "1", "0"],
        ];

        for ($i=0; $i < 6; $i++) { 
            DB::table('account_type')->insert([
                'classification_id' => $array_simple[$i][0],
                'code' => $array_simple[$i][1],
                'name' => $array_simple[$i][2],
                'cash_flow' => $array_simple[$i][3],
                'can_delete' => $array_simple[$i][4],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array_simple = [
            ["1", "110001", "Kas", "1", "0"],
            ["2", "110009", "Prive", "1", "0"],
            ["2", "110002", "Rekening Bank", "1", "0"],
            ["2", "110003", "Giro", "1", "0"],
            ["3", "110100", "Piutang Usaha", "1", "0"],
            ["4", "110101", "Piutang Usaha Belum Ditagih", "1", "0"],
        ];

        for ($i=0; $i < 6; $i++) { 
            DB::table('master_account')->insert([
                'account_type_id' => $array_simple[$i][0],
                'code' => $array_simple[$i][1],
                'account_name' => $array_simple[$i][2],
                'master_currency_id' => $array_simple[$i][3],
                'can_delete' => $array_simple[$i][4],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

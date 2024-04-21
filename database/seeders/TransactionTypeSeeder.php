<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array_simple = [
            ["Saldo Awal"],
            ["Sales Order"],
            ["Invoice"],
            ["Receive Payment"],
            ["Kas Keluar"],
            ["Kas Masuk"],
            ["Penerimaan Quotation"],
            ["Purchase Order"],
            ["Purchase Payment"],
        ];

        for ($i=0; $i < 9; $i++) { 
            DB::table('transaction_type')->insert([
                'transaction_type' => $array_simple[$i][0],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

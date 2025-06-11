<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $currencies = [
            ['name' => 'LKR', 'created_at' => Carbon::now()],
            ['name' => 'USD', 'created_at' => Carbon::now()],
            ['name' => 'EUR', 'created_at' => Carbon::now()],
        ];

        DB::table('currency')->insert($currencies);
    }
}

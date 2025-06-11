<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SetmenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $SetmenuType=[
            ['name'=>'Breakfast','created_at' => Carbon::now()],
            ['name'=>'Lunch','created_at' => Carbon::now()],
            ['name'=>'Dinner','created_at' => Carbon::now()],
        ];
        DB::table('setmenu_type')->insert($SetmenuType);
    }
}

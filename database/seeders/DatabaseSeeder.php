<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(adminseeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(LandingPageSectionsSeeder::class);
        $this->call(ReviewSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(CurrencySeeder::class);
        // $this->call(SetmenuTypeSeeder::class);
    }
}

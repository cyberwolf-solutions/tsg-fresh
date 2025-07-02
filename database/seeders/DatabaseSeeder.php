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
        $this->call(UserSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(MailConfigSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(SetmenuTypeSeeder::class);
        $this->call(TenantSeeder::class);
    }
}

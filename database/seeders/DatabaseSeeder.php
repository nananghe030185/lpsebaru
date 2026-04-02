<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(KlpdSeeder::class);
        $this->call(LpseSeeder::class);
        $this->call(SatkerSeeder::class);
        $this->call(PengaturanSeeder::class);
    }
}

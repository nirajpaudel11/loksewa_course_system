<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete Loksewa data reset & algorithm training.
     */
    public function run(): void
    {
        $this->call(LoksewaFullResetSeeder::class);
    }
}

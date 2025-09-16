<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        fake()->seed(1129);

        $this->call([
            UserSeeder::class,
            AttendanceSeeder::class,
            AttendanceCorrectionSeeder::class,
        ]);
    }
}

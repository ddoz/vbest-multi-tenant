<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            MenuSeeder::class,
            BankSeeder::class,
            JenisIzinSeeder::class,
            JenisKepemilikanSeeder::class,
            JenisKepengurusanSeeder::class,
            JenisTenagaAhliSeeder::class,
            KewarganegaraanSeeder::class,
            KualifikasiBidangSeeder::class,
            WilayahSeeder::class,
            KategoriPekerjaanSeeder::class,
        ]);
    }
}

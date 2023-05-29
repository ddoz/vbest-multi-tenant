<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisIzinUsaha;

class JenisIzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisIzinUsaha::create(
            [ 'jenis_izin' => 'Izin Akuntan Publik' ],
        );
        JenisIzinUsaha::create(
            [ 'jenis_izin' => 'Izin BPOM' ],
        );
    }
}

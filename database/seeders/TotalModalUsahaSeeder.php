<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TotalModalUsaha;

class TotalModalUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TotalModalUsaha::create(
            [ 'nama' => '< Rp1M (MIKRO)' ],
        );
        TotalModalUsaha::create(
            [ 'nama' => 'Rp1-5M (KECIL)' ],
        );
        TotalModalUsaha::create(
            [ 'nama' => '< Rp5-10M (MENENGAH)' ],
        );
        TotalModalUsaha::create(
            [ 'nama' => '< Rp10M (BESAR)' ],
        );
    }
}

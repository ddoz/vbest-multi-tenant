<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BentukUsaha;

class BentukUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BentukUsaha::create(
            [ 'nama' => 'CV' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'FIRMA' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'KOPERASI' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'PD' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'PT' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'PERKUMPULAN' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'PERORANGAN' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'UNIT' ],
        );
        BentukUsaha::create(
            [ 'nama' => 'YAYASAN' ],
        );
    }
}

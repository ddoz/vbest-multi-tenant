<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisUsaha;

class JenisUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
        JenisUsaha::create(
            [ 'nama' => 'BARANG' ],
        );
        JenisUsaha::create(
            [ 'nama' => 'PEKERJAAN KONSTRUKSI' ],
        );
        JenisUsaha::create(
            [ 'nama' => 'JASA KONSULTASI' ],
        );
        JenisUsaha::create(
            [ 'nama' => 'JASA LAINNYA' ],
        );
    }
}

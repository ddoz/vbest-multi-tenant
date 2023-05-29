<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisKepemilikan;

class JenisKepemilikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisKepemilikan::create([
            'nama_jenis' => 'Individu WNI'
        ]);
        JenisKepemilikan::create([
            'nama_jenis' => 'Individu WNA'
        ]);
        JenisKepemilikan::create([
            'nama_jenis' => 'Perusahaan Nasional'
        ]);
        JenisKepemilikan::create([
            'nama_jenis' => 'Perusahaan Asing'
        ]);
        JenisKepemilikan::create([
            'nama_jenis' => 'Pemerintah'
        ]);
    }
}

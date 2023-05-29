<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kewarganegaraan;

class KewarganegaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kewarganegaraan::create([
            'nama_kewarganegaraan' => 'Indonesia'
        ]);
        Kewarganegaraan::create([
            'nama_kewarganegaraan' => 'Jepang'
        ]);
        Kewarganegaraan::create([
            'nama_kewarganegaraan' => 'China'
        ]);
    }
}

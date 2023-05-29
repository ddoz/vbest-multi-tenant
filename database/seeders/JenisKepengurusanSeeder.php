<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisKepengurusan;

class JenisKepengurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisKepengurusan::create([
            "nama" => "Individu WNI"
        ]);
        JenisKepengurusan::create([
            "nama" => "Individu WNA"
        ]);
    }
}

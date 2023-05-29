<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinsi1 = Provinsi::create([
            "provinsi" => "Lampung"
        ]);

        $kabupaten1 = Kabupaten::create([
            "kabupaten"     => "Bandar Lampung",
            "provinsi_id"   => $provinsi1->id
        ]);

        $kecamatan1 = Kecamatan::create([
            "kecamatan"     => "Rajabasa",
            "kabupaten_id"  => $kabupaten1->id
        ]);

        $kelurahan1 = Kelurahan::create([
            "kelurahan"     => "Rajabasa",
            "kecamatan_id"  => $kecamatan1->id
        ]);
    }
}

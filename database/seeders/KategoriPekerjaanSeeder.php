<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriPekerjaan;

class KategoriPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriPekerjaan::create([
            "nama_kategori" => "Barang",
        ]);
        KategoriPekerjaan::create([
            "nama_kategori" => "Beli Alat Extracom",
        ]);
        KategoriPekerjaan::create([
            "nama_kategori" => "Jasa Konstruksi",
        ]);
        KategoriPekerjaan::create([
            "nama_kategori" => "Jasa Konsultasi",
        ]);
    }
}

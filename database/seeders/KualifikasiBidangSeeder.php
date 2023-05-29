<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KualifikasiBidang;

class KualifikasiBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent1 = KualifikasiBidang::create(
            [ 'nama_kualifikasi' => 'SBU Konstruksi', 'parent_id' => 0 ],
        );
        $parent2 = KualifikasiBidang::create(
            [ 'nama_kualifikasi' => 'KBLI', 'parent_id' => 0 ],
        );

        KualifikasiBidang::create(
            [ 'nama_kualifikasi' => 'AR. Perencanaan Arsitektur', 'parent_id' => $parent1->id ],
        );
        KualifikasiBidang::create(
            [ 'nama_kualifikasi' => 'A. Pertanian, Kehutanan Dan Perikanan', 'parent_id' => $parent2->id ],
        );
    }
}

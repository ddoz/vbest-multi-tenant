<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusUsaha;

class StatusUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusUsaha::create(
            [ 'nama' => 'KANTOR PUSAT' ],
        );
        StatusUsaha::create(
            [ 'nama' => 'KANTOR CABANG' ],
        );
        StatusUsaha::create(
            [ 'nama' => 'JOINT OPERATION' ],
        );
    }
}

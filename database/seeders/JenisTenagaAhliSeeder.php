<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisTenagaAhli;

class JenisTenagaAhliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisTenagaAhli::create([
            "nama" => "Individu WNI"
        ]);
        JenisTenagaAhli::create([
            "nama" => "Individu WNA"
        ]);
    }
}

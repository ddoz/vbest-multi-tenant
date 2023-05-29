<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            "nama_bank" => "BNI"
        ]);
        Bank::create([
            "nama_bank" => "BCA"
        ]);
        Bank::create([
            "nama_bank" => "Mandiri"
        ]);
        Bank::create([
            "nama_bank" => "BRI"
        ]);
    }
}

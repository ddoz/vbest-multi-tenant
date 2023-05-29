<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuManager;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuManager::firstOrCreate(
            [ 'menu' => 'Identitas Vendor' ],
            [
                "icon"  => "ti ti-info-alt",
                "route" => "identitas.index"
            ],
        );
        MenuManager::firstOrCreate(
            [ "menu"  => "Akta Perusahaan" ],
            [
                "icon"  => "ti ti-files",
                "route" => "akta.index"
            ],
        );
        MenuManager::firstOrCreate(
            ["menu"  => "Izin Usaha"],
            [   "icon"  => "ti ti-bookmark-alt",
                "route" => "izin.index"
            ]
        );
        MenuManager::firstOrCreate(
            [
                "menu"  => "Pemilik"],
            [
                "icon"  => "ti ti-user",
                "route" => "pemilik.index"
            ],
        );
        MenuManager::firstOrCreate(
            [
                "menu"  => "Pengurus"],
            [
                "icon"  => "ti ti-id-badge",
                "route" => "pengurus.index"
            ],
        );
        MenuManager::firstOrCreate(   
            [
                "menu"  => "Tenaga Ahli"],
            [
                "icon"  => "ti ti-plug",
                "route" => "tenaga-ahli.index"
            ],
        );
        MenuManager::firstOrCreate(
            [
                "menu"  => "Sertifikasi"],
            [
                "icon"  => "ti ti-gift",
                "route" => "sertifikasi.index"
            ],
        );
        MenuManager::firstOrCreate(
            [
                "menu"  => "Pengalaman"],
            [
                "icon"  => "ti ti-stats-up",
                "route" => "pengalaman.index"
            ],
        );
        MenuManager::firstOrCreate(
            [
                "menu"  => "Rekening Bank"],
            [
                "icon"  => "ti ti-wallet",
                "route" => "rekening-bank.index"
            ],
        );
        MenuManager::firstOrCreate(    
            [
                "menu"  => "Lap. Laba Rugi"],
            [
                "icon"  => "ti ti-agenda",
                "route" => "laba-rugi.index"
            ],
        );
        MenuManager::firstOrCreate(    
            [
                "menu"  => "Neraca Keuangan"],
            [
                "icon"  => "ti ti-agenda",
                "route" => "neraca.index"
            ],
        );
        MenuManager::firstOrCreate(    
            [
                "menu"  => "Pelaporan Pajak"],
            [
                "icon"  => "ti ti-receipt",
                "route" => "pelaporan-pajak.index"
            ],
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\IdentitasVendor;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN
        User::create([
            "name"                  => "Administrator",
            "email"                 => "admin@vendorbest.com",
            "email_verified_at"     => date("Y-m-d H:i:s"),
            "password"              => bcrypt("admin"),
            "role"                  => "ADMIN",
        ]);

        // VENDOR
        $user = User::create([
            "name"                  => "Vendor",
            "email"                 => "vendor@vendorbest.com",
            "email_verified_at"     => date("Y-m-d H:i:s"),
            "password"              => bcrypt("vendor"),
            "role"                  => "VENDOR",
        ]);
        IdentitasVendor::create([
            'nama_usaha'        => 'Vendor',                
            'bentuk_usaha'      => 'PT',
            'npwp'              => '1234567890',
            'status_usaha'      => 'KANTOR PUSAT',
            'jenis_usaha'       => '["BARANG","JASA KONSULTASI","JASA LAINNYA"]',
            'produk_usaha'      => 'it,it',
            'total_modal_usaha' => '> Rp10M (BESAR)',
            'alamat_usaha'      => 'Alamat',
            'provinsi_id'       => 1,
            'kabupaten_id'      => 1,
            'kecamatan_id'      => 1,
            'kelurahan_id'      => 1,
            'kode_pos'          => '35674',
            'no_telp'           => '0812345678',
            'fax'               => '12345678',
            'nama_pic'          => 'PIC Vendor',
            'telp_pic'          => '08123456',
            'alamat_pic'        => 'Pic Alamat',
            'user_id'           => $user->id
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class SertifikasiTenagaAhli extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "jenis_sertifikat",
        "lampiran",
        "bidang",
        "tingkatan",
        "diterbitkan",
        "berakhir",
        "penerbit",
        "tenaga_ahli_id"
    ];
}

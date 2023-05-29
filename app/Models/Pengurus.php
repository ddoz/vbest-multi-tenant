<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Pengurus extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "jenis_kepengurusan_id",
        'nama',
        'nomor_identitas',
        'npwp',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'jabatan',
        'keterangan_tambahan',
        'menjabat_sejak' ,
        'menjabat_sampai',
        'scan_dokumen',
        'tgl_verifikasi',
        'verified_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    function verified() {
        return $this->belongsTo("App\Models\User");
    }

    function jenis_kepengurusan() {
        return $this->belongsTo("App\Models\JenisKepengurusan");
    }

    function provinsi() {
        return $this->belongsTo("App\Models\Provinsi");
    }

    function kabupaten() {
        return $this->belongsTo("App\Models\Kabupaten");
    }

    function kecamatan() {
        return $this->belongsTo("App\Models\Kecamatan");
    }

    function kelurahan() {
        return $this->belongsTo("App\Models\Kelurahan");
    }
}

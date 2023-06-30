<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Pemilik extends Model
{
    use HasFactory;

    protected $fillable = [
        "jenis_kepemilikan_id",
        "nama",
        'kewarganegaraan_id',
        'nomor_identitas',
        'npwp',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'jumlah_saham',
        'jenis_saham',
        'keterangan_tambahan',
        'scan_dokumen',
        'status_dokumen',
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
    
    function jenis_kepemilikan() {
        return $this->belongsTo("App\Models\JenisKepemilikan");
    }

    function kewarganegaraan() {
        return $this->belongsTo("App\Models\Kewarganegaraan");
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

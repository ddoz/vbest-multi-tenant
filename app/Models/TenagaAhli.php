<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class TenagaAhli extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "jenis_tenaga_ahli_id",
        'nama',
        'jenis_kelamin',
        'nomor_identitas',
        'npwp',
        'tanggal_lahir',
        'kewarganegaraan_id',
        'email',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'pendidikan_akhir',
        'jabatan',
        'profesi_keahlian',
        'lama_pengalaman',
        'status_kepegawaian',
        'keterangan_tambahan',
        'riwayat_penyakit',
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

    function jenis_tenaga_ahli() {
        return $this->belongsTo("App\Models\JenisTenagaAhli");
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

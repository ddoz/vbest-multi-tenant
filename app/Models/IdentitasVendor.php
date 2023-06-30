<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class IdentitasVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'bentuk_usaha',
        'nama_usaha',
        'npwp',
        'status_usaha',
        'jenis_usaha',
        'produk_usaha',
        'total_modal_usaha',
        'alamat_usaha',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'kode_pos',
        'no_telp',
        'fax',
        'nama_pic',
        'telp_pic',
        'alamat_pic',
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

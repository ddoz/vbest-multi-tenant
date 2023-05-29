<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class AktaPerusahaan extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
       'status_dokumen',
       'jenis_akta',
       'no_akta',
       'tanggal_terbit',
       'nama_notaris',
       'keterangan',
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
}
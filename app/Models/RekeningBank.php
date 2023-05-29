<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class RekeningBank extends Model
{
    use HasFactory, UsesTenantConnection;
    
    protected $fillable = [
        "bank_id",
        "nomor_rekening",
        "nama",
        'keterangan',
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
    
    function bank() {
        return $this->belongsTo("App\Models\Bank");
    }
}

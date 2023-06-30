<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Neraca extends Model
{
    use HasFactory;

    protected $fillable = [
        "tahun",
        "aset",
        "kewajiban",
        'modal',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KualifikasiIzinUsaha extends Model
{
    use HasFactory;

    protected $fillable = [
        'kualifikasi_bidang_id',
        'izin_usaha_id',
    ];

    function kualifikasi_bidang() {
        return $this->belongsTo('App\Models\KualifikasiBidang');
    }
}

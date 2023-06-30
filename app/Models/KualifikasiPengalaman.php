<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KualifikasiPengalaman extends Model
{
    use HasFactory;

    protected $table = "kualifikasi_pengalaman";

    protected $fillable = [
        'kualifikasi_bidang_id',
        'pengalaman_id',
    ];

    function kualifikasi_bidang() {
        return $this->belongsTo('App\Models\KualifikasiBidang');
    }
}

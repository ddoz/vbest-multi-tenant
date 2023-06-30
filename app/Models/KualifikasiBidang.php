<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KualifikasiBidang extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_kualifikasi",
        "parent_id"
    ];

    function parent() {
        return $this->belongsTo("App\Models\KualifikasiBidang");
    }
}

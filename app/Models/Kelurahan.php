<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Kelurahan extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "kelurahan",
        "kecamatan_id"
    ];

    function kecamatan() {
        return $this->belongsTo('App\Models\Kecamatan');
    }
}

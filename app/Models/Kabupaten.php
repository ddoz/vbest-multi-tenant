<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Kabupaten extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "kabupaten",
        "provinsi_id"
    ];

    function provinsi() {
        return $this->belongsTo('App\Models\Provinsi');
    }
}

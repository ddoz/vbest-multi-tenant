<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        "kecamatan",
        "kabupaten_id"
    ];

    function kabupaten() {
        return $this->belongsTo('App\Models\Kabupaten');
    }
}

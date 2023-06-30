<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Provinsi extends Model
{
    use HasFactory;

    protected $fillable = [
        "provinsi"
    ];
}

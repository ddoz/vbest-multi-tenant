<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class JenisIzinUsaha extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_izin'
    ];
}

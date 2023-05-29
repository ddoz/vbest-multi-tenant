<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PengalamanTenagaAhli extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "tahun",
        "uraian",
        "tenaga_ahli_id"
    ];
}

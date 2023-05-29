<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KemampuanBahasaTenagaAhli extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        "uraian",
        "tenaga_ahli_id"
    ];
}

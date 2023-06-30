<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PendidikanTenagaAhli extends Model
{
    use HasFactory;

    protected $fillable = [
        "tahun",
        "uraian",
        "tenaga_ahli_id"
    ];
}

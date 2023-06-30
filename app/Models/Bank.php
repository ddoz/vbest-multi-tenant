<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bank'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_perusahaan",
        "alamat_lengkap",
        "background_login",
    ];
}

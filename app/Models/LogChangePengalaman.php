<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class LogChangePengalaman extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $table = "log_change_pengalaman";

    protected $fillable = [
        "state_change",
        "tipe",
        "pengalaman_id",
        "user_id",
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}

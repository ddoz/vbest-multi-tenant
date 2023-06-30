<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class IzinUsaha extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_izin_usaha_id',
        'no_surat',
        'seumur_hidup',
        'berlaku_sampai',
        'kualifikasi',
        'instansi_penerbit',
        'keterangan',
        'scan_dokumen',
        'status_dokumen',
        'tgl_verifikasi',
        'verified_id',
        'user_id',
     ];

     protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
     ];

      function verified() {
         return $this->belongsTo("App\Models\User");
      }

     function jenis_izin_usaha() {
        return $this->belongsTo('App\Models\JenisIzinUsaha');
     }
}

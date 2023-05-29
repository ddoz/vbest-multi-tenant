<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Pengalaman extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $table = "pengalaman";

    protected $fillable = [
        "nama_kontrak",
        "lingkup_pekerjaan",
        'nomor_kontrak',
        'kategori_pekerjaan_id',
        'pelaksanaan_kontrak',
        'selesai_kontrak',
        'serah_terima_pekerjaan',
        'nilai_kontrak',
        'presentase_pekerjaan',
        'tanggal_progress',
        'keterangan',
        'nama_alamat_proyek',
        'lokasi_pekerjaan_provinsi_id',
        'lokasi_pekerjaan_kabupaten_id',
        'lokasi_pekerjaan_kecamatan_id',
        'lokasi_pekerjaan_kelurahan_id',
        'instansi_pengguna',
        'alamat_instansi',
        'instansi_provinsi_id',
        'instansi_kabupaten_id',
        'instansi_kecamatan_id',
        'instansi_kelurahan_id',
        'telpon_instansi',
        'status_dokumen',
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

    function kategori_pekerjaan() {
        return $this->belongsTo("App\Models\KategoriPekerjaan");
    }
}

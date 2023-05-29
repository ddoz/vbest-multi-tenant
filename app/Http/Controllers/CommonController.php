<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KualifikasiBidang;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class CommonController extends Controller
{
    
    public function getBidangUsaha(Request $request) {
        $kualifikasiBidang = KualifikasiBidang::where('parent_id',$request->query('id'))->get()->toJson();
        return response($kualifikasiBidang, 200)->header('Content-Type', 'application/json');
    }

    public function getKabupaten(Request $request) {
        $kabupaten = Kabupaten::where('provinsi_id',$request->query('id'))->get()->toJson();
        return response($kabupaten, 200)->header('Content-Type', 'application/json');
    }

    public function getKecamatan(Request $request) {
        $kecamatan = Kecamatan::where('kabupaten_id',$request->query('id'))->get()->toJson();
        return response($kecamatan, 200)->header('Content-Type', 'application/json');
    }

    public function getKelurahan(Request $request) {
        $kelurahan = Kelurahan::where('kecamatan_id',$request->query('id'))->get()->toJson();
        return response($kelurahan, 200)->header('Content-Type', 'application/json');
    }
}

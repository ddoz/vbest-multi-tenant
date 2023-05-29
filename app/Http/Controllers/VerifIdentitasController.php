<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdentitasVendor;
use Carbon\Carbon;
use App\Events\LogService;
use Auth;

class VerifIdentitasController extends Controller
{
    public function state(Request $request, IdentitasVendor $identitas) {
        try {
            $original = IdentitasVendor::find($identitas->id);
            $state = $request->submit;
            if($state=="Y") {
                $identitas->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $identitas->status_dokumen = "REVISED";
            }
            $identitas->tgl_verifikasi = Carbon::now();
            $identitas->verified_id = Auth::user()->id;
            $identitas->fill($identitas->toArray())->save();
                        
            event( new LogService($original, $identitas, "VERIFY", "IDENTITAS", $identitas->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

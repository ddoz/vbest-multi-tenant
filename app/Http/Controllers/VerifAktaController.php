<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktaPerusahaan;
use App\Models\User;
use App\Models\LogChangeAkta;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifAktaController extends Controller
{
    public function formAkta(Request $request, User $vendor, AktaPerusahaan $akta) {
        if ($request->ajax()) {
            $data = LogChangeAkta::join("users","users.id","=","log_change_aktas.user_id")->orderBy("id","desc")->select(['log_change_aktas.*',"users.name"])->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('state', function($row){
                    $state = json_decode($row->state_change);
                    $table = "<table class='table table-stripped'><tr><td>No</td><td>Col</td><td>Old</td><td>New</td>";
                    $num = 1;
                    foreach($state as $key => $s) {
                        $table .= "<tr>";
                        $table .= "<td>".$num++."</td>";
                        $table .= "<td>".$s->col."</td>";
                        $table .= "<td>".$s->old."</td>";
                        $table .= "<td>".$s->new."</td>";
                        $table .= "</tr>";
                    }
                    $table .= "</table>";
                    return $table;
                })
                ->rawColumns(['state'])
                ->make(true);
        }
        return view('admin.formakta.index', compact('vendor','akta'));
    }

    public function state(Request $request, AktaPerusahaan $akta) {
        try {
            $original = AktaPerusahaan::find($akta->id);
            $state = $request->submit;

            if($state=="Y") {
                $akta->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $akta->status_dokumen = "REVISED";
            }
            $akta->tgl_verifikasi = Carbon::now();
            $akta->verified_id = Auth::user()->id;
            $akta->fill($akta->toArray())->save();             

            event( new LogService($original, $akta, "VERIFY", "AKTA", $akta->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

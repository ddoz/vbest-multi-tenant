<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\KualifikasiIzinUsaha;
use App\Models\User;
use App\Models\LogChangePemilik;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifPemilikController extends Controller
{
    public function index(Request $request, User $vendor, Pemilik $pemilik) {
        if ($request->ajax()) {
            $data = LogChangePemilik::join("users","users.id","=","log_change_pemiliks.user_id")->orderBy("id","desc")->select(['log_change_pemiliks.*',"users.name"])->get();
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
        return view('admin.formpemilik.index', compact('vendor','pemilik'));
    }

    public function state(Request $request, Pemilik $pemilik) {
        try {
            $original = Pemilik::find($pemilik->id);
            $state = $request->submit;

            if($state=="Y") {
                $pemilik->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $pemilik->status_dokumen = "REVISED";
            }
            $pemilik->tgl_verifikasi = Carbon::now();
            $pemilik->verified_id = Auth::user()->id;
            $pemilik->fill($pemilik->toArray())->save();             

            event( new LogService($original, $pemilik, "VERIFY", "PEMILIK", $pemilik->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

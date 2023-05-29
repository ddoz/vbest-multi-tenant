<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinUsaha;
use App\Models\KualifikasiIzinUsaha;
use App\Models\User;
use App\Models\LogChangeIzin;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;


class VerifIzinController extends Controller
{
    public function index(Request $request, User $vendor, IzinUsaha $izin) {
        if ($request->ajax()) {
            $data = LogChangeIzin::join("users","users.id","=","log_change_izins.user_id")->orderBy("id","desc")->select(['log_change_izins.*',"users.name"])->get();
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
        $kualifikasiIzinUsaha = KualifikasiIzinUsaha::where("izin_usaha_id",$izin->id)->get();
        return view('admin.formizin.index', compact('vendor','izin','kualifikasiIzinUsaha'));
    }

    public function state(Request $request, IzinUsaha $izin) {
        try {
            $original = IzinUsaha::find($izin->id);
            $state = $request->submit;

            if($state=="Y") {
                $izin->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $izin->status_dokumen = "REVISED";
            }
            $izin->tgl_verifikasi = Carbon::now();
            $izin->verified_id = Auth::user()->id;
            $izin->fill($izin->toArray())->save();             

            event( new LogService($original, $izin, "VERIFY", "IZIN", $izin->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

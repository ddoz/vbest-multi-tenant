<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Models\User;
use App\Models\LogChangeSertifikasi;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifSertifikasiController extends Controller
{
    public function index(Request $request, User $vendor, Sertifikasi $sertifikasi) {
        if ($request->ajax()) {
            $data = LogChangeSertifikasi::join("users","users.id","=","log_change_sertifikasis.user_id")->orderBy("id","desc")->select(['log_change_sertifikasis.*',"users.name"])->get();
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
        return view('admin.formsertifikasi.index', compact('vendor','sertifikasi'));
    }

    public function state(Request $request, Sertifikasi $sertifikasi) {
        try {
            $original = Sertifikasi::find($sertifikasi->id);
            $state = $request->submit;

            if($state=="Y") {
                $sertifikasi->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $sertifikasi->status_dokumen = "REVISED";
            }
            $sertifikasi->tgl_verifikasi = Carbon::now();
            $sertifikasi->verified_id = Auth::user()->id;
            $sertifikasi->fill($sertifikasi->toArray())->save();             

            event( new LogService($original, $sertifikasi, "VERIFY", "SERTIFIKASI", $sertifikasi->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

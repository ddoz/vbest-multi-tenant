<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengalaman;
use App\Models\KualifikasiPengalaman;
use App\Models\User;
use App\Models\LogChangePengalaman;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifPengalamanController extends Controller
{
    public function index(Request $request, User $vendor, Pengalaman $pengalaman) {
        if ($request->ajax()) {
            $data = LogChangePengalaman::join("users","users.id","=","log_change_pengalaman.user_id")->orderBy("id","desc")->select(['log_change_pengalaman.*',"users.name"])->get();
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
        $kualifikasiPengalaman = KualifikasiPengalaman::join("kualifikasi_bidangs","kualifikasi_bidangs.id","=","kualifikasi_pengalaman.kualifikasi_bidang_id")
                        ->select("kualifikasi_pengalaman.*","kualifikasi_bidangs.nama_kualifikasi","kualifikasi_bidangs.parent_id")
                        ->where('pengalaman_id',$pengalaman->id)->get();
        return view('admin.formpengalaman.index', compact('vendor','pengalaman','kualifikasiPengalaman'));
    }

    public function state(Request $request, Pengalaman $pengalaman) {
        try {
            $original = Pengalaman::find($pengalaman->id);
            $state = $request->submit;

            if($state=="Y") {
                $pengalaman->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $pengalaman->status_dokumen = "REVISED";
            }
            $pengalaman->tgl_verifikasi = Carbon::now();
            $pengalaman->verified_id = Auth::user()->id;
            $pengalaman->fill($pengalaman->toArray())->save();             

            event( new LogService($original, $pengalaman, "VERIFY", "PENGALAMAN", $pengalaman->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

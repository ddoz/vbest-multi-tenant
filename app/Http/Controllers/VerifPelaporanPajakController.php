<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelaporanPajak;
use App\Models\User;
use App\Models\LogChangePelaporanPajak;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifPelaporanPajakController extends Controller
{
    public function index(Request $request, User $vendor, PelaporanPajak $pelaporan_pajak) {
        if ($request->ajax()) {
            $data = LogChangePelaporanPajak::join("users","users.id","=","log_change_pelaporan_pajaks.user_id")->orderBy("id","desc")->select(['log_change_pelaporan_pajaks.*',"users.name"])->get();
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
        return view('admin.formpelaporanpajak.index', compact('vendor','pelaporan_pajak'));
    }

    public function state(Request $request, PelaporanPajak $pelaporan_pajak) {
        try {
            $original = PelaporanPajak::find($pelaporan_pajak->id);
            $state = $request->submit;

            if($state=="Y") {
                $pelaporan_pajak->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $pelaporan_pajak->status_dokumen = "REVISED";
            }
            $pelaporan_pajak->tgl_verifikasi = Carbon::now();
            $pelaporan_pajak->verified_id = Auth::user()->id;
            $pelaporan_pajak->fill($pelaporan_pajak->toArray())->save();             

            event( new LogService($original, $pelaporan_pajak, "VERIFY", "PELAPORANPAJAK", $pelaporan_pajak->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

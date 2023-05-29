<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenagaAhli;
use App\Models\PendidikanTenagaAhli;
use App\Models\PengalamanTenagaAhli;
use App\Models\KemampuanBahasaTenagaAhli;
use App\Models\SertifikasiTenagaAhli;
use App\Models\User;
use App\Models\LogChangeTenagaAhli;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifTenagaAhliController extends Controller
{
    public function index(Request $request, User $vendor, TenagaAhli $tenaga_ahli) {
        if ($request->ajax()) {
            $data = LogChangeTenagaAhli::join("users","users.id","=","log_change_tenaga_ahlis.user_id")->orderBy("id","desc")->select(['log_change_tenaga_ahlis.*',"users.name"])->get();
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
        $sertifikasi = SertifikasiTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pendidikan = PendidikanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pengalaman = PengalamanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $kemampuanBahasa = KemampuanBahasaTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        return view('admin.formtenagaahli.index', compact('vendor','tenaga_ahli','sertifikasi','pendidikan','pengalaman','kemampuanBahasa'));
    }

    public function state(Request $request, TenagaAhli $tenaga_ahli) {
        try {
            $original = TenagaAhli::find($tenaga_ahli->id);
            $state = $request->submit;

            if($state=="Y") {
                $tenaga_ahli->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $tenaga_ahli->status_dokumen = "REVISED";
            }
            $tenaga_ahli->tgl_verifikasi = Carbon::now();
            $tenaga_ahli->verified_id = Auth::user()->id;
            $tenaga_ahli->fill($tenaga_ahli->toArray())->save();             

            event( new LogService($original, $tenaga_ahli, "VERIFY", "TENAGAAHLI", $tenaga_ahli->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

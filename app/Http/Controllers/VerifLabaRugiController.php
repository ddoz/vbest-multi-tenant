<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabaRugi;
use App\Models\User;
use App\Models\LogChangeLabaRugi;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifLabaRugiController extends Controller
{
    public function index(Request $request, User $vendor, LabaRugi $laba_rugi) {
        if ($request->ajax()) {
            $data = LogChangeLabaRugi::join("users","users.id","=","log_change_laba_rugis.user_id")->orderBy("id","desc")->select(['log_change_laba_rugis.*',"users.name"])->get();
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
        return view('admin.formlabarugi.index', compact('vendor','laba_rugi'));
    }

    public function state(Request $request, LabaRugi $laba_rugi) {
        try {
            $original = LabaRugi::find($laba_rugi->id);
            $state = $request->submit;

            if($state=="Y") {
                $laba_rugi->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $laba_rugi->status_dokumen = "REVISED";
            }
            $laba_rugi->tgl_verifikasi = Carbon::now();
            $laba_rugi->verified_id = Auth::user()->id;
            $laba_rugi->fill($laba_rugi->toArray())->save();             

            event( new LogService($original, $laba_rugi, "VERIFY", "LABARUGI", $laba_rugi->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Neraca;
use App\Models\User;
use App\Models\LogChangeNeraca;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifNeracaController extends Controller
{
    public function index(Request $request, User $vendor, Neraca $neraca) {
        if ($request->ajax()) {
            $data = LogChangeNeraca::join("users","users.id","=","log_change_neracas.user_id")->orderBy("id","desc")->select(['log_change_neracas.*',"users.name"])->get();
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
        return view('admin.formneraca.index', compact('vendor','neraca'));
    }

    public function state(Request $request, Neraca $neraca) {
        try {
            $original = Neraca::find($neraca->id);
            $state = $request->submit;

            if($state=="Y") {
                $neraca->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $neraca->status_dokumen = "REVISED";
            }
            $neraca->tgl_verifikasi = Carbon::now();
            $neraca->verified_id = Auth::user()->id;
            $neraca->fill($neraca->toArray())->save();             

            event( new LogService($original, $neraca, "VERIFY", "NERACA", $neraca->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

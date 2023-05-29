<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengurus;
use App\Models\KualifikasiIzinUsaha;
use App\Models\User;
use App\Models\LogChangePengurus;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifPengurusController extends Controller
{
    public function index(Request $request, User $vendor, Pengurus $pengurus) {
        if ($request->ajax()) {
            $data = LogChangePengurus::join("users","users.id","=","log_change_penguruses.user_id")->orderBy("id","desc")->select(['log_change_penguruses.*',"users.name"])->get();
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
        return view('admin.formpengurus.index', compact('vendor','pengurus'));
    }

    public function state(Request $request, Pengurus $pengurus) {
        try {
            $original = Pengurus::find($pengurus->id);
            $state = $request->submit;

            if($state=="Y") {
                $pengurus->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $pengurus->status_dokumen = "REVISED";
            }
            $pengurus->tgl_verifikasi = Carbon::now();
            $pengurus->verified_id = Auth::user()->id;
            $pengurus->fill($pengurus->toArray())->save();             

            event( new LogService($original, $pengurus, "VERIFY", "PENGURUS", $pengurus->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

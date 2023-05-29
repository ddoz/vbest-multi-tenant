<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekeningBank;
use App\Models\User;
use App\Models\LogChangeRekeningBank;
use App\Events\LogService;
use Carbon\Carbon;
use DataTables;
use Auth;

class VerifRekeningBankController extends Controller
{
    public function index(Request $request, User $vendor, RekeningBank $rekening_bank) {
        if ($request->ajax()) {
            $data = LogChangeRekeningBank::join("users","users.id","=","log_change_rekening_banks.user_id")->orderBy("id","desc")->select(['log_change_rekening_banks.*',"users.name"])->get();
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
        return view('admin.formrekeningbank.index', compact('vendor','rekening_bank'));
    }

    public function state(Request $request, RekeningBank $rekening_bank) {
        try {
            $original = RekeningBank::find($rekening_bank->id);
            $state = $request->submit;

            if($state=="Y") {
                $rekening_bank->status_dokumen = "VERIFIED";
            }
            if($state=="T") {
                $rekening_bank->status_dokumen = "REVISED";
            }
            $rekening_bank->tgl_verifikasi = Carbon::now();
            $rekening_bank->verified_id = Auth::user()->id;
            $rekening_bank->fill($rekening_bank->toArray())->save();             

            event( new LogService($original, $rekening_bank, "VERIFY", "REKENINGBANK", $rekening_bank->id));
            
            return redirect()->back()->with("success","Berhasil Ubah Status Dokumen.");
        } catch(\Exception $e) {
            return back()->with('fail', 'Status gagal diubah. ' . $e->getMessage())->withInput();
        }
    }
}

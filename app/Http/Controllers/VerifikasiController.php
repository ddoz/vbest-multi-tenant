<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AktaPerusahaan;
use App\Models\IzinUsaha;
use App\Models\Pemilik;
use App\Models\Pengurus;
use App\Models\Sertifikasi;
use App\Models\Pengalaman;
use App\Models\RekeningBank;
use App\Models\IdentitasVendor;
use App\Models\TenagaAhli;
use App\Models\LabaRugi;
use App\Models\Neraca;
use App\Models\PelaporanPajak;
use App\Models\LogChangeIdentitas;
use DataTables;

class VerifikasiController extends Controller
{
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = User::where('role','VENDOR')->where('email_verified_at','!=',null)->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.for',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.verifikasi.index');
    }

    public function vendor(User $vendor) {
        return view('admin.verifikasi.vendor', compact('vendor'));
    }

    public function identitas(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = LogChangeIdentitas::join("users","users.id","=","log_change_identitas.user_id")->orderBy("id","desc")->select(['log_change_identitas.*',"users.name"])->get();
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

        $identitas = IdentitasVendor::where("user_id",$vendor->id)->first();
        
        return view('admin.verifikasi.identitas', compact('vendor','identitas'));
    }

    public function akta(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = AktaPerusahaan::select('*')->where('user_id',$vendor->id)->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formakta',['vendor'=>$row->user_id,'akta'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.akta', compact('vendor'));
    }

    public function izin(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = IzinUsaha::join('jenis_izin_usahas','jenis_izin_usahas.id','=','izin_usahas.jenis_izin_usaha_id')
                                ->where('izin_usahas.user_id',$vendor->id)
                                ->select('izin_usahas.*','jenis_izin_usahas.jenis_izin')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formizin',['vendor'=>$row->user_id,'izin'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.izin', compact('vendor'));
    }

    public function pemilik(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = Pemilik::join('kewarganegaraans','kewarganegaraans.id','=','pemiliks.kewarganegaraan_id')
                                ->join('jenis_kepemilikans','jenis_kepemilikans.id','=','pemiliks.jenis_kepemilikan_id')
                                ->where('pemiliks.user_id', $vendor->id)
                                ->select('pemiliks.*','kewarganegaraans.nama_kewarganegaraan','jenis_kepemilikans.nama_jenis')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formpemilik',['vendor'=>$row->user_id,'pemilik'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.pemilik', compact('vendor'));
    }

    public function pengurus(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = Pengurus::join('jenis_kepengurusans','jenis_kepengurusans.id','=','penguruses.jenis_kepengurusan_id')
                                ->where('penguruses.user_id',$vendor->id)
                                ->select('penguruses.*','jenis_kepengurusans.nama as nama_kepengurusan')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formpengurus',['vendor'=>$row->user_id,'pengurus'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.pengurus', compact('vendor'));
    }

    public function tenagaAhli(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = TenagaAhli::where('user_id',$vendor->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formtenagaahli',['vendor'=>$row->user_id,'tenaga_ahli'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.tenaga-ahli', compact('vendor'));
    }

    public function sertifikasi(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = Sertifikasi::where('user_id',$vendor->id)->select('*')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">                    
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formsertifikasi',['vendor'=>$row->user_id,'sertifikasi'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.sertifikasi', compact('vendor'));
    }

    public function pengalaman(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = Pengalaman::where('user_id', $vendor->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row">
                                    <a class="btn btn-success btn-sm" href="'.route('verifikasi.formpengalaman',['vendor'=>$row->user_id,'pengalaman'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                        return $btn;
                    })
                    ->addColumn('lampiran', function($row){
                        $btn = '<a href="" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                        return $btn;
                    })
                    ->rawColumns(['action','lampiran'])
                    ->make(true);
        }
        return view('admin.verifikasi.pengalaman', compact('vendor'));
    }

    public function rekeningBank(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = RekeningBank::join('banks','banks.id','=','rekening_banks.bank_id')
                                ->where('rekening_banks.user_id', $vendor->id)
                                ->select('rekening_banks.*','banks.nama_bank')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formrekeningbank',['vendor'=>$row->user_id,'rekening_bank'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.rekening-bank', compact('vendor'));
    }

    public function pelaporanPajak(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = PelaporanPajak::where('user_id', $vendor->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formpelaporanpajak',['vendor'=>$row->user_id,'pelaporan_pajak'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Download</a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.verifikasi.pelaporan-pajak', compact('vendor'));
    }

    public function labaRugi(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = LabaRugi::where("user_id",$vendor->id)->select('*')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formlabarugi',['vendor'=>$row->user_id,'laba_rugi'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.verifikasi.laba-rugi', compact('vendor'));
    }

    public function neraca(Request $request, User $vendor) {
        if ($request->ajax()) {
            $data = Neraca::where('user_id', $vendor->id)->select('*')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.formneraca',['vendor'=>$row->user_id,'neraca'=>$row->id]).'"><span class="ti ti-search"></span></a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.verifikasi.neraca', compact('vendor'));
    }
  
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\KualifikasiBidang;
use App\Models\KualifikasiIzinUsaha;
use DataTables;
use Auth;
use Carbon\Carbon;

class KlasifikasiBidangController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = KualifikasiBidang::select("kualifikasi_bidangs.*","b.nama_kualifikasi as nama_kualifikasi_parent")
                                    ->leftJoin('kualifikasi_bidangs as b','kualifikasi_bidangs.parent_id','=','b.id')
                                    ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-klasifikasi-bidang.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-klasifikasi-bidang.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Download</a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('admin.master.kualifikasibidang.index');
    }

    public function create() {
        $kualifikasibidang = KualifikasiBidang::all();
        return view('admin.master.kualifikasibidang.create', compact('kualifikasibidang'));
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_kualifikasi'           => 'required',
        ],[
            'nama_kualifikasi.required'  => 'Nama Kualifikasi harus diisi.',
        ]);        
        
        try {
            $validatedData['parent_id'] = $request->parent_id;
            KualifikasiBidang::create($validatedData);
            return back()->with('success', 'Kualifikasi berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Kualifikasi gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $kualifikasi = KualifikasiBidang::find($id);  
        $kualifikasiAll = KualifikasiBidang::all();  
        return view('admin.master.kualifikasibidang.edit',compact('kualifikasi','kualifikasiAll'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'kualifikasi_id'        => 'required',
            'nama_kualifikasi'      => 'required',
        ],[
            'kualifikasi_id.required'     => 'Nama Kualifikasi harus dipilih.',
            'nama_kualifikasi.required'   => 'Nama Kualifikasi harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            $validatedData['parent_id'] = $request->parent_id;
            
            $ji = KualifikasiBidang::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-klasifikasi-bidang.index')->with('success', 'Kualifikasi berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-klasifikasi-bidang.index')->with('fail', 'Kualifikasi gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $pengurus = KualifikasiIzinUsaha::where('kualifikasi_bidang_id',$id);
            if($pengurus->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Izin')->withInput(); }
            $kualifikasi = KualifikasiBidang::find($id);
            $kualifikasi->delete();
            return redirect()->route('master-klasifikasi-bidang.index')->with('success', 'Kualifikasi berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Kualifikasi gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Kewarganegaraan;
use App\Models\Pemilik;
use DataTables;
use Auth;
use Carbon\Carbon;

class KewarganegaraanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Kewarganegaraan::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-kewarganegaraan.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-kewarganegaraan.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.kewarganegaraan.index');
    }

    public function create() {
        return view('admin.master.kewarganegaraan.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_kewarganegaraan'           => 'required',
        ],[
            'nama_kewarganegaraan.required'  => 'Nama Kewarganegaraan harus diisi.',
        ]);        
        
        try {
           
            Kewarganegaraan::create($validatedData);
            return back()->with('success', 'Kewarganegaraan berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Kewarganegaraan gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $kewarganegaraan = Kewarganegaraan::find($id);  
        return view('admin.master.kewarganegaraan.edit',compact('kewarganegaraan'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'kewarganegaraan_id'        => 'required',
            'nama_kewarganegaraan'      => 'required',
        ],[
            'kewarganegaraan_id.required'     => 'Nama Kewarganegaraan harus dipilih.',
            'nama_kewarganegaraan.required'   => 'Nama Kewarganegaraan harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = Kewarganegaraan::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-kewarganegaraan.index')->with('success', 'Kewarganegaraan berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-kewarganegaraan.index')->with('fail', 'Kewarganegaraan gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $pengurus = Pemilik::where('kewarganegaraan_id',$id);
            if($pengurus->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Tenaga Ahli')->withInput(); }
            $kewarganegaraan = Kewarganegaraan::find($id);
            $kewarganegaraan->delete();
            return redirect()->route('master-kewarganegaraan.index')->with('success', 'Kewarganegaraan berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Kewarganegaraan gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

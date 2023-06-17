<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriPekerjaan;
use App\Models\Pengalaman;
use DataTables;
use Auth;
use Carbon\Carbon;

class KategoriPekerjaanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = KategoriPekerjaan::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-kategori-pekerjaan.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-kategori-pekerjaan.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.kategoripekerjaan.index');
    }

    public function create() {
        return view('admin.master.kategoripekerjaan.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_kategori'           => 'required',
        ],[
            'nama_kategori.required'  => 'Nama Kategori harus diisi.',
        ]);        
        
        try {
           
            KategoriPekerjaan::create($validatedData);
            return back()->with('success', 'Kategori berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Kategori gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $kategoripekerjaan = KategoriPekerjaan::find($id);  
        return view('admin.master.kategoripekerjaan.edit',compact('kategoripekerjaan'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'kategori_pekerjaan_id'        => 'required',
            'nama_kategori'      => 'required',
        ],[
            'kategori_pekerjaan_id.required'     => 'Nama Kategori harus dipilih.',
            'nama_kategori.required'   => 'Nama Kategori harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = KategoriPekerjaan::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-kategori-pekerjaan.index')->with('success', 'Kategori berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-kategori-pekerjaan.index')->with('fail', 'Kategori gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $cekForeign = Pengalaman::where('kategori_pekerjaan_id',$id);
            if($cekForeign->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Data Pengalaman')->withInput(); }
            $kpekerjaan = KategoriPekerjaan::find($id);
            $kpekerjaan->delete();
            return redirect()->route('master-kategori-pekerjaan.index')->with('success', 'Kategori berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Kategori Pekerjaan gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\JenisUsaha;
use App\Models\IdentitasVendor;
use DataTables;
use Auth;
use Carbon\Carbon;

class JenisUsahaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = JenisUsaha::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-jenis-usaha.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-jenis-usaha.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.jenisusaha.index');
    }

    public function create() {
        return view('admin.master.jenisusaha.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Jenis Usaha harus diisi.',
        ]);        
        
        try {
           
            JenisUsaha::create($validatedData);
            return back()->with('success', 'Jenis Usaha berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Jenis Usaha gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $jenisusaha = JenisUsaha::find($id);  
        return view('admin.master.jenisusaha.edit',compact('jenisusaha'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'jenis_usaha_id'           => 'required',
            'nama' => 'required',
        ],[
            'jenis_usaha_id.required'          => 'Jenis Usaha harus dipilih.',
            'nama.required'                     => 'Jenis Usaha harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = JenisUsaha::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-jenis-usaha.index')->with('success', 'Jenis Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-jenis-usaha.index')->with('fail', 'Jenis Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($jenisusaha) {
        try {
            $identitas = IdentitasVendor::where('jenis_usaha',$jenisusaha);
            if($identitas->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
            $jenisusahaRow = JenisUsaha::find($jenisusaha);
            $jenisusahaRow->delete();
            return redirect()->route('master-jenis-usaha.index')->with('success', 'Jenis Usaha berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Jenis Usaha gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

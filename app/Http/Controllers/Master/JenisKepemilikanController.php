<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\JenisKepemilikan;
use App\Models\Pemilik;
use DataTables;
use Auth;
use Carbon\Carbon;

class JenisKepemilikanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = JenisKepemilikan::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-jenis-kepemilikan.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-jenis-kepemilikan.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.jeniskepemilikan.index');
    }

    public function create() {
        return view('admin.master.jeniskepemilikan.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_jenis'           => 'required',
        ],[
            'nama_jenis.required'             => 'Nama Jenis harus diisi.',
        ]);        
        
        try {
           
            JenisKepemilikan::create($validatedData);
            return back()->with('success', 'Jenis Kepemilikan berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Jenis Kepemilikan gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $jeniskepemilikan = JenisKepemilikan::find($id);  
        return view('admin.master.jeniskepemilikan.edit',compact('jeniskepemilikan'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'jenis_kepemilikan_id'        => 'required',
            'nama_jenis' => 'required',
        ],[
            'jenis_kepemilikan_id.required'          => 'Nama Jenis Kepemilikan harus dipilih.',
            'nama_jenis.required'   => 'Nama Jenis Kepemilikan harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = JenisKepemilikan::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-jenis-kepemilikan.index')->with('success', 'Jenis Kepemilikan Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-jenis-kepemilikan.index')->with('fail', 'Jenis Kepemilikan Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $pemilik = Pemilik::where('jenis_kepemilikan_id',$id);
            if($pemilik->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Pemilik')->withInput(); }
            $jeniskepemilikan = JenisKepemilikan::find($id);
            $jeniskepemilikan->delete();
            return redirect()->route('master-jenis-kepemilikan.index')->with('success', 'Jenis Kepemilikan berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Jenis Izin gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

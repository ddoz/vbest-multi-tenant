<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\JenisKepengurusan;
use App\Models\Pengurus;
use DataTables;
use Auth;
use Carbon\Carbon;

class JenisKepengurusanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = JenisKepengurusan::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-jenis-kepengurusan.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-jenis-kepengurusan.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.jeniskepengurusan.index');
    }

    public function create() {
        return view('admin.master.jeniskepengurusan.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Nama Jenis harus diisi.',
        ]);        
        
        try {
           
            JenisKepengurusan::create($validatedData);
            return back()->with('success', 'Jenis Kepengurusan berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Jenis Kepengurusan gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $jeniskepengurusan = JenisKepengurusan::find($id);  
        return view('admin.master.jeniskepengurusan.edit',compact('jeniskepengurusan'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'jenis_kepengurusan_id'        => 'required',
            'nama' => 'required',
        ],[
            'jenis_kepengurusan_id.required'          => 'Nama Kepengurusan harus dipilih.',
            'nama.required'   => 'Nama Kepengurusan harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = JenisKepengurusan::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-jenis-kepengurusan.index')->with('success', 'Jenis Kepengurusan berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-jenis-kepengurusan.index')->with('fail', 'Jenis Kepengurusan gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $pengurus = Pengurus::where('jenis_kepengurusan_id',$id);
            if($pengurus->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Pemilik')->withInput(); }
            $jenisk = JenisKepengurusan::find($id);
            $jenisk->delete();
            return redirect()->route('master-jenis-kepengurusan.index')->with('success', 'Tenaga Ahli berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Jenis Izin gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

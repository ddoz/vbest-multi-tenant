<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\JenisTenagaAhli;
use App\Models\TenagaAhli;
use DataTables;
use Auth;
use Carbon\Carbon;

class JenisTenagaAhliController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = JenisTenagaAhli::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-jenis-tenaga-ahli.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-jenis-tenaga-ahli.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.jenistenagaahli.index');
    }

    public function create() {
        return view('admin.master.jenistenagaahli.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Nama Jenis harus diisi.',
        ]);        
        
        try {
           
            JenisTenagaAhli::create($validatedData);
            return back()->with('success', 'Jenis Tenaga Ahli berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Jenis Tenaga Ahli gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $jenistenagaahli = JenisTenagaAhli::find($id);  
        return view('admin.master.jenistenagaahli.edit',compact('jenistenagaahli'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'jenis_tenaga_ahli_id'        => 'required',
            'nama' => 'required',
        ],[
            'jenis_tenaga_ahli_id.required'          => 'Nama Jenis harus dipilih.',
            'nama.required'   => 'Nama Jenis harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = JenisTenagaAhli::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-jenis-tenaga-ahli.index')->with('success', 'Jenis Tenaga Ahli berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-jenis-tenaga-ahli.index')->with('fail', 'Jenis Tenaga Ahli gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id) {
        try {
            $pengurus = TenagaAhli::where('jenis_tenaga_ahli_id',$id);
            if($pengurus->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Tenaga Ahli')->withInput(); }
            $jenisk = JenisTenagaAhli::find($id);
            $jenisk->delete();
            return redirect()->route('master-jenis-tenaga-ahli.index')->with('success', 'Jenis Tenaga Ahli berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Jenis Tenaga Ahli gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

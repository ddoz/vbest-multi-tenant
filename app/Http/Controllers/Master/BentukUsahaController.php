<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\BentukUsaha;
use App\Models\IdentitasVendor;
use DataTables;
use Auth;
use Carbon\Carbon;

class BentukUsahaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = BentukUsaha::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-bentuk-usaha.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-bentuk-usaha.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.bentukusaha.index');
    }

    public function create() {
        return view('admin.master.bentukusaha.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Bentuk Usaha harus diisi.',
        ]);        
        
        try {
           
            BentukUsaha::create($validatedData);
            return back()->with('success', 'Bentuk Usaha berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Bentuk Usaha gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $bentukusaha = BentukUsaha::find($id);  
        return view('admin.master.bentukusaha.edit',compact('bentukusaha'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'bentuk_usaha_id'           => 'required',
            'nama' => 'required',
        ],[
            'bentuk_usaha_id.required'          => 'Bentuk Usaha harus dipilih.',
            'nama.required'                     => 'Bentuk Usaha harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = BentukUsaha::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-bentuk-usaha.index')->with('success', 'Bentuk Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-bentuk-usaha.index')->with('fail', 'Bentuk Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($bentukusaha) {
        try {
            $identitas = IdentitasVendor::where('bentuk_usaha_id',$bentukusaha);
            if($identitas->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
            $bentukusahaRow = BentukUsaha::find($bentukusaha);
            $bentukusahaRow->delete();
            return redirect()->route('master-bentuk-usaha.index')->with('success', 'Bentuk Usaha berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Bentuk Usaha gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

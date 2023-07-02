<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\TotalModalUsaha;
use App\Models\IdentitasVendor;
use DataTables;
use Auth;
use Carbon\Carbon;

class ModalUsahaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = TotalModalUsaha::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-modal-usaha.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-modal-usaha.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.modalusaha.index');
    }

    public function create() {
        return view('admin.master.modalusaha.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Modal Usaha harus diisi.',
        ]);        
        
        try {
           
            TotalModalUsaha::create($validatedData);
            return back()->with('success', 'Modal Usaha berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Modal Usaha gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $modalusaha = TotalModalUsaha::find($id);  
        return view('admin.master.modalusaha.edit',compact('modalusaha'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'total_modal_usaha_id'           => 'required',
            'nama' => 'required',
        ],[
            'total_modal_usaha_id.required'          => 'Modal Usaha harus dipilih.',
            'nama.required'                     => 'Modal Usaha harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = TotalModalUsaha::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-modal-usaha.index')->with('success', 'Modal Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-modal-usaha.index')->with('fail', 'Modal Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($modalusaha) {
        try {
            $identitas = IdentitasVendor::where('total_modal_usaha_id',$modalusaha);
            if($identitas->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
            $modalusahaRow = TotalModalUsaha::find($modalusaha);
            $modalusahaRow->delete();
            return redirect()->route('master-modal-usaha.index')->with('success', 'Modal Usaha berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Modal Usaha gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

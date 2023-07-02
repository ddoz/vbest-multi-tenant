<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\StatusUsaha;
use App\Models\IdentitasVendor;
use DataTables;
use Auth;
use Carbon\Carbon;

class StatusUsahaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = StatusUsaha::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-status-usaha.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-status-usaha.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.statususaha.index');
    }

    public function create() {
        return view('admin.master.statususaha.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama'           => 'required',
        ],[
            'nama.required'             => 'Status Usaha harus diisi.',
        ]);        
        
        try {
           
            StatusUsaha::create($validatedData);
            return back()->with('success', 'Status Usaha berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Status Usaha gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $statususaha = StatusUsaha::find($id);  
        return view('admin.master.statususaha.edit',compact('statususaha'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'status_usaha_id'           => 'required',
            'nama' => 'required',
        ],[
            'status_usaha_id.required'          => 'Status Usaha harus dipilih.',
            'nama.required'                     => 'Status Usaha harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = StatusUsaha::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-status-usaha.index')->with('success', 'Status Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-status-usaha.index')->with('fail', 'Status Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($statususaha) {
        try {
            $identitas = IdentitasVendor::where('status_usaha_id',$statususaha);
            if($identitas->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
            $statususahaRow = StatusUsaha::find($statususaha);
            $statususahaRow->delete();
            return redirect()->route('master-status-usaha.index')->with('success', 'Status Usaha berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Status Usaha gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

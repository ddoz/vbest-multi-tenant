<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\JenisIzinUsaha;
use App\Models\IzinUsaha;
use DataTables;
use Auth;
use Carbon\Carbon;

class JenisIzinController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = JenisIzinUsaha::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-jenis-izin.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-jenis-izin.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.jenisizin.index');
    }

    public function create() {
        return view('admin.master.jenisizin.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_izin'           => 'required',
        ],[
            'jenis_izin.required'             => 'Jenis Izin harus diisi.',
        ]);        
        
        try {
           
            JenisIzinUsaha::create($validatedData);
            return back()->with('success', 'Jenis Izin berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Jenis Izin gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function edit($id)
    {
        $jenisizinusaha = JenisIzinUsaha::find($id);  
        return view('admin.master.jenisizin.edit',compact('jenisizinusaha'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'jenis_izin_id'        => 'required',
            'jenis_izin' => 'required',
        ],[
            'jenis_izin_id.required'          => 'Jenis Izin harus dipilih.',
            'jenis_izin.required'   => 'Jenis Izin harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $ji = JenisIzinUsaha::find($id);
            $ji->fill($validatedData)->save();

            return redirect()->route('master-jenis-izin.index')->with('success', 'Jenis Izin Usaha berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-jenis-izin.index')->with('fail', 'Jenis Izin Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($jenisizin) {
        try {
            $izinusaha = IzinUsaha::where('jenis_izin_usaha_id',$jenisizin);
            if($izinusaha->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Izin Usaha')->withInput(); }
            $jenisizin = JenisIzinUsaha::find($jenisizin);
            $jenisizin->delete();
            return redirect()->route('master-jenis-izin.index')->with('success', 'Jenis Izin berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Jenis Izin gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

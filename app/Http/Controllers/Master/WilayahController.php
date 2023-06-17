<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\IdentitasVendor;
use DataTables;
use Auth;
use Carbon\Carbon;

class WilayahController extends Controller
{
    public function index(Request $request) {
        $tab = $request->get('tab');
        if ($request->ajax()) {
            if($tab=='') {
                $data = Provinsi::get();
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-wilayah.destroy',$row->id).'" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                    <a class="btn btn-primary btn-sm" href="'.route('master-wilayah.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                    '.csrf_field().'
                                    <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                                    <input type="hidden" name="tab" value="provinsi" autocomplete="off">
                                </form></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            if($tab=='kabupaten') {
                $data = Kabupaten::select('kabupatens.*','provinsis.provinsi')
                            ->join('provinsis','provinsis.id','=','kabupatens.provinsi_id')
                            ->get();
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-wilayah.destroy',$row->id).'" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                    <a class="btn btn-primary btn-sm" href="'.route('master-wilayah.edit',$row->id).'?tab=kabupaten"><span class="ti ti-pencil"></span></a>
                                    '.csrf_field().'
                                    <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                                    <input type="hidden" name="tab" value="kabupaten" autocomplete="off">
                                </form></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            if($tab=='kecamatan') {
                $data = Kecamatan::select('kecamatans.*','kabupatens.kabupaten','provinsis.provinsi')
                            ->join('kabupatens','kabupatens.id','=','kecamatans.kabupaten_id')
                            ->join('provinsis','provinsis.id','=','kabupatens.provinsi_id')
                            ->get();
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-wilayah.destroy',$row->id).'" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                    <a class="btn btn-primary btn-sm" href="'.route('master-wilayah.edit',$row->id).'?tab=kecamatan"><span class="ti ti-pencil"></span></a>
                                    '.csrf_field().'
                                    <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                                    <input type="hidden" name="tab" value="kecamatan" autocomplete="off">
                                </form></div>';
                        return $btn;
                    })                    
                    ->rawColumns(['action'])
                    ->make(true);
            }

            if($tab=='kelurahan') {
                $data = Kelurahan::select('kelurahans.*','kecamatans.kecamatan','kabupatens.kabupaten','provinsis.provinsi')
                            ->join('kecamatans','kecamatans.id','=','kelurahans.kecamatan_id')
                            ->join('kabupatens','kabupatens.id','=','kecamatans.kabupaten_id')
                            ->join('provinsis','provinsis.id','=','kabupatens.provinsi_id')
                            ->get();
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-wilayah.destroy',$row->id).'" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                    <a class="btn btn-primary btn-sm" href="'.route('master-wilayah.edit',$row->id).'?tab=kelurahan"><span class="ti ti-pencil"></span></a>
                                    '.csrf_field().'
                                    <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                                    <input type="hidden" name="tab" value="kelurahan" autocomplete="off">
                                </form></div>';
                        return $btn;
                    })                    
                    ->rawColumns(['action'])
                    ->make(true);
            }
            
        }
        return view('admin.master.wilayah.index',compact('tab'));
    }

    public function create(Request $request) {
        $tab = $request->get('tab');
        $provinsi = Provinsi::all();
        $kabupaten = [];
        $kecamatan = [];
        if($tab == 'kecamatan') {
            $kabupaten = Kabupaten::all();
        }
        if($tab == 'kelurahan') {
            $kecamatan = Kecamatan::all();
        }
        return view('admin.master.wilayah.create', compact('tab','provinsi','kabupaten','kecamatan'));
    }
    
    public function store(Request $request) {
        $tab = $request->tab;
        if($tab == "provinsi") {
            $validatedData = $request->validate([
                'provinsi'           => 'required',
            ],[
                'provinsi.required'  => 'Provinsi harus diisi.',
            ]);        
            
            try {
               
                Provinsi::create($validatedData);
                return back()->with('success', 'Provinsi berhasil disimpan.');
                
            } catch(\Exception $e) {
                return back()->with('fail', 'Provinsi gagal disimpan. ' . $e->getMessage())->withInput();
            }
        }

        if($tab == "kabupaten") {
            $validatedData = $request->validate([
                'kabupaten'           => 'required',
                'provinsi_id'           => 'required',
            ],[
                'kabupaten.required'  => 'Kabupaten harus diisi.',
                'provinsi_id.required'  => 'Provinsi harus dipilih.',
            ]);        
            
            try {
               
                Kabupaten::create($validatedData);
                return back()->with('success', 'Kabupaten berhasil disimpan.');
                
            } catch(\Exception $e) {
                return back()->with('fail', 'Kabupaten gagal disimpan. ' . $e->getMessage())->withInput();
            }
        }

        if($tab == "kecamatan") {
            $validatedData = $request->validate([
                'kecamatan'                 => 'required',
                'kabupaten_id'              => 'required',
            ],[
                'kecamatan.required'        => 'Kecamatan harus diisi.',
                'kabupaten_id.required'     => 'Kabupaten harus dipilih.',
            ]);        
            
            try {
               
                Kecamatan::create($validatedData);
                return back()->with('success', 'Kecamatan berhasil disimpan.');
                
            } catch(\Exception $e) {
                return back()->with('fail', 'Kecamatan gagal disimpan. ' . $e->getMessage())->withInput();
            }
        }

        if($tab == "kelurahan") {
            $validatedData = $request->validate([
                'kelurahan'                 => 'required',
                'kecamatan_id'              => 'required',
            ],[
                'kelurahan.required'        => 'Kelurahan harus diisi.',
                'kecamatan_id.required'     => 'Kecamatan harus dipilih.',
            ]);        
            
            try {
                unset($validatedData['tab']);
                Kelurahan::create($validatedData);
                return back()->with('success', 'Kelurahan berhasil disimpan.');
                
            } catch(\Exception $e) {
                return back()->with('fail', 'Kelurahan gagal disimpan. ' . $e->getMessage())->withInput();
            }
        }


    }

    public function edit(Request $request, $id)
    {
        $tab = $request->get('tab');
        $provinsi = Provinsi::all();
        $kabupaten = [];
        $kecamatan = [];
        $data = Provinsi::find($id);
        if($tab == 'kabupaten') {
            $data = Kabupaten::find($id);
        }
        if($tab == 'kecamatan') {
            $kabupaten = Kabupaten::all();
            $data = Kecamatan::find($id);
        }
        if($tab == 'kelurahan') {
            $kecamatan = Kecamatan::all();
            $data = Kelurahan::find($id);
        } 
        return view('admin.master.wilayah.edit',compact('tab', 'provinsi', 'kabupaten', 'kecamatan', 'data'));
    }

    public function update(Request $request, $id) {
        $tab = $request->tab;
        if($tab == "provinsi") {
            $validatedData = $request->validate([
                'provinsi'      => 'required',
            ],[
                'provinsi.required'   => 'Provinsi harus diisi.',
            ]);
            
            try {
                $validatedData['updated_at'] = Carbon::now();
                
                $ji = Provinsi::find($id);
                $ji->fill($validatedData)->save();

                return redirect()->route('master-wilayah.index')->with('success', 'Provinsi berhasil diubah.');
            } catch(\Exception $e) {
                return redirect()->route('master-wilayah.index')->with('fail', 'Provinsi gagal diubah. ' . $e->getMessage())->withInput();
            }
        }
        if($tab == "kabupaten") {
            $validatedData = $request->validate([
                'provinsi_id'        => 'required',
                'kabupaten'      => 'required',
            ],[
                'provinsi_id.required'     => 'Provinsi harus dipilih.',
                'kabupaten.required'   => 'Kabupaten harus diisi.',
            ]);
            
            try {
                $validatedData['updated_at'] = Carbon::now();
                
                $ji = Kabupaten::find($id);
                $ji->fill($validatedData)->save();

                return redirect()->back()->with('success', 'Kabupaten berhasil diubah.');
            } catch(\Exception $e) {
                return redirect()->back()->with('fail', 'Kabupaten gagal diubah. ' . $e->getMessage())->withInput();
            }
        }
        if($tab == "kecamatan") {
            $validatedData = $request->validate([
                'kabupaten_id'        => 'required',
                'kecamatan'      => 'required',
            ],[
                'kabupaten_id.required'     => 'Kabupaten harus dipilih.',
                'kecamatan.required'   => 'Kecamatan harus diisi.',
            ]);
            
            try {
                $validatedData['updated_at'] = Carbon::now();
                
                $ji = Kecamatan::find($id);
                $ji->fill($validatedData)->save();

                return redirect()->back()->with('success', 'Kecamatan berhasil diubah.');
            } catch(\Exception $e) {
                return redirect()->back()->with('fail', 'Kecamatan gagal diubah. ' . $e->getMessage())->withInput();
            }
        }
        if($tab == "kelurahan") {
            $validatedData = $request->validate([
                'kecamatan_id'        => 'required',
                'kelurahan'      => 'required',
            ],[
                'kecamatan_id.required'     => 'Kecamatan harus dipilih.',
                'kelurahan.required'   => 'Kelurahan harus diisi.',
            ]);
            
            try {
                $validatedData['updated_at'] = Carbon::now();
                
                $ji = Kewarganegaraan::find($id);
                $ji->fill($validatedData)->save();

                return redirect()->back()->with('success', 'Kelurahan berhasil diubah.');
            } catch(\Exception $e) {
                return redirect()->back()->with('fail', 'Kelurahan gagal diubah. ' . $e->getMessage())->withInput();
            }
        }
        return redirect()->route('master-wilayah.index')->with('fail', 'Data Tidak Ditemukan.');
    }

    public function destroy(Request $request, $id) {
        if($request->tab=='provinsi') {
                try {
                $cek = IdentitasVendor::where('provinsi_id',$id);
                if($cek->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
                $cekKab = Kabupaten::where('provinsi_id',$id);
                if($cekKab->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Kabupaten')->withInput(); }
    
                $data = Provinsi::find($id);
                $data->delete();
                return redirect()->back()->with('success', 'Provinsi berhasil dihapus.');
            } catch(Exception $e) {
                return back()->with('fail', 'Provinsi gagal dihapus. ' . $e->getMessage())->withInput();
            }
        }
        if($request->tab=='kabupaten') {
            try {
                $cek = IdentitasVendor::where('kabupaten_id',$id);
                if($cek->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
                $cekKec = Kecamatan::where('kabupaten_id',$id);
                if($cekKec->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Kecamatan')->withInput(); }

                $data = Kabupaten::find($id);
                $data->delete();
                return redirect()->back()->with('success', 'Kabupaten berhasil dihapus.');
            } catch(Exception $e) {
                return back()->with('fail', 'Kabupaten gagal dihapus. ' . $e->getMessage())->withInput();
            }
        }
        if($request->tab=='kecamatan') {
            try {
                $cek = IdentitasVendor::where('kecamatan_id',$id);
                if($cek->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
                $cekKec = Kelurahan::where('kecamatan_id',$id);
                if($cekKec->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Kelurahan')->withInput(); }

                $data = Kecamatan::find($id);
                $data->delete();
                return redirect()->back()->with('success', 'Kecamatan berhasil dihapus.');
            } catch(Exception $e) {
                return back()->with('fail', 'Kecamatan gagal dihapus. ' . $e->getMessage())->withInput();
            }
        }
        if($request->tab=='kelurahan') {
            try {
                $cek = IdentitasVendor::where('kelurahan_id',$id);
                if($cek->exists()) { return back()->with('fail', 'Gagal dihapus. Karena Terdapat Pada Identitas Vendor')->withInput(); }
                
                $data = Kelurahan::find($id);
                $data->delete();
                return redirect()->back()->with('success', 'Kelurahan berhasil dihapus.');
            } catch(Exception $e) {
                return back()->with('fail', 'Kelurahan gagal dihapus. ' . $e->getMessage())->withInput();
            }
        }
        return redirect()->route('master-wilayah.index')->with('fail', 'Data Tidak Ditemukan.');

    }
}

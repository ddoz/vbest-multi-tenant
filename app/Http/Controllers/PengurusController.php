<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pengurus;
use App\Models\JenisKepengurusan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Carbon\Carbon;
use DataTables;
use Auth;

class PengurusController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pengurus::join('jenis_kepengurusans','jenis_kepengurusans.id','=','penguruses.jenis_kepengurusan_id')
                                ->select('penguruses.*','jenis_kepengurusans.nama as nama_kepengurusan')
                                ->where('penguruses.user_id',Auth::user()->id)
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('pengurus.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('pengurus.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('pengurus.show',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('pengurus/index');
    }

    public function create() {
        $jenisKepengurusan = JenisKepengurusan::all();
        $provinsi = Provinsi::all();
        return view('pengurus/create', compact('jenisKepengurusan','provinsi'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_kepengurusan_id'     => 'required',
            'nama'                      => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'jabatan'                   => 'required',
            'menjabat_sejak'            => 'required',
            'menjabat_sampai'           => 'required',
            'scan_dokumen'              => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_kepengurusan_id.required'    => 'Jenis Kepemilikan harus dipilih.',
            'nama.required'                     => 'Nama harus diisi.',
            'nomor_identitas.required'          => 'Nomor Identitas harus diisi.',
            'npwp.required'                     => 'NPWP harus diisi.',
            'alamat.required'                   => 'Alamat harus diisi.',
            'provinsi_id.required'              => 'Provinsi harus diisi.',
            'kabupaten_id.required'             => 'Kabupaten harus diisi.',
            'kecamatan_id.required'             => 'Kecamatan harus diisi.',
            'kelurahan_id.required'             => 'Kelurahan harus diisi.',
            'jabatan.required'                  => 'Jabatan harus diisi.',
            'menjabat_sejak.required'           => 'Menjabat Sejak harus diisi.',
            'menjabat_sampai.required'          => 'Menjabat Sampai harus diisi.',
            'scan_dokumen.required'             => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'             => 'Scan dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'             => 'Scan dokumen maksimal 10MB.',
        ]);
        
        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['user_id']       = Auth::user()->id;
        
        try {
            if ($request->hasFile('scan_dokumen')) { 

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pengurus/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                Pengurus::create($validatedData);
                return back()->with('success', 'Pengurus berhasil disimpan.');
            }else {
                return back()->with('fail', 'Pengurus gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            return back()->with('fail', 'Pengurus gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Pengurus $penguru)
    {
        return view('pengurus.show',compact('penguru'));
    }

    public function edit(Pengurus $penguru)
    {
        // Check if data is owned by user login
        if($penguru->user_id != Auth::user()->id) return redirect()->route('pengurus.index');

        $jenisKepengurusan = JenisKepengurusan::all();
        $provinsi  = Provinsi::all();
        $kabupaten = Kabupaten::find($penguru->kabupaten_id);
        $kecamatan = Kecamatan::find($penguru->kecamatan_id);
        $kelurahan = Kelurahan::find($penguru->kelurahan_id);

        return view('pengurus.edit',compact('penguru','jenisKepengurusan','provinsi','kabupaten','kecamatan','kelurahan'));
    }

    public function update(Request $request, Pengurus $penguru) {
        $validatedData = $request->validate([
            'jenis_kepengurusan_id'     => 'required',
            'nama'                      => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'jabatan'                   => 'required',
            'menjabat_sejak'            => 'required',
            'menjabat_sampai'           => 'required',
            // 'scan_dokumen'               => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_kepengurusan_id.required'    => 'Jenis Kepemilikan harus dipilih.',
            'nama.required'                     => 'Nama harus diisi.',
            'nomor_identitas.required'          => 'Nomor Identitas harus diisi.',
            'npwp.required'                     => 'NPWP harus diisi.',
            'alamat.required'                   => 'Alamat harus diisi.',
            'provinsi_id.required'              => 'Provinsi harus diisi.',
            'kabupaten_id.required'             => 'Kabupaten harus diisi.',
            'kecamatan_id.required'             => 'Kecamatan harus diisi.',
            'kelurahan_id.required'             => 'Kelurahan harus diisi.',
            'jabatan.required'                  => 'Jabatan harus diisi.',
            'menjabat_sejak.required'           => 'Menjabat Sejak harus diisi.',
            'menjabat_sampai.required'          => 'Menjabat Sampai harus diisi.',
        ]);
        
        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['user_id']       = Auth::user()->id;

        try {
            $validatedData['updated_at'] = Carbon::now();
            if ($request->hasFile('scan_dokumen')) {
                
                $request->validate([
                    'scan_dokumen'              => 'mimes:jpg,png,bmp,pdf|max:10000',
                ],[
                    'scan_dokumen.mimes'        => 'Dokumen harus berupa jpg, png, bmp atau pdf',
                    'scan_dokuemn.max'          => 'Dokumen maksimal 10MB', 
                ]);

                // delete eksisting file di cloud
                Storage::disk('s3')->delete($penguru->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pengurus/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 
            $penguru->fill($validatedData)->save();

            return redirect()->route('pengurus.index')->with('success', 'Pengurus berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('pengurus.index')->with('fail', 'Pengurus gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(Pengurus $penguru) {
        // Delete file di storage cloud
        // script here
        try {
            
            $penguru->delete();
            return redirect()->route('pengurus.index')->with('success', 'Pengurus berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Pengurus gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

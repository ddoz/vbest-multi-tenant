<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pemilik;
use App\Models\JenisKepemilikan;
use App\Models\Kewarganegaraan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Carbon\Carbon;
use DataTables;
use Auth;

class PemilikController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pemilik::join('kewarganegaraans','kewarganegaraans.id','=','pemiliks.kewarganegaraan_id')
                                ->join('jenis_kepemilikans','jenis_kepemilikans.id','=','pemiliks.jenis_kepemilikan_id')
                                ->where('pemiliks.user_id', Auth::user()->id)
                                ->select('pemiliks.*','kewarganegaraans.nama_kewarganegaraan','jenis_kepemilikans.nama_jenis')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('pemilik.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('pemilik.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('pemilik.show',$row->id).'"><span class="ti ti-search"></span></a>
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
        return view('pemilik/index');
    }

    public function create() {
        $jenisKepemilikan = JenisKepemilikan::all();
        $kewarganegaraan = Kewarganegaraan::all();
        $provinsi = Provinsi::all();
        return view('pemilik/create', compact('jenisKepemilikan', 'kewarganegaraan', 'provinsi'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_kepemilikan_id'      => 'required',
            'nama'                      => 'required',
            'kewarganegaraan_id'        => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'jumlah_saham'              => 'required',
            'jenis_saham'               => 'required',
            'scan_dokumen'              => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_kepemilikan_id.required'     => 'Jenis Kepemilikan harus dipilih.',
            'nama.required'                     => 'Nama harus diisi.',
            'kewarganegaraan_id.required'       => 'Kewarganegaraan harus dipilih.',
            'nomor_identitas.required'          => 'Nomor Identitas harus diisi.',
            'npwp.required'                     => 'NPWP harus diisi.',
            'alamat.required'                   => 'Alamat harus diisi.',
            'provinsi_id.required'              => 'Provinsi harus diisi.',
            'kabupaten_id.required'             => 'Kabupaten harus diisi.',
            'kecamatan_id.required'             => 'Kecamatan harus diisi.',
            'kelurahan_id.required'             => 'Kelurahan harus diisi.',
            'jumlah_saham.required'             => 'Jumlah Saham harus diisi.',
            'jenis_saham.required'              => 'Jenis Saham harus diisi.',
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
                $filePath = 'pemilik/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                Pemilik::create($validatedData);
                return back()->with('success', 'Pemilik berhasil disimpan.');
            } else{
                return back()->with('fail', 'Pemilik gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            return back()->with('fail', 'Pemilik gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Pemilik $pemilik)
    {
        return view('pemilik.show',compact('pemilik'));
    }

    public function edit(Pemilik $pemilik)
    {
        // Check if data is owned by user login
        if($pemilik->user_id != Auth::user()->id) return redirect()->route('pemilik.index');

        $jenisKepemilikan = JenisKepemilikan::all();
        $kewarganegaraan = Kewarganegaraan::all();
        $provinsi  = Provinsi::all();
        $kabupaten = Kabupaten::find($pemilik->kabupaten_id);
        $kecamatan = Kecamatan::find($pemilik->kecamatan_id);
        $kelurahan = Kelurahan::find($pemilik->kelurahan_id);

        return view('pemilik.edit',compact('pemilik','jenisKepemilikan','kewarganegaraan','provinsi','kabupaten','kecamatan','kelurahan'));
    }

    public function update(Request $request, Pemilik $pemilik) {
        $validatedData = $request->validate([
            'jenis_kepemilikan_id'      => 'required',
            'nama'                      => 'required',
            'kewarganegaraan_id'        => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'jumlah_saham'              => 'required',
            'jenis_saham'               => 'required',
        ],[
            'jenis_kepemilikan_id.required'     => 'Jenis Kepemilikan harus dipilih.',
            'nama.required'                     => 'Nama harus diisi.',
            'kewarganegaraan_id.required'       => 'Kewarganegaraan harus dipilih.',
            'nomor_identitas.required'          => 'Nomor Identitas harus diisi.',
            'npwp.required'                     => 'NPWP harus diisi.',
            'alamat.required'                   => 'Alamat harus diisi.',
            'provinsi_id.required'              => 'Provinsi harus diisi.',
            'kabupaten_id.required'             => 'Kabupaten harus diisi.',
            'kecamatan_id.required'             => 'Kecamatan harus diisi.',
            'kelurahan_id.required'             => 'Kelurahan harus diisi.',
            'jumlah_saham.required'             => 'Jumlah Saham harus diisi.',
            'jenis_saham.required'              => 'Jenis Saham harus diisi.',
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
                    'scan_dokumen.max'          => 'Dokumen maksimal 10MB', 
                ]);

                // delete eksisting file di cloud
                Storage::disk('s3')->delete($izin->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pemilik/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 
            $pemilik->fill($validatedData)->save();

            return redirect()->route('pemilik.index')->with('success', 'Pemilik berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('pemilik.index')->with('fail', 'Pemilik gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(Pemilik $pemilik) {
        // Delete file di storage cloud
        // script here
        try {
            
            Storage::disk('s3')->delete($pemilik->scan_dokumen);
            $pemilik->delete();

            return redirect()->route('pemilik.index')->with('success', 'Pemilik berhasil dihapus.');
        } catch(Exception $e) {
            return back()->with('fail', 'Pemilik gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

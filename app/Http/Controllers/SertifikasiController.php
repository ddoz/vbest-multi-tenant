<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use Auth;

class SertifikasiController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Sertifikasi::where('user_id',Auth::user()->id)->select('*')
                                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('sertifikasi.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('sertifikasi.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('sertifikasi.show',$row->id).'"><span class="ti ti-search"></span></a>
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
        return view('sertifikasi/index');
    }

    public function create() {
        return view('sertifikasi/create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_sertifikat'       => 'required',
            'nomor'                  => 'required',
            'seumur_hidup'           => 'required',
            'instansi_pemberi'       => 'required',
            'scan_dokumen'               => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_sertifikat.required'         => 'Jenis Sertifikat harus dipilih.',
            'nomor.required'                    => 'Nomor harus diisi.',
            'seumur_hidup.required'             => 'Seumur Hidup harus diisi.',
            'instansi_pemberi.required'         => 'Instansi Pemberi harus diisi.',
            'scan_dokumen.required'             => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'             => 'Scan dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'             => 'Scan dokumen maksimal 10MB.',

        ]);
        
        if($request->seumur_hidup == "Ya") {
            $request->validate([
                'berlaku_sampai' => 'required'
            ],[
                'berlaku_sampai.required' => 'Masukkan Tanggal Berlaku jika memilih Seumur Hidup.'
            ]);
            $validatedData['berlaku_sampai']    = $request->berlaku_sampai;
        }
        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['user_id']       = Auth::user()->id;
        
        try {
            if($request->hasFile('scan_dokumen')) {
                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'sertifikasi/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                Sertifikasi::create($validatedData);
                return back()->with('success', 'Sertifikasi berhasil disimpan.');
            }else {
                return back()->with('fail', 'Sertifikasi gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            return back()->with('fail', 'Sertifikasi gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Sertifikasi $sertifikasi)
    {
        return view('sertifikasi.show',compact('sertifikasi'));
    }

    public function edit(Sertifikasi $sertifikasi)
    {
        // Check if data is owned by user login
        if($sertifikasi->user_id != Auth::user()->id) return redirect()->route('sertifikasi.index');

        return view('sertifikasi.edit',compact('sertifikasi'));
    }

    public function update(Request $request, Sertifikasi $sertifikasi) {
        $validatedData = $request->validate([
            'jenis_sertifikat'      => 'required',
            'nomor'                  => 'required',
            'seumur_hidup'           => 'required',
            'instansi_pemberi'       => 'required',
        ],[
            'jenis_sertifikat.required'        => 'Jenis Sertifikat harus dipilih.',
            'nomor.required'                    => 'Nomor harus diisi.',
            'seumur_hidup.required'             => 'Seumur Hidup harus diisi.',
            'instansi_pemberi.required'         => 'Instansi Pemberi harus diisi.',
        ]);
        
        if($request->seumur_hidup == "Tidak") {
            $request->validate([
                'berlaku_sampai' => 'required'
            ],[
                'berlaku_sampai.required' => 'Masukkan Tanggal Berlaku jika memilih Seumur Hidup.'
            ]);
            $validatedData['berlaku_sampai']    = $request->berlaku_sampai;
        }
        
        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['user_id']       = Auth::user()->id;

        try {
            $validatedData['updated_at'] = Carbon::now();

            if($request->hasFile('scan_dokumen')) {
                $request->validate([
                    'scan_dokumen'              => 'mimes:jpg,png,bmp,pdf|max:10000',
                ],[
                    'scan_dokumen.mimes'        => 'Dokumen harus berupa jpg, png, bmp atau pdf',
                    'scan_dokuemn.max'          => 'Dokumen maksimal 10MB', 
                ]);

                // delete eksisting file di cloud
                Storage::disk('s3')->delete($sertifikasi->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'sertifikasi/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;  
            }
            $sertifikasi->fill($validatedData)->save();

            return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('sertifikasi.index')->with('fail', 'Sertifikasi gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(Sertifikasi $sertifikasi) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($sertifikasi->scan_dokumen);
            $sertifikasi->delete();
            return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Sertifikasi gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

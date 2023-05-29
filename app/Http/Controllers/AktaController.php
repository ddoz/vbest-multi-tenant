<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktaPerusahaan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Exception;
use Auth;

class AktaController extends Controller
{ 
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = AktaPerusahaan::select('*')->where('user_id',Auth::user()->id)->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('akta.destroy',$row->id).'" method="POST">
                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Hapus Data" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="'.route('akta.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Data" href="'.route('akta.show',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="" data-toggle="tooltip" data-placement="top" title="Download Lampiran" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('akta/index');
    }

    public function create() {
        return view('akta/create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_akta'                => 'required',
            'no_akta'                   => 'required',
            'tanggal_terbit'            => 'required',
            'nama_notaris'              => 'required',
            'keterangan'                => 'required',
            'scan_dokumen'              => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_akta.required'       => 'Jenis Akta harus dipilih.',
            'no_akta.required'          => 'Nomor Akta harus diisi.',
            'tanggal_terbit.required'   => 'Tanggal Terbit harus diisi.',
            'nama_notaris.required'     => 'Nama Notaris harus diisi.',
            'keterangan.required'       => 'Keterangan harus diisi.',
            'scan_dokumen.required'     => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'        => 'Scan Dokumen harus berupa tipe jpg,png,bmp,pdf.',
            'scan_dokumen.max'          => 'Scan Dokumen maksimal 10MB.',
        ]);

        
        $validatedData['user_id']       = Auth::user()->id;

        $newData = new AktaPerusahaan;
       
        try {
            if ($request->hasFile('scan_dokumen')) {
                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'akta-perusahaan/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;
                $newData->create($validatedData);
                return back()->with('success', 'Akta Perusahaan berhasil disimpan.');
            } else {
                return back()->with('fail', 'Akta Perusahaan gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            return back()->with('fail', 'Akta Perusahaan gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(AktaPerusahaan $aktum)
    {
        return view('akta.show',compact('aktum'));
    }

    public function edit(AktaPerusahaan $aktum)
    {
        // Check if data is owned by user login
        if($aktum->user_id != Auth::user()->id) return redirect()->route('akta.index');

        return view('akta.edit',compact('aktum'));
    }

    public function update(Request $request, AktaPerusahaan $aktum) {
        $validatedData = $request->validate([
            'jenis_akta'                => 'required',
            'no_akta'                   => 'required',
            'tanggal_terbit'            => 'required',
            'nama_notaris'              => 'required',
            'keterangan'                => 'required',
            
        ],[
            'jenis_akta.required'       => 'Jenis Akta harus dipilih.',
            'no_akta.required'          => 'Nomor Akta harus diisi.',
            'tanggal_terbit.required'   => 'Tanggal Terbit harus diisi.',
            'nama_notaris.required'     => 'Nama Notaris harus diisi.',
            'keterangan.required'       => 'Keterangan harus diisi.',
        ]);

        $validatedData['scan_dokumen']  = 'dummy.png'; // ganti dengan cloudstorage api
        $validatedData['user_id']       = Auth::user()->id;

        try {

            if ($request->hasFile('scan_dokumen')) {
                
                $request->validate([
                    'scan_dokumen'              => 'mimes:jpg,png,bmp,pdf|max:10000',
                ],[
                    'scan_dokumen.mimes'        => 'Dokumen harus berupa jpg, png, bmp atau pdf',
                    'scan_dokumen.max'          => 'Dokumen maksimal 10MB', 
                ]);

                // delete eksisting file di cloud
                Storage::disk('s3')->delete($aktum->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'akta-perusahaan/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 
            $aktum->fill($validatedData)->save();
            return redirect()->route('akta.index')->with('success', 'Akta Perusahaan berhasil diubah.');
        } catch(Exception $e) {
            return back()->with('fail', 'Akta Perusahaan gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(AktaPerusahaan $aktum) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($aktum->scan_dokumen);
            $aktum->delete();
            return redirect()->route('akta.index')->with('success', 'Akta Perusahaan berhasil dihapus.');
        } catch(Exception $e) {
            return back()->with('fail', 'Akta Perusahaan gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }

}

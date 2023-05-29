<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinUsaha;
use App\Models\JenisIzinUsaha;
use App\Models\KualifikasiBidang;
use App\Models\KualifikasiIzinUsaha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DataTables;
use Auth;

class IzinController extends Controller
{ 
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = IzinUsaha::join('jenis_izin_usahas','jenis_izin_usahas.id','=','izin_usahas.jenis_izin_usaha_id')
                                ->where('izin_usahas.user_id',Auth::user()->id)
                                ->select('izin_usahas.*','jenis_izin_usahas.jenis_izin')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('izin.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('izin.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('izin.show',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->addColumn('lampiran', function($row){
                    $btn = '<a href="" class="btn btn-primary btn-sm"><span class="ti ti-download"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action','lampiran'])
                ->make(true);
        }
        return view('izin/index');
    }

    public function create() {
        $jenisIzinUsaha = JenisIzinUsaha::all();
        $kualifikasiBidang = KualifikasiBidang::where('parent_id',0)->get();
        return view('izin/create',['jenisIzinUsaha'=>$jenisIzinUsaha,'kualifikasiBidang'=>$kualifikasiBidang]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_izin_usaha_id'           => 'required',
            'no_surat'                      => 'required',
            'seumur_hidup'                  => 'required',
            'kualifikasi'                   => 'required',
            'instansi_penerbit'             => 'required',
            'scan_dokumen'                  => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            'kualifikasiBidangUsaha'        => 'required|array|min:1',
            'kualifikasiBidangUsaha.*'      => 'required',
        ],[
            'jenis_izin_usaha_id.required'  => 'Jenis Izin harus dipilih.',
            'no_surat.required'             => 'Nomor Surat harus diisi.',
            'seumur_hidup.required'         => 'Seumur Hidup harus diisi.',
            'kualifikasi.required'          => 'Kualifikasi harus dipilih.',
            'instansi_penerbit.required'    => 'Instansi Penerbit harus diisi.',
            'kualifikasiBidangUsaha.*.required'  => 'Kualifikasi Bidang harus diisi minimal 1.',
            'scan_dokumen.required'              => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'              => 'Scan Dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'              => 'Scan Dokumen maksimal 10MB.',
        ]);

        if($request->seumur_hidup == "Tidak") {
            $request->validate([
                'berlaku_sampai'            => 'required'
            ],[
                'berlaku_sampai.required'   => 'Tanggal Berlaku harus diisi jika Tidak Seumur Hidup'
            ],);
            $validatedData['berlaku_sampai'] = $request->berlaku_sampai;
        }
        
        $validatedData['keterangan']    = $request->keterangan;
        $validatedData['user_id']       = Auth::user()->id;
        DB::beginTransaction();
        try {
            if ($request->hasFile('scan_dokumen')) { 
                unset($validatedData['kualifikasiBidangUsaha']);
                $validatedData['created_at'] = Carbon::now();
                $validatedData['updated_at'] = Carbon::now();

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'izin-usaha/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                $newData = IzinUsaha::insertGetId($validatedData);
    
                foreach($request->kualifikasiBidangUsaha as $rowInput) {
                    if($rowInput != null) {
                        KualifikasiIzinUsaha::create([
                            "kualifikasi_bidang_id" => $rowInput,
                            "izin_usaha_id"         => $newData
                        ]);
                    }
                }
                DB::commit();
                return back()->with('success', 'Izin Usaha berhasil disimpan.');
            } else {
                DB::rollback();
                return back()->with('fail', 'Izin gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Izin Usaha gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(IzinUsaha $izin)
    {
        $kualifikasiIzinUsaha = KualifikasiIzinUsaha::join("kualifikasi_bidangs","kualifikasi_bidangs.id","=","kualifikasi_izin_usahas.kualifikasi_bidang_id")
                        ->select("kualifikasi_izin_usahas.*","kualifikasi_bidangs.nama_kualifikasi","kualifikasi_bidangs.parent_id")
                        ->where('izin_usaha_id',$izin->id)->get();
        return view('izin.show',compact('izin','kualifikasiIzinUsaha'));
    }

    public function edit(IzinUsaha $izin)
    {
        // Check if data is owned by user login
        if($izin->user_id != Auth::user()->id) return redirect()->route('izin.index');

        $jenisIzinUsaha = JenisIzinUsaha::all();
        $kualifikasiBidang = KualifikasiBidang::where('parent_id',0)->get();
        $kualifikasiIzinUsaha = KualifikasiIzinUsaha::join("kualifikasi_bidangs","kualifikasi_bidangs.id","=","kualifikasi_izin_usahas.kualifikasi_bidang_id")
                        ->select("kualifikasi_izin_usahas.*","kualifikasi_bidangs.nama_kualifikasi","kualifikasi_bidangs.parent_id")
                        ->where('izin_usaha_id',$izin->id)->get();

        return view('izin.edit',compact('izin','jenisIzinUsaha','kualifikasiIzinUsaha','kualifikasiBidang'));
    }

    public function update(Request $request, IzinUsaha $izin) {
        $validatedData = $request->validate([
            'jenis_izin_usaha_id'           => 'required',
            'no_surat'                      => 'required',
            'seumur_hidup'                  => 'required',
            'kualifikasi'                   => 'required',
            'instansi_penerbit'             => 'required',
            'kualifikasiBidangUsaha'         => 'required|array|min:1',
            'kualifikasiBidangUsaha.*'         => 'required',
        ],[
            'jenis_izin_usaha_id.required'  => 'Jenis Izin harus dipilih.',
            'no_surat.required'             => 'Nomor Surat harus diisi.',
            'seumur_hidup.required'         => 'Seumur Hidup harus diisi.',
            'kualifikasi.required'          => 'Kualifikasi harus dipilih.',
            'instansi_penerbit.required'    => 'Instansi Penerbit harus diisi.',
            'kualifikasiBidangUsaha.*.required'  => 'Kualifikasi Bidang harus diisi minimal 1.',
        ]);

        if($request->seumur_hidup == "Tidak") {
            $request->validate([
                'berlaku_sampai'            => 'required'
            ],[
                'berlaku_sampai.required'   => 'Tanggal Berlaku harus diisi jika Tidak Seumur Hidup'
            ],);
            $validatedData['berlaku_sampai'] = $request->berlaku_sampai;
        }
        
        $validatedData['keterangan']    = $request->keterangan;
        $validatedData['user_id']       = Auth::user()->id;

        DB::beginTransaction();
        try {
            unset($validatedData['kualifikasiBidangUsaha']);
            $validatedData['updated_at'] = Carbon::now();

            if ($request->hasFile('scan_dokumen')) {
                
                $request->validate([
                    'scan_dokumen'              => 'mimes:jpg,png,bmp,pdf|max:10000',
                ],[
                    'scan_dokumen.mimes'        => 'Dokumen harus berupa jpg, png, bmp atau pdf',
                    'scan_dokuemn.max'          => 'Dokumen maksimal 10MB', 
                ]);

                // delete eksisting file di cloud
                Storage::disk('s3')->delete($izin->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'izin-usaha/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 

            $izin->fill($validatedData)->save();

            // remove old data kualifikasi izin
            KualifikasiIzinUsaha::where('izin_usaha_id',$izin->id)->delete();

            foreach($request->kualifikasiBidangUsaha as $rowInput) {
                if($rowInput != null) {
                    KualifikasiIzinUsaha::create([
                    "kualifikasi_bidang_id" => $rowInput,
                    "izin_usaha_id"         => $izin->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('izin.index')->with('success', 'Izin Usaha berhasil diubah.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('izin.index')->with('fail', 'Izin Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(IzinUsaha $izin) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($izin->scan_dokumen);
            KualifikasiIzinUsaha::where('izin_usaha_id',$izin->id)->delete();
            $izin->delete();
            return redirect()->route('izin.index')->with('success', 'Izin Usaha berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Izin Usaha gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }

}

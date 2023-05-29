<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\TenagaAhli;
use App\Models\JenisTenagaAhli;
use App\Models\SertifikasiTenagaAhli;
use App\Models\PengalamanTenagaAhli;
use App\Models\PendidikanTenagaAhli;
use App\Models\KemampuanBahasaTenagaAhli;
use App\Models\Kewarganegaraan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use DataTables;
use Auth;

class TenagaAhliController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = TenagaAhli::where('user_id',Auth::user()->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('tenaga-ahli.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('tenaga-ahli.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('tenaga-ahli.show',$row->id).'"><span class="ti ti-search"></span></a>
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
        return view('tenaga-ahli/index');
    }

    public function create() {
        $jenisTenagaAhli = JenisTenagaAhli::all();
        $kewarganegaraan = Kewarganegaraan::all();
        $provinsi = Provinsi::all();
        return view('tenaga-ahli/create', compact('jenisTenagaAhli','kewarganegaraan','provinsi'));
    }

    public function store(Request $request) {
        
        $validatedData = $request->validate([
            'jenis_tenaga_ahli_id'      => 'required',
            'nama'                      => 'required',
            'jenis_kelamin'             => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'tanggal_lahir'             => 'required',
            'kewarganegaraan_id'        => 'required',
            'email'                     => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'pendidikan_akhir'          => 'required',
            'jabatan'                   => 'required',
            'profesi_keahlian'          => 'required',
            'lama_pengalaman'           => 'required',
            'status_kepegawaian'        => 'required',
            'scan_dokumen'              => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            // 'jenis_sertifikat'        => 'required|array|min:1',
            // 'jenis_sertifikat.*'      => 'required',
            // 'lampiran'                  => 'required',
            // 'lampiran.*'                => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            // 'bidang'                    => 'required|array|min:1',
            // 'bidang.*'                  => 'required',
            // 'tingkatan'                 => 'required|array|min:1',
            // 'tingkatan.*'               => 'required',
            // 'diterbitkan'               => 'required|array|min:1',
            // 'diterbitkan.*'             => 'required',
            // 'berakhir'                  => 'required|array|min:1',
            // 'berakhir.*'                => 'required',
            // 'penerbit'                  => 'required|array|min:1',
            // 'penerbit.*'                => 'required',
            // 'tahun_pengalaman'          => 'required|array|min:1',
            // 'tahun_pengalaman.*'        => 'required',
            // 'uraian_pengalaman'         => 'required|array|min:1',
            // 'uraian_pengalaman.*'       => 'required',
            // 'tahun_pendidikan'          => 'required|array|min:1',
            // 'tahun_pendidikan.*'        => 'required',
            // 'uraian_pendidikan'         => 'required|array|min:1',
            // 'uraian_pendidikan.*'       => 'required',
            // 'bahasa'                    => 'required|array|min:1',
            // 'bahasa.*'                  => 'required',
        ],[
            'jenis_tenaga_ahli_id.required'         => 'Jenis Tenaga Ahli harus dipilih.',
            'nama.required'                         => 'Nama harus diisi.',
            'jenis_kelamin.required'                => 'Jenis Kelamin harus dipilih.',
            'nomor_identitas.required'              => 'Nomor Identitas harus diisi.',
            'npwp.required'                         => 'NPWP harus diisi.',
            'tanggal_lahir.required'                => 'Tanggal Lahir harus diisi.',
            'kewarganegaraan_id.required'           => 'Kewarganegaraan harus dipilih.',
            'alamat.required'                       => 'Alamat harus diisi.',
            'provinsi_id.required'                  => 'Provinsi harus dipilih.',
            'kabupaten_id.required'                 => 'Kabupaten harus dipilih.',
            'kecamatan_id.required'                 => 'Kecamatan harus dipilih.',
            'kelurahan_id.required'                 => 'Kelurahan harus dipilih.',
            'pendidikan_akhir.required'             => 'Pendidikan Akhir harus diisi.',
            'jabatan.required'                      => 'Jabatan harus diisi.',
            'profesi_keahlian.required'             => 'Profesi Keahlian harus diisi.',
            'lama_pengalaman.required'              => 'Lama Pengalaman harus diisi.',
            'status_kepegawaian.required'           => 'Sattus Kepegawaian harus dipilih.',
            'scan_dokumen.required'                 => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'             => 'Scan dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'             => 'Scan dokumen maksimal 10MB.',

            // 'jenis_sertifikasi.*.required'        => 'Jenis Sertifikasi harus diisi minimal 1.',
        ]);

        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['riwayat_penyakit']    = $request->riwayat_penyakit;
        $validatedData['user_id']       = Auth::user()->id;
        DB::beginTransaction();
        try {
            if ($request->hasFile('scan_dokumen')) { 
                
                $validatedData['created_at'] = Carbon::now();
                $validatedData['updated_at'] = Carbon::now();

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'tenaga-ahli/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                $newData = TenagaAhli::insertGetId($validatedData);

                //insert sertifikasi
                if($request->has('jenis_sertifikat')) {
                    foreach($request->jenis_sertifikat as $key => $rowInputSertifikat) {
                        if($rowInputSertifikat != null) {
    
                            $file = $request->file('lampiran')[$key];
                            $extension  = $file->getClientOriginalExtension(); 
                            $name = time() .'_' . Str::random(8) . '.' . $extension;
                            $filePathSertifikat = 'tenaga-ahli/sertifikasi/' . $name;
                            Storage::disk('s3')->put($filePath, file_get_contents($file));
                            Storage::disk('s3')->setVisibility($filePath, "public"); 
    
                            SertifikasiTenagaAhli::create([
                                "jenis_sertifikat"  => $rowInputSertifikat,
                                "lampiran"          => $filePathSertifikat,
                                "bidang"            => $request->bidang[$key],
                                "tingkatan"         => $request->tingkatan[$key],
                                "diterbitkan"       => $request->diterbitkan[$key],
                                "berakhir"          => $request->berakhir[$key],
                                "penerbit"          => $request->penerbit[$key],
                                "tenaga_ahli_id"    => $newData,
                            ]);
                            
                        }
                    }
                }

                //insert pengalaman
                if($request->has('tahun_pengalaman')) {
                    foreach($request->tahun_pengalaman as $key => $rowInput) {
                        if($rowInput != null) {
                            PengalamanTenagaAhli::create([
                                "tahun"             => $rowInput,
                                "uraian"            => $request->uraian_pengalaman[$key],
                                "tenaga_ahli_id"    => $newData,
                            ]);
                        }
                    }
                }

                //insert pendidikan
                if($request->has('tahun_pendidikan')) {
                    foreach($request->tahun_pendidikan as $key => $rowInput) {
                        if($rowInput != null) {
                            PendidikanTenagaAhli::create([
                                "tahun"             => $rowInput,
                                "uraian"            => $request->uraian_pendidikan[$key],
                                "tenaga_ahli_id"    => $newData,
                            ]);
                        }
                    }
                }

                //insert bahasa
                if($request->has('bahasa')) {
                    foreach($request->bahasa as $key => $rowInput) {
                        if($rowInput != null) {
                            KemampuanBahasaTenagaAhli::create([
                                "uraian"            => $rowInput,
                                "tenaga_ahli_id"    => $newData,
                            ]);
                        }
                    }
                }

                DB::commit();
                return back()->with('success', 'Tenaga Ahli berhasil disimpan.');
            } else {
                DB::rollback();
                return back()->with('fail', 'Tenaga Ahli gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Tenaga Ahli gagal disimpan. ' . $e->getMessage())->withInput();
        }
    }

    public function show(TenagaAhli $tenaga_ahli)
    {
        $sertifikasi = SertifikasiTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pendidikan = PendidikanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pengalaman = PengalamanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $kemampuanBahasa = KemampuanBahasaTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        return view('tenaga-ahli.show',compact('tenaga_ahli','sertifikasi','pendidikan','pengalaman','kemampuanBahasa'));
    }

    public function edit(TenagaAhli $tenaga_ahli)
    {
        // Check if data is owned by user login
        if($tenaga_ahli->user_id != Auth::user()->id) return redirect()->route('tenaga-ahli.index');

        $jenisTenagaAhli = JenisTenagaAhli::all();
        $kewarganegaraan = Kewarganegaraan::all();
        $provinsi  = Provinsi::all();
        $kabupaten = Kabupaten::find($tenaga_ahli->kabupaten_id);
        $kecamatan = Kecamatan::find($tenaga_ahli->kecamatan_id);
        $kelurahan = Kelurahan::find($tenaga_ahli->kelurahan_id);
        $sertifikasi = SertifikasiTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pendidikan = PendidikanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $pengalaman = PengalamanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();
        $kemampuanBahasa = KemampuanBahasaTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get();

        return view('tenaga-ahli.edit',compact('tenaga_ahli','provinsi','kabupaten','kecamatan', 'kelurahan','kemampuanBahasa','jenisTenagaAhli','kewarganegaraan','sertifikasi','pendidikan','pengalaman','kemampuanBahasa'));
    }

    public function update(Request $request, TenagaAhli $tenaga_ahli) {
        $validatedData = $request->validate([
            'jenis_tenaga_ahli_id'      => 'required',
            'nama'                      => 'required',
            'jenis_kelamin'             => 'required',
            'nomor_identitas'           => 'required',
            'npwp'                      => 'required',
            'tanggal_lahir'             => 'required',
            'kewarganegaraan_id'        => 'required',
            'email'                     => 'required',
            'alamat'                    => 'required',
            'provinsi_id'               => 'required',
            'kabupaten_id'              => 'required',
            'kecamatan_id'              => 'required',
            'kelurahan_id'              => 'required',
            'pendidikan_akhir'          => 'required',
            'jabatan'                   => 'required',
            'profesi_keahlian'          => 'required',
            'lama_pengalaman'           => 'required',
            'status_kepegawaian'        => 'required',
            // 'scan_dokumen'              => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            // 'jenis_sertifikat'        => 'required|array|min:1',
            // 'jenis_sertifikat.*'      => 'required',
            // 'lampiran'                  => 'required',
            // 'lampiran.*'                => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            // 'bidang'                    => 'required|array|min:1',
            // 'bidang.*'                  => 'required',
            // 'tingkatan'                 => 'required|array|min:1',
            // 'tingkatan.*'               => 'required',
            // 'diterbitkan'               => 'required|array|min:1',
            // 'diterbitkan.*'             => 'required',
            // 'berakhir'                  => 'required|array|min:1',
            // 'berakhir.*'                => 'required',
            // 'penerbit'                  => 'required|array|min:1',
            // 'penerbit.*'                => 'required',
            // 'tahun_pengalaman'          => 'required|array|min:1',
            // 'tahun_pengalaman.*'        => 'required',
            // 'uraian_pengalaman'         => 'required|array|min:1',
            // 'uraian_pengalaman.*'       => 'required',
            // 'tahun_pendidikan'          => 'required|array|min:1',
            // 'tahun_pendidikan.*'        => 'required',
            // 'uraian_pendidikan'         => 'required|array|min:1',
            // 'uraian_pendidikan.*'       => 'required',
            // 'bahasa'                    => 'required|array|min:1',
            // 'bahasa.*'                  => 'required',
        ],[
            'jenis_tenaga_ahli_id.required'         => 'Jenis Tenaga Ahli harus dipilih.',
            'nama.required'                         => 'Nama harus diisi.',
            'jenis_kelamin.required'                => 'Jenis Kelamin harus dipilih.',
            'nomor_identitas.required'              => 'Nomor Identitas harus diisi.',
            'npwp.required'                         => 'NPWP harus diisi.',
            'tanggal_lahir.required'                => 'Tanggal Lahir harus diisi.',
            'kewarganegaraan_id.required'           => 'Kewarganegaraan harus dipilih.',
            'alamat.required'                       => 'Alamat harus diisi.',
            'provinsi_id.required'                  => 'Provinsi harus dipilih.',
            'kabupaten_id.required'                 => 'Kabupaten harus dipilih.',
            'kecamatan_id.required'                 => 'Kecamatan harus dipilih.',
            'kelurahan_id.required'                 => 'Kelurahan harus dipilih.',
            'pendidikan_akhir.required'             => 'Pendidikan Akhir harus diisi.',
            'jabatan.required'                      => 'Jabatan harus diisi.',
            'profesi_keahlian.required'             => 'Profesi Keahlian harus diisi.',
            'lama_pengalaman.required'              => 'Lama Pengalaman harus diisi.',
            'status_kepegawaian.required'           => 'Sattus Kepegawaian harus dipilih.',
            // 'scan_dokumen.required'                 => 'Scan Dokumen harus diisi.',

            // 'jenis_sertifikasi.*.required'        => 'Jenis Sertifikasi harus diisi minimal 1.',
        ]);
        
        $validatedData['keterangan_tambahan']    = $request->keterangan_tambahan;
        $validatedData['riwayat_penyakit']       = $request->riwayat_penyakit;     
        $validatedData['user_id']                = Auth::user()->id;

        DB::beginTransaction();
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
                Storage::disk('s3')->delete($tenaga_ahli->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'tenaga-ahli/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 

            $tenaga_ahli->fill($validatedData)->save();

            // remove old data child
            // handling file in sertifikat
            $idUpdate = array();
            if($request->has('sertifikat_id')) {
                foreach($request->sertifikat_id as $row) {
                    if($row!=0) {
                        array_push($idUpdate,$row);
                    }
                }
            }
            //insert sertifikasi
            if($request->has('jenis_sertifikat')) {
                SertifikasiTenagaAhli::whereNotIn('id',$idUpdate)->delete();
                foreach($request->jenis_sertifikat as $key => $rowInputSertifikat) {
                    if($rowInputSertifikat != null) {
                        if($request->sertifikat_id[$key]==0) {
                            if($request->hasFile('lampiran')) {
                                $file = $request->file('lampiran')[$key];
                                $extension  = $file->getClientOriginalExtension(); 
                                $name = time() .'_' . Str::random(8) . '.' . $extension;
                                $filePathSertifikat = 'tenaga-ahli/sertifikasi/' . $name;
                                Storage::disk('s3')->put($filePath, file_get_contents($file));
                                Storage::disk('s3')->setVisibility($filePath, "public"); 
                                SertifikasiTenagaAhli::create([
                                    "jenis_sertifikat"  => $rowInputSertifikat,
                                    "lampiran"          => $filePathSertifikat,
                                    "bidang"            => $request->bidang[$key],
                                    "tingkatan"         => $request->tingkatan[$key],
                                    "diterbitkan"       => $request->diterbitkan[$key],
                                    "berakhir"          => $request->berakhir[$key],
                                    "penerbit"          => $request->penerbit[$key],
                                ]);
                            }
                        }else {
                            if($request->hasFile('lampiran')) {
                                $file = $request->file('lampiran')[$key];
                                $extension  = $file->getClientOriginalExtension(); 
                                $name = time() .'_' . Str::random(8) . '.' . $extension;
                                $filePathSertifikat = 'tenaga-ahli/sertifikasi/' . $name;
                                Storage::disk('s3')->put($filePath, file_get_contents($file));
                                Storage::disk('s3')->setVisibility($filePath, "public"); 
                                
                                SertifikasiTenagaAhli::where("id",$request->sertifikat_id[$key])
                                                ->update([
                                                    "jenis_sertifikat"  => $rowInputSertifikat,
                                                    "lampiran"          => $filePathSertifikat,
                                                    "bidang"            => $request->bidang[$key],
                                                    "tingkatan"         => $request->tingkatan[$key],
                                                    "diterbitkan"       => $request->diterbitkan[$key],
                                                    "berakhir"          => $request->berakhir[$key],
                                                    "penerbit"          => $request->penerbit[$key],
                                                ]);
                            }else {
                                SertifikasiTenagaAhli::where("id",$request->sertifikat_id[$key])
                                                ->update([
                                                    "jenis_sertifikat"  => $rowInputSertifikat,
                                                    "bidang"            => $request->bidang[$key],
                                                    "tingkatan"         => $request->tingkatan[$key],
                                                    "diterbitkan"       => $request->diterbitkan[$key],
                                                    "berakhir"          => $request->berakhir[$key],
                                                    "penerbit"          => $request->penerbit[$key],
                                                ]);
                            }
                        }                                             
                    }
                }
            }                    
            
            //insert pengalaman
            if($request->has('tahun_pengalaman')) {
                PengalamanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
                foreach($request->tahun_pengalaman as $key => $rowInput) {
                    if($rowInput != null) {
                        PengalamanTenagaAhli::create([
                            "tahun"             => $rowInput,
                            "uraian"            => $request->uraian_pengalaman[$key],
                            "tenaga_ahli_id"    => $tenaga_ahli->id,
                        ]);
                    }
                }
            }

            //insert pendidikan
            if($request->has('tahun_pengalaman')) {
                PendidikanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
                foreach($request->tahun_pendidikan as $key => $rowInput) {
                    if($rowInput != null) {
                        PendidikanTenagaAhli::create([
                            "tahun"             => $rowInput,
                            "uraian"            => $request->uraian_pendidikan[$key],
                            "tenaga_ahli_id"    => $tenaga_ahli->id,
                        ]);
                    }
                }
            }

            //insert bahasa
            if($request->has('bahasa')) {
                KemampuanBahasaTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
                foreach($request->bahasa as $key => $rowInput) {
                    if($rowInput != null) {
                        KemampuanBahasaTenagaAhli::create([
                            "uraian"            => $rowInput,
                            "tenaga_ahli_id"    => $tenaga_ahli->id,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli Usaha berhasil diubah.');
        } catch(\Exception $e) {
            DB::rollback();
            dd($e);
            // return redirect()->route('tenaga-ahli.index')->with('fail', 'Tenaga Ahli Usaha gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(TenagaAhli $tenaga_ahli) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($tenaga_ahli->scan_dokumen);

            foreach(SertifikasiTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->get() as $st) {
                Storage::disk('s3')->delete($st->lampiran);
            };
            SertifikasiTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
            PengalamanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
            PendidikanTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
            KemampuanBahasaTenagaAhli::where('tenaga_ahli_id',$tenaga_ahli->id)->delete();
            $tenaga_ahli->delete();
            return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli  berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Tenaga Ahli  gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

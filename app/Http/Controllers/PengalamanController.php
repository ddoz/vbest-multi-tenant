<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengalaman;
use App\Models\KualifikasiBidang;
use App\Models\KualifikasiPengalaman;
use App\Models\KategoriPekerjaan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DataTables;
use Auth;

class PengalamanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pengalaman::where('user_id', Auth::user()->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('pengalaman.destroy',$row->id).'" method="POST">
                                    <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                    <a class="btn btn-primary btn-sm" href="'.route('pengalaman.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                    <a class="btn btn-success btn-sm" href="'.route('pengalaman.show',$row->id).'"><span class="ti ti-search"></span></a>
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
        return view('pengalaman/index');
    }

    public function create() {
        $kategoriPekerjaan = KategoriPekerjaan::all();
        $kualifikasiBidang = KualifikasiBidang::where('parent_id',0)->get();
        $provinsi = Provinsi::all();
        return view('pengalaman.create',compact('kategoriPekerjaan','kualifikasiBidang','provinsi'));
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_kontrak'           => 'required',
            'lingkup_pekerjaan'                      => 'required',
            'nomor_kontrak'                  => 'required',
            'kategori_pekerjaan_id'                  => 'required',
            'pelaksanaan_kontrak'                  => 'required',
            'selesai_kontrak'                  => 'required',
            'serah_terima_pekerjaan'                  => 'required',
            'tanggal_progress'                  => 'required',
            'nilai_kontrak'                  => 'required',
            'presentase_pekerjaan'                  => 'required',
            'keterangan' => 'required',
            'nama_alamat_proyek' => 'required',
            'lokasi_pekerjaan_provinsi_id' => 'required',
            'lokasi_pekerjaan_kabupaten_id' => 'required',
            'lokasi_pekerjaan_kecamatan_id' => 'required',
            'lokasi_pekerjaan_kelurahan_id' => 'required',
            'instansi_pengguna' => 'required',
            'alamat_instansi' => 'required',
            'instansi_provinsi_id' => 'required',
            'instansi_kabupaten_id' => 'required',
            'instansi_kecamatan_id' => 'required',
            'instansi_kelurahan_id' => 'required',
            'telpon_instansi' => 'required',
            'scan_dokumen'                  => 'required|mimes:jpg,png,bmp,pdf|max:10000',
            // 'kualifikasiBidangUsaha'        => 'required|array|min:1',
            // 'kualifikasiBidangUsaha.*'      => 'required',
        ],[
            'nama_kontrak.required'  => 'Jenis Izin harus dipilih.',
            'lingkup_pekerjaan.required'             => 'Nomor Surat harus diisi.',
            'nomor_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'kategori_pekerjaan_id.required'         => 'Seumur Hidup harus diisi.',
            'pelaksanaan_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'selesai_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'serah_terima_pekerjaan.required'         => 'Seumur Hidup harus diisi.',
            'presentase_pekerjaan.required'         => 'Seumur Hidup harus diisi.',
            'tanggal_progress.required'         => 'Seumur Hidup harus diisi.',
            'keterangan.required'         => 'Seumur Hidup harus diisi.',
            'nama_alamat_proyek.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_provinsi_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kabupaten_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kecamatan_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kelurahan_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_pengguna.required'         => 'Seumur Hidup harus diisi.',
            'alamat_instansi.required'         => 'Seumur Hidup harus diisi.',
            'instansi_provinsi_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kabupaten_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kecamatan_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kelurahan_id.required'         => 'Seumur Hidup harus diisi.',
            'telpon_instansi.required'         => 'Seumur Hidup harus diisi.',
            'kualifikasiBidangUsaha.*.required'  => 'Kualifikasi Bidang harus diisi minimal 1.',
            'scan_dokumen.required'              => 'Scan Dokumen harus diisi.',
            'scan_dokumen.mimes'             => 'Scan dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'             => 'Scan dokumen maksimal 10MB.',
        ]);
        
        $validatedData['keterangan']    = $request->keterangan;
        $validatedData['user_id']       = Auth::user()->id;
        DB::beginTransaction();
        try {
            if ($request->hasFile('scan_dokumen')) { 
                
                $validatedData['created_at'] = Carbon::now();
                $validatedData['updated_at'] = Carbon::now();

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pengalaman/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                $newData = Pengalaman::insertGetId($validatedData);
    
                foreach($request->kualifikasiBidangUsaha as $rowInput) {
                    if($rowInput != null) {
                        KualifikasiPengalaman::create([
                            "kualifikasi_bidang_id" => $rowInput,
                            "pengalaman_id"         => $newData
                        ]);
                    }
                }
                DB::commit();
                return back()->with('success', 'Pengalaman berhasil disimpan.');
            } else {
                DB::rollback();
                return back()->with('fail', 'Pengalaman gagal disimpan. Gagal Upload File.')->withInput();
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Pengalaman gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Pengalaman $pengalaman)
    {
        $kualifikasiPengalaman = KualifikasiPengalaman::join("kualifikasi_bidangs","kualifikasi_bidangs.id","=","kualifikasi_pengalaman.kualifikasi_bidang_id")
                        ->select("kualifikasi_pengalaman.*","kualifikasi_bidangs.nama_kualifikasi","kualifikasi_bidangs.parent_id")
                        ->where('pengalaman_id',$pengalaman->id)->get();
        return view('pengalaman.show',compact('pengalaman','kualifikasiPengalaman'));
    }

    public function edit(Pengalaman $pengalaman)
    {
        // Check if data is owned by user login
        if($pengalaman->user_id != Auth::user()->id) return redirect()->route('pengalaman.index');

        $kategoriPekerjaan = KategoriPekerjaan::all();
        $kualifikasiBidang = KualifikasiBidang::where('parent_id',0)->get();
        $kualifikasiPengalaman = KualifikasiPengalaman::join("kualifikasi_bidangs","kualifikasi_bidangs.id","=","kualifikasi_pengalaman.kualifikasi_bidang_id")
                        ->select("kualifikasi_pengalaman.*","kualifikasi_bidangs.nama_kualifikasi","kualifikasi_bidangs.parent_id")
                        ->where('pengalaman_id',$pengalaman->id)->get();
        $provinsi= Provinsi::all();
        $kabupatenLokasi = Kabupaten::where("id",$pengalaman->lokasi_pekerjaan_kabupaten_id)->first();
        $kecamatanLokasi = Kecamatan::where("id",$pengalaman->lokasi_pekerjaan_kecamatan_id)->first();
        $kelurahanLokasi = Kelurahan::where("id",$pengalaman->lokasi_pekerjaan_kelurahan_id)->first();
        $kabupatenInstansi = Kabupaten::where("id",$pengalaman->instansi_kabupaten_id)->first();
        $kecamatanInstansi = Kecamatan::where("id",$pengalaman->instansi_kecamatan_id)->first();
        $kelurahanInstansi = Kelurahan::where("id",$pengalaman->instansi_kelurahan_id)->first();
        return view('pengalaman.edit',compact('provinsi','kabupatenInstansi','kecamatanInstansi','kelurahanInstansi','kabupatenLokasi','kecamatanLokasi','kelurahanLokasi','pengalaman','kategoriPekerjaan','kualifikasiPengalaman','kualifikasiBidang','kategoriPekerjaan'));
    }

    public function update(Request $request, Pengalaman $pengalaman) {
        $validatedData = $request->validate([
            'nama_kontrak'           => 'required',
            'lingkup_pekerjaan'                      => 'required',
            'nomor_kontrak'                  => 'required',
            'kategori_pekerjaan_id'                  => 'required',
            'pelaksanaan_kontrak'                  => 'required',
            'selesai_kontrak'                  => 'required',
            'serah_terima_pekerjaan'                  => 'required',
            'tanggal_progress'                  => 'required',
            'nilai_kontrak'                  => 'required',
            'presentase_pekerjaan'                  => 'required',
            'keterangan' => 'required',
            'nama_alamat_proyek' => 'required',
            'lokasi_pekerjaan_provinsi_id' => 'required',
            'lokasi_pekerjaan_kabupaten_id' => 'required',
            'lokasi_pekerjaan_kecamatan_id' => 'required',
            'lokasi_pekerjaan_kelurahan_id' => 'required',
            'instansi_pengguna' => 'required',
            'alamat_instansi' => 'required',
            'instansi_provinsi_id' => 'required',
            'instansi_kabupaten_id' => 'required',
            'instansi_kecamatan_id' => 'required',
            'instansi_kelurahan_id' => 'required',
            'telpon_instansi' => 'required',
        ],[
            'nama_kontrak.required'  => 'Jenis Izin harus dipilih.',
            'lingkup_pekerjaan.required'             => 'Nomor Surat harus diisi.',
            'nomor_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'kategori_pekerjaan_id.required'         => 'Seumur Hidup harus diisi.',
            'pelaksanaan_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'selesai_kontrak.required'         => 'Seumur Hidup harus diisi.',
            'serah_terima_pekerjaan.required'         => 'Seumur Hidup harus diisi.',
            'presentase_pekerjaan.required'         => 'Seumur Hidup harus diisi.',
            'tanggal_progress.required'         => 'Seumur Hidup harus diisi.',
            'keterangan.required'         => 'Seumur Hidup harus diisi.',
            'nama_alamat_proyek.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_provinsi_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kabupaten_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kecamatan_id.required'         => 'Seumur Hidup harus diisi.',
            'lokasi_pekerjaan_kelurahan_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_pengguna.required'         => 'Seumur Hidup harus diisi.',
            'alamat_instansi.required'         => 'Seumur Hidup harus diisi.',
            'instansi_provinsi_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kabupaten_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kecamatan_id.required'         => 'Seumur Hidup harus diisi.',
            'instansi_kelurahan_id.required'         => 'Seumur Hidup harus diisi.',
            'telpon_instansi.required'         => 'Seumur Hidup harus diisi.',
            'kualifikasiBidangUsaha.*.required'  => 'Kualifikasi Bidang harus diisi minimal 1.',
        ]);
        
        $validatedData['keterangan']    = $request->keterangan;
        $validatedData['user_id']       = Auth::user()->id;

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
                Storage::disk('s3')->delete($pengalaman->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pengalaman/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 

            $pengalaman->fill($validatedData)->save();

            // remove old data kualifikasi pengalaman
            KualifikasiPengalaman::where('pengalaman_id',$pengalaman->id)->delete();

            foreach($request->kualifikasiBidangUsaha as $rowInput) {
                if($rowInput != null) {
                    KualifikasiPengalaman::create([
                    "kualifikasi_bidang_id" => $rowInput,
                    "pengalaman_id"         => $pengalaman->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('pengalaman.index')->with('success', 'Pengalaman berhasil diubah.');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->route('pengalaman.index')->with('fail', 'Pengalaman gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(Pengalaman $pengalaman) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($pengalaman->scan_dokumen);
            KualifikasiPengalaman::where('pengalaman_id',$pengalaman->id)->delete();
            $pengalaman->delete();
            return redirect()->route('pengalaman.index')->with('success', 'Pengalaman berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Pengalaman gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

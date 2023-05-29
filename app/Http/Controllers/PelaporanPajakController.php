<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelaporanPajak;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;
use Auth;

class PelaporanPajakController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = PelaporanPajak::where('user_id', Auth::user()->id)->select('*')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('pelaporan-pajak.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('pelaporan-pajak.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('pelaporan-pajak.show',$row->id).'"><span class="ti ti-search"></span></a>
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
        return view('pelaporan-pajak/index');
    }

    public function create() {
        return view('pelaporan-pajak/create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'jenis_pelaporan'        => 'required',
            'masa_tahun_pajak' => 'required',
            'nomor_bukti_surat'           => 'required',
            'tanggal_bukti_surat'           => 'required',
            'scan_dokumen'               => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'jenis_pelaporan.required'          => 'Jenis Pelaporan harus dipilih.',
            'masa_tahun_pajak.required'   => 'Masa Tahun Pajak harus diisi.',
            'nomor_bukti_surat.required'             => 'Nomor Bukti Surat harus diisi.',
            'tanggal_bukti_surat.required'             => 'Tanggal Bukti Surat harus diisi.',
            'scan_dokumen.required'             => 'Scan dokumen harus diisi.',
            'scan_dokumen.mimes'             => 'Scan dokumen harus berupa jpg,png,bmp,pdf.',
            'scan_dokumen.max'             => 'Scan dokumen maksimal 10MB.',
        ]);
        
        $validatedData['keterangan']    = $request->keterangan;
        $validatedData['user_id']       = Auth::user()->id;
        
        try {
            if ($request->hasFile('scan_dokumen')) { 

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pelaporan-pajak/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                PelaporanPajak::create($validatedData);
                return back()->with('success', 'Pelaporan Pajak berhasil disimpan.');
            } else{
                return back()->with('fail', 'Pelaporan Pajak gagal disimpan. Gagal Upload File.')->withInput();
            }
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Pelaporan Pajak gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(PelaporanPajak $pelaporan_pajak)
    {
        return view('pelaporan-pajak.show',compact('pelaporan_pajak'));
    }

    public function edit(PelaporanPajak $pelaporan_pajak)
    {
        // Check if data is owned by user login
        if($pelaporan_pajak->user_id != Auth::user()->id) return redirect()->route('pelaporan-pajak.index');
        return view('pelaporan-pajak.edit',compact('pelaporan_pajak'));
    }

    public function update(Request $request, PelaporanPajak $pelaporan_pajak) {
        $validatedData = $request->validate([
            'jenis_pelaporan'        => 'required',
            'masa_tahun_pajak' => 'required',
            'nomor_bukti_surat'           => 'required',
            'tanggal_bukti_surat'           => 'required',
        ],[
            'jenis_pelaporan.required'          => 'Jenis Pelaporan harus dipilih.',
            'masa_tahun_pajak.required'   => 'Masa Tahun Pajak harus diisi.',
            'nomor_bukti_surat.required'             => 'Nomor Bukti Surat harus diisi.',
            'tanggal_bukti_surat.required'             => 'Tanggal Bukti Surat harus diisi.',
        ]);
        
        $validatedData['keterangan']    = $request->keterangan;
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
                Storage::disk('s3')->delete($pelaporan_pajak->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'pelaporan-pajak/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 
            $pelaporan_pajak->fill($validatedData)->save();

            return redirect()->route('pelaporan-pajak.index')->with('success', 'Pelaporan Pajak berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('pelaporan-pajak.index')->with('fail', 'Pelaporan Pajak gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(PelaporanPajak $pelaporan_pajak) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($pelaporan_pajak->scan_dokumen);
            $pelaporan_pajak->delete();
            return redirect()->route('pelaporan-pajak.index')->with('success', 'Pelaporan Pajak berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Pelaporan Pajak gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

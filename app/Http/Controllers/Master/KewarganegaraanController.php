<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Kewarganegaraan;
use DataTables;
use Auth;
use Carbon\Carbon;

class KewarganegaraanController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Kewarganegaraan::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('master-bank.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('master-bank.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
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
        return view('admin.master.kewarganegaraan.index');
    }

    public function create() {
        $bank = Bank::all();
        return view('rekening-bank/create', compact('bank'));
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'bank_id'        => 'required',
            'nomor_rekening' => 'required',
            'nama'           => 'required',
            'scan_dokumen'               => 'required|mimes:jpg,png,bmp,pdf|max:10000',
        ],[
            'bank_id.required'          => 'Bank harus dipilih.',
            'nomor_rekening.required'   => 'Nomor Rekening harus diisi.',
            'nama.required'             => 'Nama harus diisi.',
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
                $filePath = 'rekening-bank/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;

                RekeningBank::create($validatedData);
                return back()->with('success', 'Rekening Bank berhasil disimpan.');
            } else{
                return back()->with('fail', 'Rekening Bank gagal disimpan. Gagal Upload File.')->withInput();
            }
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Rekening Bank gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(RekeningBank $rekening_bank)
    {
        return view('rekening-bank.show',compact('rekening_bank'));
    }

    public function edit(RekeningBank $rekening_bank)
    {
        // Check if data is owned by user login
        if($rekening_bank->user_id != Auth::user()->id) return redirect()->route('rekening_bank.index');
        $bank = Bank::all();
        return view('rekening-bank.edit',compact('rekening_bank','bank'));
    }

    public function update(Request $request, RekeningBank $rekening_bank) {
        $validatedData = $request->validate([
            'bank_id'        => 'required',
            'nomor_rekening' => 'required',
            'nama'           => 'required',
        ],[
            'bank_id.required'          => 'Bank harus dipilih.',
            'nomor_rekening.required'   => 'Nomor Rekening harus diisi.',
            'nama.required'             => 'Nama harus diisi.',
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
                Storage::disk('s3')->delete($rekening_bank->scan_dokumen);

                $file = $request->file('scan_dokumen');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'rekening-bank/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $validatedData['scan_dokumen']  = $filePath;                
            } 
            $rekening_bank->fill($validatedData)->save();

            return redirect()->route('rekening-bank.index')->with('success', 'Rekening Bank berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('rekening-bank.index')->with('fail', 'Rekening Bank gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(RekeningBank $rekening_bank) {
        // Delete file di storage cloud
        // script here
        try {
            Storage::disk('s3')->delete($rekening_bank->scan_dokumen);
            $rekening_bank->delete();
            return redirect()->route('rekening-bank.index')->with('success', 'Rekening Bank berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Rekening Bank gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

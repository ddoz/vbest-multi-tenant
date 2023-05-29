<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabaRugi;
use DataTables;
use Auth;
use Carbon\Carbon;

class LabaRugiController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = LabaRugi::where("user_id",Auth::user()->id)->select('*')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('laba-rugi.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('laba-rugi.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('laba-rugi.show',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('laba-rugi/index');
    }

    public function create() {
        return view('laba-rugi/create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'tahun'                 => 'required',
            'pendapatan'            => 'required',
            'laba_kotor'            => 'required',
            'laba_bersih'           => 'required',
        ],[
            'tahun.required'        => 'Tahun harus dipilih.',
            'pendapatan.required'   => 'Pendapatan harus diisi.',
            'laba_kotor.required'   => 'Laba Kotor harus diisi.',
            'laba_bersih.required'   => 'Laba Bersih harus diisi.',
        ]);
        
        $validatedData['user_id']       = Auth::user()->id;
        
        try {            
            LabaRugi::create($validatedData);
            return back()->with('success', 'Laporan Laba Rugi berhasil disimpan.');            
        } catch(\Exception $e) {
            return back()->with('fail', 'Laporan Laba Rugi gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(LabaRugi $laba_rugi)
    {
        return view('laba-rugi.show',compact('laba_rugi'));
    }

    public function edit(LabaRugi $laba_rugi)
    {
        // Check if data is owned by user login
        if($laba_rugi->user_id != Auth::user()->id) return redirect()->route('laba_rugi.index');        
        return view('laba-rugi.edit',compact('laba_rugi'));
    }

    public function update(Request $request, LabaRugi $laba_rugi) {
        $validatedData = $request->validate([
            'tahun'                 => 'required',
            'pendapatan'            => 'required',
            'laba_kotor'            => 'required',
            'laba_bersih'           => 'required',
        ],[
            'tahun.required'        => 'Tahun harus dipilih.',
            'pendapatan.required'   => 'Pendapatan harus diisi.',
            'laba_kotor.required'   => 'Laba Kotor harus diisi.',
            'laba_bersih.required'   => 'Laba Bersih harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $laba_rugi->fill($validatedData)->save();

            return redirect()->route('laba-rugi.index')->with('success', 'Laporan Laba Rugi berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('laba-rugi.index')->with('fail', 'Laporan Laba Rugi gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(LabaRugi $laba_rugi) {
        try {
            $laba_rugi->delete();
            return redirect()->route('laba-rugi.index')->with('success', 'Laporan Laba Rugi berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Laporan Laba Rugi gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

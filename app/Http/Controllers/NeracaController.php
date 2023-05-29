<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Neraca;
use Carbon\Carbon;
use DataTables;
use Auth;

class NeracaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Neraca::where('user_id', Auth::user()->id)->select('*')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row"><form onsubmit="return confirm(\'Hapus Data?\')" class="formDelete" action="'.route('neraca.destroy',$row->id).'" method="POST">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="ti ti-trash"></span></button>
                                <a class="btn btn-primary btn-sm" href="'.route('neraca.edit',$row->id).'"><span class="ti ti-pencil"></span></a>
                                <a class="btn btn-success btn-sm" href="'.route('neraca.show',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE" autocomplete="off">
                            </form></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('neraca/index');
    }

    public function create() {
        return view('neraca/create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'tahun'                 => 'required',
            'aset'            => 'required',
            'kewajiban'            => 'required',
            'modal'           => 'required',
        ],[
            'tahun.required'        => 'Tahun harus dipilih.',
            'aset.required'   => 'Aset harus diisi.',
            'kewajiban.required'   => 'Kewajiban harus diisi.',
            'modal.required'   => 'Modal harus diisi.',
        ]);
        
        $validatedData['user_id']       = Auth::user()->id;
        
        try {            
            Neraca::create($validatedData);
            return back()->with('success', 'Laporan Neraca berhasil disimpan.');            
        } catch(\Exception $e) {
            return back()->with('fail', 'Laporan Neraca gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Neraca $neraca)
    {
        return view('neraca.show',compact('neraca'));
    }

    public function edit(Neraca $neraca)
    {
        // Check if data is owned by user login
        if($neraca->user_id != Auth::user()->id) return redirect()->route('neraca.index');        
        return view('neraca.edit',compact('neraca'));
    }

    public function update(Request $request, Neraca $neraca) {
        $validatedData = $request->validate([
            'tahun'                 => 'required',
            'aset'            => 'required',
            'kewajiban'            => 'required',
            'modal'           => 'required',
        ],[
            'tahun.required'        => 'Tahun harus dipilih.',
            'aset.required'   => 'Aset harus diisi.',
            'kewajiban.required'   => 'Kewajiban harus diisi.',
            'modal.required'   => 'Modal harus diisi.',
        ]);
        
        try {
            $validatedData['updated_at'] = Carbon::now();
            
            $neraca->fill($validatedData)->save();

            return redirect()->route('neraca.index')->with('success', 'Laporan Neraca berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('neraca.index')->with('fail', 'Laporan Neraca gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy(Neraca $neraca) {
        try {
            $neraca->delete();
            return redirect()->route('neraca.index')->with('success', 'Laporan Neraca berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Laporan Neraca gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

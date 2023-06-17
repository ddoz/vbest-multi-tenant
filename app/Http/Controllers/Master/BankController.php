<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\RekeningBank;
use DataTables;
use Auth;
use Carbon\Carbon;

class BankController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Bank::get();
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
        return view('admin.master.bank.index');
    }

    public function create() {
        return view('admin.master.bank.create');
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama_bank'             => 'required',
        ],[
            'nama_bank.required'    => 'Bank harus diisi.',
        ]);
        
        try {
           
            Bank::create($validatedData);
            return back()->with('success', 'Bank berhasil disimpan.');          
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Bank gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function show(Bank $bank)
    {
        return view('admin.master.bank.show',compact('bank'));
    }

    public function edit($bank)
    {   
        $bank = Bank::find($bank);
        return view('admin.master.bank.edit',compact('bank'));
    }

    public function update(Request $request, $bank) {
        $validatedData = $request->validate([
            'bank_id'        => 'required',
            'nama_bank'      => 'required',
        ],[
            'bank_id.required'          => 'Bank harus dipilih.',
            'nama_bank.required'        => 'Nama Bank harus diisi.',
        ]);        

        try {
            $validatedData['updated_at'] = Carbon::now();
            $bank = Bank::find($bank);
            $bank->fill($validatedData)->save();

            return redirect()->route('master-bank.index')->with('success', 'Bank berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('master-bank.index')->with('fail', 'Bank gagal diubah. ' . $e->getMessage())->withInput();
        }

    }

    public function destroy($bank) {
        try {
            $rekening = RekeningBank::where('bank_id',$bank);
            if($rekening->exists()) { return back()->with('fail', 'Bank gagal dihapus. Karena Terdapat Pada Rekening Bank')->withInput(); }
            $bank = Bank::find($bank);
            $bank->delete();
            return redirect()->route('master-bank.index')->with('success', 'Bank berhasil dihapus.');

        } catch(Exception $e) {
            return back()->with('fail', 'Bank gagal dihapus. ' . $e->getMessage())->withInput();
        }
    }
}

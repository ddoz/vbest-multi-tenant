<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdentitasVendor;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Carbon\Carbon;
use Auth;

class IdentitasController extends Controller
{ 
    public function index() {
        $identitas  = IdentitasVendor::where('user_id',Auth::user()->id)->first();
        $provinsi   = Provinsi::all();
        $kabupaten  = Kabupaten::find($identitas->kabupaten_id);
        $kecamatan  = Kecamatan::find($identitas->kecamatan_id);
        $kelurahan  = Kelurahan::find($identitas->kelurahan_id);
        return view('identitas/index', compact('identitas','provinsi','kabupaten','kecamatan','kelurahan'));
    }

    public function update(Request $request, IdentitasVendor $identita) {
        $validatedData = $request->validate([
                'name' => 'required',                
                'bentuk_usaha' => 'required',
                'npwp' => 'required',
                'status_usaha' => 'required',
                'jenis_usaha' => 'required',
                'produk_usaha' => 'required',
                'total_modal_usaha' => 'required',
                'alamat_usaha' => 'required',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'kode_pos' => 'required',
                'no_telp' => 'required',
                'fax' => 'required',
                'nama_pic' => 'required',
                'telp_pic' => 'required',
                'alamat_pic' => 'required',
            ],[
                'name.required'                 => 'Nama harus diisi.',
                'bentuk_usaha'                  => 'Bentuk Usaha harus dipilih.',
                'npwp.required'                 => 'NPWP harus diisi.',
                'status_usaha.required'         => 'Status Usaha harus dipilih.',
                'jenis_usaha.required'          => 'Jenis Usaha harus dipilih.',
                'produk_usaha.required'         => 'Produk Usaha harus diisi.',
                'total_modal_usaha.required'    => 'Total Modal Usaha harus dipilih.',
                'alamat_usaha.required'         => 'Alamat Usaha harus diisi.',
                'provinsi_id.required'          => 'Provinsi harus dipilih.',
                'kabupaten_id.required'         => 'Kabupaten harus dipilih.',
                'kecamatan_id.required'         => 'Kecamatan harus dipilih.',
                'kelurahan_id.required'         => 'Kelurahan harus dipilih.',
                'kode_pos.required'             => 'Kode Pos harus diisi.',
                'no_telp.required'              => 'No Telpon harus diisi.',
                'fax.required'                  => 'Fax harus diisi.',
                'nama_pic.required'             => 'Nama PIC harus diisi.',
                'telp_pic.required'             => 'No Telpon PIC harus diisi.',
                'alamat_pic.required'           => 'Alamat PIC harus diisi.',
            ]
        );

        try {
            $validatedData['updated_at']    = Carbon::now();
            $validatedData['jenis_usaha']   = json_encode($request->jenis_usaha);
            $identita->fill($validatedData)->save();

            $user = User::find($identita->id);
            $user->name = $request->name;
            $user->save();

            return redirect()->route('identitas.index')->with('success', 'Identitas berhasil diubah.');
        } catch(\Exception $e) {
            return redirect()->route('identitas.index')->with('fail', 'Identitas gagal diubah. ' . $e->getMessage())->withInput();
        }

    }
}

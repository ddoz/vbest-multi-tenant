<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\User;
use App\Models\IdentitasVendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Auth;
use Hash;

class HomesController extends Controller
{
    
    // AUTH ROUTES HANDLER
    public function index() {
        if(true) {
            if(Auth::user()->role == "ADMIN") {
                return view('home/admin');
            }else {
                return view('home/index');
            }
        }else {
            return view('auth/login');
        }
    }

    public function registration() {
        $provinsi = Provinsi::all();
        return view('auth/register', compact('provinsi'));
    }
    // END AUTH ROUTES HANDLER

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'bentuk_usaha' => 'required',
                'npwp' => 'required|numeric',
                'status_usaha' => 'required',
                'jenis_usaha' => 'required',
                'produk_usaha' => 'required',
                'total_modal_usaha' => 'required',
                'alamat_usaha' => 'required',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'kode_pos' => 'required|numeric',
                'no_telp' => 'required|numeric',
                'fax' => 'required|numeric',
                'nama_pic' => 'required',
                'telp_pic' => 'required|numeric',
                'alamat_pic' => 'required|email',
            ],[
                'name.required'                 => 'Nama harus diisi.',
                'email.required'                => 'Email harus diisi.',
                'email.email'                   => 'Email harus dalam bentuk format email.',
                'email.unique'                  => 'Email sudah ada dalam database. Gunakan email lainnya.',
                'password.required'             => 'Password harus diisi.',
                'password.min'                  => 'Password minimal 6 karakter.',
                'bentuk_usaha'                  => 'Bentuk Usaha harus dipilih.',
                'npwp.required'                 => 'NPWP harus diisi.',
                'npwp.numeric'                  => 'NPWP harus format numeric.',
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
                'kode_pos.numeric'              => 'Kode Pos harus format numeric.',
                'no_telp.required'              => 'No Telpon harus diisi.',
                'no_telp.numeric'               => 'No Telpon harus format numeric.',
                'fax.required'                  => 'Fax harus diisi.',
                'fax.numeric'                   => 'Fax harus format numeric.',
                'nama_pic.required'             => 'Nama PIC harus diisi.',
                'telp_pic.required'             => 'No Telpon PIC harus diisi.',
                'telp_pic.numeric'              => 'No Telpon PIC harus format numeric.',
                'alamat_pic.required'           => 'Alamat Email PIC harus diisi.',
                'alamat_pic.email'              => 'Alamat Email PIC harus format email.',
            ]
        );
           
        DB::beginTransaction();

        try {

            $data = $request->only('name','email','password');
            $user = $this->create($data);

            $userId = $user->id;

            // insert identitas
            IdentitasVendor::create([
                'bentuk_usaha'         => $request->bentuk_usaha,
                'nama_usaha'           => $request->name,
                'npwp'                 => $request->npwp,
                'status_usaha'         => $request->status_usaha,
                'jenis_usaha'          => json_encode($request->jenis_usaha),
                'produk_usaha'         => $request->produk_usaha,
                'total_modal_usaha'    => $request->total_modal_usaha,
                'alamat_usaha'         => $request->alamat_usaha,
                'provinsi_id'          => $request->provinsi_id,
                'kabupaten_id'         => $request->kabupaten_id,
                'kecamatan_id'         => $request->kecamatan_id,
                'kelurahan_id'         => $request->kelurahan_id,
                'kode_pos'             => $request->kode_pos,
                'no_telp'              => $request->no_telp,
                'fax'                  => $request->fax,
                'nama_pic'             => $request->fax,
                'telp_pic'             => $request->telp_pic,
                'alamat_pic'           => $request->alamat_pic,                
                'user_id'              => $userId,                
            ]);

            DB::commit();

            event(new Registered($user));
         
            return redirect()->route('login')->with('success','Registrasi Berhasil. Silahkan Periksa Email anda, untuk melakukan verifikasi akun.');

        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Registrasi Gagal. ' . $e->getMessage())->withInput();
        }


    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'email_verified_at' => date("Y-m-d H:i:s") //bypass dulu
      ]);
    }
}

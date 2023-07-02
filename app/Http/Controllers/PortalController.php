<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\Config;
use Hyn\Tenancy\Facades\TenancyFacade;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Jobs\RegisterUserJob;

use DB;

class PortalController extends Controller
{
    
    public function index() {
        return view("portal.index");
    }

    public function register(Request $request) {
        
        $request->validate([
            "email"                 => 'required|email|unique:users',
            "nama"                  => 'required',
            "password"              => 'required:min:6',
            "domain"                => 'required|unique:users',
            "perusahaan"            => 'required',
        ],[
            "email.unique"          => "Email sudah pernah digunakan. Silahkan gunakan email lainnya.",
            "domain.unique"         => "Domain tidak tersedia. Silahkan gunakan domain lainnya.",
            "email.required"        => "Email harus diisi.",
            "email.email"           => "Email harus dalam format email dan aktif.",
            "nama.required"         => "Nama harus diisi.",
            "domain.required"       => "Domain harus diisi.",
            "perusahaan.required"   => 'Perusahaan harus diisi.',
            "password.required"     => 'Password harus diisi.',
            "password.min"          => 'Password minimal 6 karakter.',
        ]);

        try {
            
            //check domain
            // $tenant = Tenant::where('id',$request->input('domain'));
            // if($tenant->exists()) {
            //     return response()->json(['status'=>'fail','message'=>'Domain Tidak Tersedia. Coba dengan Domain Lainnya.']);
            // }
            $arrData = [
                'name' => $request->input('nama'),
                'email' => $request->input('email'),
                'domain' => $request->input('domain'),
                'tenant_id' => $request->input('domain'),
                'password' => Hash::make($request->input('password'))];
            RegisterUserJob::dispatch($arrData);
            
            return back()->with('success', 'Registrasi Berhasil. Kami Akan memberitahu melalui Email Jika Proses Sudah Selesai. Terima Kasih Sudah Mendaftar.');            
        }catch(\Exception $e) {
            return back()->with('fail', 'Registrasi gagal disimpan. ' . $e->getMessage())->withInput();
        }
    }

    protected function sendEmailVerificationNotification($user, $verificationUrl)
    {
        $user->sendEmailVerificationNotification($verificationUrl);
    }
}

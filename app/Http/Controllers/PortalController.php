<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\Config;

use DB;

class PortalController extends Controller
{
    
    public function index() {
        return view("portal.index");
    }

    public function register(Request $request) {
        
        $request->validate([
            "email"                 => 'required|email',
            "nama"                  => 'required',
            "password"              => 'required',
            "subdomain"             => 'required',
            "perusahaan"            => 'required',
        ],[
            "email.required"        => "Email harus diisi.",
            "email.email"           => "Email harus dalam format email dan aktif.",
            "nama.required"         => "Nama harus diisi.",
            "subdomain.required"    => "Subdomain harus diisi.",
            "perusahaan.required"   => 'Perusahaan harus diisi.',
        ]);

        try {
            $fqdn = sprintf('%s.%s', $request->subdomain, "vbest.my.id");

            //cek email dan subdomain
            $website = Website::where('email',$request->email);
            if($website->exists()) {
                return response()->json(['msg'=>'Email Sudah Terdaftar.'],422);
            }
            $domain = Hostname::where('fqdn', $fqdn);
            if($domain->exists()) {
                return response()->json(['msg'=>'Domain Tidak Dapat Digunakan.'],422);
            }

            // This will be the complete website name (tenantUser.mysite.com)
            // The website object will save the tenant instance information
            // I recommend to use something random for security reasons
            $website = new Website;
            $website->uuid = "vendorbest_" . Str::random(6);
            $website->email = $request->email;
            $website->name = $request->nama;
            app(WebsiteRepository::class)->create($website);
            // The hostname object will save the tenant hosting information, and will be related to the previous created software.
            $hostname = new Hostname;
            $hostname->fqdn = $fqdn;
            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);

            // // Mendapatkan website (tenant) berdasarkan hostname
            // $hostnames = app(HostnameRepository::class)->findByHostname($fqdn);
            // $websites = $hostnames->website;
            // // Mendapatkan konfigurasi koneksi database tenant
            // $config = $websites->database->getConfiguration();
            DB::connection('tenant')->statement('insert into users (name,email,password,role) values (?, ?, ?, ?)', [$request->nama, $request->email, bcrypt($request->password), "ADMIN"]);

            // Config::set('app.url', $fqdn);
            // $user['email'] = $request->email;
            // $user['name'] = $request->nama;
            // event(new Registered($user));

            return response()->json(['status'=>'success', 'message'=>"Registrasi Berhasil. Silahkan Kunjungi <a href='http://".$fqdn."'>$fqdn</a> kemudian login dan ikuti proses selanjutnya untuk aktivasi."]);
        }catch(\Exception $e) {
            return response()->json(['status'=>'fail','message'=>$e]);
        }
    }
}

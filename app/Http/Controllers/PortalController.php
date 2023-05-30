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
            // This will be the complete website name (tenantUser.mysite.com)
            $fqdn = sprintf('%s.%s', $request->subdomain, "vendorbest.test");
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

            // Mendapatkan website (tenant) berdasarkan hostname
            $hostnames = app(HostnameRepository::class)->findByHostname($fqdn);
            $websites = $hostnames->website;
            // Mendapatkan konfigurasi koneksi database tenant
            // $config = $websites->database->getConfiguration();
            DB::connection('tenant')->statement('insert into users (name,email,password,role) values (?, ?, ?, ?)', [$request->nama, $request->email, bcrypt($request->password), "ADMIN"]);
   
            return back()->with("success","Registrasi Berhasil. Silahkan Kunjungi <a href='http://".$fqdn."'>$fqdn</a> kemudian login dan ikuti proses selanjutnya untuk aktivasi.");
        }catch(\Exception $e) {
            return back()->with("fail","Registrasi Gagal. Pastikan email belum pernah terdaftar sebelumnya.");
        }
    }
}

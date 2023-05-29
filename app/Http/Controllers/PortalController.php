<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;

class PortalController extends Controller
{
    
    public function index() {
        return view("portal.index");
    }

    public function register(Request $request) {
        try {
            // This will be the complete website name (tenantUser.mysite.com)
            $fqdn = sprintf('%s.%s', $request->subdomain, "vendorbest.test");
            // The website object will save the tenant instance information
            // I recommend to use something random for security reasons
            $website = new Website;
            $website->uuid = "vendorbest_" . Str::random(6);
            app(WebsiteRepository::class)->create($website);
            // The hostname object will save the tenant hosting information, and will be related to the previous created software.
            $hostname = new Hostname;
            $hostname->fqdn = $fqdn;
            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);

            // Membuat koneksi database baru untuk tenant yang baru
            $tenantConnection = 'tenant_' . $website->uuid;
            config(["database.connections.$tenantConnection" => [
                'driver' => config('database.default'),
                'host' => config('database.connections.mysql.host'),
                'port' => config('database.connections.mysql.port'),
                'database' => "vendorbest_".$tenant->uuid, // Nama database baru untuk tenant
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
                'charset' => config('database.connections.mysql.charset'),
                'collation' => config('database.connections.mysql.collation'),
                'prefix' => '',
                'strict' => false,
                'engine' => null,
            ]]);
   
            return back()->with("success","Registrasi Berhasil. Silahkan Periksa Email anda untuk proses aktivasi.");
        }catch(\Exception $e) {
            dd($e);
        }
    }
}

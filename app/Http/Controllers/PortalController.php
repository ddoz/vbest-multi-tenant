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
            // Membuat website tenant baru
            // $website = new Website;
            // $website->uuid = "vendorbest_" . Str::random(6);
            // $website->email = $request->email;
            // $website->name = $request->nama;
            // $website->managed_by_database_connection = 'tenant';
            // $website->save();

            // // Membuat hostname baru untuk website tenant
            // $hostname = new Hostname;
            // $hostname->fqdn = $request->input('subdomain') . '.' . 'vendorbest.test';
            // $hostname->website_id = $website->id;
            // $hostname->save();

            // // Menyimpan tenant_id yang akan digunakan untuk koneksi tenant
            // $tenantId = $website->id;

            // // Beralih ke koneksi tenant yang baru dibuat
            // TenancyFacade::hostname($hostname);           

            // Membuat pengguna baru pada tenant
            $user = new User;
            $user->name = $request->input('nama');
            $user->email = $request->input('email');
            $user->domain = $request->input('subdomain');
            $user->tenant_id = $request->input('subdomain');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $userTenant = Tenant::create(['id' => $user->domain]);
            $userTenant->domains()->create(['domain' => $user->domain . "." . env("APP_DOMAIN")]);
            $userTenant->run(function () use ($user) {
                $fqdn = sprintf('%s.%s', $user->domain, "vbest.my.id");
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'domain' => $user->domain                   
                ]);
                
                $verificationUrl = $fqdn . '/email/verify';
                // Modify the verification URL
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    [
                        'id' => $user->id,
                        'hash' => sha1($user->email),
                    ]
                );
                $verificationUrl = str_replace('vendorbest.test', $user->domain . '.vendorbest.test', $verificationUrl);

                // Set the modified URL on the user object
                // $user->email_verification_url = $verificationUrl;
                // $user->save();

                // Trigger the Registered event with the modified user object
                // Event::dispatch(new Registered($user));
            });

            // // Menjalankan migrasi pada skema tenant
            // Artisan::call('tenancy:migrate', [
            //     '--website_id' => $website->id,
            // ]);

            // // Kembali ke koneksi landlord (skema utama)
            // TenancyFacade::hostname(null);
            

            // //cek email dan subdomain
            // $website = Website::where('email',$request->email);
            // if($website->exists()) {
            //     return response()->json(['msg'=>'Email Sudah Terdaftar.'],422);
            // }
            // $domain = Hostname::where('fqdn', $fqdn);
            // if($domain->exists()) {
            //     return response()->json(['msg'=>'Domain Tidak Dapat Digunakan.'],422);
            // }

            // // This will be the complete website name (tenantUser.mysite.com)
            // // The website object will save the tenant instance information
            // // I recommend to use something random for security reasons
            // $website = new Website;
            // $website->uuid = "vendorbest_" . Str::random(6);
            // $website->email = $request->email;
            // $website->name = $request->nama;
            // app(WebsiteRepository::class)->create($website);
            // // The hostname object will save the tenant hosting information, and will be related to the previous created software.
            // $hostname = new Hostname;
            // $hostname->fqdn = $fqdn;
            // $hostname = app(HostnameRepository::class)->create($hostname);
            // app(HostnameRepository::class)->attach($hostname, $website);

            // // // Mendapatkan website (tenant) berdasarkan hostname
            // // $hostnames = app(HostnameRepository::class)->findByHostname($fqdn);
            // // $websites = $hostnames->website;
            // // // Mendapatkan konfigurasi koneksi database tenant
            // // $config = $websites->database->getConfiguration();
            // DB::connection('tenant')->statement('insert into users (name,email,password,role) values (?, ?, ?, ?)', [$request->nama, $request->email, bcrypt($request->password), "ADMIN"]);

            // Config::set('app.url', $fqdn);
            // $user['email'] = $request->email;
            // $user['name'] = $request->nama;
            // event(new Registered($user));
            $fqdn = sprintf('%s.%s', $user->domain, "vbest.my.id");
            
            return response()->json(['status'=>'success', 'message'=>"Registrasi Berhasil. Silahkan Kunjungi <a href='http://".$fqdn."'>$fqdn</a> kemudian login dan ikuti proses selanjutnya untuk aktivasi."]);
        }catch(\Exception $e) {
            dump($e);
            return response()->json(['status'=>'fail','message'=>$e]);
        }
    }

    protected function sendEmailVerificationNotification($user, $verificationUrl)
    {
        $user->sendEmailVerificationNotification($verificationUrl);
    }
}

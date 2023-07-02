<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Hyn\Tenancy\Facades\TenancyFacade;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegistrationEmail;

class RegisterUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $request = $this->data;
        // TENANCY PROCESS
        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->domain = $request['domain'];
        $user->tenant_id = $request['tenant_id'];
        $user->password = Hash::make($request['password']);
        $user->save();

        $userTenant = Tenant::create(['id' => $user->domain]);
        $userTenant->domains()->create(['domain' => $user->domain . ".vbest.my.id"]);
        $userTenant->run(function () use ($user) {
            $fqdn = sprintf('%s.%s', $user->domain, "vbest.my.id");
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'domain' => $user->domain                   
            ]);
            
        });
        $fqdn = sprintf('%s.%s', $user->domain, "vbest.my.id");
        $verificationUrl = "http://". $fqdn . "/email/verify/" . $user->id . "/" . sha1($user->email);
        $data = [
            'domain' => $fqdn, // Ganti dengan domain yang telah didaftarkan
            'verificationUrl' => $verificationUrl//route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)])
        ];
    
        Mail::to($user->email)->send(new RegistrationEmail($data));
        
    }
}

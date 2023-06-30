<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'domain',
        'tenant_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function identitas_vendor() {
        return $this->hasOne("App\Models\IdentitasVendor");
    }

    // public static function booted() {
    //     static::created(function($user){
    //         $userTenant = Tenant::create(['id' => $user->domain]);
    //         $userTenant->domains()->create(['domain' => $user->domain . "." . env("APP_DOMAIN")]);
    //         $userTenant->run(function () use ($user) {
    //             $user = User::create([
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'password' => $user->password,
    //                 'domain' => $user->domain                   
    //             ]);
    //             event(new Registered($user));
    //         });
            
    //     });
    // }

}

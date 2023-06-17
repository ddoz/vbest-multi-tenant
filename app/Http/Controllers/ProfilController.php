<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = User::find(Auth::user()->id);
        if(Auth::user()->role=='ADMIN') {
            return view("profil.admin", compact('profil'));
        }
        if(Auth::user()->role=='VENDOR') {
            return view("profil.vendor", compact('profil'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ],[
            'name.required' => 'Nama Tidak Boleh Kosong'
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();
        return back()->with('success', 'Profil berhasil disimpan.');
    }

    public function password(Request $request) {
        $request->validate([
            'old' => 'required',
            'new' => 'required|min:6',
        ],[
            'old.required' => 'Password Lama Tidak Boleh Kosong',
            'new.required' => 'Password Baru Tidak Boleh Kosong',
            'new.min' => 'Password Baru Tidak Boleh Kurang dari 6',
        ]);

        $user = User::find(Auth::user()->id);

        if(password_verify($request->old,$user->password)) {
            $user->password = Hash::make($request->new);
            $user->save();
        }else {
            return back()->with('fail', 'Password Lama Tidak Sesuai.');
        }        
        return back()->with('success', 'Profil berhasil disimpan.');
    }
}

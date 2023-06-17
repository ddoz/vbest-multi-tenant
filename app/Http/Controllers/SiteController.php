<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuManager;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use Auth;


class SiteController extends Controller
{
    public function index(Request $request) {
        $menu = MenuManager::all();
        return view('admin.pengaturan.index', compact('menu'));
    }

    public function site(Request $request) {
        $site = SiteSetting::find(1);
        return view('admin.pengaturan.site', compact('site'));
    }

    public function storeSite(Request $request) {            
        try {
            $backgroundLogin = "";
            $logo = "";
            if($request->hasFile('background_login')) {
                $validatedData = $request->validate([                   
                    'background_login'               => 'mimes:jpg,png|max:10000',
                ],[
                    'background_login.mimes'             => 'Gambar harus berupa jpg,png.',
                    'background_login.max'             => 'Gambar maksimal 10MB.',    
                ]);
                $file = $request->file('background_login');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'background/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $backgroundLogin  = $filePath;
            }
            if($request->hasFile('logo')) {
                $validatedData = $request->validate([                   
                    'logo'               => 'mimes:jpg,png|max:10000',
                ],[
                    'logo.mimes'             => 'Gambar harus berupa jpg,png.',
                    'logo.max'             => 'Gambar maksimal 10MB.',    
                ]);
                $file = $request->file('logo');
                $extension  = $file->getClientOriginalExtension(); 
                $name = time() .'_' . Str::random(8) . '.' . $extension;
                $filePath = 'logo/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->setVisibility($filePath, "public"); 
                $logo  = $filePath;
            }
            $site = SiteSetting::find(1);
            if($site) {
                $site->nama_perusahaan = $request->nama_perusahaan;
                $site->alamat_lengkap = $request->alamat_lengkap;
                if($backgroundLogin!="") {
                    $site->background_login = $backgroundLogin;
                }
                if($logo!="") {
                    $site->logo = $logo;
                }
                $site->save();
            }else {
                $save = array(
                    "nama_perusahaan" => $request->nama_perusahaan,
                    "alamat_lengkap"  => $request->alamat_lengkap,
                    "background_login" => $backgroundLogin,
                    "logo" => $logo,
                );
                SiteSetting::create($save);
            }
            return back()->with('success', 'Site berhasil disimpan.');
            
        } catch(\Exception $e) {
            return back()->with('fail', 'Site gagal disimpan. ' . $e->getMessage())->withInput();
        }

    }

    public function changeMenu(Request $request) {
        $id = $request->id;
        $tipe = $request->tipe;
        $menu = MenuManager::find($id);
        if($tipe=='required'){
            $menu->is_required = !$request->is_required;
            $menu->save();
        }
        if($tipe=='hide'){
            $menu->hide = !$request->hide;
            $menu->save();
        }

        return redirect()->back()->with('success','Menu Berhasil Di Setting.');
    }
}

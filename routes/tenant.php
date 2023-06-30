<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('login');

    Auth::routes();

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    // Email Verification Route
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // App Routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [App\Http\Controllers\HomesController::class, 'index'])->name('home');
        Route::get('/home', [App\Http\Controllers\HomesController::class, 'index'])->name('home');
        Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil');
        Route::post('/profil/update', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
        Route::post('/profil/password', [App\Http\Controllers\ProfilController::class, 'password'])->name('profil.password');
        

        Route::middleware(['vendorAccess'])->group(function () {
            Route::resource('/identitas', 'App\Http\Controllers\IdentitasController');
            Route::resource('/akta', 'App\Http\Controllers\AktaController');
            Route::resource('/izin', 'App\Http\Controllers\IzinController');
            Route::resource('/pemilik', 'App\Http\Controllers\PemilikController');
            Route::resource('/pengurus', 'App\Http\Controllers\PengurusController');
            Route::resource('/tenaga-ahli', 'App\Http\Controllers\TenagaAhliController');
            Route::resource('/sertifikasi', 'App\Http\Controllers\SertifikasiController');
            Route::resource('/pengalaman', 'App\Http\Controllers\PengalamanController');
            Route::resource('/rekening-bank', 'App\Http\Controllers\RekeningBankController');
            Route::resource('/pelaporan-pajak', 'App\Http\Controllers\PelaporanPajakController');
            Route::resource('/laba-rugi', 'App\Http\Controllers\LabaRugiController');
            Route::resource('/neraca', 'App\Http\Controllers\NeracaController');
        });


        Route::middleware(['adminAccess'])->group(function () {
            Route::resource('pengaturan', "App\Http\Controllers\SiteController");
            Route::post('/pengaturan-menu/change', [App\Http\Controllers\SiteController::class, "changeMenu"])->name('pengaturan-menu.change');
            Route::get('/pengaturan-site', [App\Http\Controllers\SiteController::class, "site"])->name('pengaturan-site.index');
            Route::post('/pengaturan-site/store', [App\Http\Controllers\SiteController::class, "storeSite"])->name('pengaturan-site.store');

            Route::resource('master', "App\Http\Controllers\MasterController");
            Route::resource('master-bank', 'App\Http\Controllers\Master\BankController');
            Route::resource('master-jenis-izin', 'App\Http\Controllers\Master\JenisIzinController');
            Route::resource('master-jenis-kepemilikan', 'App\Http\Controllers\Master\JenisKepemilikanController');
            Route::resource('master-jenis-kepengurusan', 'App\Http\Controllers\Master\JenisKepengurusanController');
            Route::resource('master-jenis-tenaga-ahli', "App\Http\Controllers\Master\JenisTenagaAhliController");
            Route::resource('master-kewarganegaraan', "App\Http\Controllers\Master\KewarganegaraanController");
            Route::resource('master-klasifikasi-bidang', "App\Http\Controllers\Master\KlasifikasiBidangController");
            Route::resource('master-wilayah', "App\Http\Controllers\Master\WilayahController");
            Route::resource('master-kategori-pekerjaan', "App\Http\Controllers\Master\KategoriPekerjaanController");

            Route::get('/verifikasi', [App\Http\Controllers\VerifikasiController::class, 'index'])->name('verifikasi');
            Route::get('/verifikasi/for/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'vendor'])->name('verifikasi.for');
            
            Route::get('/verifikasi/identitas/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'identitas'])->name('verifikasi.identitas');
            Route::post('/identitas/state/{identitas}', [App\Http\Controllers\VerifIdentitasController::class, 'state'])->name('identitas.state');
            
            Route::get('/verifikasi/akta/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'akta'])->name('verifikasi.akta');
            Route::get('/verifikasi/akta/form/{vendor}/{akta}', [App\Http\Controllers\VerifAktaController::class, 'formAkta'])->name('verifikasi.formakta');
            Route::post('/akta/state/{akta}', [App\Http\Controllers\VerifAktaController::class, 'state'])->name('akta.state');
            
            Route::get('/verifikasi/izin/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'izin'])->name('verifikasi.izin');
            Route::get('/verifikasi/izin/form/{vendor}/{izin}', [App\Http\Controllers\VerifIzinController::class, 'index'])->name('verifikasi.formizin');
            Route::post('/izin/state/{izin}', [App\Http\Controllers\VerifIzinController::class, 'state'])->name('izin.state');
            
            Route::get('/verifikasi/pemilik/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'pemilik'])->name('verifikasi.pemilik');
            Route::get('/verifikasi/pemilik/form/{vendor}/{pemilik}', [App\Http\Controllers\VerifPemilikController::class, 'index'])->name('verifikasi.formpemilik');
            Route::post('/pemilik/state/{pemilik}', [App\Http\Controllers\VerifPemilikController::class, 'state'])->name('pemilik.state');

            Route::get('/verifikasi/pengurus/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'pengurus'])->name('verifikasi.pengurus');
            Route::get('/verifikasi/pengurus/form/{vendor}/{pengurus}', [App\Http\Controllers\VerifPengurusController::class, 'index'])->name('verifikasi.formpengurus');
            Route::post('/pengurus/state/{pengurus}', [App\Http\Controllers\VerifPengurusController::class, 'state'])->name('pengurus.state');

            Route::get('/verifikasi/tenaga-ahli/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'tenagaAhli'])->name('verifikasi.tenaga-ahli');
            Route::get('/verifikasi/tenaga-ahli/form/{vendor}/{tenaga_ahli}', [App\Http\Controllers\VerifTenagaAhliController::class, 'index'])->name('verifikasi.formtenagaahli');
            Route::post('/tenaga-ahli/state/{tenaga_ahli}', [App\Http\Controllers\VerifTenagaAhliController::class, 'state'])->name('tenaga-ahli.state');

            Route::get('/verifikasi/sertifikasi/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'sertifikasi'])->name('verifikasi.sertifikasi');
            Route::get('/verifikasi/sertifikasi/form/{vendor}/{sertifikasi}', [App\Http\Controllers\VerifSertifikasiController::class, 'index'])->name('verifikasi.formsertifikasi');
            Route::post('/sertifikasi/state/{sertifikasi}', [App\Http\Controllers\VerifSertifikasiController::class, 'state'])->name('sertifikasi.state');

            Route::get('/verifikasi/pengalaman/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'pengalaman'])->name('verifikasi.pengalaman');
            Route::get('/verifikasi/pengalaman/form/{vendor}/{pengalaman}', [App\Http\Controllers\VerifPengalamanController::class, 'index'])->name('verifikasi.formpengalaman');
            Route::post('/pengalaman/state/{pengalaman}', [App\Http\Controllers\VerifPengalamanController::class, 'state'])->name('pengalaman.state');

            Route::get('/verifikasi/rekening-bank/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'rekeningBank'])->name('verifikasi.rekening-bank');
            Route::get('/verifikasi/rekening-bank/form/{vendor}/{rekening_bank}', [App\Http\Controllers\VerifRekeningBankController::class, 'index'])->name('verifikasi.formrekeningbank');
            Route::post('/rekening-bank/state/{rekening_bank}', [App\Http\Controllers\VerifRekeningBankController::class, 'state'])->name('rekening-bank.state');

            Route::get('/verifikasi/pelaporan-pajak/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'pelaporanPajak'])->name('verifikasi.pelaporan-pajak');
            Route::get('/verifikasi/pelaporan-pajak/form/{vendor}/{pelaporan_pajak}', [App\Http\Controllers\VerifPelaporanPajakController::class, 'index'])->name('verifikasi.formpelaporanpajak');
            Route::post('/pelaporan-pajak/state/{pelaporan_pajak}', [App\Http\Controllers\VerifPelaporanPajakController::class, 'state'])->name('pelaporan-pajak.state');

            Route::get('/verifikasi/laba-rugi/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'labaRugi'])->name('verifikasi.laba-rugi');
            Route::get('/verifikasi/laba-rugi/form/{vendor}/{laba_rugi}', [App\Http\Controllers\VerifLabaRugiController::class, 'index'])->name('verifikasi.formlabarugi');
            Route::post('/laba-rugi//state/{laba_rugi}', [App\Http\Controllers\VerifLabaRugiController::class, 'state'])->name('laba-rugi.state');

            Route::get('/verifikasi/neraca/{vendor}', [App\Http\Controllers\VerifikasiController::class, 'neraca'])->name('verifikasi.neraca');
            Route::get('/verifikasi/neraca/form/{vendor}/{neraca}', [App\Http\Controllers\VerifNeracaController::class, 'index'])->name('verifikasi.formneraca');
            Route::post('/neraca/state/{neraca}', [App\Http\Controllers\VerifNeracaController::class, 'state'])->name('neraca.state');
        });

    });

    Route::name('common.')->group(function () {
        Route::get('/common/get-bidang-usaha', [App\Http\Controllers\CommonController::class, 'getBidangUsaha'])->name('get-bidang-usaha');
        Route::get('/common/get-kabupaten', [App\Http\Controllers\CommonController::class, 'getKabupaten'])->name('get-kabupaten');
        Route::get('/common/get-kecamatan', [App\Http\Controllers\CommonController::class, 'getKecamatan'])->name('get-kecamatan');
        Route::get('/common/get-kelurahan', [App\Http\Controllers\CommonController::class, 'getKelurahan'])->name('get-kelurahan');
    });

    Route::get('registration', [App\Http\Controllers\HomesController::class, 'registration'])->name('register');
    Route::post('post-registration', [App\Http\Controllers\HomesController::class, 'postRegistration'])->name('register.post');
});

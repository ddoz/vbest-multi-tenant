<?php

namespace App\Listeners;

use App\Events\LogService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LogChangeAkta;
use App\Models\LogChangeIzin;
use App\Models\LogChangePemilik;
use App\Models\LogChangeIdentitas;
use App\Models\LogChangePengurus;
use App\Models\LogChangeTenagaAhli;
use App\Models\LogChangeSertifikasi;
use App\Models\LogChangePengalaman;
use App\Models\LogChangeRekeningBank;
use App\Models\LogChangeLabaRugi;
use App\Models\LogChangeNeraca;
use App\Models\LogChangePelaporanPajak;
use Illuminate\Support\Str;
use Auth;

class StoreLogHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LogService  $event
     * @return void
     */
    public function handle(LogService $event)
    {
        $arrLog = array();
        $original = $event->original;
        $model = $event->model;
        $tipe = $event->tipe;
        $table = $event->table;
        $id = $event->id;

        foreach($model->getChanges() as $key => $gc) {
            if($key != "updated_at") {
                array_push($arrLog, 
                    array(
                        "col"=>Str::of($key)->snake()->replace('_', ' ')->title(),
                        "old"=>$original->getOriginal($key),
                        "new"=>$gc
                    )
                );
            }
        }
        if($arrLog != null) {
            $insert = [
                "state_change" => json_encode($arrLog),
                "tipe"         => $tipe,
                "user_id"       => Auth::user()->id
            ];
            if($table == "IDENTITAS") {
                $insert["identitas_vendor_id"] = $id;
                LogChangeIdentitas::create($insert);
            }
            if($table == "AKTA") {
                $insert["akta_perusahaan_id"] = $id;
                LogChangeAkta::create($insert);
            }
            if($table == "IZIN") {
                $insert["izin_usaha_id"] = $id;
                LogChangeIzin::create($insert);
            }
            if($table == "PEMILIK") {
                $insert["pemilik_id"] = $id;
                LogChangePemilik::create($insert);
            }
            if($table == "PENGURUS") {
                $insert["pengurus_id"] = $id;
                LogChangePengurus::create($insert);
            }
            if($table == "TENAGAAHLI") {
                $insert["tenaga_ahli_id"] = $id;
                LogChangeTenagaAhli::create($insert);
            }
            if($table == "SERTIFIKASI") {
                $insert["sertifikasi_id"] = $id;
                LogChangeSertifikasi::create($insert);
            }
            if($table == "PENGALAMAN") {
                $insert["pengalaman_id"] = $id;
                LogChangePengalaman::create($insert);
            }
            if($table == "REKENINGBANK") {
                $insert["rekening_bank_id"] = $id;
                LogChangeRekeningBank::create($insert);
            }
            if($table == "LABARUGI") {
                $insert["laba_rugi_id"] = $id;
                LogChangeLabaRugi::create($insert);
            }
            if($table == "NERACA") {
                $insert["neraca_id"] = $id;
                LogChangeNeraca::create($insert);
            }
            if($table == "PELAPORANPAJAK") {
                $insert["pelaporan_pajak_id"] = $id;
                LogChangePelaporanPajak::create($insert);
            }
        }
        return $arrLog;
    }
}

<?php

namespace App\Listeners;

use App\Events\LogIdentitasService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LogChangeIdentitas;
use Illuminate\Support\Str;
use Auth;

class StoreIdentitasLogHistory
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
     * @param  \App\Events\LogIdentitasService  $event
     * @return void
     */
    public function handle(LogIdentitasService $event)
    {
        $arrLog = array();
        $identitas = $event->identitas;
        $tipe = $event->tipe;
        $id = $event->id;

        foreach($identitas->getChanges() as $key => $gc) {
            if($key != "updated_at" || $key != "id") {
                array_push($arrLog, 
                    array(
                        "col"=>Str::of($key)->snake()->replace('_', ' ')->title(),
                        "old"=>$identitas->getOriginal($key),
                        "new"=>$gc
                    )
                );
            }
        }
        if($arrLog != null) {
            LogChangeIdentitas::create([
                "state_change" => json_encode($arrLog),
                "tipe"         => $tipe,
                "identitas_vendor_id" => $id,
                "user_id"       => Auth::user()->id
            ]);
        }
        return $arrLog;
    }
}

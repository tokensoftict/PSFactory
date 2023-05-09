<?php

namespace App\Listeners;

use App\Events\CompletePuchaseOrderEvent;
use App\Jobs\AddLogToRawMaterialBinCard;
use App\Models\Rawmaterialbatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CompletePuchaseOrderListener
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
     * @param  \App\Events\CompletePuchaseOrderEvent  $event
     * @return void
     */
    public function handle(CompletePuchaseOrderEvent $event)
    {

        if($event->purchaseorder->status_id === status('Complete')) return ;

        $bincards = [];

        foreach($event->purchaseorder->purchaseorderitems as $item)
        {
            DB::transaction(function() use(&$event,&$item){

                $item->batch_id = Rawmaterialbatch::create([
                    'received_date' => $event->purchaseorder->purchase_date,
                    'cost_price' => $item->cost_price,
                    'expiry_date' => $item->expiry_date,
                    'measurement' =>  $item->measurement,
                    'rawmaterial_id' => $item->purchase_id,
                    'supplier_id' => $event->purchaseorder->supplier_id,
                ])->id;;

                $item->update();

                $item->purchase->cost_price = $item->cost_price; // update the cost price of the material to newly completed material
                $item->purchase->updateAvailableQuantity();

                $event->purchaseorder->update();
            });

            $bincards[] = [
                'rawmaterialbatch_id' =>  $item->batch_id,
                'rawmaterial_id' => $item->purchase_id,
                'user_id' => auth()->id(),
                'in' => $item->measurement,
                'out' => 0,
                'date_added' => dailyDate(),
                'return' => 0,
                'total' =>  $item->purchase->measurement,
                'type' => 'RECEIVED'
            ];
        }

        dispatch(new AddLogToRawMaterialBinCard($bincards));

        $event->purchaseorder->date_completed = date('Y-m-d');
        $event->purchaseorder->status_id = status('Complete');
        $event->purchaseorder->completed_by = auth()->id();

        $event->purchaseorder->update();

    }
}

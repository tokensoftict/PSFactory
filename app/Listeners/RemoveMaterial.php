<?php

namespace App\Listeners;

use App\Events\MaterialApprovedEvent;
use App\Jobs\AddLogToRawMaterialBinCard;
use App\Models\ProductionMaterialItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveMaterial
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
     * @param  \App\Events\MaterialApprovedEvent  $event
     * @return void
     */
    public function handle(MaterialApprovedEvent $event)
    {

        $bincards = [];

        foreach ($event->materials as $material)
        {

            if($event->add === false) {

                $batches = $material->rawmaterial->getBatches($material->convert_measurement);

                $material->rawmaterial->remove($batches);

                if ($material->requesttype_type == ProductionMaterialItem::class){

                    $collectedBatches = collect($batches);

                    $material->requesttype->cost_price = ($collectedBatches->sum('cost_price') / $collectedBatches->count());

                    $material->requesttype->total_cost_price = ($material->requesttype->cost_price * $material->convert_measurement);

                    $material->requesttype->update();
                }

                $bincards[] = [
                    'rawmaterialbatch_id' => NULL,
                    'rawmaterial_id' => $material->rawmaterial->id,
                    'user_id' => auth()->id(),
                    'in' => 0,
                    'date_added' => dailyDate(),
                    'out' => $material->convert_measurement,
                    'return' => 0,
                    'total' => $material->rawmaterial->measurement,
                    'type' => 'TRANSFER'
                ];
            }else{
                $material->rawmaterial->add($material->edited_measurement);
                $bincards[] = [
                    'rawmaterialbatch_id' => NULL,
                    'rawmaterial_id' => $material->rawmaterial->id,
                    'user_id' => auth()->id(),
                    'in' => 0,
                    'date_added' => dailyDate(),
                    'out' => 0,
                    'return' => $material->edited_measurement,
                    'total' => $material->rawmaterial->measurement,
                    'type' => 'RETURN'
                ];
            }
        }

        dispatch(new AddLogToRawMaterialBinCard($bincards));
    }
}

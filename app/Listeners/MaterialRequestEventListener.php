<?php

namespace App\Listeners;

use App\Events\MaterialRequestEvent;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MaterialRequestEventListener
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
     * @param  \App\Events\MaterialRequestEvent  $event
     * @return void
     */
    public function handle(MaterialRequestEvent $event)
    {

        MaterialRequest::where('request_type', $event->eventData['request_type'])
            ->where('request_id', $event->eventData['request_id'])->delete();

        $requests = MaterialRequest::create($event->eventData);

        $requests->request->update(['material_request_id'=>$requests->id]);

        $items = [];

        foreach ($requests->request->items as $item)
        {
            $items[] = new MaterialRequestItem(
                [
                    'name' => $item->name,
                    'requesttype_type' => get_class($item),
                    'requesttype_id' => $item->id,
                    'rawmaterial_id' => $item->rawmaterial_id,
                    'department_id' => $item->department_id,
                    'status_id' => status('Pending'),
                    'measurement' => $item->measurement,
                    'unit' => $item->unit,
                    'convert_measurement' => $item->convert_measurement,
                    'convert_unit' => $item->convert_unit,
                ]
            );
        }

        $requests->material_request_items()->saveMany($items);

    }
}

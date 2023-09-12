<?php

namespace App\Http\Livewire\RawMaterial\Requests;

use App\Events\MaterialApprovedEvent;
use App\Models\MaterialRequest;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MaterialRequestComponent extends Component
{
    use LivewireAlert;

    public MaterialRequest $materialRequest;

    public  $production_items;

    public $items;

    public bool $showApproval = false;

    public function boot()
    {

    }

    public function mount()
    {
        if(in_array(auth()->user()->department_id, [1,2])){

            // if the login user can approve this only show the items he / she can approve
            $this->items = $this->materialRequest->material_request_items()->where('department_id', auth()->user()->department_id)->get();

            if($this->materialRequest->status_id !== status("Approved")) {
                $this->items->each(function ($item) {
                    if ($item->status_id == status('Pending')) {
                        $this->showApproval = true;
                    }
                });

                foreach ($this->items as $key => $item) {
                    $this->items[$key] = $item;
                    $this->production_items[$item->id] = false;
                }

            }

        }else{

            //this is just a normal user viewing it

            $this->items = $this->materialRequest->material_request_items()->get();

            $this->showApproval = false;


        }

    }

    public function render()
    {
        return view('livewire.raw-material.requests.material-request-component');
    }


    public function approveRequest()
    {

        foreach ($this->items as $item)
        {
            if($item->rawmaterial->measurement < $item->convert_measurement)
            {
                $this->alert(
                    "error",
                    "Material Request",
                    [
                        'position' => 'center',
                        'timer' => 1500,
                        'toast' => false,
                        'text' =>  "Insufficient measurement / quantity for ".$item->rawmaterial->name,
                    ]
                );

                return;
            }
        }



        foreach ($this->items as $item)
        {
            if($item->requesttype_type === ProductionMaterialItem::class) { // if this is a production request
                $item->requesttype->update([
                    'status_id' => status('Approved'),
                    'approved_by' => auth()->id(),
                    'approved_date' => dailyDate(),
                    'approved_time' => Carbon::now()->toDateTimeLocalString()
                ]);
            }

            $item->status_id  = status('Approved');
            $item->resolve_by_id = auth()->id();
            $item->resolve_date = dailyDate();
            $item->resolve_time = Carbon::now()->toDateTimeLocalString();

            $item->update();
        }

        event(new MaterialApprovedEvent($this->items)); // trigger material items bin-card event


        $approval_status = $this->materialRequest->material_request_items->count() ===  $this->materialRequest->material_request_items()
                ->where('status_id',status('Approved') )->count();

        if($approval_status)
        {
            $this->materialRequest->update([
                'status_id'=>status('Approved'),
                // update the real material request
            ]);
            if($this->materialRequest->request_type == Production::class){ // if this is a production request
                $this->materialRequest->request->update([
                    'status_id'=>status('In-Progress'), // update production or material request
                ]);
            }

        }
        else {
            $this->materialRequest->update([
                'status_id'=>status('Material-Approval-In-Progress'),
                // update the real material request
            ]);
            if($this->materialRequest->request_type == Production::class) { // if this is a production request
                $this->materialRequest->request->update([
                    'status_id' => status('Material-Approval-In-Progress'), // update production or material request
                ]);
            }
        }

        $this->alert(
            "success",
            "Material Request",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  "Request have been approved successfully!",
            ]
        );

        return redirect()->route('rawmaterial.request');

    }


    public function declineRequest()
    {
        return DB::transaction(function (){
            foreach ($this->items as $item)
            {
                if($item->requesttype_type === ProductionMaterialItem::class) { // if this is a production request
                    if($item->requesttype->production->status_id == status('Waiting-Material')){
                        $item->requesttype->update([
                            'status_id' => status('Declined'),
                            'approved_by' => auth()->id(),
                            'approved_date' => dailyDate(),
                            'approved_time' => Carbon::now()->toDateTimeLocalString()
                        ]);
                    }else if($item->requesttype->production->status_id == status('Material-Approval-In-Progress')) {
                        $item->requesttype->update([
                            'status_id' => status('Declined'),
                            'approved_by' => auth()->id(),
                            'approved_date' => dailyDate(),
                            'approved_time' => Carbon::now()->toDateTimeLocalString()
                        ]);
                    }else{
                        $item->requesttype->delete();
                        // this is an extra material been requested
                        // the request was declined so lets the delete the item from production items
                    }
                }

                $item->status_id  = status('Declined');
                $item->resolve_by_id = auth()->id();
                $item->resolve_date = dailyDate();
                $item->resolve_time = Carbon::now()->toDateTimeLocalString();

                $item->update();
            }

            $this->materialRequest->update([
                'status_id'=>status('Declined'),
                // update the real material request
            ]);

            if($this->materialRequest->request_type == Production::class) { // if this is a production request

                $this->materialRequest->request->update([
                    'status_id' => status('Declined'), // update production or material request
                ]);

            }

            $this->alert(
                "success",
                "Material Request",
                [
                    'position' => 'center',
                    'timer' => 1500,
                    'toast' => false,
                    'text' =>  "Request have been declined successfully!",
                ]
            );

            return redirect()->route('rawmaterial.request');
        });

    }
}

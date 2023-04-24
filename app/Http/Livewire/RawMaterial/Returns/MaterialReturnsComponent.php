<?php

namespace App\Http\Livewire\RawMaterial\Returns;

use App\Events\MaterialApprovedEvent;
use App\Models\MaterialReturn;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MaterialReturnsComponent extends Component
{
    use LivewireAlert;

    public MaterialReturn $materialReturn;

    public  $production_items;

    public $items;

    public bool $showApproval = false;

    public function boot()
    {

    }

    public function mount()
    {
        if(in_array(auth()->user()->department_id, [1,2]) && $this->materialReturn->status_id !== status("Approved")){
            // if the login user can approve this only show the items he / she can approve
            $this->items = $this->materialReturn->material_return_items()->where('department_id', auth()->user()->department_id)->get();

            $this->items->each(function($item){
                if($item->status_id == status('Pending'))
                {
                    $this->showApproval = true;
                }
            });

            foreach ($this->items as $key=>$item)
            {
                $this->items[$key] = $item;
                $this->production_items[$item->id] = false;
            }

        }else{

            //this is just a normal user viewing it

            $this->items = $this->materialReturn->material_return_items()->get();

            $this->showApproval = false;


        }

    }

    public function render()
    {
        return view('livewire.raw-material.returns.material-returns-component');
    }


    public function approveReturn()
    {

        foreach ($this->items as $item)
        {
            if($item->returntype_type === ProductionMaterialItem::class) { // if this is a production return
                $item->returntype->update([
                     'returns' =>   ($item->returntype->returns + $item->convert_measurement)
                ]);
            }

            $item->status_id  = status('Approved');
            $item->resolve_by_id = auth()->id();
            $item->resolve_date = dailyDate();
            $item->resolve_time = Carbon::now()->toDateTimeLocalString();

            $item->update();
        }

        event(new MaterialApprovedEvent($this->items, true)); // triger material items bincard event


        $approval_status = $this->materialReturn->material_return_items->count() ===  $this->materialReturn->material_return_items()
                ->where('status_id',status('Approved') )->count();

        if($approval_status)
        {
            $this->materialReturn->update([
                'status_id'=>status('Approved'),
                // update the real material return
            ]);


        }
        else {
            $this->materialReturn->update([
                'status_id'=>status('Material-Approval-In-Progress'),
                // update the real material return
            ]);
        }

        $this->alert(
            "success",
            "Material Return",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  "Return have been approved successfully!",
            ]
        );

        return redirect()->route('rawmaterial.returns');

    }


    public function declineReturn()
    {

        foreach ($this->items as $item)
        {
            if($item->returntype_type === ProductionMaterialItem::class) { // if this is a production return
                $item->returntype->update([
                    'status_id' => status('Declined'),
                    'approved_by' => auth()->id(),
                    'approved_date' => dailyDate(),
                    'approved_time' => Carbon::now()->toDateTimeLocalString()
                ]);
            }

            $item->status_id  = status('Declined');
            $item->resolve_by_id = auth()->id();
            $item->resolve_date = dailyDate();
            $item->resolve_time = Carbon::now()->toDateTimeLocalString();

            $item->update();
        }


        $this->materialReturn->update([
            'status_id'=>status('Declined'),
            // update the real material return
        ]);
        if($this->materialReturn->return_type == Production::class) { // if this is a production return
            $this->materialReturn->return->update([
                'status_id' => status('Cancelled'), // update production or material return
            ]);
        }

        $this->alert(
            "success",
            "Material Return",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  "Return have been declined successfully!",
            ]
        );
    }

}

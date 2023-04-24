<?php

namespace App\Http\Livewire\ProductionManager\Complete;

use App\Jobs\AddLogToRawMaterialBinCard;
use App\Models\MaterialReturn;
use App\Models\Production;
use App\Repositories\MaterialReturnRepository;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CompleteProductionComponent extends Component
{
    use LivewireAlert;

    public Production $production;

    public array $data;


    protected array $messages = [
        'data.rough_quantity.required' => 'Rough Quantity is required',
        'data.yield_quantity.required' => 'Yield Quantity is required',
        'data.quantity_1.required' => 'Quantity 1 Field is required',
        'data.quantity_2.required' => 'Quantity 2 Field is required',
        'data.quantity_3.required' => 'Quantity 3 Field is required',
        'data.expiry_date.required' => 'Expiry Date is required',
    ];

    public function boot()
    {

    }

    public function mount()
    {
        $this->data = $this->production->toArray();

    }

    public function render()
    {
        return view('livewire.production-manager.complete.complete-production-component');
    }



    public function completeProduction()
    {

        $this->validate([
           'data.rough_quantity' => 'required',
            'data.yield_quantity' => 'required',
            'data.quantity_1' => 'required',
            'data.quantity_2' =>  'required',
            'data.quantity_3' => 'required',
            'data.expiry_date' => 'required',
        ]);

        $this->data['status_id'] = status('Ready');

        $this->data['completed_id'] = auth()->id();

        $this->production->update($this->data);

        $this->alert(
            "success",
            "Production",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Production has been completed successfully!.",
            ]
        );

        // construct the material to return from here

        $returnqty =  ($this->production->expected_quantity - ($this->production->yield_quantity + $this->production->rough_quantity));

        $packagingItems = $this->production->production_material_items()->where('department_id',2)->where('extra',0)->get();

        $bincard = [];


        $repo = new MaterialReturnRepository();

        $data = [
            'return_date' => todaysDate(),
            'return_time' =>  Carbon::now()->toDateTimeLocalString(),
            'return_by_id' => auth()->id(),
            'return_type' => Production::class,
            'return_id' => $this->production->id,
            'status_id' => status('Pending'),
            'description' => "Material was return by system automatically after the production has been completed",
            'material_return_items' => []
        ];

        foreach ($packagingItems as $packagingItem)
        {
            $data['material_return_items'][] = [
                'rawmaterial_id' => $packagingItem->rawmaterial->id,
                'unit' => $packagingItem->rawmaterial->materialtype->production_measurement_unit,
                'measurement' => $returnqty, //$packagingItem->measurement,
                'name' => $packagingItem->rawmaterial->name,
                'extra' => $packagingItem->extra
            ];
        }

        $repo->createReturn($data);

        /*
        foreach ($packagingItems as $packagingItem)
        {
            $batch = $packagingItem->rawmaterial->rawmaterialbatches()->orderBy('expiry_date','ASC')->first();
            $batch->measurement = ($batch->measurement +  $returnqty);
            $batch->update();
            $batch->rawmaterial->updateAvailableQuantity();

            $bincard[] = [
                'rawmaterialbatch_id' => $batch->update(),
                'rawmaterial_id' => $batch->rawmaterial_id,
                'user_id' => auth()->id(),
                'date_added' => dailyDate(),
                'in' => 0,
                'out' => 0,
                'return' => $returnqty,
                'total' =>  $batch->rawmaterial->measurement,
                'type' => 'RETURN',
            ];

            $packagingItem->returns = $returnqty;
            $packagingItem->update();
        }

        if(count($bincard) > 0)
        {
            dispatch(new AddLogToRawMaterialBinCard($bincard));
        }
        */

        return redirect()->route('production.index');
    }

}

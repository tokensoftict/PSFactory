<?php

namespace App\Http\Livewire\ProductionManager\Complete;

use App\Jobs\AddLogToRawMaterialBinCard;
use App\Models\MaterialReturn;
use App\Models\Production;
use App\Models\Rawmaterial;
use App\Models\Stockbatch;
use App\Repositories\MaterialReturnRepository;
use App\Repositories\ProductionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CompleteProductionComponent extends Component
{
    use LivewireAlert;

    public Production $production;

    private ProductionRepository $productionRepository;

    public array $data;

    protected array $messages = [
        'data.ending_unscrabler.required' => 'End Unscrabler Field is required',
        'data.ending_unibloc.required' => 'End UniBloc Field is required',
        'data.ending_oriental.required' => 'End Oriental Field is required',
        'data.ending_labelling.required' => 'End Labelling Field is required',

        'data.starting_unscrabler.required' => 'Starting Unscrabler Field is required',
        'data.starting_unibloc.required' => 'Starting UniBloc Field is required',
        'data.starting_oriental.required' => 'Starting Oriental Field is required',
        'data.starting_labelling.required' => 'Starting Labelling Field is required',
        'productionItems.*.rough' => 'This Rough Field is required',
        'data.yield_quantity.required' => 'Yield Quantity is required',
        'data.expiry_date.required' => 'Expiry Date is required',
    ];

    public function boot(ProductionRepository $productionRepository)
    {
        $this->productionRepository = $productionRepository;
    }

    public function mount()
    {
        $this->data = $this->production->toArray();

        $this->data['expiry_date'] = mysql_str_date($this->data['expiry_date']);

        $this->productionItems = $this->production->production_material_items()
            ->with(['rawmaterial','rawmaterial.department', 'rawmaterial.materialtype'])
            ->select(
            'rawmaterial_id',
                DB::raw('MAX(rough) as rough'),
                    DB::raw('MAX(returns) as returns'),
            DB::raw('SUM(measurement) as measurement'),
            DB::raw('SUM(total_cost_price) as total_cost_price'),
        )
            ->where('department_id', 2)
            ->groupBy('rawmaterial_id')
            ->get()
            ->map(function($item){
                $item['rough'] = $item['rough'] > 0 ? $item['rough'] : 0;
                $item['returns'] =  $item['returns'] > 0 ?  $item['returns'] : 0;
                return $item;
            })->toArray();

    }

    public function render()
    {
        return view('livewire.production-manager.complete.complete-production-component');
    }



    public function completeProduction()
    {

        $error = false;


        $this->validate([
            'data.ending_unscrabler' => 'required',
            'data.ending_unibloc' =>  'required',
            'data.ending_oriental' => 'required',
            'data.ending_labelling' => 'required',

            'data.starting_unscrabler' => 'required',
            'data.starting_unibloc' =>  'required',
            'data.starting_oriental' => 'required',
            'data.starting_labelling' => 'required',

            'data.expiry_date' => 'required',
            'data.yield_quantity' => 'required',
        ]);


        foreach ($this->productionItems as $key=>$items)
        {
            unset($this->productionItems[$key]['error']);

            if($items['rough'] == ""){
                $error = true;
                $this->productionItems[$key]['error'] = "This Rough Field is required!..";
            }

            //temporary fix for production now
            $yield_quantity = $this->data['yield_quantity'];

            $mat = Rawmaterial::find($items['rawmaterial_id']);

            if($mat->divide_by_carton === true)
            {
                $yield_quantity = floor(($this->data['yield_quantity'] / $this->production->stock->carton));
            }


            if($items['rawmaterial']['materialgroup_id'] == NULL) { // if the raw material have been grouped the dont calculate
                $validate = ($items['measurement'] - $yield_quantity) - $items['rough'];
            }else{
                $validate = $items['rough'];
            }

            if($validate < 0)
            {
                $error = true;
                $this->productionItems[$key]['error'] = "
                Invalid Rough Amount, Return value can not be less than zero (".$items['measurement']." - ".$yield_quantity.") - ".$items['rough'].") = ".$validate.")";
            }
        }


        if($error === true) return true;

        $this->data['status_id'] = status('Complete');

        $this->data['completed_id'] = auth()->id();

        $repo = new MaterialReturnRepository();

        $data = [
            'return_date' => todaysDate(),
            'return_time' =>  Carbon::now()->toDateTimeLocalString(),
            'return_by_id' => auth()->id(),
            'return_type' => Production::class,
            'return_id' => $this->production->id,
            'status_id' => status('Pending'),
            'description' => "Material was returned by system automatically after the production was completed, the value Return was generated automatically",
            'material_return_items' => []
        ];


        foreach ($this->productionItems as $items)
        {

            $item = $this->production->production_material_items()->whereRawmaterialId($items['rawmaterial_id'])->whereExtra(0)->first();

            if($item == NULL) {
                $this->alert(
                    "error",
                    "Production",
                    [
                        'position' => 'center',
                        'timer' => 6000,
                        'toast' => false,
                        'text' =>  $items['rawmaterial']['name']." is not in production template, unable to continue",
                    ]
                );

                return false;
            }

            $item->rough = $items['rough'];

            $yield_quantity = $this->data['yield_quantity'];

            $mat = Rawmaterial::find($items['rawmaterial_id']);

            if($mat->divide_by_carton === true) //14
            {
                $yield_quantity = floor(($this->data['yield_quantity'] / $this->production->stock->carton));
            }


            if($items['rawmaterial']['materialgroup_id'] == NULL) { // if the raw material have been grouped the dont calculate

                $item->returns = ($items['measurement'] - $yield_quantity) - $items['rough'];

            }else{

                $item->returns = $items['returns'];
            }

            $item->update();

            if( $item->returns > 0) {

                $data['material_return_items'][] = [
                    'rawmaterial_id' => $items['rawmaterial_id'],
                    'name' => $item->rawmaterial->name,
                    'unit' => $item->unit,
                    'measurement' => $item->returns,
                    'extra' => 0,
                    'returntype_id' => $item->id
                ];
            }

        }

       $reports =  $this->productionRepository->calculatePackagingReports($this->production);

        $this->production->packaging_reports = $reports;

        $this->production->update();

        if(count($data['material_return_items']) > 0) {

            MaterialReturn::where('return_type', Production::class)->where('return_id', $this->production->id)->delete();

            $repo->createReturn($data);
        }



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

        Stockbatch::where('production_id', $this->production->id)->update(['expiry_date' => $this->production->expiry_date]);
        // set th expiry date of the batch
        return redirect()->route('production.index');
    }

}

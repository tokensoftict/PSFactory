<?php

namespace App\Http\Livewire\ProductionManager;

use App\Models\Production;
use App\Models\Productionline;
use App\Models\ProductionTemplate;
use App\Models\Status;
use App\Models\Stock;
use App\Repositories\ProductionRepository;
use Illuminate\Support\Arr;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductionModule extends Component
{

    use LivewireAlert;

    public Production $production;

    public $stocks;

    public $production_templates = [];

    public  $data;

    public  $listStatuses = [];

    public $productionlines;

    private ProductionRepository $productionRepository;

    public array $statuses = ['Pending','Draft','Waiting-Material'];


    protected array $messages =  [
        'data.name.required' => "Name field is required",
        'data.production_date.required' => "Production date is required",
        'data.stock_id.required' => "Please select product",
        'data.production_template_id.required' => "Production template is required",
        'data.batch_number.required'  => "Batch Number is required",
        'data.production_time.required'  => "Production Time is required",
        'data.status_id.required'  => "Please select production status",
        'data.productionline_id.required'  => "Please select production line",
    ];

    public function boot(ProductionRepository $productionRepository)
    {
        $this->productionRepository = $productionRepository;
    }

    public function mount()
    {

        $this->data = ProductionRepository::$fields;

        $this->data['user_id'] =  auth()->id();

        if(isset($this->production->id))
        {
            $this->data  = Arr::only($this->production->toArray(), array_keys(ProductionRepository::$fields));
            $this->data['production_date'] = mysql_str_date( $this->data['production_date']);
            $this->data['production_time'] = twentyfourHourClock($this->data['production_time']);

        }

        $this->productionlines = Productionline::where('status',1 )->get();

        $this->production_templates = ProductionTemplate::where('stock_id', $this->data['stock_id'])->get();

        $this->stocks = Stock::where('status', 1)->get();

        $this->listStatuses = Status::whereIn('name',$this->statuses)->get();
    }

    protected function rules()
    {
        return ProductionRepository::$validation;
    }

    public function render()
    {
        $this->production_templates = ProductionTemplate::where('stock_id', $this->data['stock_id'])->get();

        return view('livewire.production-manager.production-module');
    }


    public function saveProduction()
    {
        $this->validate();

        if(isset($this->production->id)) {

            $this->productionRepository->update($this->production, $this->data);

            $this->alert(
                "success",
                "Production",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  "Production has been updated successfully!.",
                ]
            );

        }else{
            $this->productionRepository->create($this->data);

            $this->alert(
                "success",
                "Production",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  "Production has been created successfully!.",
                ]
            );

        }


        return redirect()->route('production.index');


    }

}

<?php

namespace App\Http\Livewire\ProductModule\Template;

use App\Models\ProductionTemplate;
use App\Models\Stock;
use App\Repositories\ProductRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class ProductProductionTemplateComponent extends Component
{

    use LivewireAlert;

    public $stocks;

    public Stock $product;

    public ProductionTemplate $template;

    private ProductRepository $productRepository;

    public String $expected_quantity = "";

    public String $template_name  = "";

    public String $stock_id  = "";

    public String $date_created  = "";

    public String $unitConfig = "";

    public String $status = "";

    public String $last_updated_by = "";

    public String $addedMaterial;

    public function boot(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }



    public function mount ()
    {

        if(isset($this->template->id)){

            $this->template_name = $this->template->name;

            $this->status = $this->template->status;

            $__items  = $this->template->production_template_items->toArray();

            foreach ($__items as $key=>$item) {
                $__items[$key]['date_created'] = mysql_str_date( $__items[$key]['date_created']);
                Arr::forget($__items,  [$key.'.id', $key.'.total_cost' ,$key.'.created_at', $key.'.updated_at', $key.'.rawmaterial', $key.'.production_template_id']);
            }

            $this->addedMaterial =json_encode($__items);

            $this->date_created = $this->template->date_created;

            $this->stock_id = $this->template->stock_id;

            $this->expected_quantity = $this->template->expected_quantity;
        }


        if(isset($this->product->id))
        {
            $this->stock_id = $this->product->id;
        }

        $this->unitConfig = json_encode(config('convert'));

        $this->stocks = Stock::where('status',1)->get();
    }


    public function render()
    {

        return view('livewire.product-module.template.product-production-template-component');
    }


    public function updateTemplate()
    {

        $user = auth()->id();

        $data = [
            'stock_id' => $this->stock_id,
            'name' => $this->template_name,
            'user_id' => $user,
            'expected_quantity' => $this->expected_quantity,
            'status' => $this->status,
            'last_updated_by' => $user
        ];

        $this->template =  $this->productRepository->productionTemplateRepository->update($this->template->id, $data);

        $this->template->production_template_items()->delete();

        $this->productRepository->productionTemplateRepository->saveTemplateMaterialItems( $this->template, json_decode($this->addedMaterial,true));


        $this->alert(
            "success",
            "Production Template",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Template has been updated successfully!.",
            ]
        );

    }


    public function saveTemplate()
    {

        $user = auth()->id();

        $data = [
            'stock_id' => $this->stock_id,
            'name' => $this->template_name,
            'date_created' => $this->date_created,
            'user_id' => $user,
            'expected_quantity' => $this->expected_quantity,
            'status' => $this->status,
            'last_updated_by' => $user
        ];

        $template =  $this->productRepository->productionTemplateRepository->create($data);

        $this->productRepository->productionTemplateRepository->saveTemplateMaterialItems($template, json_decode($this->addedMaterial,true));


        $this->alert(
            "success",
            "Production Template",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Template has been created successfully!.",
            ]
        );

        if(isset($this->product->id))
        {
            return redirect()->route('product.show', $this->product->id);
        }

    }



}

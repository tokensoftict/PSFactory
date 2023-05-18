<?php

namespace App\Http\Livewire\ProductModule;

use App\Models\Category;
use App\Models\Stock;
use App\Repositories\ProductRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductComponent extends Component
{

    use LivewireAlert;

    public  $categories;

    public Stock $product;

    public String $category_id = "";
    public String $selling_price = "";
    public String $cost_price = "";
    public String $expiry = "";
    public String $carton = "1";
    public String $lead_time = "";
    public String $code = "";
    public String $name = "";
    public String $incentives_percentage = "0";
    public String $description = "";


    private ProductRepository $productRepository;



    public function boot(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }


    public function mount()
    {
        $this->categories = Category::where('status',1)->get();

        if(isset($this->product->id))
        {

            $this->selling_price = $this->product->selling_price;
            $this->cost_price = $this->product->cost_price;
            $this->expiry = $this->product->expiry  ? "1" : "0";
            $this->name = $this->product->name;
            $this->carton = $this->product->carton;
            $this->description = $this->product->description;
            $this->incentives_percentage = $this->product->incentives_percentage;
            $this->code = $this->product->code;
            $this->category_id = $this->product->category_id ?? "";
            $this->lead_time = $this->product->lead_time ?? 0;

        }

    }

    public function render()
    {

        return view('livewire.product-module.product-component');
    }

    public function saveStock()
    {


        $this->validate([
            'selling_price' => 'required',
            'cost_price' => 'required',
            'expiry' => 'required',
            'name' =>  'required',
            'carton' => 'required',
            'incentives_percentage' => 'required',
            'lead_time' => 'required'
        ]);


        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code,
            'category_id' => empty($this->category_id) ? NULL : $this->category_id,
            'selling_price' => $this->selling_price,
            'cost_price' => $this->cost_price,
            'incentives_percentage' => $this->incentives_percentage,
            'expiry' => $this->expiry == "Yes" ? 1 : 0,
            'carton' => empty($this->carton) ? 1 : $this->carton,
            'lead_time' => $this->lead_time,
            'user_id' => auth()->id(),
            'last_updated_by' => auth()->id()
        ];

        if(isset($this->product->id))
        {
            $message = "updated";
            Arr::forget($data, ['user_id']);
            $this->product =  $this->productRepository->update($this->product->id, $data);
        }
        else {
            $message = "created";

            $this->product =  $this->productRepository->create($data);

            // clear all fields for input
            foreach ($data as $key=>$value)
            {
                $this->{$key} = "";
            }

        }

        $this->alert(
            "success",
            "Product",
            [
                'position' => 'center',
                'timer' => 12000,
                'toast' => false,
                'text' =>  "Product has been ".$message." successfully!.",
            ]
        );


        return redirect()->route('product.index');

    }
}

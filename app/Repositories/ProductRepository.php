<?php

namespace App\Repositories;

use App\Models\Stock;

class ProductRepository
{

    public ProductProductionTemplateRepository $productionTemplateRepository;

    public function __construct(ProductProductionTemplateRepository $productionTemplateRepository)
    {
        $this->productionTemplateRepository = $productionTemplateRepository;
    }

    public function create($data) : Stock{

        return Stock::create($data);
    }


    public function getStock($id) : Stock {
        return Stock::find($id);
    }


    public function update($id, $data) : Stock{

        $stock  = $this->getStock($id);

        $stock->update($data);

        return $stock;
    }


    public function destroy($id) : void
    {
         $this->getStock($id)->delete();
    }

    public function findProduct(mixed $name)
    {
        $name = explode(" ",$name);

        return  Stock::query()->with(['category'])->where('quantity', '>', 0)->where(function($query) use(&$name){
            foreach ($name as $char) {
                $query->where('name', 'LIKE', "%$char%");
            }
        })->get();
    }

}

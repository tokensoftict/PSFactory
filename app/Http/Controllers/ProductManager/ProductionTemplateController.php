<?php

namespace App\Http\Controllers\ProductManager;

use App\Http\Controllers\Controller;
use App\Models\ProductionTemplate;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductionTemplateController extends Controller
{

    public function index()
    {
        return setPageContent('product.template.index');
    }

    public function create()
    {
        $data = [
            'template' => new ProductionTemplate(),
            'product' => \request()->get('product_id') ? Stock::find(\request()->get('product_id')) : new Stock(),
            'title'=>'New',
            'subtitle'=>'Create new'
        ];

        return setPageContent('product.template.form',$data);
    }



    public function store(Request $request)
    {

    }

    public function show(ProductionTemplate $productionTemplate)
    {
        $data = [
            'template' => $productionTemplate,
            'product' =>$productionTemplate->stock,
        ];

        return setPageContent('product.template.form',$data);
    }

    public function edit(ProductionTemplate $productionTemplate)
    {
        $data = [
            'template' => $productionTemplate,
            'product' =>$productionTemplate->stock,
            'title'=>'Update',
            'subtitle'=>'Update'
        ];

        return setPageContent('product.template.form',$data);
    }


    public function update(Request $request,ProductionTemplate $productionTemplate)
    {

    }


    public function toggle(Stock $stock)
    {

    }



}

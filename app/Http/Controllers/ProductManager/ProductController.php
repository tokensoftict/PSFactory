<?php

namespace App\Http\Controllers\ProductManager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data = [];

        $filter = ['status' => 1];

        $data['filters'] = $filter;

        return setPageContent('product.index', $data);
    }

    public function create()
    {
        $data = [
            'product'=> new Stock(),
            'title'=>'New',
            'subtitle'=>'Create new'
        ];

        return setPageContent('product.form',$data);
    }



    public function store(Request $request)
    {

    }

    public function show(Stock $stock)
    {
        $data = [
            'product'=> $stock,
        ];

        return setPageContent('product.show',$data);
    }

    public function edit(Stock $stock)
    {
        $data = [
            'product'=> $stock,
            'title'=>'Update',
            'subtitle'=>'Update'
        ];

        return setPageContent('product.form',$data);
    }





    public function toggle(Stock $stock)
    {

    }

    public function disabled()
    {
        $data = [];

        $filter = ['status' => 0];

        $data['filters'] = $filter;

        return setPageContent('product.index', $data);
    }


    public function product_transfer()
    {
        $data = [];

        $filter = [
            'transfer_date' => dailyDate()
        ];

        $data['filters'] = $filter;

        return setPageContent('product.transfer', $data);
    }


    public function approveTransfer()
    {

    }


    public function changeSellingPrice()
    {

    }

    public function changeCostPrice()
    {

    }

    public function stock_report(Request $request, Stock $stock)
    {

    }

    public function export_current_stock()
    {

    }
}

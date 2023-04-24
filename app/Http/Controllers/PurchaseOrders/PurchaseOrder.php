<?php

namespace App\Http\Controllers\PurchaseOrders;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchaseorder as Po;

class PurchaseOrder extends Controller
{

    public function index(){

        return setPageContent('purchaseorder.index',['filters'=>['purchase_date'=>dailyDate()]]);
    }


    public function create(){

        $purchaseOrder = new Po();
        return setPageContent('purchaseorder.new',['purchaseorder'=>$purchaseOrder]);
    }


    public function store(Request $request){


    }

    public function show(Po $purchaseOrder){

        return setPageContent('purchaseorder.show',['purchaseorder'=>$purchaseOrder]);
    }

    public function destroy($id){

    }



    public function edit(Po $purchaseOrder){

        return setPageContent('purchaseorder.new',['purchaseorder'=>$purchaseOrder]);
    }


    public function update(Request $request, Po $purchaseOrder)
    {

    }

    public function markAsComplete(Request $request, Po $purchaseOrder){

    }


}

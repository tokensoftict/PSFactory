<?php

namespace App\Http\Controllers\InvoiceAndSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceReasonController extends Controller
{
    public function index(){

        return setPageContent('settings.reason.index');
    }


    public function create(){

    }


    public function toggle($id){


    }


    public function update(Request $request, $id){

    }


    public function destroy()
    {}

}

<?php

namespace App\Http\Controllers\CustomerManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        return setPageContent('customermanager.index');
    }

    public function create(){
    }


    public function update(Request $request, $id){
    }


}

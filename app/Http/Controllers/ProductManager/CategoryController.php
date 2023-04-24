<?php

namespace App\Http\Controllers\ProductManager;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){

        return setPageContent('settings.category.index');
    }


    public function create(){

    }




    public function toggle($id){



    }




    public function update(Request $request, $id){


    }

}

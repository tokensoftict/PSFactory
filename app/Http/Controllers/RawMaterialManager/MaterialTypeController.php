<?php

namespace App\Http\Controllers\RawMaterialManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function index(){

        return setPageContent('settings.materialtype.index');
    }

    public function create(){

    }

    public function toggle($id){

    }

    public function update(Request $request, $id){

    }

}

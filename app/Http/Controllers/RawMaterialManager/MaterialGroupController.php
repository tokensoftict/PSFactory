<?php

namespace App\Http\Controllers\RawMaterialManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialGroupController extends Controller
{
    public function index(){

        return view('settings.materialgroup.index');
    }

    public function create(){

    }

    public function toggle($id){

    }

    public function update(Request $request, $id){

    }

}

<?php

namespace App\Http\Controllers\ProductionManager;

use App\Http\Controllers\Controller;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{

    public function index()
    {
        $data = ['filter'=>['production_date'=>dailyDate()]];
        return setPageContent('production.index',$data);
    }

    public function store()
    {

    }


    public function create()
    {
        $data = [
            'production'=> new Production(),
            'title'=>'New',
            'subtitle'=>'Create new'
        ];

        return setPageContent('production.form',$data);
    }

    public function show(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'View',
            'subtitle'=>'View full details of ',
        ];

        return view('production.show',$data);
    }

    public function edit(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'Update',
            'subtitle'=>'Update',
        ];

        return view('production.form',$data);
    }

    public function update(Production $production)
    {

    }

    public function destroy(Production $production)
    {

    }

    public function rollback(Production $production)
    {

    }


    public function complete(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'Complete',
            'subtitle'=>'Complete',
        ];

        return view('production.complete',$data);
    }

    public function transfer(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'Transfer',
            'subtitle'=>'Transfer',
        ];

        return view('production.transfer',$data);
    }



    public function edit_production_item(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'Edit Production Item',
            'subtitle'=>'Edit Production Item',
        ];

        return view('production.edit_production_item',$data);
    }



    public function enter_yield(Production $production)
    {
        $data = [
            'production'=> $production,
            'title'=>'Enter Production Yield',
            'subtitle'=>'Enter Production Yield',
        ];

        return view('production.enter_production_yield',$data);
    }

}

<?php

namespace App\Http\Controllers\RawMaterialManager;

use App\Classes\Settings;
use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;
use App\Models\MaterialReturn;
use Illuminate\Http\Request;
use PDF;

class RawMaterialController extends Controller
{
    public Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function index(){

        return setPageContent('rawmaterialmanager.index',['filters'=>[]]);
    }

    public function create(){
    }


    public function update(){
    }


    public function requests()
    {

        return view('rawmaterialmanager.requests.index', ['filters'=>['request_date'=>dailyDate()]]);
    }


    public function new_request()
    {
        $data['title'] = "New Material Request";
        $data['subtitle'] = "Request for Production or For Other Usage";
        $data['materialRequest'] = new MaterialRequest();
        return view('rawmaterialmanager.requests.create', $data);
    }

    public function edit_request(MaterialRequest $materialRequest)
    {
        $data['title'] = "Edit Material Request";
        $data['subtitle'] = "Edit Already Saved Request for Production or For Other Usage";
        $data['materialRequest'] = $materialRequest;
        return view('rawmaterialmanager.requests.create', $data);
    }


    public function showrequest(MaterialRequest $materialRequest)
    {
        return view('rawmaterialmanager.requests.show',['materialRequest'=>$materialRequest]);
    }

    public function returns()
    {
        return view('rawmaterialmanager.returns.index', ['filters'=>['return_date'=>dailyDate()]]);
    }

    public function showreturns(MaterialReturn $materialReturn)
    {
        return view('rawmaterialmanager.returns.show',['materialReturn'=>$materialReturn]);
    }

    public function new_return()
    {
        $data['title'] = "New Material Return";
        $data['subtitle'] = "Return Material use for Production or For Other Usage";
        $data['materialReturn'] = new MaterialReturn();
        return view('rawmaterialmanager.returns.create', $data);
    }


    public function edit_return(MaterialReturn $materialReturn)
    {
        $data['title'] = "New Material Return";
        $data['subtitle'] = "Return Material use for Production or For Other Usage";
        $data['materialReturn'] = $materialReturn;
        return view('rawmaterialmanager.returns.create', $data);
    }


    public function declinerequest()
    {

    }

    public function approverequest()
    {

    }

    public function declinereturns(MaterialReturn $materialReturn)
    {

    }

    public function approvereturns(MaterialReturn $materialReturn)
    {

    }


    public function toggle()
    {

    }

    public function printMaterialRequest(MaterialRequest $materialRequest)
    {
        $data['materialRequest'] =$materialRequest;
        $data['store'] = $this->settings->store();
        $pdf = PDF::loadView("print.transfer_print",$data);
        $pdf->getMpdf()->SetWatermarkText(strtoupper($materialRequest->status->name));
        $pdf->getMpdf()->showWatermarkText = true;

        return $pdf->stream('document.pdf');
    }

}

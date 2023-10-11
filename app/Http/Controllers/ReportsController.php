<?php

namespace App\Http\Controllers;

use App\Classes\Settings;
use App\Models\Module;
use App\Models\Nearoutofmaterial;
use App\Models\Nearoutofstock;


class ReportsController extends Controller
{


    public Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        $data = [];
        $data['modules'] = Module::with(['tasks'])->whereIn('id' ,Settings::$reports)->get();
        return setPageContent('reports', $data);
    }


    public function run_p_nearos()
    {
        $this->settings->put('p_run_nears', 'run');
        Nearoutofstock::truncate();
        return redirect()->route('reports.producttransferreport.product_nearoutofstock');
    }

    public function run_nearos()
    {
        $this->settings->put('m_run_nears', 'run');
        Nearoutofmaterial::truncate();
        return redirect()->route('reports.materialtransferreport.material_nearos');
    }
}

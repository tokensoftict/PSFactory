<?php

namespace App\Http\Controllers\MaterialReturnsReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MaterialReturnsReportController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Material Return Report By Date',
            'subtitle' => 'View Material Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.return_date' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.return_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.materialreturnreport.index', $data);
    }


    public function by_system_user(Request $request)
    {
        $data = [
            'title' => 'Product Return Report By User',
            'subtitle' => 'View Return Report By System User',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'request_by_id' => 1,
                'filters' => [
                    'between.return_date' => monthlyDateRange(),
                    'request_by_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.return_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['request_by_id'] = $data['filters']['request_by_id'];
        }


        return setPageContent('reports.materialreturnreport.index', $data);
    }



    public function by_status(Request $request)
    {
        $data = [
            'title' => 'Material Return Report By Status',
            'subtitle' => 'View Material Return Report By Date Range and System Status',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'status_id' => 1,
                'filters' => [
                    'between.return_date' => monthlyDateRange(),
                    'status_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.return_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['status_id'] = $data['filters']['status_id'];

        }
        return setPageContent('reports.materialreturnreport.index', $data);
    }



    public function by_material(Request $request)
    {
        $data = [
            'title' => 'Material Return Report By Raw Material',
            'subtitle' => 'View Material Return Report By Date Range and Raw Material',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'rawmaterial_id' => 1,
                'filters' => [
                    'between.material_returns.return_date' => monthlyDateRange(),
                    'rawmaterial_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.material_returns.return_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['rawmaterial_id'] = $data['filters']['rawmaterial_id'];

        }
        return setPageContent('reports.materialreturnreport.returnbymaterial', $data);
    }

}

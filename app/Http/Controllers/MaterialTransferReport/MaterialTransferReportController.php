<?php

namespace App\Http\Controllers\MaterialTransferReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MaterialTransferReportController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'title' => 'Material Request Report By Date',
            'subtitle' => 'View Material Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.request_date' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.request_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.materialtransferreport.index', $data);
    }


    public function by_system_user(Request $request)
    {
        $data = [
            'title' => 'Product Request Report By User',
            'subtitle' => 'View Request Report By System User',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'request_by_id' => 1,
                'filters' => [
                    'between.request_date' => monthlyDateRange(),
                    'request_by_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.request_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['request_by_id'] = $data['filters']['request_by_id'];
        }
        return setPageContent('reports.materialtransferreport.index', $data);
    }



    public function by_status(Request $request)
    {
        $data = [
            'title' => 'Material Request Report By Status',
            'subtitle' => 'View Material Request Report By Date Range and System Status',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'status_id' => 1,
                'filters' => [
                    'between.request_date' => monthlyDateRange(),
                    'status_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.request_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['status_id'] = $data['filters']['status_id'];

        }
        return setPageContent('reports.materialtransferreport.index', $data);
    }



    public function by_material(Request $request)
    {
        $data = [
            'title' => 'Material Request Report By Raw Material',
            'subtitle' => 'View Material Request Report By Date Range and Raw Material',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'rawmaterial_id' => 1,
                'filters' => [
                    'between.material_requests.request_date' => monthlyDateRange(),
                    'rawmaterial_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.material_requests.request_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['rawmaterial_id'] = $data['filters']['rawmaterial_id'];

        }
        return setPageContent('reports.materialtransferreport.requestbymaterial', $data);
    }


    public function bincard(Request $request)
    {
        $data = [
            'title' => 'Material Bin Card Report By Date',
            'subtitle' => 'Material History / Bin Card By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.date_added' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.date_added'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.materialtransferreport.bincard', $data);
    }

    public function bincard_by_material(Request $request)
    {
        $data = [
            'title' => 'Material Bin Card Report By Date and Material',
            'subtitle' => 'Material History / Bin Card By Date Range and Material',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'rawmaterial_id' => 1,
                'filters' => [
                    'between.date_added' => monthlyDateRange(),
                    'rawmaterial_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.date_added'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['rawmaterial_id'] = $data['filters']['rawmaterial_id'];

        }

        return setPageContent('reports.materialtransferreport.bincard', $data);
    }

}

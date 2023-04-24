<?php

namespace App\Http\Controllers\ProductionReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductionReportsController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'title' => 'Production Report By Date',
            'subtitle' => 'View Production Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.production_date' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.production.index', $data);
    }


    public function by_system_user(Request $request)
    {
        $data = [
            'title' => 'Production Report By Date',
            'subtitle' => 'View Production Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'user_id' => 1,
                'filters' => [
                    'between.production_date' => monthlyDateRange(),
                    'user_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['user_id'] = $data['filters']['user_id'];
        }
        return setPageContent('reports.production.index', $data);
    }


    public function by_status(Request $request)
    {
        $data = [
            'title' => 'Production Report By Status',
            'subtitle' => 'View Report By Date Range and System Status',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'status_id' => 1,
                'filters' => [
                    'between.production_date' => monthlyDateRange(),
                    'status_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['status_id'] = $data['filters']['status_id'];

        }
        return setPageContent('reports.production.index', $data);
    }


    public function by_product(Request $request)
    {
        $data = [
            'title' => 'Production Report By Product',
            'subtitle' => 'View Report By Date Range and Product',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'stock_id' => 1,
                'filters' => [
                    'between.production_date' => monthlyDateRange(),
                    'stock_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['stock_id'] = $data['filters']['stock_id'];

        }
        return setPageContent('reports.production.index', $data);
    }

    public function by_product_template(Request $request)
    {
        $data = [
            'title' => 'Production Report By Production Template',
            'subtitle' => 'View Report By Date Range and Production Template',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'production_template_id' => 1,
                'filters' => [
                    'between.production_date' => monthlyDateRange(),
                    'production_template_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['production_template_id'] = $data['filters']['production_template_id'];

        }
        return setPageContent('reports.production.index', $data);
    }

    public function by_productionline(Request $request)
    {
        $data = [
            'title' => 'Production Report By Production Line',
            'subtitle' => 'View Report By Date Range and Production Line / Tank',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'productionline_id' => 1,
                'filters' => [
                    'between.production_date' => monthlyDateRange(),
                    'productionline_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.production_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['productionline_id'] = $data['filters']['productionline_id'];

        }
        return setPageContent('reports.production.index', $data);
    }

}

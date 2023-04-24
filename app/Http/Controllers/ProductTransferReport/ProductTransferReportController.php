<?php

namespace App\Http\Controllers\ProductTransferReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductTransferReportController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'title' => 'Product Transfer Report By Date',
            'subtitle' => 'View Product Transfer Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.transfer_date' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.transfer_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.producttransferreport.index', $data);
    }


    public function by_system_user(Request $request)
    {
        $data = [
            'title' => 'Product Transfer Report By User',
            'subtitle' => 'View Invoice Report By System User',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'transfer_by_id' => 1,
                'filters' => [
                    'between.transfer_date' => monthlyDateRange(),
                    'transfer_by_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.transfer_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['transfer_by_id'] = $data['filters']['transfer_by_id'];
        }
        return setPageContent('reports.producttransferreport.index', $data);
    }


    public function by_product(Request $request)
    {
        $data = [
            'title' => 'Product Transfer Report By Product',
            'subtitle' => 'View Report By Date Range and Product',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'stock_id' => 1,
                'filters' => [
                    'between.transfer_date' => monthlyDateRange(),
                    'stock_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.transfer_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['stock_id'] = $data['filters']['stock_id'];

        }
        return setPageContent('reports.producttransferreport.index', $data);
    }


    public function by_status(Request $request)
    {
        $data = [
            'title' => 'Product Transfer Report By Status',
            'subtitle' => 'View Report By Date Range and System Status',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'status_id' => 1,
                'filters' => [
                    'between.transfer_date' => monthlyDateRange(),
                    'status_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.transfer_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['status_id'] = $data['filters']['status_id'];

        }
        return setPageContent('reports.producttransferreport.index', $data);
    }


    public function bincard(Request $request)
    {
        $data = [
            'title' => 'Product Bin Card Report By Date',
            'subtitle' => 'Product History / Bin Card Report By Date Range',
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
        return setPageContent('reports.producttransferreport.bincard', $data);
    }

    public function bincard_by_product(Request $request)
    {
        $data = [
            'title' => 'Product Bin Card Report By Date and Product',
            'subtitle' => 'Product History / Bin Card Report By Date Range and Product',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'stock_id' => 1,
                'filters' => [
                    'between.date_added' => monthlyDateRange(),
                    'stock_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.date_added'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['stock_id'] = $data['filters']['stock_id'];

        }

        return setPageContent('reports.producttransferreport.bincard', $data);
    }


}

<?php

namespace App\Http\Controllers\PurchaseReport;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PurchaseReportsController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date',
            'subtitle' => 'View Report By Date Range',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'filters' => [
                    'between.purchase_date' => monthlyDateRange()
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
        }
        return setPageContent('reports.purchases.index', $data);
    }

    public function by_supplier(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date',
            'subtitle' => 'View Report By Date Range and Supplier',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'supplier_id' => 1,
                'filters' => [
                    'between.purchase_date' => monthlyDateRange(),
                    'supplier_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['supplier_id'] = $data['filters']['supplier_id'];

        }
        return setPageContent('reports.purchases.index', $data);
    }

    public function by_system_user(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date',
            'subtitle' => 'View Report By Date Range and Supplier',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'created_by' => 1,
                'filters' => [
                    'between.purchase_date' => monthlyDateRange(),
                    'created_by' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['created_by'] = $data['filters']['created_by'];

        }
        return setPageContent('reports.purchases.index', $data);
    }

    public function by_material(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date and Material',
            'subtitle' => 'View Report By Date Range and Material',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'purchase_id' => 1,
                'filters' => [
                    'between.purchaseorders.purchase_date' => monthlyDateRange(),
                    'purchase_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchaseorders.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['purchase_id'] = $data['filters']['purchase_id'];

        }
        return setPageContent('reports.purchases.purchaseorderbymaterial', $data);
    }

    public function by_status(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date',
            'subtitle' => 'View Report By Date Range and System Status',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'status_id' => 1,
                'filters' => [
                    'between.purchase_date' => monthlyDateRange(),
                    'status_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['status_id'] = $data['filters']['status_id'];

        }
        return setPageContent('reports.purchases.index', $data);
    }

    public function by_department(Request $request)
    {
        $data = [
            'title' => 'Purchase Report By Date',
            'subtitle' => 'View Report By Date Range and Department',
            'filters' => [
                'from' =>monthlyDateRange()[0],
                'to'=>monthlyDateRange()[1],
                'department_id' => 1,
                'filters' => [
                    'between.purchase_date' => monthlyDateRange(),
                    'department_id' => 1
                ]
            ]
        ];
        if($request->get('filter'))
        {
            $data['filters'] = $request->get('filter');
            $data['filters']['filters']['between.purchase_date'] = Arr::only(array_values( $request->get('filter')), [0,1]);
            $data['filters']['filters']['department_id'] = $data['filters']['department_id'];

        }
        return setPageContent('reports.purchases.index', $data);
    }



}

<?php

namespace App\Http\Controllers\InvoiceAndSales;

use App\Http\Controllers\Controller;
use App\Models\InvoiceReturn;
use Illuminate\Http\Request;

class InvoiceReturnController extends Controller
{


    public function index()
    {
        $data = [];

        $data['title'] = 'Return Invoice List(s)';
        $data['subtitle'] = 'List of Draft Return Invoice - '.dailyDate();
        $data['filters'] = ['return_date'=>dailyDate()];
        return setPageContent('invoiceandsales.returns.index', $data);
    }

    public function create()
    {
        $data = [];

        $data['title'] = 'New Return';
        $data['subtitle'] = 'Generate New Return ';
        $data['invoiceReturn'] = new InvoiceReturn();
        return setPageContent('invoiceandsales.returns.form', $data);
    }



    public function edit(InvoiceReturn $invoiceReturn)
    {
        $data = [];

        $data['title'] = 'Update Return';
        $data['subtitle'] = 'Edit Return ';
        $data['invoiceReturn'] = $invoiceReturn;
        return setPageContent('invoiceandsales.returns.edit', $data);
    }



    public function  approve(InvoiceReturn $invoiceReturn)
    {

    }

    public function decline(InvoiceReturn $invoiceReturn){

    }

    public function destroy(InvoiceReturn $invoiceReturn){

    }


    public function show(InvoiceReturn $invoiceReturn){
        $data = [];

        $data['title'] = 'Return Invoice Details';
        $data['subtitle'] = 'Full Details of Returned Invoice';
        $data['invoiceReturn'] = $invoiceReturn;
        return setPageContent('invoiceandsales.returns.show', $data);
    }

}

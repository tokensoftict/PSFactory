<?php

namespace App\Http\Controllers\InvoiceAndSales;

use App\Classes\Settings;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{

    public Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function create()
    {
        $data = [];

        $data['title'] = 'New ';
        $data['subtitle'] = 'Generate New ';
        $data['invoice'] = new Invoice();
        return setPageContent('invoiceandsales.form', $data);
    }

    public function draft()
    {
        $data = [];

        $data['title'] = 'Draft Invoice(s)';
        $data['subtitle'] = 'List of Unpaid Invoice - '.todaysDate();
        $data['filters'] = ['status_id'=>status('Draft'), 'invoice_date'=>todaysDate()];
        return setPageContent('invoiceandsales.index', $data);
    }


    public function paid()
    {
        $data = [];

        $data['title'] = 'Paid Invoice(s)';
        $data['subtitle'] = 'List of Paid Invoice - '.todaysDate();
        $data['filters'] = ['status_id'=>status('Paid'), 'invoice_date'=>todaysDate()];
        return setPageContent('invoiceandsales.index', $data);
    }

    public function dispatched()
    {
        $data = [];

        $data['title'] = 'Dispatched Invoice(s)';
        $data['subtitle'] = 'List of Completely Dispatched Invoice - '.todaysDate();
        $data['filters'] = ['status_id'=>status('Dispatched'), 'invoice_date'=>todaysDate()];
        return setPageContent('invoiceandsales.index', $data);
    }


    public function print_pos(Invoice $invoice)
    {
        logActivity($invoice->id, $invoice->invoice_number,'Print Invoice Thermal Status:'.$invoice->status->name);

        $data['invoice'] =$invoice;
        $data['store'] = $this->settings->store();
        $page_size = $invoice->invoiceitems->count() * 15;
        $page_size += 180;
        $pdf = PDF::loadView('print.pos', $data,[],[
            'format' => [70,$page_size],
            'margin_left'          => 0,
            'margin_right'         => 0,
            'margin_top'           => 0,
            'margin_bottom'        => 0,
            'margin_header'        => 0,
            'margin_footer'        => 0,
            'orientation'          => 'P',
            'display_mode'         => 'fullpage',
            'custom_font_dir'      => '',
            'custom_font_data' 	   => [],
            'default_font_size'    => '12',
        ]);
        $pdf->getMpdf()->SetWatermarkText(strtoupper($invoice->status->name));
        $pdf->getMpdf()->showWatermarkText = true;

        return $pdf->stream('document.pdf');
    }

    public function print_afour(Invoice $invoice)
    {
        logActivity($invoice->id, $invoice->invoice_number,'Print Invoice A4 Status:'.$invoice->status->name);

        $data['invoice'] = $invoice;
        $data['store'] = $this->settings->store();
        $pdf = PDF::loadView("print.pos_afour",$data);
        $pdf->getMpdf()->SetWatermarkText(strtoupper($invoice->status->name));
        $pdf->getMpdf()->showWatermarkText = true;

        return $pdf->stream('document.pdf');
    }

    public function print_way_bill(Invoice $invoice)
    {
        logActivity($invoice->id, $invoice->invoice_number,'Print Invoice Way Bill Status:'.$invoice->status->name);

        $data['invoice'] = $invoice;
        $data['store'] = $this->settings->store();
        $pdf = PDF::loadView("print.pos_afour_waybill",$data);
        $pdf->getMpdf()->SetWatermarkText(strtoupper($invoice->status->name));
        $pdf->getMpdf()->showWatermarkText = true;
        return $pdf->stream('document.pdf');
    }

    public function view(Invoice $invoice)
    {
        $data = [];

        $data['invoice'] = $invoice;

        logActivity($invoice->id, $invoice->invoice_number,'Invoice viewed :'.$invoice->status->name);

        return setPageContent('invoiceandsales.show', $data);
    }

    public function edit(Invoice $invoice)
    {
        $data = [];

        $data['title'] = 'Edit ';
        $data['subtitle'] = 'Update Already Generated ';
        $data['invoice'] = $invoice;

        logActivity($invoice->id, $invoice->invoice_number,'Invoice edit/update page was viewed :'.$invoice->status->name);

        return setPageContent('invoiceandsales.form', $data);
    }

    public function applyInvoiceDiscount(Invoice $invoice)
    {

    }

    public function applyProductDiscount(Invoice $invoice)
    {
        $data = [];

        $data['title'] = 'Product Discount';
        $data['subtitle'] = 'Apply Product Discount ';
        $data['invoice'] = $invoice;

        logActivity($invoice->id, $invoice->invoice_number,'Apply invoice discount was page was viewed :'.$invoice->status->name);

        return setPageContent('invoiceandsales.applyproductdiscount', $data);
    }

    public function destroy(Invoice $invoice)
    {

    }

    public function update(Invoice $invoice)
    {

    }

    public function dispatchInvoice(Invoice $invoice)
    {

    }

}

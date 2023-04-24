<?php

namespace App\Repositories;

use App\Jobs\AddLogToCustomerLedger;
use App\Jobs\AddLogToProductBinCard;
use App\Models\Invoice;
use App\Models\Invoiceitem;
use App\Models\Invoiceitembatch;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class InvoiceRepository
{
    public function __construct()
    {
        //
    }

    public function validateInvoiceForPayment(Invoice $invoice) : array
    {
        $items = $invoice->invoiceitems;
        $errors = [];
        $stockBatches = [];
        foreach ($items as $item)
        {
            $batches = $item->stock->pingSaleableBatches($item->quantity);

            if($batches === false)
            {
                $errors[$item->stock->id] = "Not enough available quantity to process ".$item->stock->name." for payment, Available quantity is ".$item->stock->quantity;
            }
            else {
                $stockBatches[$item->id] = $batches;
            }
        }

        if(count($errors) > 0) return ['status' => false, 'errors'=> $errors];

        return ['status'=> true, 'batches'=>$stockBatches, 'items'=>$items];
    }


    public function removeStockInInvoice($batches,  $items)
    {

        $bincards = [];

        foreach ($items as $item)
        {
            $item->stock->removeSaleableBatches($batches[$item->id]);

            $invoiceItemBatches =  [];
            foreach ($batches[$item->id] as $key=>$batch)
            {
                $invoiceItemBatches[] = new Invoiceitembatch([
                    'invoice_id' => $item->invoice_id,
                    'stock_id' => $item->stock_id,
                    'stockbatch_id' => $key,
                    'customer_id' => $item->customer_id,
                    'batchno' =>$batch['batch_number'],
                    'cost_price' => $item->stock->cost_price,
                    'selling_price' =>  $item->stock->selling_price,
                    'profit' =>  $item->stock->selling_price - $item->stock->cost_price,
                    'incentives' => (($item->incentives_percentage / 100) * $item->stock->selling_price) *$item->quantity,
                    'quantity' => $batch['qty'],
                    'invoice_date' => $item->invoice_date,
                    'sales_time' => $item->sales_time,
                ]);

                $bincards[] = [
                    'stock_id' => $item->stock_id,
                    'stockbatch_id' => $key,
                    'user_id' => auth()->id(),
                    'in' => 0,
                    'out' => 0,
                    'date_added'=>dailyDate(),
                    'sold' =>  $batch['qty'],
                    'return' => 0,
                    'total' =>  $item->stock->quantity,
                    'type' => 'SOLD'
                ];

            }

            $item->invoiceitembatches()->saveMany($invoiceItemBatches);


        }

        dispatch(new AddLogToProductBinCard($bincards));
    }

    public function createInvoice(array $data, array $items) : Invoice
    {
        $data['status_id'] = status('Draft');
        $data['created_by'] = auth()->id();
        $data['last_updated_by'] = auth()->id();
        $data['invoice_date'] = dailyDate();
        $data['sales_time'] = Carbon::now()->toDateTimeLocalString();

        $validatedItems = $this->validateInvoiceItems($data, $items);

        $invoiceItems = $validatedItems['items']; unset($validatedItems['items']);

        $data = array_merge($data, $validatedItems);

        $data['discount_type'] = "None";
        $data['discount_amount'] =0;
        $data['total_amount_paid'] = 0;
        $data['vat'] = 0;
        $data['vat_amount'] = 0;

        $invoice = Invoice::create($data);

        $invoice->invoiceitems()->saveMany($invoiceItems);

        logActivity($invoice->id, $invoice->invoice_number,'Invoice was generated status :'.$invoice->status->name);

        dispatch(new AddLogToCustomerLedger([
            'payment_id' => NULL,
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'amount' => -($invoice->sub_total - $invoice->discount_amount),
            'transaction_date' => $invoice->invoice_date,
            'user_id' => auth()->id(),
        ]));

        return $invoice;

    }


    private function validateInvoiceItems(array $data, array $items)
    {

        $stocks = Stock::wherein('id', Arr::pluck($items, 'stock_id'))->get();
        $_stock = [];
        $invoiceItems = [];
        foreach($stocks as $stock)
        {
            $_stock[$stock->id] = $stock->toArray();
        }

        foreach ($items as $key=>$item)
        {
            $items[$key]['customer_id'] = $data['customer_id'];
            $items[$key]['status_id'] = $data['status_id'];
            $items[$key]['invoice_date'] = $data['invoice_date'];
            $items[$key]['sales_time'] = $data['sales_time'];
            $items[$key]['cost_price'] = $_stock[$items[$key]['stock_id']]['cost_price'];
            $items[$key]['selling_price'] = $_stock[$items[$key]['stock_id']]['selling_price'];
            $items[$key]['profit'] = $_stock[$items[$key]['stock_id']]['selling_price'] -  $_stock[$items[$key]['stock_id']]['cost_price'];
            $items[$key]['total_cost_price'] =  $_stock[$items[$key]['stock_id']]['cost_price'] * $items[$key]['quantity'];
            $items[$key]['total_selling_price'] =  $_stock[$items[$key]['stock_id']]['selling_price'] * $items[$key]['quantity'];
            $items[$key]['total_profit'] =  $items[$key]['profit'] * $items[$key]['quantity'];
            $items[$key]['total_incentives'] =  ( $_stock[$items[$key]['stock_id']]['selling_price'] * $_stock[$items[$key]['stock_id']]['incentives_percentage']) *  $items[$key]['quantity'];

            $items[$key]['discount_type'] = "None";
            $items[$key]['discount_amount'] = 0;
            $invoiceItems[] =new Invoiceitem($items[$key]);
        }

        $itemsCollection = collect($items);

      return [
           'sub_total' => $itemsCollection->sum('total_selling_price'),
           'total_cost' => $itemsCollection->sum('total_cost_price'),
           'total_profit' => $itemsCollection->sum('total_profit'),
           'total_incentives' =>  $itemsCollection->sum('total_incentives'),
           'items' => $invoiceItems
       ];

    }


    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->update(['status_id'=>status("Cancelled")]);
        logActivity($invoice->id, $invoice->invoice_number,'Invoice was cancelled status :'.$invoice->status->name);
    }




    public function update(Invoice $invoice, array &$data, array $items) : Invoice
    {
        $data['status_id'] = status('Draft');
        $data['last_updated_by'] = auth()->id();
        $data['invoice_date'] = dailyDate();
        $data['sales_time'] = Carbon::now()->toDateTimeLocalString();

        $validatedItems = $this->validateInvoiceItems($data, $items);

        $invoiceItems = $validatedItems['items']; unset($validatedItems['items']);

        $data = array_merge($data, $validatedItems);

        $data['discount_type'] = "None";
        $data['discount_amount'] =0;
        $data['total_amount_paid'] = 0;
        $data['vat'] = 0;
        $data['vat_amount'] = 0;

        $invoice->update($data);

        $invoice->invoiceitems()->delete();

        $invoice->invoiceitembatches()->delete();

        //check if the invoice has been paid for if yes please return the stock

        $invoice->invoiceitems()->saveMany($invoiceItems);

        logActivity($invoice->id, $invoice->invoice_number,'Invoice was update status :'.$invoice->status->name);

        return $invoice;
    }

}

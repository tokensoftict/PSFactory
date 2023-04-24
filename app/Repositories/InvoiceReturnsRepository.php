<?php

namespace App\Repositories;

use App\Models\InvoiceReturn;
use App\Models\InvoiceReturnsItem;

class InvoiceReturnsRepository
{
    public function __construct()
    {
        //
    }


    public function createReturns(array $data) : InvoiceReturn
    {
        $totals = self::calculateTotal($data);

        $items = $data['items']; unset($data['items']);

        $data['sub_total'] = $totals['sub_total'];

        $returns = InvoiceReturn::create($data);

        $returns->invoice_returns_items()->saveMany($totals['items']);

        return $returns;
    }

    public function updateReturns(InvoiceReturn $invoiceReturn, array $data)  : InvoiceReturn
    {
        $invoiceReturn->invoice_returns_items()->delete();

        $totals = self::calculateTotal($data);

        $items = $data['items']; unset($data['items']);

        $data['sub_total'] = $totals['sub_total'];

        $invoiceReturn->update($data);

        $invoiceReturn->invoice_returns_items()->saveMany($totals['items']);

        return $invoiceReturn;
    }

    public static function calculateTotal(array $data) : array
    {
        $total = 0;
        $cost_total = 0;
        $total_profit = 0;
        $invoice_return_items = [];

        $items = $data['items'];

        foreach($items as $item){

            $total += $item['total_selling_price'];
            $cost_total += $item['total_cost_price'];
            $total_profit +=$item['total_profit'];

            $invoice_return_items[] = new InvoiceReturnsItem([
                'invoice_id' => $data['invoice_id'],
                'customer_id' => $data['customer_id'],
                'status_id' => status("Pending"),
                'quantity' => $item['returnquantity'],
                'pieces' => 0,//$item['pieces'],
                'added_by' => auth()->id(),
                'cost_price' => $item['cost_price'],
                'stock_id' => $item['stock_id'],
                'selling_price' => $item['selling_price'],
                'total_cost_price' => $item['total_cost_price'],
                'total_selling_price' => $item['total_selling_price'],
                'total_profit' => $item['total_profit']
            ]);

        }

        return [
            'sub_total' => $total,
            'cost_total' => $cost_total,
            'total_profit' => $total_profit,
            'items' => $invoice_return_items
        ];
    }

}

<?php

namespace App\Http\Livewire\InvoiceAndSales\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Models\Invoice;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invoiceitem;

class IncentiveReportDatatable extends ExportDataTableComponent
{

    public  array $filters;

    use SimpleDatatableComponentTrait;

    protected $model = Invoiceitem::class;

    public function builder(): Builder
    {
        return Invoiceitem::query()->select('*')->filterdata($this->filters);
    }

    public static function  mountColumn() : array
    {
        return [
            Column::make("Product", "stock.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable()->searchable(),
            Column::make("Customer", "customer.firstname")
                ->format(fn($value, $row, Column $column)=> $row->customer->firstname." ".$row->customer->lastname)
                ->sortable()->searchable(),
            Column::make("Department", "department.name")
                ->sortable()->searchable(),
            Column::make("Selling Price", "selling_price")
                ->format(fn($value, $row, Column $column)=> money($row->selling_price))
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->format(fn($value, $row, Column $column)=> money($row->quantity))
                ->sortable(),
            Column::make("Incentive", "total_incentives")
                ->format(fn($value, $row, Column $column)=> money($value))
                ->sortable(),
            Column::make("Total", "total_selling_price")
                ->format(fn($value, $row, Column $column)=> money($row->total_selling_price))
                ->sortable(),
            Column::make("Date", "invoice.invoice_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($value))
                ->sortable(),



        ];
    }

}

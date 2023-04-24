<?php

namespace App\Http\Livewire\InvoiceAndSales\Returns\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\InvoiceReturnsItem;
use Illuminate\Database\Eloquent\Builder;

class InvoiceReturnItemsDatatable extends DataTableComponent
{

    use SimpleDatatableComponentTrait;

    public array $filters;

    protected $model = InvoiceReturnsItem::class;

    public function builder(): Builder
    {

        return InvoiceReturnsItem::query()->select('*')->filterdata($this->filters);

    }


    public static function  mountColumn() : array
    {
        return [
            Column::make("Return Reference", "invoice_return.return_number")
                ->sortable()->searchable(),
            Column::make("Customer", "customer.firstname")
                ->format(fn($value, $row, Column $column)=> $row->customer->firstname." ".$row->customer->lastname)
                ->sortable()->searchable(),
            Column::make("Product", "stock.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable()->searchable(),
            Column::make("Quantity", "quantity")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Selling price", "selling_price")
                ->format(fn($value, $row, Column $column)=> money($value))
                ->sortable(),
            Column::make("Total Selling price", "total_selling_price")
                ->format(fn($value, $row, Column $column)=> money($value))
                ->sortable(),
            Column::make("Date", "invoice_return.return_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($row->return_date))
                ->sortable(),
            Column::make("Time", "invoice_return.return_time")
                ->format(fn($value, $row, Column $column)=> twelveHourClock($row->return_time))
                ->sortable(),
            Column::make("By", "invoice_return.create_by.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Action","invoice_return.id")
                ->format(function($value, $row, Column $column) {
                    $html = "No Action";
                    if( userCanView('returns.view')) {
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if (userCanView('returns.view')) {
                            $html .= '<a href="' . route('returns.view', $row->invoice_return->id) . '" class="dropdown-item">View Invoice Return</a></li>';
                        }
                        $html .= '</ul></div>';

                        return $html;
                    }
                })
                ->html()
        ];
    }

}

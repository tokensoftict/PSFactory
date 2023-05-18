<?php

namespace App\Http\Livewire\InvoiceAndSales\Returns\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\InvoiceReturn;
use Illuminate\Database\Eloquent\Builder;

class InvoiceReturnDatatable extends DataTableComponent
{
    use SimpleDatatableComponentTrait;

    protected $model = InvoiceReturn::class;


    public array $filters = [];

    public function builder(): Builder
    {

        return InvoiceReturn::query()->select('*')->filterdata($this->filters);

    }





    public static function  mountColumn() : array
    {
        return [
            Column::make("Return Reference", "return_number")
                ->sortable()->searchable(),
            Column::make("Invoice Reference", "invoice.invoice_number")
                ->sortable()->searchable(),
            Column::make("Customer", "customer.firstname")
                ->format(fn($value, $row, Column $column)=> $row->customer->firstname." ".$row->customer->lastname)
                ->sortable()->searchable(),
            Column::make("Department", "department.name")
                ->sortable()->searchable(),
            Column::make("Sub total", "sub_total")
                ->format(fn($value, $row, Column $column)=> money($row->sub_total))
                ->sortable(),
            Column::make("Status", "status.name")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),
            Column::make("Reason", "invoiceReturnsReason.title")
                ->format(fn($value, $row, Column $column) => $value)->html()
                ->sortable(),
            Column::make("Date", "return_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($row->return_date))
                ->sortable(),
            Column::make("Time", "return_time")
                ->format(fn($value, $row, Column $column)=> twelveHourClock($row->return_time))
                ->sortable(),
            Column::make("By", "create_by.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column) {
                    $html = "No Action";
                    if(userCanView('returns.edit') || userCanView('returns.view') || userCanView('returns.destroy')) {
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if (userCanView('returns.view')) {
                            $html .= '<a href="' . route('returns.view', $row->id) . '" class="dropdown-item">View Invoice Return</a></li>';
                        }


                        if (userCanView('returns.edit') && $row->status_id != status('Approved')) {
                            $html .= '<a href="' . route('returns.edit', $row->id) . '" class="dropdown-item">Edit Invoice Return</a></li>';
                        }


                        $html .= '</ul></div>';

                        return $html;
                    }
                })
                ->html()
        ];
    }


}

<?php

namespace App\Http\Livewire\InvoiceAndSales\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invoice;

class InvoiceDataTable extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait,LivewireAlert;

    protected $model = Invoice::class;

    public array $filters = [];

    public function builder(): Builder
    {

        return Invoice::query()->select('*')->filterdata($this->filters);


    }

    public static function  mountColumn() : array
    {
        return [
            Column::make("Invoice number", "invoice_number")
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
            Column::make("Discount", "discount_amount")
                ->format(fn($value, $row, Column $column)=> money($row->discount_amount))
                ->sortable(),
            Column::make("Total paid", "total_amount_paid")
                ->format(fn($value, $row, Column $column)=> money($row->total_amount_paid))
                ->sortable(),
            Column::make("Date", "invoice_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($row->invoice_date))
                ->sortable(),
            Column::make("Time", "sales_time")
                ->format(fn($value, $row, Column $column)=> twelveHourClock($row->sales_time))
                ->sortable(),
            Column::make("By", "last_updated.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = "No Action";
                    if(can(['view','edit','printAfour','printThermal','printWaybill','delete'], $row)) {
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';
                        if (auth()->user()->can('view', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.view', $row->id) . '" class="dropdown-item">Invoice Details</a></li>';
                        }
                        if (auth()->user()->can('edit', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.edit', $row->id) . '" class="dropdown-item">Edit Invoice</a></li>';
                        }
                        if (auth()->user()->can('printAfour', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.print_afour', $row->id) . '" class="dropdown-item print">Print A4</a></li>';
                        }

                        if (auth()->user()->can('printThermal', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.pos_print', $row->id) . '" class="dropdown-item print">Print Thermal</a></li>';
                        }

                        if (auth()->user()->can('printWaybill', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.print_way_bill', $row->id) . '" class="dropdown-item print">Print Waybill</a></li>';
                        }

                        if (auth()->user()->can('delete', $row)) {
                            $html .= '<a href="' . route('invoiceandsales.destroy', $row->id) . '" href="javascript:" class="dropdown-item">Delete Invoice</a></li>';
                        }

                        $html .= '</ul></div>';
                    }
                    return $html;
                })
                ->html()
        ];
    }
    /*
        public function columns(): array
        {
            return [
                Column::make("Id", "id")
                    ->sortable(),
                Column::make("Invoice number", "invoice_number")
                    ->sortable(),
                Column::make("Customer id", "customer_id")
                    ->sortable(),
                Column::make("Discount type", "discount_type")
                    ->sortable(),
                Column::make("Discount amount", "discount_amount")
                    ->sortable(),
                Column::make("Discount value", "discount_value")
                    ->sortable(),
                Column::make("Status id", "status_id")
                    ->sortable(),
                Column::make("Payment id", "payment_id")
                    ->sortable(),
                Column::make("Sub total", "sub_total")
                    ->sortable(),
                Column::make("Total amount paid", "total_amount_paid")
                    ->sortable(),
                Column::make("Total profit", "total_profit")
                    ->sortable(),
                Column::make("Total cost", "total_cost")
                    ->sortable(),
                Column::make("Total incentives", "total_incentives")
                    ->sortable(),
                Column::make("Vat", "vat")
                    ->sortable(),
                Column::make("Vat amount", "vat_amount")
                    ->sortable(),
                Column::make("Created by", "created_by")
                    ->sortable(),
                Column::make("Last updated by", "last_updated_by")
                    ->sortable(),
                Column::make("Voided by", "voided_by")
                    ->sortable(),
                Column::make("Invoice date", "invoice_date")
                    ->sortable(),
                Column::make("Sales time", "sales_time")
                    ->sortable(),
                Column::make("Void reason", "void_reason")
                    ->sortable(),
                Column::make("Date voided", "date_voided")
                    ->sortable(),
                Column::make("Void time", "void_time")
                    ->sortable(),
                Column::make("Picked by", "picked_by")
                    ->sortable(),
                Column::make("Checked by", "checked_by")
                    ->sortable(),
                Column::make("Packed by", "packed_by")
                    ->sortable(),
                Column::make("Dispatched by", "dispatched_by")
                    ->sortable(),
                Column::make("Created at", "created_at")
                    ->sortable(),
                Column::make("Updated at", "updated_at")
                    ->sortable(),
            ];
        }
    */
}

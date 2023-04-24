<?php

namespace App\Http\Livewire\PurchaseOrder\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchaseorderitem;
use Illuminate\Database\Eloquent\Builder;

class PurchaseOrderItemDatatable extends DataTableComponent
{

    use SimpleDatatableComponentTrait;

    public array $filters = [];

    protected $model = Purchaseorderitem::class;

    public function builder(): Builder
    {
        return Purchaseorderitem::query()->select('*')->filterdata($this->filters);

    }

    public function columns(): array
    {
       return [
           Column::make("Reference", "purchaseorder.reference")
               ->sortable(),
           Column::make("Supplier", "purchaseorder.supplier.name")
               ->format(fn($value, $row, Column $column)=> $value)
               ->searchable()
               ->sortable(),
           Column::make("Purchase date", "purchaseorder.purchase_date")
               ->format(fn($value, $row, Column $column)=> eng_str_date($value))
               ->sortable(),

           Column::make("Cost Price", "cost_price")
               ->format(fn($value, $row, Column $column)=> number_format($row->cost_price,2))
               ->sortable(),
           Column::make("Measurement", "measurement")
               ->format(fn($value, $row, Column $column)=> number_format($value,2).$row->unit)
               ->sortable(),
           Column::make("Status", "purchaseorder.status.name")
               ->format(fn($value, $row, Column $column) => showStatus($value))->html()
               ->sortable(),
           Column::make("Updated By", "purchaseorder.update_by.name")
               ->format(fn($value, $row, Column $column)=> $value)
               ->sortable(),
           Column::make("Action","id")
               ->format(function($value, $row, Column $column){

                   $html = 'No Action';
                   if(auth()->user()->can(["edit","view"], $row)) {
                       $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                       $html .= '<ul class="dropdown-menu dropdown-menu-end">';
                       if(auth()->user()->can('edit',$row->purchaseorder)){
                       $html .= '<a href="' . route('purchaseorders.show', $row->purchaseorder_id) . '" class="dropdown-item">View Purchase</a></li>';
                       }
                       if(auth()->user()->can('edit',$row->purchaseorder)){
                       $html .= '<a href="' . route('purchaseorders.edit', $row->purchaseorder_id) . '" class="dropdown-item">Edit Purchase</a></li>';
                       }

                       $html .= '</ul>';
                   }
                   return $html;
               })
               ->html()
       ];
    }

    /*
     *  return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Purchaseorder id", "purchaseorder_id")
                ->sortable(),
            Column::make("Purchase type", "purchase_type")
                ->sortable(),
            Column::make("Purchase id", "purchase_id")
                ->sortable(),
            Column::make("Batch type", "batch_type")
                ->sortable(),
            Column::make("Batch id", "batch_id")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            Column::make("Department id", "department_id")
                ->sortable(),
            Column::make("Measurement", "measurement")
                ->sortable(),
            Column::make("Cost price", "cost_price")
                ->sortable(),
            Column::make("Selling price", "selling_price")
                ->sortable(),
            Column::make("Added by", "added_by")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
     */
}

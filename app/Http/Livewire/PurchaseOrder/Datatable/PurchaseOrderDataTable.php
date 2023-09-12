<?php

namespace App\Http\Livewire\PurchaseOrder\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Events\CompletePuchaseOrderEvent;
use App\Models\Purchaseorder;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PurchaseOrderDataTable extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait;

    public array $filters = [];

    protected $model = Purchaseorder::class;



    public function builder(): Builder
    {
        return Purchaseorder::query()->select('*')->filterdata($this->filters)->orderBy('purchaseorders.id', 'DESC');

    }


    public static function mountColumn() : array
    {
        return  [
            Column::make("Reference", "reference")
                ->sortable(),
            Column::make("Supplier", "supplier.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->searchable()
                ->sortable(),
            Column::make("Purchase date", "purchase_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($value))
                ->sortable(),
            Column::make("Total", "total")
                ->format(fn($value, $row, Column $column)=> number_format($row->total,2))
                ->sortable(),
            Column::make("Status", "status.name")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),
            Column::make("Updated By", "update_by.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = 'No Action';

                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if (auth()->user()->can("view", $row)) {
                            $html .= '<a href="' . route('purchaseorders.show', $row->id) . '" class="dropdown-item">View Purchase</a></li>';
                        }
                        if (auth()->user()->can("edit", $row)) {
                            $html .= '<a href="' . route('purchaseorders.edit', $row->id) . '" class="dropdown-item">Edit Purchase</a></li>';
                        }
                        if (auth()->user()->can("complete", $row)) {
                            $html .= '<a onclick="confirm(\'Are you sure you want to complete this purchase order ?\') || event.stopImmediatePropagation()" wire:click.prevent="completePurchaseOrder(' . $row->id . ')" href="javascript:" class="dropdown-item">Complete Purchase</a></li>';
                        }
                        if (auth()->user()->can("delete", $row)) {
                            $html .= '<a href="javascript:" onclick="confirm(\'Are you sure you want to delete this purchase order ?\') || event.stopImmediatePropagation()" wire:click.prevent="deletePurchaseOrder(' . $row->id . ')"  class="dropdown-item">Delete Purchase</a></li>';
                        }


                        $html .= '</ul>';
                    return $html;
                })
                ->html()
        ];
    }


    public function completePurchaseOrder(PurchaseOrder $purchaseOrder)
    {

        event(new CompletePuchaseOrderEvent($purchaseOrder));

        $this->alert(
            "success",
            "Purchase Order",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Purchase Order has been completed successfully!.",
            ]
        );

        $this->emit('$refresh',[]);
    }


    public function deletePurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        $this->alert(
            "success",
            "Purchase Order",
            [
                'position' => 'center',
                'timer' => 1000,
                'toast' => false,
                'text' =>  "Purchase Order has been deleted successfully!.",
            ]
        );

        return redirect()->route('purchaseorders.index');
    }

}

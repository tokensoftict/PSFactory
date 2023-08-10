<?php

namespace App\Http\Livewire\ProductModule\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stock;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class ProductComponentDatatable extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait;

    protected $model = Stock::class;

    public array $filters = [];

    public function builder(): Builder
    {
        return Stock::query()->select('*')->filterdata($this->filters);

    }

    public static function mountColumn() : array
    {
        return  [
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("Category", "category.name")
                ->format(fn($value, $row, Column $column)=> isset($row->category->name) ? $row->category->name : "Un-categorized")
                ->sortable()->searchable(),
            Column::make("Lead Time", "lead_time")
                ->sortable(),
            Column::make("Cost Price", "cost_price")
                ->format(fn($value, $row, Column $column)=> number_format($row->cost_price,2))
                ->sortable(),
            Column::make("Selling Price", "selling_price")
                ->format(fn($value, $row, Column $column)=> number_format($row->selling_price,2))
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->format(fn($value, $row, Column $column)=> $row->quantity)
                ->sortable(),
            Column::make("Pieces", "pieces")
                ->format(fn($value, $row, Column $column)=> $row->pieces)
                ->sortable(),
            Column::make("Carton", "carton")
                ->format(fn($value, $row, Column $column)=> $row->carton)
                ->sortable(),
            BooleanColumn::make('Expiry','expiry')
                ->yesNo(),
            Column::make("Status", "id")
                ->format(function ($value, $row, Column $column) {
                    if (userCanView('product.toggle')){
                        return '<div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle(' . $value . ')" id="user' . $value . '" type="checkbox" class="form-check-input" id="customSwitch1" ' . ($row->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>
                                    </div>';
                    }
                    else {
                        return ' <label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>';
                    }
                })->html(),
            Column::make("Updated By", "last_updated.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = 'No Action';
                    if(userCanView('product.show') || userCanView('product.update')){
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';

                        $html .='<ul class="dropdown-menu dropdown-menu-end">';
                        if(userCanView('product.show')) {
                            $html .= '<a href="' . route('product.show', $row->id) . '" class="dropdown-item">View Stock</a></li>';
                        }
                        if(userCanView('product.edit')) {
                            $html .= '<a href="' . route('product.edit', $row->id) . '" class="dropdown-item">Edit Stock</a></li>';
                        }
                        $html .='</ul>';
                    }

                    return $html;
                })
                ->html()
        ];
    }


    public function toggle($id)
    {
        $product = Stock::find($id);
        $product->status = !$product->status;
        $product->save();
        $this->emit('$refreshData');
    }


}

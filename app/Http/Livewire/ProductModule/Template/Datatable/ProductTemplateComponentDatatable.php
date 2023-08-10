<?php

namespace App\Http\Livewire\ProductModule\Template\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Models\Stock;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ProductionTemplate;


class ProductTemplateComponentDatatable extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait;

    protected $model = ProductionTemplate::class;

    public Stock $product;

    public array $filters = [];

    public function builder(): Builder
    {
        $templates =  ProductionTemplate::query()->select('production_templates.status')->filterdata($this->filters);

        if(isset($this->product->id))
        {
            $templates->where('stock_id', $this->product->id); // filter by stock if stock is present
        }

        $templates->with(['stock','last_updated']);

        return $templates;

    }

    public static function mountColumn() : array
    {
        return [
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Stock Name", "stock.name")
                ->searchable()
                ->sortable(),
            Column::make("Expected quantity", "expected_quantity")
                ->format(fn($value, $row, Column $column)=> number_format($row->expected_quantity))
                ->sortable(),
            Column::make("Status", "id")
                ->format(function ($value, $row, Column $column){
                    if (userCanView('template.toggle')) {
                        return '<div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle(' . $value . ')" id="user' . $value . '" type="checkbox" class="form-check-input" id="customSwitch1" ' . ($row->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>
                                    </div>';
                    }else {
                        return '<label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>';
                    }
                })->html(),
            Column::make("Date created", "date_created")
                ->format(fn($value, $row, Column $column)=> eng_str_date($row->date_created))
                ->sortable(),
            Column::make("Last Updated", "last_updated_by")
                ->format(fn($value, $row, Column $column)=> $row->last_updated->name)
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = "No Action";
                    if (userCanView('template.show') ||  userCanView('template.update')) {

                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';

                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';
                        if (userCanView('template.show')) {
                            $html .= '<a href="' . route('template.show', $row->id) . '" class="dropdown-item">View Template</a></li>';
                        }
                        if (userCanView('template.update')) {
                            $html .= '<a href="' . route('template.update', $row->id) . '" class="dropdown-item">Edit Template</a></li>';
                        }
                    }
                    $html .='</ul>';
                    return $html;
                })
                ->html()
        ];
    }


    public function toggle($id)
    {
        $template = ProductionTemplate::find($id);
        $template->status = !$template->status;
        $template->save();
    }
}

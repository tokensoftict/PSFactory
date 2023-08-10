<?php

namespace App\Http\Livewire\RawMaterial\Returns\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\MaterialReturnItem;
use Illuminate\Database\Eloquent\Builder;

class MaterialReturnItemsDatatable extends ExportDataTableComponent
{
    protected $model = MaterialReturnItem::class;

    use SimpleDatatableComponentTrait;

    public array $filters = [];

    public function builder(): Builder
    {
        return  MaterialReturnItem::query()->select("*")->filterdata($this->filters);

    }

    public static function mountColumn() : array
    {
        return [
            Column::make("Material", "name")
                ->searchable()
                ->sortable(),
            Column::make("Measurement", "convert_measurement")
                ->format(function($value, $row, Column $column) {
                    return $value." ".$row->convert_unit;
                })
                ->sortable(),
            Column::make("Return Date", "material_return.return_date")
                ->format(function($value, $row, Column $column){
                    return eng_str_date($value);
                }),
            Column::make("Return time", "material_return.return_time")
                ->format(function($value, $row, Column $column){
                    return twelveHourClock($value);
                })
                ->sortable(),
            Column::make("Returned By", "material_return.return_by.name")
                ->format(fn($value, $row, Column $column)=> $value ?? "")
                ->sortable(),
            Column::make("Resolved By", "resolve_by.name")
                ->format(fn($value, $row, Column $column)=>  $value ?? "")
                ->sortable(),
            Column::make("Status", "material_return.status.name")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),
            Column::make("Action","material_return.id")
                ->format(function($value, $row, Column $column){
                    $html = "No Action";
                    if (userCanView('rawmaterial.showreturn')){
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .='<ul class="dropdown-menu dropdown-menu-end">';

                        $html.='<a href="'.route('rawmaterial.showreturn',$value).'" class="dropdown-item">View all Returned Items</a></li>';

                        $html .='</ul>';
                    }
                    return $html;

                })
                ->html()
        ];
    }
}

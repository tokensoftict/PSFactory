<?php

namespace App\Http\Livewire\RawMaterial\Requests\Datatable;


use App\Classes\ExportDataTableComponent;
use App\Models\MaterialRequestItem;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


class MaterialRequestItemsDatatable extends ExportDataTableComponent
{
    protected $model = MaterialRequestItem::class;

    use SimpleDatatableComponentTrait;

    public array $filters = [];

    public function builder(): Builder
    {
        return  MaterialRequestItem::query()->select("*")->filterdata($this->filters)->orderBy('material_request_items.id', 'DESC');

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
            Column::make("Request Date", "material_request.request_date")
                ->format(function($value, $row, Column $column){
                    return eng_str_date($value);
                }),
            Column::make("Request time", "material_request.request_time")
                ->format(function($value, $row, Column $column){
                    return twelveHourClock($value);
                })
                ->sortable(),
            Column::make("Requested By", "material_request.request_by.name")
                ->format(fn($value, $row, Column $column)=> $value ?? "")
                ->sortable(),
            Column::make("Resolved By", "material_request.resolve_by.name")
                ->format(fn($value, $row, Column $column)=>  $value ?? "")
                ->sortable(),
            Column::make("Status", "material_request.status.name")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),
            Column::make("Action","material_request.id")
                ->format(function($value, $row, Column $column){
                    $html = "No Action";
                    if (userCanView('rawmaterial.showrequest')){
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .='<ul class="dropdown-menu dropdown-menu-end">';

                        $html.='<a href="'.route('rawmaterial.showrequest',$value).'" class="dropdown-item">View all Requested Items</a></li>';

                        $html .='</ul>';
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
            Column::make("Production id", "production_id")
                ->sortable(),
            Column::make("Rawmaterial id", "rawmaterial_id")
                ->sortable(),
            Column::make("Production template id", "production_template_id")
                ->sortable(),
            Column::make("Department id", "department_id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Measurement", "measurement")
                ->sortable(),
            Column::make("Unit", "unit")
                ->sortable(),
            Column::make("Convert measurement", "convert_measurement")
                ->sortable(),
            Column::make("Convert unit", "convert_unit")
                ->sortable(),
            Column::make("Returns", "returns")
                ->sortable(),
            Column::make("Production date", "production_date")
                ->sortable(),
            Column::make("Production time", "production_time")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
     */
}

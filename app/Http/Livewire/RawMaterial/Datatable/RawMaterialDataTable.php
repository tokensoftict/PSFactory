<?php

namespace App\Http\Livewire\RawMaterial\Datatable;

use App\Classes\Settings;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Rawmaterial;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class RawMaterialDataTable extends DataTableComponent
{

    use SimpleDatatableComponentTrait;

    public array $filters =  [];

    public function builder(): Builder
    {
        return Rawmaterial::query()->select('*')->filterdata($this->filters);
    }

    private static function mountColumn() : array
    {
        return  [
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Measurement", "measurement")
                ->format(function($value, $row, Column $column){
                    return $row->measurement." ".$row->materialtype->storage_measurement_unit;
                })
                ->searchable()
                ->sortable(),
            Column::make("Cost price", "cost_price")
                ->format(fn($value, $row, Column $column)=> money($row->cost_price))
                ->sortable(),
            Column::make("Lead Time", "lead_time")
                ->sortable(),
            Column::make("Department", "department.name")
                ->searchable()
                ->sortable(),
            Column::make("Description", "description"),

            Column::make("Type", "materialtype.name")
                ->searchable(),
            BooleanColumn::make('Expiry','expiry')
                ->yesNo(),
            BooleanColumn::make('Divide By Carton','divide_by_carton')
                ->yesNo(),
            Column::make("Status", "id")
                ->format(function ($value, $row, Column $column) {
                    if (userCanView('rawmaterial.toggle')) {
                        return '<div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle(' . $value . ')" id="user' . $value . '" type="checkbox" class="form-check-input" id="customSwitch1" ' . ($row->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>
                                    </div>';
                    }else{
                        return '<label class="form-check-label" for="customSwitch1">' . ($row->status ? 'Active' : 'Inactive') . '</label>';
                    }
                })->html(),
            Column::make("Action","status")
                ->format(function($value, $row, Column $column){
                    $html = "No Action";
                        if(userCanView('rawmaterial.update')){
                        $html = '<a class="btn btn-outline-primary btn-sm edit" wire:click="edit(' . $row->id . ')" href="javascript:void(0);" >

                                    <span wire:loading wire:target="edit(' . $row->id . ')" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                    <i class="fas fa-pencil-alt" wire:loading.remove wire:target="edit(' . $row->id . ')"></i>


                                </a>';


                    }
                        return $html;
                })->html()
        ];
    }
}

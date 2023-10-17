<?php

namespace App\Http\Livewire\RawMaterial\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Nearoutofmaterial;
use Illuminate\Database\Eloquent\Builder;

class MaterialNearoutotstock extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait;

    protected $model = Nearoutofmaterial::class;


    public array $filters;

    public function builder(): Builder
    {
        return Nearoutofmaterial::query()->select('*')->filterdata($this->filters);
    }

    private static function mountColumn() : array
    {
        return [
            Column::make("Name", "rawmaterial.name")
                ->sortable(),
            Column::make("Threshold type", "threshold_type")
                ->sortable(),
            Column::make("To Buy", "toBuy")
                ->format( fn($value, $row, Column $column) => number_format($value))
                ->sortable(),
            Column::make("Threshold", "threshold")
                ->format( fn($value, $row, Column $column) => number_format($value))
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->format( fn($value, $row, Column $column) => number_format($value))
                ->sortable(),
            Column::make("Used", "used")
                ->format( fn($value, $row, Column $column) => number_format($value))
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }


}

<?php

namespace App\Http\Livewire\RawMaterial\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Nearoutofmaterial;
use Illuminate\Database\Eloquent\Builder;

class MaterialNearoutotstock extends DataTableComponent
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
                ->sortable(),
            Column::make("Threshold", "threshold")
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->sortable(),
            Column::make("Used", "used")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }


}

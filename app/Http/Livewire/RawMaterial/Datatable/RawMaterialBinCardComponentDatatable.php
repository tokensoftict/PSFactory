<?php

namespace App\Http\Livewire\RawMaterial\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Rawmaterialbincard;
use Illuminate\Database\Eloquent\Builder;

class RawMaterialBinCardComponentDatatable extends DataTableComponent
{


    protected $model = Rawmaterialbincard::class;

    use SimpleDatatableComponentTrait;

    public array $filters;

    public function builder(): Builder
    {
        return Rawmaterialbincard::query()->select('*')->filterdata($this->filters);
    }

    private static function mountColumn() : array
    {
        return [
            Column::make("Material", "rawmaterial.name")->searchable()->sortable(),
            Column::make("User", "user.name")->sortable()->searchable(),
            Column::make("Type", "type")->sortable(),
            Column::make("Date", "date_added")->format(
                fn($value, $row, Column $column)=> eng_str_date($value)
            )->sortable(),
            Column::make("In", "in")->sortable(),
            Column::make("Out", "out")->sortable(),
            Column::make("Return", "return")->sortable(),
            Column::make("Total", "total")->sortable(),
        ];
    }

  /*
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Rawmaterialbatch id", "rawmaterialbatch_id")
                ->sortable(),
            Column::make("Rawmaterial id", "rawmaterial_id")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("In", "in")
                ->sortable(),
            Column::make("Out", "out")
                ->sortable(),
            Column::make("Return", "return")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
  */
}

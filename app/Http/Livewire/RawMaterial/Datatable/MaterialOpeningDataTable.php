<?php

namespace App\Http\Livewire\RawMaterial\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Rawmaterialopening;
use Illuminate\Database\Eloquent\Builder;

class MaterialOpeningDataTable extends DataTableComponent
{
    use SimpleDatatableComponentTrait;

    protected $model = Rawmaterialopening::class;


    public array $filters;

    public function builder(): Builder
    {

        return Rawmaterialopening::query()->select('*')->filterdata($this->filters);
    }


    private static function mountColumn() : array
    {
        return [
            Column::make("name", "rawmaterial.name")
                ->searchable()
                ->sortable(),
            Column::make("Measurement", "measurement")
                ->sortable(),
            Column::make("Average cost price", "average_cost_price")
                ->format(fn($value, $row, Column $column) => money($value))
                ->sortable(),
            Column::make("Date added", "date_added")
                ->sortable(),
        ];

    }

    /*

    public function columns(): array
    {

    }
    */
}

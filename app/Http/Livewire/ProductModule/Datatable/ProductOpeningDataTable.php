<?php

namespace App\Http\Livewire\ProductModule\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Stockopening;
use Illuminate\Database\Eloquent\Builder;

class ProductOpeningDataTable extends ExportDataTableComponent
{
    use SimpleDatatableComponentTrait;

    protected $model = Stockopening::class;

    public array $filters;

    public function builder(): Builder
    {

        return Stockopening::query()->select('*')->filterdata($this->filters);
    }

    private static function mountColumn() : array
    {
        return [

            Column::make("Name", "stock.name")
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->sortable(),
            Column::make("Pieces", "pieces")
                ->sortable(),
            Column::make("Average cost price", "average_cost_price")
                ->format(fn($value, $row, Column $column) => money($value))
                ->sortable(),
            Column::make("Date added", "date_added")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];

    }

}

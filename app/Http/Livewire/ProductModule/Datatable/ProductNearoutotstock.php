<?php

namespace App\Http\Livewire\ProductModule\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Nearoutofstock;
use Illuminate\Database\Eloquent\Builder;

class ProductNearoutotstock extends DataTableComponent
{

    use SimpleDatatableComponentTrait;

    protected $model = Nearoutofstock::class;

    public array $filters;

    public function builder(): Builder
    {
        return Nearoutofstock::query()->select('*')->filterdata($this->filters);
    }

    private static function mountColumn() : array
    {
        return [
            Column::make("Name", "stock.name")
                ->sortable(),
            Column::make("Threshold type", "threshold_type")
                ->sortable(),
            Column::make("ToBuy", "toBuy")
                ->sortable(),
            Column::make("Threshold", "threshold")
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->sortable(),
            Column::make("Sold", "sold")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }


}

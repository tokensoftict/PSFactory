<?php

namespace App\Http\Livewire\ProductionManager\Datatable;

use App\Classes\Settings;
use App\Traits\SimpleDatatableComponentTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Production;
use Illuminate\Database\Eloquent\Builder;

class ProductionManagerDatatableComponent extends DataTableComponent
{
    protected $model = Production::class;

    public array $filters = [];

    use SimpleDatatableComponentTrait;
    use LivewireAlert;


    public function builder(): Builder
    {
       return Production::query()->select('*')->filterdata($this->filters);

    }


    public static function mountColumn() : array
    {
        return [
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("Product", "stock.name")
                ->sortable()->searchable(),
            Column::make("Department", "department.name")
                ->sortable()->searchable(),
            Column::make("Template", "production_template.name")
                ->sortable()->searchable(),
            Column::make("Batch Number", "batch_number")
                ->sortable()->searchable(),
            Column::make("Yield", "yield_quantity")
                ->sortable(),
            Column::make("Status", "status.name")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),
            Column::make("Created By", "user.name")
                ->sortable()->searchable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = "No action";
                    if(can(['view','edit','transfer','complete','delete'], $row)) {
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';
                        if(auth()->user()->can('view', $row)) {
                            $html .= '<a href="' . route('production.show', $row->id) . '" class="dropdown-item">View Production</a></li>';
                        }
                        if(auth()->user()->can('edit', $row)) {
                            $html .= '<a href="' . route('production.edit', $row->id) . '" class="dropdown-item">Edit Production</a></li>';
                        }
                        if(auth()->user()->can('transfer', $row)) {
                            $html .= '<a href="' . route('production.transfer', $row->id) . '" class="dropdown-item">Transfer Production</a></li>';
                        }
                        if(auth()->user()->can('complete', $row)) {
                            $html .= '<a href="' . route('production.complete', $row->id) . '" href="javascript:" class="dropdown-item">Complete Production</a></li>';
                        }
                        if(auth()->user()->can('delete', $row)) {
                            $html .= '<a onclick="confirm(\'Are you sure you want to delete this production  ?\') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduction(' . $row->id . ')" href="javascript:" class="dropdown-item">Delete Production</a></li>';
                        }

                        $html .= '</ul></div>';
                    }
                    return $html;
                })
                ->html()
        ];
    }


    public function deleteProduction($id)
    {
        $production  = Production::find($id);

        $production->delete();

        $this->alert(
            "success",
            "Production",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Production has been deleted successfully!.",
            ]
        );

    }

}

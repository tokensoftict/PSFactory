<?php

namespace App\Http\Livewire\RawMaterial\Returns\Datatable;

use App\Traits\SimpleDatatableComponentTrait;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\MaterialReturn;
use Illuminate\Database\Eloquent\Builder;

class MaterialReturnDatatable extends DataTableComponent
{
    protected $model = MaterialReturn::class;

    use SimpleDatatableComponentTrait;


    public array $filters = [];

    public function builder(): Builder
    {
        return  MaterialReturn::query()->select("*")
            ->whereHas('material_return_items', function($query){
                if(auth()->user()->department_id === NULL)
                {
                    $query->whereIn('department_id', [1,2]);
                }else {
                    $query->where('department_id', auth()->user()->department_id); // only show material returns items the login user can approve or has approved.
                }
            })
            ->filterdata($this->filters);

    }

    public static function mountColumn() : array
    {
        return [
            Column::make("Return Type", "return_type")
                ->format(function($value, $row, Column $column) {
                    $type = explode('\\',$value);
                    return $type[count($type) -1];
                })
                ->sortable(),
            Column::make("Return Date", "return_date")
                ->format(function($value, $row, Column $column){
                    return eng_str_date($value);
                }),
            Column::make("Return time", "return_time")
                ->format(function($value, $row, Column $column){
                    return twelveHourClock($value);
                })
                ->sortable(),
            Column::make("Returned By", "return_by_id")
                ->format(fn($value, $row, Column $column)=> $row->return_by->name)
                ->sortable(),

            Column::make("Status", "status.id")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),

            Column::make("Action","id")
                ->format(function($value, $row, Column $column) {
                    $html = "No Action";

                    if (userCanView('rawmaterial.showreturns') || (userCanView('rawmaterial.edit_return') && ($row->status->id == status('Pending') || $row->status->id == status('Material-Approval-In-Progress') || $row->status->id == status('Approved')) )){

                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if (userCanView('rawmaterial.showreturns')){
                            $html .= '<a href="' . route('rawmaterial.showreturns', $row->id) . '" class="dropdown-item">View Return </a></li>';
                        }

                        if(userCanView('rawmaterial.edit_return') && $row->status->id == status('Pending')) {
                            $html .= '<a href="' . route('rawmaterial.edit_return', $row->id) . '" class="dropdown-item">Edit Return </a></li>';
                        }

                        $html .= '</ul>';
                    }
                    return $html;
                })
                ->html()
        ];
    }
}

<?php

namespace App\Http\Livewire\RawMaterial\Requests\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Models\Production;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\MaterialRequest;

class MaterialRequestDatatable extends ExportDataTableComponent
{

    use SimpleDatatableComponentTrait;

    protected $model = MaterialRequest::class;

    public array $filters = [];

    public function builder(): Builder
    {
        return  MaterialRequest::query()->select("*")->with(['request'])->filterdata($this->filters)->orderBy('material_requests.id', 'DESC');

    }


    public static function mountColumn() : array
    {
        return [
            Column::make("Request Type", "request_type")
                ->format(function($value, $row, Column $column) {
                    $type = explode('\\',$value);
                    return $type[count($type) -1];
                })
                ->sortable(),
            Column::make("Request Date", "request_date")
                ->format(function($value, $row, Column $column){
                    return eng_str_date($value);
                }),
            Column::make("Production Batch", "id")->format(function($value, $row, Column $column){
                return $row->request->name ?? "N/A";
            })
                ,
            Column::make("Request time", "request_time")
                ->format(function($value, $row, Column $column){
                    return twelveHourClock($value);
                })
                ->sortable(),
            Column::make("Requested By", "request_by_id")
                ->format(fn($value, $row, Column $column)=> $row->request_by->name)
                ->sortable(),

            Column::make("Status", "status.id")
                ->format(fn($value, $row, Column $column) => showStatus($value))->html()
                ->sortable(),

            Column::make("Action","id")
                ->format(function($value, $row, Column $column) {
                    $html = "No Action";
                    if (userCanView('rawmaterial.showrequest') || (userCanView('rawmaterial.edit_request') && ($row->status->id == status('Pending') || $row->status->id == status('Material-Approval-In-Progress') || $row->status->id == status('Approved')) )){
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if (userCanView('rawmaterial.showrequest')){
                            $html .= '<a href="' . route('rawmaterial.showrequest', $row->id) . '" class="dropdown-item">View Request </a></li>';
                        }

                        if(userCanView('rawmaterial.edit_request') && $row->status->id == status('Pending')) {
                            $html .= '<a href="' . route('rawmaterial.edit_request', $row->id) . '" class="dropdown-item">Edit Request </a></li>';
                        }

                        $html .= '</ul>';
                    }
                    return $html;
                })
                ->html()
        ];
    }
}

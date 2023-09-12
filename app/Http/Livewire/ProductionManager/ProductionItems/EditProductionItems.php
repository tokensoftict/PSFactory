<?php

namespace App\Http\Livewire\ProductionManager\ProductionItems;

use App\Models\Department;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use App\Repositories\MaterialRequestRepository;
use App\Traits\ProductionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditProductionItems extends Component
{
    use LivewireAlert, ProductionTrait;

    public Production $production;

    public $departments;

    public array $production_items;

    public function boot()
    {

    }

    public function mount()
    {
        $this->departments = Department::where('status', 1)->where('department_type', 'Store')->get();

        foreach ($this->departments as $department){
            $items =  $this->production->production_material_items()
                ->with(['rawmaterial','rawmaterial.department', 'rawmaterial.materialtype','approved'])
                ->where('department_id', $department->id)->where(function($query){
                    $query->orWhere('status_id', status('Pending'));
                    $query->orWhere('status_id', status('Declined'));
                })->get();
            foreach ($items as $item){
                $this->production_items[$item->id] = $item->measurement;
            }
        }
    }

    public function render()
    {
        return view('livewire.production-manager.production-items.edit-production-items');
    }

    public function saveProductionItems()
    {
        DB::transaction(function(){
            collect($this->production_items)->each(function ($item, $key){
                $prod = ProductionMaterialItem::find($key);
                $prod->measurement = $item;
                $prod->status_id = status('Pending');
                $prod->approved_by = NULL;
                $prod->approved_date = NULL;
                $prod->approved_time = NULL;
                $prod->update();
            });

            $eventData = [
                'request_date' => dailyDate(),
                'request_time' => Carbon::now()->toDateTimeLocalString(),
                'request_type' => Production::class,
                'request_id' => $this->production->id,
                'request_by_id' => auth()->id(),
                'status_id' => status('Pending'),
            ];

            $eventData['material_request_items'] = [];

            foreach ($this->production->production_material_items()
                         ->with(['rawmaterial','rawmaterial.department', 'rawmaterial.materialtype','approved'])
                         ->where(function($query){
                             $query->orWhere('status_id', status('Pending'));
                             $query->orWhere('status_id', status('Declined'));
                         })->get()
                     as $item)
            {
                $eventData['material_request_items'][] = [
                    'name' => $item->name,
                    'requesttype_type' => get_class($item),
                    'requesttype_id' => $item->id,
                    'rawmaterial_id' => $item->rawmaterial_id,
                    'department_id' => $item->department_id,
                    'status_id' => status('Pending'),
                    'measurement' => $item->measurement,
                    'unit' => $item->unit,
                    'convert_measurement' => $item->convert_measurement,
                    'convert_unit' => $item->convert_unit,
                ];
            }

            (new MaterialRequestRepository())->createRequest($eventData);

            $this->production->status_id = status('Waiting-Material');
            $this->production->update();

            $this->alert(
                "success",
                "Production",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  "Production items has been updated successfully / Material request has been re-sent!.",
                ]
            );

            return redirect()->route('production.index');
        });
    }
}

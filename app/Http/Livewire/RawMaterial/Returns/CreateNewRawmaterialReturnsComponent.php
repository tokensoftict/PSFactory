<?php

namespace App\Http\Livewire\RawMaterial\Returns;

use App\Models\Department;
use App\Models\MaterialReturn;
use App\Models\Production;
use App\Repositories\MaterialReturnRepository;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateNewRawmaterialReturnsComponent extends Component
{
    use LivewireAlert;


    protected MaterialReturnRepository $materialReturnRepository;

    public MaterialReturn $materialReturn;

    public $productions;

    public $listDepartments;

    public array $data;

    public array $errors;

    public function boot(MaterialReturnRepository $materialReturnRepository)
    {
        $this->materialReturnRepository = $materialReturnRepository;
    }

    public function mount()
    {
        $this->productions = Production::whereIn('status_id',[
            status('Transferred'),
            status('Complete')
        ])->whereBetween('production_date', [yesterdayDate(),todaysDate()])->get();

        $this->listDepartments = Department::where('status',1)->get();

        $this->data = MaterialReturnRepository::materialReturn(new MaterialReturn());

        if(isset($this->materialReturn->id))
        {
            $this->data = MaterialReturnRepository::materialReturn($this->materialReturn);
        }
    }


    public function returnMaterial()
    {
        $error = false;
        $material_items = [];

        if($this->data['return_id'] !== "") {
            $production = Production::find($this->data['return_id']);
            $material_items = json_decode($this->data['material_return_items'], true);
            foreach ($material_items as $key=>$item) {
                $count = $production->production_material_items()->where('rawmaterial_id', $item['rawmaterial_id'])->
                      first();
               if(!$count){
                   $error = true;
                   if($item['extra'] == "1"){
                       $material_items[$key]["error"] = $item['name']." is not part of raw material listed of selected production";
                   }else{
                       $material_items[$key]["error"] = $item['name']." is not part of extra raw material listed of selected production";
                   }

               }
               else {
                   $returns = $count->returns + $item['measurement'];
                   if($returns > $count->measurement){
                       $error = true;
                       $material_items[$key]["error"] = " You can not return more than ".($count->measurement-$count->returns).' '.$count->unit." for ".$item['name'];
                   }
               }
            }
        }

        if($error === true) {
            $this->data['material_return_items'] = json_encode($material_items);
            $this->alert(
                "error",
                "Material Return",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' =>  "You have an error in your material return form",
                ]
            );
            return  $this->data['material_return_items'];
        }

        if(isset($this->materialReturn->id))
        {
            $this->data['material_return_items'] = json_decode( $this->data['material_return_items'] ,true);
            $return = $this->materialReturnRepository->updateReturn($this->materialReturn, $this->data);
            $message = "Return has been updated and sent successfully!";
        }else{
            $this->data['material_return_items'] = json_decode( $this->data['material_return_items'] ,true);
            $return = $this->materialReturnRepository->createReturn($this->data);
            $message = "Return has been sent successfully!";
        }

        if($return === false)
        {
            $this->alert(
                "error",
                "Unknown error occurred!...",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  $message,
                ]
            );
        }else {
            $this->alert(
                "success",
                "Material Return",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' => $message,
                ]
            );
        }
        return redirect()->route('rawmaterial.returns');
    }


    public function render()
    {
        return view('livewire.raw-material.returns.create-new-rawmaterial-returns-component');
    }
}

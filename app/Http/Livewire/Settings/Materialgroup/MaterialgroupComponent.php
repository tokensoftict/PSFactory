<?php

namespace App\Http\Livewire\Settings\Materialgroup;

use App\Models\Category;
use App\Models\Department;
use App\Models\Manufacturer;
use App\Models\Materialgroup;
use App\Models\Materialtype;
use App\Models\Paymentmethod;
use App\Models\Productionline;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class MaterialgroupComponent extends Component
{
    use SimpleComponentTrait;



    public function mount()
    {

        $this->model = Materialgroup::class;
        $this->modalName = "Material Group";
        $this->data = [
            'name' => ['label' => 'Name', 'type'=>'text'],
        ];

        $this->newValidateRules = [
            'name' => 'required|min:1',
        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();


    }

    public function render()
    {
        return view('livewire.settings.materialgroup.materialgroup-component');
    }


}

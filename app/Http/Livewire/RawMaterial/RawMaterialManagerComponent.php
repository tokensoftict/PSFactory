<?php

namespace App\Http\Livewire\RawMaterial;

use App\Models\Department;
use App\Models\Materialtype;
use App\Models\Rawmaterial;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class RawMaterialManagerComponent extends Component
{
    use SimpleComponentTrait;


    public function mount()
    {
        $this->model = Rawmaterial::class;
        $this->modalName = "Raw Material";
        $this->data = [
            'name' => ['label' => 'Name', 'type'=>'text'],
            'description' => ['label' => 'Description', 'type'=>'textarea'],
            'materialtype_id' => ['label' => 'Material Type', 'type'=>'select',
                'options'=> Materialtype::all()->toArray()
            ],
            'expiry' => ['label' => 'Can Material Expiry', 'type'=>'select',
                'options'=> [
                    ['name'=>'Yes','id'=>"1"],
                    ['name'=>'No','id'=>"0"],
                ]
            ],
            'department_id' => ['label' => 'Department', 'type'=>'select',
                'options'=> Department::where('department_type','Store')->get()->toArray()
            ],
        ];

        $this->newValidateRules = [
            'name' => 'required|min:3',
            'materialtype_id' => 'required',
            'department_id' => 'required',
            'expiry' => 'required',

        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();

    }


    public function render()
    {
        return view('livewire.raw-material.raw-material-manager-component');
    }
}

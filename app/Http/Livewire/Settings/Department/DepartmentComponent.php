<?php

namespace App\Http\Livewire\Settings\Department;

use App\Models\Category;
use App\Models\Department;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class DepartmentComponent extends Component
{

    use SimpleComponentTrait;


    public function mount()
    {
        $this->model = Department::class;

        $this->modalName = "Department";

        $this->data = [
            'name' => ['label' => 'Department Name', 'type'=>'text'],
            'department_type' => ['label' => 'Department Type', 'type'=>'select', 'options'=>
            [
                [
                    'name' => 'Sales',
                    'id' => 'Sales'
                ],
                [
                    'name' => 'Store',
                    'id' => 'Store'
                ]
            ]
            ],
        ];

        $this->newValidateRules = [
            'name' => 'required|min:1',
        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();

    }

    public function render()
    {
        return view('livewire.settings.department.department-component');
    }
}

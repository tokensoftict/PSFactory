<?php

namespace App\Http\Livewire\Settings\Materialtype;

use App\Models\Category;
use App\Models\Department;
use App\Models\Manufacturer;
use App\Models\Materialtype;
use App\Models\Paymentmethod;
use App\Models\Productionline;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class MaterialtypeComponent extends Component
{
    use SimpleComponentTrait;



    public function mount()
    {
        $this->editcallback = [
            'filter_production_measurement_unit'
        ];

        $this->model = Materialtype::class;
        $this->modalName = "Material Type";
        $this->data = [
            'name' => ['label' => 'Name', 'type'=>'text'],
            'storage_measurement_unit' => ['label' => 'Storage Measurement Unit', 'type'=>'select',
                'options' => config('convert'),
                'change' => 'filter_production_measurement_unit'
            ],
            'production_measurement_unit' => ['label' => 'Production Measurement Unit', 'type'=>'select',
                'options' => []
            ],
        ];

        $this->newValidateRules = [
            'name' => 'required|min:1',
            'storage_measurement_unit' => 'required|min:1',
            'production_measurement_unit' => 'required|min:1',
        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();


    }

    public function render()
    {
        return view('livewire.settings.materialtype.materialtype-component');
    }

    public function filter_production_measurement_unit()
    {
        $this->data['production_measurement_unit'] = ['label' => 'Production Measurement Unit', 'type'=>'select',
            'options' => config('convert.'.$this->storage_measurement_unit.".to")
        ];
    }


}

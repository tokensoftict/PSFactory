<?php

namespace App\Http\Livewire\Settings\Tankmanager;

use App\Models\Category;
use App\Models\Department;
use App\Models\Manufacturer;
use App\Models\Paymentmethod;
use App\Models\Productionline;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class TankmanagerComponent extends Component
{

    use SimpleComponentTrait;


    public function mount()
    {
        $this->model = Productionline::class;
        $this->modalName = "Tank or Lines";
        $this->data = [
            'name' => ['label' => 'Tank / Lines', 'type'=>'text'],
            'capacity' => ['label' => 'Capacity', 'type'=>'text'],
        ];

        $this->newValidateRules = [
            'name' => 'required|min:1',
            'capacity' => 'required|min:1',
        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();

    }

    public function render()
    {
        return view('livewire.settings.tankmanager.tankmanager-component');
    }
}

<?php

namespace App\Http\Livewire\ProductionManager\Show;

use App\Models\Department;
use App\Models\Production;
use App\Traits\ProductionTrait;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowProductionComponent extends Component
{
    use LivewireAlert, ProductionTrait;

    public Production $production;

    public $departments;

    public function boot()
    {

    }

    public function mount()
    {
        $this->departments = Department::where('status', 1)->where('department_type', 'Store')->get();
    }

    public function render()
    {
        return view('livewire.production-manager.show.show-production-component');
    }


}

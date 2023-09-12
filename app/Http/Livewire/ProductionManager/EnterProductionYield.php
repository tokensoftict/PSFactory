<?php

namespace App\Http\Livewire\ProductionManager;

use App\Models\Production;
use App\Models\ProductionYieldHistory;
use App\Traits\ProductionTrait;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EnterProductionYield extends Component
{
    use LivewireAlert, ProductionTrait;

    public Production $production;

    public int $yield = 0;

    public function boot()
    {

    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.production-manager.enter-production-yield');
    }


    public function save()
    {

        if($this-> yield == 0 || $this->yield < 0){
            $this->alert(
                "success",
                "Invoice",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' => "Yield value must be greater than zero!",
                ]
            );
        }else {

            ProductionYieldHistory::create([
                'yield' => $this->yield,
                'production_id' => $this->production->id,
                'date_added' => today(),
                'time_added' => now(),
                'user_id' => auth()->id()
            ]);

            $this->yield = 0;


            $this->alert(
                "success",
                "Invoice",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' => "Yield as been enter successfully!",
                ]
            );

            $this->dispatchBrowserEvent("refreshPage", []);
        }
    }

    public function new()
    {
        $this->dispatchBrowserEvent("openModal", []);
    }

    public function deleteItem($id)
    {
        $history = ProductionYieldHistory::find($id);
        if($history) $history->delete();
        $this->alert(
            "success",
            "Invoice",
            [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'text' => "Yield as been deleted successfully!",
            ]
        );

        $this->dispatchBrowserEvent("refreshPage", []);
    }
}

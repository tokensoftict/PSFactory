<?php

namespace App\Http\Livewire\ProductionManager\Transfer;

use App\Models\Production;
use App\Models\ProductTransfer;
use App\Models\Stockbatch;
use App\Repositories\ProductionRepository;
use App\Repositories\ProductProductionTemplateRepository;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TransferProductionComponent extends Component
{
    use LivewireAlert;

    public Production $production;

    public array $data;


    public function boot()
    {

    }

    public function mount()
    {
        $this->data = $this->production->toArray();
        $this->data['yield_quantity'] = $this->data['yield_quantity'] - $this->data['total_transferred'];
        $this->data['carton_quantity_pcs'] = $this->data['yield_quantity'] % $this->production->stock->carton;
        $this->data['carton_quantity'] = floor($this->data['yield_quantity'] / $this->production->stock->carton);
        $this->data['tt_transfer'] = $this->data['carton_quantity']." carton";
        if($this->data['carton_quantity_pcs'] > 0)
        {
            $this->data['tt_transfer'].= " and ". $this->data['carton_quantity_pcs']. " pcs";
        }

    }

    public function render()
    {
        return view('livewire.production-manager.transfer.transfer-production-component');
    }


    public function transferProduction()
    {

       $price =  (new ProductionRepository())->calculateProductionCostPrice($this->production);

       if(is_string($price))
       {
           $this->alert(
               "error",
               "Production Transfer",
               [
                   'position' => 'center',
                   'timer' => 7000,
                   'toast' => false,
                   'text' => $price,
               ]
           );

           return false;
       }

        $product_transfer = [
            'transfer_date' => dailyDate(),
            'transfer_time' => Carbon::now()->toDateTimeLocalString(),
            'quantity' => floor($this->data['yield_quantity'] / $this->production->stock->carton),
            'pieces' => $this->data['yield_quantity'] % $this->production->stock->carton,
            'stock_id' =>  $this->production->stock_id,
            'transferable_type' => Production::class,
            'transferable_id' => $this->production->id,
            'transfer_by_id' => auth()->id(),
            'status_id' => status('Pending'),
        ];
/*
        ProductTransfer::where([
            'stock_id' =>  $this->production->stock_id,
            'transferable_type' => Production::class,
            'transferable_id' => $this->production->id,
        ])->delete();
*/
        ProductTransfer::create($product_transfer);

        //$this->production->status_id = status('Transferred');

        $this->production->total_transferred +=$this->data['yield_quantity'];

        $this->production->update();

        //$this->production->stock->updateAvailableQuantity();

        $this->alert(
            "success",
            "Production",
            [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'text' =>  $this->data['tt_transfer']." has been transferred successfully!.",
            ]
        );

        return redirect()->route('production.index');
    }

}

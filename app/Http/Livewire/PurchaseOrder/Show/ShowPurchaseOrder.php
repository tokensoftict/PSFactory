<?php

namespace App\Http\Livewire\PurchaseOrder\Show;


use App\Models\Purchaseorder;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;

class ShowPurchaseOrder extends Component
{

    use SimpleComponentTrait;

    public PurchaseOrder $purchaseorder;

    public function render()
    {
        return view('livewire.purchase-order.show.show-purchase-order');
    }
}

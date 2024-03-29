<?php

namespace App\Http\Livewire\InvoiceAndSales\Dispatch;

use App\Models\Invoice;
use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InvoiceDispatcherComponent extends Component
{
    use LivewireAlert;

    public Invoice $invoice;

    public $users;

    public array $data;

    public function boot()
    {

    }

    public function mount()
    {
        $this->users = User::where('usergroup_id',2)->get();

        $this->data['picked_by'] = "";
        $this->data['checked_by'] = "";
        $this->data['packed_by'] = "";
        $this->data['vehicle_number'] = "";
        $this->data['driver_name'] = "";
        $this->data['driver_phone_number'] = "";
        $this->data['received_by'] = "";

    }

    public function render()
    {
        return view('livewire.invoice-and-sales.dispatch.invoice-dispatcher-component');
    }

    public function dispatchedInvoice()
    {
        $this->validate(
            [
                'data.picked_by' => 'required',
                'data.checked_by' => 'required',
                'data.packed_by' => 'required',
                'data.dispatched_by' => 'required',
                'data.driver_name' => 'required',
                'data.vehicle_number' => 'required',
                'data.driver_phone_number' => 'required',
                //'data.received_by' => 'required',
            ]
        );

        $this->data['status_id'] = status('Dispatched');

        $this->invoice->update($this->data);


        $this->dispatchBrowserEvent('refreshBrowser', ['link'=>route('invoiceandsales.view',$this->invoice->id)]);
        $this->alert(
            "success",
            "Invoice Dispatcher",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  "Invoice has been dispatched successfully, Invoice is now completed!",
            ]
        );

    }

}

<?php

namespace App\Http\Livewire\PaymentManager;

use App\Models\Creditpaymentlog;
use App\Models\Customer;
use App\Traits\PaymentComponentTrait;
use Livewire\Component;

class AddcreditComponent extends Component
{
    use PaymentComponentTrait;


    public $amount = 0;

    public int $customer_id = 0;

    public Customer $customer;

    protected $listeners = [
        'generateCreditPayment' => 'generateCreditPayment',
        'generateInvoicePayment' => 'generateInvoicePayment',
    ];


    public function mount()
    {
        $this->mountProperties();

        $this->payments = $this->payments->filter(function($payment){
            return ($payment->id !== 4 && $payment->id !== 5);
        });

        $this->sub_total = $this->amount;

        $this->totalCredit = Creditpaymentlog::where('customer_id',$this->customer_id)->sum('amount');

    }

    public function render()
    {
        $this->updateDisplay($this);

        return view('livewire.payment-manager.addcredit-component');
    }
}

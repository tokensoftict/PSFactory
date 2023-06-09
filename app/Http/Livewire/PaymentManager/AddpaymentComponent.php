<?php

namespace App\Http\Livewire\PaymentManager;

use App\Models\BankAccount;
use App\Models\Creditpaymentlog;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Paymentmethod;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use App\Traits\PaymentComponentTrait;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddpaymentComponent extends Component
{

    use PaymentComponentTrait;

    public int $customer_id = 0;

    public Customer $customer;

    protected $listeners = [
        'generateCreditPayment' => 'generateCreditPayment',
        'generateInvoicePayment' => 'generateInvoicePayment',
    ];


    public function mount()
    {
        $this->mountProperties();

        $this->sub_total = $this->invoice->sub_total - $this->invoice->discount_amount;

        $this->totalCredit = Creditpaymentlog::where('customer_id',$this->invoice->customer_id)->sum('amount');

    }

    public function render()
    {
        $this->updateDisplay();

        return view('livewire.payment-manager.addpayment-component');

    }


}

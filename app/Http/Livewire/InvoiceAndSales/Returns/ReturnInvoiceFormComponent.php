<?php

namespace App\Http\Livewire\InvoiceAndSales\Returns;

use App\Models\Invoice;
use App\Models\InvoiceReturn;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReturnInvoiceFormComponent extends Component
{
    use LivewireAlert;

    public InvoiceReturn $invoiceReturn;

    public Invoice $invoice;

    public string $invoice_number;

    public function boot()
    {

    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.invoice-and-sales.returns.return-invoice-form-component');
    }

    public function getInvoice()
    {
        $invoice = Invoice::where('invoice_number', $this->invoice_number)->first();
        if(!$invoice)
        {
            $this->alert(
                "error",
                "Return Invoice",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' =>  "Invoice not found, please check invoice number and try again",
                ]
            );
        }
        else {
            $this->invoice = $invoice;
            $this->dispatchBrowserEvent('displayInvoice',$this->invoice->id);
            //$this->dispatchBrowserEvent("openreturnInvoiceModal", []);
        }

        return $invoice->toArray();
    }
}

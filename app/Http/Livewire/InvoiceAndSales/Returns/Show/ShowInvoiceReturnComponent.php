<?php

namespace App\Http\Livewire\InvoiceAndSales\Returns\Show;

use App\Jobs\AddLogToProductBinCard;
use App\Models\Invoice;
use App\Models\InvoiceReturn;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowInvoiceReturnComponent extends Component
{
    use LivewireAlert;

    public InvoiceReturn $invoiceReturn;
    public Invoice $invoice;

    public function boot()
    {

    }

    public function mount()
    {
        $this->invoice = $this->invoiceReturn->invoice;
    }

    public function render()
    {
        return view('livewire.invoice-and-sales.returns.show.show-invoice-return-component');
    }


    public function approve()
    {
        $this->invoiceReturn->status_id = status('Approved');
        $this->invoiceReturn->update();

        $bincards = [];

        foreach ($this->invoiceReturn->invoice_returns_items as $item){
            $batch = $this->invoice->invoiceitembatches()->where('stock_id', $item->stock_id)->first();
            $batch->stockbatch->quantity =  $batch->stockbatch->quantity + $item->quantity;
            $batch->stockbatch->update();
            $item->stock->updateAvailableQuantity();
            $bincards[] = [
                'stock_id' => $item->stock_id,
                'stockbatch_id' => $batch->id,
                'user_id' => auth()->id(),
                'date_added' => todaysDate(),
                'in' => 0,
                'out' => 0,
                'sold' => 0,
                'return' => $item->quantity,
                'pieces' => 0,
                'total' => $item->stock->quantity,
                'total_pieces' => $item->stock->pieces,
                'type' => 'RETURN',
                'comment' => $this->invoiceReturn->invoiceReturnsReason->reason
            ];
        }

        dispatch(new AddLogToProductBinCard($bincards));

        $this->alert(
            "success",
            "Return Invoice",
            [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'text' =>  "Return Invoice has been approved successfully"
            ]
        );
    }

    public function decline(){

        $this->invoiceReturn->status_id = status('Declined');
        $this->invoiceReturn->update();

        $this->alert(
            "success",
            "Return Invoice",
            [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'text' =>  "Return Invoice has been decline successfully"
            ]
        );

    }

    public function delete()
    {
        $this->invoiceReturn->delete();

        $this->alert(
            "success",
            "Return Invoice",
            [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'text' =>  "Return Invoice has been deleted successfully"
            ]
        );

        return redirect()->route('returns.index');
    }

}

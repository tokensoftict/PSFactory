<?php

namespace App\Http\Livewire\InvoiceAndSales\Returns\Forms;

use App\Models\Invoice;
use App\Models\InvoiceReturn;
use App\Models\InvoiceReturnsReason;
use App\Repositories\InvoiceReturnsRepository;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReturnInvoiceFormComponent extends Component
{
    use LivewireAlert;

    public String $items;
    public string $invoice_reference = "";
    public string $invoice_date = "";
    public array $selectCustomer;

    public Invoice $invoice;

    public $invoiceReasons;

    public  $invoiceData = [];

    public InvoiceReturn $invoiceReturn;

    private InvoiceReturnsRepository $invoiceReturnsRepository;


    public function boot(InvoiceReturnsRepository $invoiceReturnsRepository)
    {
        $this->invoiceReturnsRepository = $invoiceReturnsRepository;
    }


    public function mount()
    {
        $this->invoice = new Invoice();

        $this->invoiceReasons = InvoiceReturnsReason::where('status', 1)->get();

        if(isset($this->invoiceReturn->id)){

            $this->invoice = $this->invoiceReturn->invoice;

            $items = $this->invoiceReturn->invoice_returns_items->map(function($item){

                $item['returnquantity'] = $item['quantity'];
                $item['name'] = $item['stock']['name'];

                $item['quantity'] = $this->invoice->invoiceitems->filter(function($invoiceItem) use($item){

                    return $invoiceItem->stock_id === $item['stock_id'];

                })->first()->quantity;

                return $item;
            });

            $this->invoiceData['items'] = json_encode($items->toArray());
            $this->invoiceData['invoice_date'] = mysql_str_date($this->invoice->invoice_date);
            $this->invoiceData['customer_id'] = $this->invoice->customer->toArray();
            $this->invoiceData['invoice_number'] = $this->invoice->invoice_number;
            $this->invoiceData['invoice_returns_reason_id'] = $this->invoiceReturn->invoice_returns_reason_id;
            $this->invoiceData['return_date'] =  mysql_str_date($this->invoiceReturn->return_date);

        }else{

            $this->invoiceData['items'] = json_encode([]);
            $this->invoiceData['invoice_date'] = dailyDate();
            $this->invoiceData['customer_id'] = "";
            $this->invoiceData['invoice_number'] = "";
            $this->invoiceData['invoice_returns_reason_id'] = "";
            $this->invoiceData['return_date'] =  todaysDate();
        }


    }

    public function render()
    {
        return view('livewire.invoice-and-sales.returns.forms.return-invoice-form-component');
    }

    public function displayInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $items = $this->invoice->invoiceitems->map(function($item){
            $item['returnquantity'] = 1;
            $item['total_selling_price'] = $item['returnquantity'] * $item['selling_price'];
            return $item;
        });
        $this->invoiceData['items'] = json_encode($items->toArray());
        $this->invoiceData['invoice_date'] = mysql_str_date($this->invoice->invoice_date);
        $this->invoiceData['customer_id'] = $this->invoice->customer->toArray();
        $this->invoiceData['invoice_number'] = $this->invoice->invoice_number;

        return $this->invoiceData;
    }


    public function saveReturns()
    {

        $items = json_decode($this->invoiceData['items'], true);

        $data = [
            'return_number' => invoiceReturnOrdeReferenceNumber(),
            'customer_id' => $this->invoice->customer_id,
            'invoice_id' => $this->invoice->id,
            'status_id' => status("Pending"),
            'invoice_returns_reason_id' => $this->invoiceData['invoice_returns_reason_id'],
            'created_by' => auth()->id(),
            'return_date' => $this->invoiceData['return_date'],
            'return_time' =>Carbon::now()->toDateTimeLocalString(),
            'items' => $items
        ];



        if(isset($this->invoiceReturn->id)){
            $message = "Invoice Return has been updated successfully";
            unset($data['return_number']);
            $this->invoiceReturnsRepository->updateReturns($this->invoiceReturn, $data);
        }else{
            $message = "Invoice Return has been created successfully";
            $this->invoiceReturnsRepository->createReturns($data);
        }

        $this->alert(
            "success",
            "Return Invoice",
            [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'text' =>  $message
            ]
        );

        return redirect()->route('returns.index');

    }

}

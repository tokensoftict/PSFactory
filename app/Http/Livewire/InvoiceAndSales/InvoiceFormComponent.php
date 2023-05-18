<?php

namespace App\Http\Livewire\InvoiceAndSales;

use App\Jobs\AddLogToCustomerLedger;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\State;
use App\Repositories\InvoiceRepository;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InvoiceFormComponent extends Component
{
    use LivewireAlert, SimpleComponentTrait;

    public Invoice $invoice;

    public String $items;
    public string $invoice_reference = "";
    public string $invoice_date = "";
    public array $selectCustomer;

    public array $invoiceData = [];


    private InvoiceRepository $invoiceRepository;


    //for new customer

    public String $firstname = "";
    public String $lastname = "";
    public String $address = "";
    public String $company_name = "";
    public String $phone_number = "";
    public String $email = "";
    public String $type = "COMPANY";
    public String $state_id = "";

    public array $departments = [];

    private  $selectedDepartment;

    public $states;


    public function boot(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function mount()
    {

        $this->invoiceData['invoice_date'] = dailyDate();
        $this->invoiceData['customer_id'] = null;
        $this->invoiceData['invoice_number'] = invoiceOrderReferenceNumber();
        $this->invoiceData['department_id'] = salesDepartments(true)->first()->id;

        $this->states = states();

        $this->data = [];

        if(isset($this->invoice->id))
        {
            $this->items = json_encode($this->invoice->invoiceitems->toArray());
            $this->invoiceData['invoice_date'] = $this->invoice->invoice_date;
            $this->invoiceData['customer_id'] = $this->invoice->customer->toArray();
            $this->invoiceData['invoice_number'] = $this->invoice->invoice_number;
            $this->invoiceData['department_id'] = $this->invoice->department_id;
        }
    }

    private function initDepartment()
    {
        $this->selectedDepartment = department_by_id($this->invoiceData['department_id']);

        $this->departments = salesDepartments(true)->toArray();

        $this->dispatchBrowserEvent('departmentChange', ['department'=> $this->invoiceData['department_id']]);
    }


    public function render()
    {
        $this->initDepartment();

        return view('livewire.invoice-and-sales.invoice-form-component');
    }


    public function newCustomer()
    {

        $this->modalTitle = "New";

        $this->saveButton = "Save";

        $this->dispatchBrowserEvent("openModal", []);
    }


    public function save()
    {
        $this->validate([
            'company_name' =>'required',
            'firstname' =>'required',
            'lastname' => 'required',
            'state_id' =>'required',
            'phone_number' => 'required|digits_between:11,11|unique:customers,phone_number',
        ]);

        $customer = new Customer();

        $customer->firstname = $this->firstname;
        $customer->lastname = $this->lastname;
        $customer->email = $this->email;
        $customer->company_name = $this->company_name;
        $customer->phone_number = $this->phone_number;
        $customer->type = $this->type;
        $customer->address = $this->address;
        $customer->state_id = $this->state_id;


        $customer->save();

        $this->dispatchBrowserEvent("newCustomer", ['customer'=>$customer->toArray()]);
    }


    public function generateInvoice()
    {

        if(!isset($this->invoice->id))
        {
            $this->invoiceData['invoice_number'] = invoiceOrderReferenceNumber();

            $this->invoice = $this->invoiceRepository->createInvoice($this->invoiceData, json_decode($this->items, true));

            $this->dispatchBrowserEvent("invoiceLink", ['link'=>route('invoiceandsales.view',$this->invoice->id)]);

            $this->alert(
                "success",
                "Invoice",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' =>  "Invoice has been generated successfully!.",
                ]
            );
        }
        else {

            $this->invoice = $this->invoiceRepository->update($this->invoice, $this->invoiceData,  json_decode($this->items, true));

            $this->dispatchBrowserEvent("invoiceLink", ['link'=>route('invoiceandsales.view',$this->invoice->id)]);

            $this->alert(
                "success",
                "Invoice",
                [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => false,
                    'text' =>  "Invoice has been updated successfully!.",
                ]
            );
        }

    }



}

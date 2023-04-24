<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class CustomerManagerComponent extends Component
{

    public String $modalTitle = "New";

    public String $saveButton = "Save";

    public String $modalName = "Customer";

    public string $modelId = "";


    public String $firstname = "";
    public String $lastname = "";
    public String $address = "";
    public String $company_name = "";
    public String $phone_number = "";
    public String $email = "";
    public String $type = "COMPANY";


    public function render()
    {
        return view('livewire.customer.customer-manager-component');
    }


    public function edit($id)
    {
        $this->modalTitle = "Update";

        $this->modelId = $id;

        $customer = Customer::find($id);

        $this->firstname = $customer->firstname ;
        $this->lastname = $customer->lastname;
        $this->email = $customer->email ;
        $this->company_name = $customer->company_name;
        $this->phone_number = $customer->phone_number;
        $this->type = $customer->type;
        $this->address  = $customer->address;

        $this->saveButton = "Update";

        $this->dispatchBrowserEvent("openModal", []);
    }


    public function new()
    {

        $this->modalTitle = "New";

        $this->saveButton = "Save";

        $this->dispatchBrowserEvent("openModal", []);
    }


    public function update($id)
    {
        $customer = Customer::find($id);

        $customer->firstname = $this->firstname;
        $customer->lastname = $this->lastname;
        $customer->email = $this->email;
        $customer->company_name = $this->company_name;
        $customer->phone_number = $this->phone_number;
        $customer->type = $this->type;
        $customer->address = $this->address;

        $customer->save();

        $this->dispatchBrowserEvent("closeModal", []);
    }


    public function save()
    {
        $this->validate([
            'company_name' =>'required',
            'firstname' =>'required',
            'lastname' => 'required',
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

        $customer->save();

        $this->dispatchBrowserEvent("closeModal", []);
    }


    public function toggle($id)
    {
        $model = Customer::find($id);
        $model->status = !$model->status;
        $model->save();
    }


    public function get()
    {
        return Customer::where('id','>',1)->get();
    }

}

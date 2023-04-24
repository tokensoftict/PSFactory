<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function __construct()
    {
        //
    }

    public function findCustomer($name)
    {
        return  Customer::query()->where(function($query) use ($name){
            $query->orwhere('firstname', 'LIKE', "%{$name}%")
                ->orwhere('lastname', 'LIKE', "%{$name}%")
                ->orWhere('phone_number', "LIKE", "%{$name}%")
                ->orWhere('email', "LIKE", "%{$name}%");
        })->where('status',1)->where('id','<>', 1)->get();
    }


}

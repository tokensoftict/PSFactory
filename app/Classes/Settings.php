<?php

namespace App\Classes;

use Spatie\Valuestore\Valuestore;

class Settings extends Valuestore
{
    public static  $validation = [
        'store.name' => 'required|max:255',
        'store.first_address'=>'required',
        'store.contact_number'=>'required',
    ];

    public function store(){
        return json_decode(json_encode($this->all()));
    }

    public static function convert() : array{
        return config('convert');
    }

    public static function convertCode($key) : String
    {
        return self::convert()[$key]['code'];
    }

    public static array $reports = [10,11,12,13,14,15,16,17,18];

    public static function icons() : array
    {
        return [
            'show' => asset('img/icons/eye1.svg'),
            'edit' => asset('img/icons/edit.svg'),
            'payment' => asset('img/icons/dollar-square.svg'),
            'download' => asset('img/icons/download.svg'),
            'delete' => asset('img/icons/delete1.svg'),
            'check' => asset('img/icons/check.svg'),
            'template' => asset('img/icons/template.svg'),
            'shipping1' => asset('img/icons/shipping.svg'),
            'transfer' => asset('img/icons/transfer2.svg'),
            'print' => asset('img/icons/printer.svg'),
            'items' => asset('img/icons/material.svg'),
        ];
    }

    public static function iconLinks($icon) : String {
        return self::icons()[$icon];
    }
}

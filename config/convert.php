<?php

return [
    'Litres'=> [
        'id'=>'Litres',
        'name'=>'Litres',
        'code' => 'L',
        'to' => [
            'Milliliters'=>  [
                'id'=>'Milliliters',
                'name'=>'Milliliters',
                'unit' => 1000,
                'code' => 'mL',
                'operation' => '*'
            ],
            'Litres' =>  [
                'id'=>'Litres',
                'name'=>'Litres',
                'unit' => 1,
                'code' => 'L',
                'operation' => '*'
            ],
        ]
    ],
    'Milliliters' => [
        'id'=>'Milliliters',
        'name'=>'Milliliters',
        'code' => 'mL',
        'to' => [
            'Litres' =>  [
                'id'=>'Litres',
                'name'=>'Litres',
                'code' => 'L',
                'unit' => 1000,
                'operation' => '/'
            ],
            'Milliliters' =>   [
                'id'=>'Milliliters',
                'name'=>'Milliliters',
                'unit' => 1,
                'code' => 'mL',
                'operation' => '*'
            ],
        ]
    ],

    'Grams'=>  [
        'id'=>'Grams',
        'name'=>'Grams',
        'code' => 'G',
        'to' => [
            'Kilograms' =>   [
                'id'=>'Kilograms',
                'name'=>'Kilograms',
                'unit' => 1000,
                'code' => 'Kg',
                'operation' => '/'
            ],
            'Grams' =>   [
                'id'=>'Grams',
                'name'=>'Grams',
                'code' => 'G',
                'unit' => 1,
                'operation' => '*'
            ]
        ]
    ],

    'Kilograms' =>  [
        'id'=>'Kilograms',
        'name'=>'Kilograms',
        'code' => 'Kg',
        'to' => [
            'Grams' =>   [
                'id'=>'Grams',
                'name'=>'Grams',
                'unit' => 1000,
                'operation' => '*'
            ],
            'Kilograms' =>   [
                'id'=>'Kilograms',
                'name'=>'Kilograms',
                'unit' => 1,
                'code' => 'Kg',
                'operation' => '*'
            ],]
    ],

    'Pieces' =>  [
        'id'=>'Pieces',
        'name'=>'Pieces',
        'code' => 'pcs',
        'to' => [
            'Pieces' =>    [
                'id'=>'Pieces',
                'name'=>'Pieces',
                'unit' => 1,
                'operation' => "*"
            ]
        ]
    ]
];


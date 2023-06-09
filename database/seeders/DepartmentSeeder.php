<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(
            [

                ['name'=>'Chemical Department','status'=>1, 'department_type'=>'Store', 'quantity_column'=>NULL ,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],

                ['name'=>'Packaging Department','status'=>1, 'department_type'=>'Store', 'quantity_column'=>NULL, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],

                ['name'=>'Sales Department','status'=>1, 'department_type'=>'Sales', 'quantity_column'=>'', 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]
            ]
        );
    }
}

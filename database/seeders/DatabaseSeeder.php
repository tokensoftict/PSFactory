<?php

namespace Database\Seeders;


use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StateSeeder::class);
        $this->call(BanksSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        Artisan::call('task:generate');
        $this->call(PermissionSeeder::class);
    }
}

<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Production;
use App\Models\Purchaseorder;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\ProductionPolicy;
use App\Policies\PurchaseorderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Invoice::class => InvoicePolicy::class,
        Purchaseorder::class => PurchaseorderPolicy::class,
        Production::class => ProductionPolicy::class,
        Payment::class => PaymentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

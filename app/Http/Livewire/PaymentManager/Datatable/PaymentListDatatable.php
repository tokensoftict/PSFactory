<?php

namespace App\Http\Livewire\PaymentManager\Datatable;

use App\Classes\ExportDataTableComponent;
use App\Classes\Settings;
use App\Models\Creditpaymentlog;
use App\Models\Customerdeposit;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use App\Traits\SimpleDatatableComponentTrait;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Payment;

class PaymentListDatatable extends ExportDataTableComponent
{
    use SimpleDatatableComponentTrait, LivewireAlert;

    public array $filters = [];

    private PaymentRepository $paymentRepository;

    protected $model = Payment::class;

    public static array $invoiceType = [
      Invoice::class => 'Invoice Payment',
      Creditpaymentlog::class => "Credit Payment",
      Customerdeposit::class => "Deposit Payment"
    ];


    public function builder(): Builder
    {
       return  Payment::query()->select('*')->filterdata($this->filters);
    }


    public static function mountColumn() : array
    {
        return [
            Column::make("Customer", "customer.firstname")
                ->format(fn($value, $row, Column $column)=> $row->customer->firstname." ".$row->customer->lastname)
                ->searchable()
                ->sortable(),
            Column::make("Invoice Number", "invoice_number")
                ->format(fn($value, $row, Column $column)=> $row->invoice->invoice_number)
                ->sortable(),
            Column::make("Type", "invoice_type")
                ->format(function($value, $row, Column $column){
                    return PaymentListDatatable::$invoiceType[$row->invoice_type];
                } )
                ->sortable(),
            Column::make("Sub Total", "total_paid")
                ->format(fn($value, $row, Column $column)=> money($row->invoice->sub_total))
                ->sortable(),
            Column::make("Total Paid", "total_paid")
                ->format(fn($value, $row, Column $column)=> money($row->total_paid))
                ->sortable(),
            Column::make("Payment Date", "payment_date")
                ->format(fn($value, $row, Column $column) => eng_str_date($row->payment_date))
                ->sortable(),
            Column::make("Time", "payment_time")
                ->format(fn($value, $row, Column $column) => twelveHourClock($row->payment_time))
                ->sortable(),
            Column::make("By", "user_id")
                ->format(fn($value, $row, Column $column) => $row->user->name)
                ->searchable()
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column){
                    $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';
                    $html .='<ul class="dropdown-menu dropdown-menu-end">';
                    $html.='<a href="'.route('payment.show',$row->id).'" class="dropdown-item">View Payment</a></li>';

                    $html.='<a onclick="confirm(\'Are you sure you want to delete this payment  ?\') || event.stopImmediatePropagation()" wire:click.prevent="deletepayment('.$row->id.')" href="javascript:" class="dropdown-item">Delete Payment</a></li>';

                    $html .='</ul></div>';
                    return $html;
                })
                ->html()
        ];
    }


    public function deletepayment(Payment $payment)
    {
        $paymentRepository = new PaymentRepository(new InvoiceRepository());

        $paymentRepository->deletePayment($payment);

        $this->dispatchBrowserEvent('invoiceDiscountModal', []);
        $this->dispatchBrowserEvent('refreshBrowser', []);
        $this->alert(
            "success",
            "Delete Payment",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  "Payment has been deleted successfully!.",
            ]
        );

    }


/*
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Customer id", "customer_id")
                ->sortable(),
            Column::make("Invoice number", "invoice_number")
                ->sortable(),
            Column::make("Invoice type", "invoice_type")
                ->sortable(),
            Column::make("Invoice id", "invoice_id")
                ->sortable(),
            Column::make("Subtotal", "subtotal")
                ->sortable(),
            Column::make("Total paid", "total_paid")
                ->sortable(),
            Column::make("Payment time", "payment_time")
                ->sortable(),
            Column::make("Payment date", "payment_date")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
*/
}

<?php

namespace App\Http\Livewire\ProductModule\Datatable;

use App\Classes\Settings;
use App\Jobs\AddLogToProductBinCard;
use App\Models\Stockbatch;
use App\Repositories\ProductRepository;
use App\Traits\SimpleDatatableComponentTrait;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ProductTransfer;
use Illuminate\Database\Eloquent\Builder;

class ProductTransferListDatatable extends DataTableComponent
{

    use SimpleDatatableComponentTrait, LivewireAlert;

    public $quantity_carton = "";

    public $quantity_pieces = "";

    protected $model = ProductTransfer::class;

    public array $filters = [];

    public ProductTransfer $productTransfer;

    public function builder(): Builder
    {
        return  ProductTransfer::query()->select('*')->filterdata($this->filters);
    }

    public static function mountColumn() : array
    {
        return [
            Column::make("Name", "stock.name")
                ->format(fn($value, $row, Column $column)=> $value)
                ->sortable(),
            Column::make("Date", "transfer_date")
                ->format(fn($value, $row, Column $column)=> eng_str_date($row->transfer_date))
                ->sortable(),
            Column::make("Trans. By", "transfer_by_id")
                ->format(fn($value, $row, Column $column)=>  $row->transfer_by->name)
                ->sortable(),
            Column::make("Quantity", "quantity")
                ->sortable(),
            Column::make("Pieces", "pieces")
                ->sortable(),
            Column::make("Status", "status_id")
                ->format(fn($value, $row, Column $column) => showStatus($row->transferstatus))->html()
                ->sortable(),
            Column::make("Resolved By", "resolve_by_id")
                ->format(fn($value, $row, Column $column)=> $row->resolve_by_id ?  $row->resolve_by->name : "")
                ->sortable(),
            Column::make("Approved Quantity", "approved_quantity")
                ->sortable(),
            Column::make("Approved Pieces", "approved_pieces")
                ->sortable(),
            Column::make("Action","id")
                ->format(function($value, $row, Column $column) {

                    $htm = "No Action";

                    if (($row->status_id === status('Pending') && userCanView('product.approveTransfer')) || $row->status_id !== status('Pending')){
                        $html = '<div class="dropdown"><button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>';

                        $html .= '<ul class="dropdown-menu dropdown-menu-end">';

                        if ($row->status_id === status('Pending') && userCanView('product.approveTransfer')) {
                            $html .= '<a href="javascript:" wire:click="approveTransferModal(' . $row . ')"  class="dropdown-item">Approve Transfer</a></li>';
                        }

                        if ($row->status_id !== status('Pending')) {
                            $html .= '<a href="javascript:" wire:click="approveTransferModal(' . $row . ')" class="dropdown-item">View Transfer</a></li>';
                        }


                        $html .= '</ul>';
                    }
                    return $html;
                }) ->html()
        ];
    }


    public function customView(): string
    {
        return 'component.include.transfers';
    }


    public function approveTransferModal(ProductTransfer $row)
    {
        $this->productTransfer = $row;

        $this->quantity_carton = $this->productTransfer->quantity;
        $this->quantity_pieces = $this->productTransfer->pieces;

        $this->dispatchBrowserEvent('openModal');
    }


    public function approve()
    {

        $dept = $this->productTransfer->transferable->department;

        if(!$dept)
        {
            $this->alert(
                "error",
                "Product Inventory",
                [
                    'position' => 'center',
                    'timer' => 1500,
                    'toast' => false,
                    'text' =>  "Error while transferring product, unable to determine department",
                ]
            );
            return false;
        }

        $this->productTransfer->update(
            [
                'approved_quantity' =>  $this->productTransfer->quantity,
                'approved_pieces' => $this->productTransfer->pieces,
                'resolve_by_id' => auth()->id(),
                'status_id' => status('Approved'),
                'resolve_time' => Carbon::now()->toDateTimeLocalString()
            ]
        );


        $transfer_data = [
            'production_id' => $this->productTransfer->transferable->id,
            $dept->quantity_column.'pieces' => $this->productTransfer->pieces,
            'batch_number' => $this->productTransfer->transferable->batch_number,
            'received_date' => dailyDate(),
            'expiry_date' => $this->productTransfer->transferable->expiry_date,
            $dept->quantity_column.'quantity' => $this->productTransfer->quantity,
            'stock_id' => $this->productTransfer->transferable->stock_id,
            'cost_price' =>  $this->productTransfer->transferable->cost_price
        ];

        $id = Stockbatch::create($transfer_data);


        $this->productTransfer->stock->updateAvailableQuantity();


        $bincards[] = [
            'stock_id' => $this->productTransfer->transferable->stock_id,
            'stockbatch_id' =>  $id->id,
            'user_id' => auth()->id(),
            'in' => $this->productTransfer->quantity,
            'date_added'=>dailyDate(),
            'out' => 0,
            'sold' =>  0,
            'return' => 0,
            'pieces' => $this->productTransfer->pieces,
            'total' =>  $this->productTransfer->stock->quantity,
            'total_pieces' => $this->productTransfer->stock->pieces,
            'type' => 'RECEIVED'
        ];


        dispatch(new AddLogToProductBinCard($bincards));

        $this->productTransfer->transferable->update(['status_id'=>status("Complete")]);

        ProductRepository::convertPiecesToCarton();

        $this->alert(
            "success",
            "Product Inventory",
            [
                'position' => 'center',
                'timer' => 1500,
                'toast' => false,
                'text' =>  $this->productTransfer->stock->name." ".$this->productTransfer->quantity." carton and ".$this->productTransfer->pieces." pieces has been received successfully!.",
            ]
        );

        //$this->emit('$refresh');

        $this->dispatchBrowserEvent('closeModal');

        return true;
    }

}

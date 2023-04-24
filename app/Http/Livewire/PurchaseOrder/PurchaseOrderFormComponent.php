<?php

namespace App\Http\Livewire\PurchaseOrder;

use App\Events\CompletePuchaseOrderEvent;
use App\Models\Department;
use App\Models\Purchaseorder;
use App\Models\Purchaseorderitem;
use App\Models\Rawmaterial;
use App\Models\Rawmaterialbatch;
use App\Models\Status;
use App\Models\Supplier;
use App\Repositories\PurchaseOrderRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PurchaseOrderFormComponent extends Component
{

    use LivewireAlert;

    public String $addedMaterial = "[]";

    public String $searchString = "";

    public String $department_id = "";

    private Collection $materials;


    public Purchaseorder $purchaseorder;

    protected PurchaseOrderRepository $purchaseOrderRepository;

    public string $supplier_id = "";

    public String $purchase_date = "";

    public String $reference = "";

    public String $status_id = "";

    public String $unitConfig = "";

    public array $statuses = ['Pending','Draft'];

    public  $listSuppliers;

    public  $listStatuses;

    public $listDepartments;


    public function boot(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }

    public function mount()
    {
        if(auth()->user()->can('complete', new Purchaseorder()))
        {
           // $this->statuses[] = 'Complete';
        }

        $this->listStatuses = Status::whereIn('name',$this->statuses)->get();

        $this->listSuppliers = Supplier::where('status',1)->get();

        $this->listDepartments = Department::where('status',1)->get();

        $this->materials = collect([]);

        $this->unitConfig = json_encode(config('convert'));

        $this->reference = purchaseOrderReferenceNumber();

        $this->department_id = '1';

        if(isset($this->purchaseorder->id))
        {

            $this->supplier_id = $this->purchaseorder->supplier_id;
            $this->reference = $this->purchaseorder->reference;
            $this->purchase_date = $this->purchaseorder->purchase_date;
            $this->status_id = $this->purchaseorder->status_id;
            //$this->department_id = $this->purchaseorder->department_id;
            $__items =  $this->purchaseorder->purchaseorderitems->toArray();

            $items = [];

            foreach ( $__items as $key=> $item)
            {
                $items[] =  Arr::only($item, ['purchase_id','purchase_type','batch_type','name','batch_id','measurement','department_id','unit','added_by',
                        'selling_price','expiry_date','expiry','cost_price','total']
                );
            }

            $this->addedMaterial = json_encode($items);

        }

    }

    public function render()
    {
        return view('livewire.purchase-order.purchase-order-form-component');
    }



    public function savePurchaseOrder()
    {

        $purchase = $this->purchaseOrderRepository->create(
            [
                'supplier_id' =>$this->supplier_id,
                'date_created' => date('Y-m-d'),
                'purchase_date' => $this->purchase_date,
                'department_id' => NULL,
                'purchase_type' => Rawmaterial::class,
                'reference' => purchaseOrderReferenceNumber(),
                'purchase_id' => NULL,
                'total' => $this->purchaseOrderRepository->calculateTotal(json_decode($this->addedMaterial ,true)),
                'status_id' => $this->status_id,
                'created_by' =>auth()->id(),
                'updated_by' =>auth()->id(),
                'approved_by' => auth()->id()
            ]
        );

        $purchase =  $this->purchaseOrderRepository->savePurchaseOrderItems(json_decode($this->addedMaterial ,true), $purchase);

        if($this->status_id == status('Complete'))
        {
            $this->complete($purchase);
        }
        else {
            $this->alert(
                "success",
                "Purchase Order",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  "Purchase Order has been created successfully!.",
                ]
            );
        }

    }



    public function updatePurchaseOrder()
    {
        $purchase = $this->purchaseOrderRepository->update($this->purchaseorder,[
            'supplier_id' =>$this->supplier_id,
            'purchase_date' => $this->purchase_date,
            //'department_id' => $this->department_id,
            'total' => $this->purchaseOrderRepository->calculateTotal(json_decode($this->addedMaterial ,true)),
            'status_id' => $this->status_id == status('Complete') ? status('Pending') :  $this->status_id,
            'updated_by' =>auth()->id(),
            'approved_by' => auth()->id()
        ]);


        $purchase =  $this->purchaseOrderRepository->savePurchaseOrderItems(json_decode($this->addedMaterial ,true), $purchase);

        if($this->status_id == status('Complete'))
        {
            $this->complete($purchase);
        }
        else {
            $this->alert(
                "success",
                "Purchase Order",
                [
                    'position' => 'center',
                    'timer' => 6000,
                    'toast' => false,
                    'text' =>  "Purchase Order has been updated successfully!.",
                ]
            );
        }

        if($this->status_id === status('Complete'))
        {
            return redirect()->route('purchaseorders.show', $purchase->id);
        }

        return redirect()->route('purchaseorders.show', $purchase->id);
    }


    public function complete(PurchaseOrder $purchaseOrder){

        $this->purchaseOrderRepository->completePurchaseOrder($purchaseOrder);

        $this->alert(
            "success",
            "Purchase Order",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Purchase Order has been completed successfully!.",
            ]
        );

        return redirect()->route('purchaseorders.show', $purchaseOrder->id);
    }


}

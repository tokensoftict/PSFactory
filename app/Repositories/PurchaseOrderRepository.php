<?php

namespace App\Repositories;


use App\Events\CompletePuchaseOrderEvent;
use App\Models\Purchaseorder;
use App\Models\Purchaseorderitem;
use App\Models\Rawmaterial;
use App\Models\Rawmaterialbatch;
use App\Models\Status;
use Illuminate\Support\Arr;


class PurchaseOrderRepository
{

    /**
     * @param $data
     * @return Purchaseorder
     */

    public function create($data) : PurchaseOrder
    {
        return PurchaseOrder::create($data);
    }

    public function update(Purchaseorder $purchaseorder, array $data) : PurchaseOrder
    {
        $purchaseorder->update($data);

        return $purchaseorder;
    }


    public function savePurchaseOrderItems(array $items, Purchaseorder $purchaseOrder)
    {
        $purchase = [];

        foreach ($items as $item)
        {
            Arr::forget($item,['unit',]);
            Arr::set($item,'purchase_type', Rawmaterial::class);
            Arr::set($item,'batch_type', Rawmaterialbatch::class);
            $purchase[] = new Purchaseorderitem($item);
        }

        $purchaseOrder->purchaseorderitems()->delete();

        $purchaseOrder->purchaseorderitems()->saveMany($purchase);

        return $purchaseOrder;
    }


    public function calculateTotal($materials)
    {
        $total = 0;
        foreach ($materials as $material){
            $total += $material['total'];
        }
        return $total;
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function findMaterial(String $name)
    {
        $name = explode(" ",$name);

        return  Rawmaterial::query()->with(['materialtype'])->where('status', "1")->where(function($query) use(&$name){
            foreach ($name as $char) {
                $query->where('name', 'LIKE', "%$char%");
            }
        })->get();
    }


    public function completePurchaseOrder(Purchaseorder $purchaseOrder) : Purchaseorder
    {

        event(new CompletePuchaseOrderEvent($purchaseOrder));

        return $purchaseOrder;
    }

}

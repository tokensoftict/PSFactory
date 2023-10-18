<?php

namespace App\Repositories;

use App\Jobs\AddLogToProductBinCard;
use App\Models\Stock;

class ProductRepository
{

    public ProductProductionTemplateRepository $productionTemplateRepository;

    public function __construct(ProductProductionTemplateRepository $productionTemplateRepository)
    {
        $this->productionTemplateRepository = $productionTemplateRepository;
    }

    public function create($data) : Stock{

        return Stock::create($data);
    }


    public function getStock($id) : Stock {
        return Stock::find($id);
    }


    public function update($id, $data) : Stock{

        $stock  = $this->getStock($id);

        $stock->update($data);

        return $stock;
    }


    public function destroy($id) : void
    {
         $this->getStock($id)->delete();
    }

    public function findProduct(mixed $name)
    {
        $name = explode(" ",$name);

        $dept = salesDepartment_by_id(request()->get('department_id'));

        if(!$dept) return [];

        return  Stock::query()
            ->with(['category'])
            ->where($dept->quantity_column.'quantity', '>', 0)
            ->where(function($query) use(&$name){
            foreach ($name as $char) {
                $query->where('name', 'LIKE', "%$char%");
            }
        })->get();
    }


    public static function convertPiecesToCarton() : void
    {
        $stocks = Stock::with(['stockbatches'])->where('status', 1)->get();
        foreach ($stocks as $stock)
        {
            $depts = salesDepartments(true);

            foreach ($depts as $dept) {

                if($dept->quantity_column != "quantity")
                {
                    $column_pack =  $dept->quantity_column.'quantity';
                    $column_pieces = $dept->quantity_column.'pieces';
                }else{
                    $column_pack = "quantity";
                    $column_pieces = "pieces";
                }

                if($stock->{$column_pieces} >= $stock->carton){ // piesces can be convert

                    $reminder = $stock->{$column_pieces} % $stock->carton;

                    $actual = $stock->{$column_pieces} - $reminder;

                    $carton = ($actual /  $stock->carton);

                    $pieces = $reminder;

                    $p_batches = $stock->stockbatches()->where($column_pieces, ">", 0)->get();

                    foreach ($p_batches as $batch)
                    {
                        $batch->{$column_pieces} = 0;
                        $batch->update();
                    }


                    $recentBatch = $stock->stockbatches()->orderBy('id', 'DESC')->limit(1)->get()->first();

                    $recentBatch->{$column_pack} = $recentBatch->{$column_pack} + $carton;
                    $recentBatch->{$column_pieces} = $pieces;

                    $recentBatch->update();

                    $stock->updateAvailableQuantity();

                    $bincards[] = [
                        'stock_id' => $stock->id,
                        'stockbatch_id' =>  $recentBatch->id,
                        'user_id' => auth()->id(),
                        'in' => $carton,
                        'date_added'=>dailyDate(),
                        'out' => 0,
                        'sold' =>  0,
                        'return' => 0,
                        'pieces' => $pieces,
                        'total' =>  $stock->totalBalance(),
                        'total_pieces' =>$stock->totalBalancePieces(),
                        'type' => 'RECEIVED',
                        'comment' => 'Pieces was converted to carton automatically by system'
                    ];

                    dispatch(new AddLogToProductBinCard($bincards));
                }

            }

        }
    }

}

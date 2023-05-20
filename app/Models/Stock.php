<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $code
 * @property int|null $category_id
 * @property float|null $selling_price
 * @property float|null $cost_price
 * @property bool $expiry
 * @property int $carton
 * @property bool $status
 * @property float $quantity
 * @property float $incentives_percentage
 * @property float $pieces
 * @property float $lead_time
 * @property string|null $image
 * @property int|null $user_id
 * @property int|null $last_updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Category|null $category
 * @property User|null $user
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 * @property Collection|Invoiceitem[] $invoiceitems
 * @property Collection|Nearoutofstock[] $nearoutofstocks
 * @property Collection|Stockbatch[] $stockbatches
 * @property Collection|Stockbincard[] $stockbincards
 * @property Collection|Stockopening[] $stockopenings
 *
 * @package App\Models
 */
class Stock extends Model
{
    use ModelFilterTraits;

    protected $table = 'stocks';

    protected $casts = [
        'category_id' => 'int',
        'selling_price' => 'float',
        'cost_price' => 'float',
        'expiry' => 'bool',
        'carton' => 'int',
        'status' => 'bool',
        'quantity' => 'float',
        'incentives_percentage'=>'float',
        'pieces' => 'float',
        'user_id' => 'int',
        'last_updated_by' => 'int'
    ];

    protected $guarded = [];

/*
    protected $fillable = [
        'name',
        'description',
        'code',
        'category_id',
        'selling_price',
        'cost_price',
        'expiry',
        'carton',
        'status',
        'quantity',
        'incentives_percentage',
        'image',
        'user_id',
        'pieces',
        'last_updated_by'
    ];
*/
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function last_updated()
    {
        return $this->belongsTo(User::class,'last_updated_by');
    }

    public function invoiceitembatches()
    {
        return $this->hasMany(Invoiceitembatch::class);
    }

    public function invoiceitems()
    {
        return $this->hasMany(Invoiceitem::class);
    }

    public function nearoutofstocks()
    {
        return $this->hasMany(Nearoutofstock::class);
    }

    public function stockbatches()
    {
        return $this->hasMany(Stockbatch::class);
    }

    public function stockbincards()
    {
        return $this->hasMany(Stockbincard::class);
    }

    public function stockopenings()
    {
        return $this->hasMany(Stockopening::class);
    }

    public function totalBalance()
    {
        $quantity = 0;

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

            $quantity += $this->stockbatches()->where($column_pack, ">", 0)->sum($column_pack);
        }
        return $quantity;
    }

    public function updateAvailableQuantity()
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

            $this->{$column_pack} = $this->stockbatches()->where($column_pack, ">", 0)->sum($column_pack);
            $this->{$column_pieces} = $this->stockbatches()->where($column_pieces, ">", 0)->sum($column_pieces);
        }
        $this->update();
    }


    public function removeSaleableBatches($batches){
        foreach ($batches as $key=>$batch){
            $stockbatch = Stockbatch::find($key);
            $stockbatch->{$batch['from']} =   $stockbatch->{$batch['from']} - $batch['qty'];
            $stockbatch->update();
        }
        $this->updateAvailableQuantity();
    }





    public function pingSaleableBatches($quantity, $from = "quantity"){

        if(is_numeric($from))
        {
            $from = salesDepartment_by_id($from)->quantity_column;
            if(!empty($from)) {
                $from = "quantity";
            }
            else {
                $from = $from."quantity";
            }
        }

        $batch_ids = [];

        if(!$this->stockBatches()->exists()) return false;

        $stockbatches = $this->stockBatches()->where($from, ">", "0")->orderBy("expiry_date", "ASC")->get();

        if ($stockbatches->count() == 0) return false;

        foreach($stockbatches as $batch) {
            if($batch->{$from} - $quantity < 0){
                $quantity = $quantity - $batch->{$from};
                $b = $batch->toArray();
                $b['qty'] = $batch->{$from};
                $b['from'] = $from;
                $batch_ids[$batch->id] =$b;
            }else{
                $batch->{$from} = $batch->{$from} - $quantity;
                $b = $batch->toArray();
                $b['qty'] = $quantity;
                $b['from'] = $from;
                $batch_ids[$batch->id] = $b;
                $quantity = 0;
            }
            if($quantity === 0)  return $batch_ids;
        }

        if($quantity != 0) return false;

        return $batch_ids;

    }


}

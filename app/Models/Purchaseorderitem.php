<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Purchaseorderitem
 *
 * @property int $id
 * @property int $purchaseorder_id
 * @property string|null $purchase_type
 * @property int|null $purchase_id
 * @property string|null $batch_type
 * @property int|null $batch_id
 * @property Carbon|null $expiry_date
 * @property int $department_id
 * @property float $measurement
 * @property float|null $cost_price
 * @property float|null $selling_price
 * @property int|null $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Department $department
 * @property Purchaseorder $purchaseorder
 *
 * @package App\Models
 */
class Purchaseorderitem extends Model
{

    use ModelFilterTraits;

	protected $table = 'purchaseorderitems';

	protected $casts = [
		'purchaseorder_id' => 'int',
		'purchase_id' => 'int',
		'batch_id' => 'int',
		'department_id' => 'int',
		'measurement' => 'float',
		'cost_price' => 'float',
		'selling_price' => 'float',
		'added_by' => 'int'
	];

	protected $dates = [
		//'expiry_date'
	];

	protected $fillable = [
		'purchaseorder_id',
		'purchase_type',
		'purchase_id',
		'batch_type',
		'batch_id',
		'expiry_date',
		'department_id',
		'measurement',
		'cost_price',
		'selling_price',
		'added_by'
	];


    protected $with = ['purchase'];

    protected $appends = ['name','unit', 'total'];


    function getNameAttribute()
    {
        return $this->purchase->name;
    }


    function getUnitAttribute()
    {
        return $this->purchase->materialtype->storage_measurement_unit ?? ""; //config('convert.'.$this->purchase->materialtype->storage_measurement_unit.'.code');
    }

    function getTotalAttribute()
    {
        return $this->measurement * $this->cost_price;
    }

    public function purchase() : MorphTo
    {
        return $this->morphTo();
    }


    public function batch() : MorphTo
    {
        return $this->morphTo();
    }

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function purchaseorder()
	{
		return $this->belongsTo(Purchaseorder::class);
	}
}

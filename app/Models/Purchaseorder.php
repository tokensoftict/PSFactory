<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Purchaseorder
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property Carbon|null $date_created
 * @property Carbon|null $date_completed
 * @property Carbon|null $purchase_date
 * @property int|null $department_id
 * @property string|null $purchase_type
 * @property int|null $purchase_id
 * @property float $total
 * @property int $status_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $completed_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property String $reference
 * @property User|null $user
 * @property Department|null $department
 * @property Status $status
 * @property Supplier|null $supplier
 * @property Collection|Purchaseorderitem[] $purchaseorderitems
 *
 * @package App\Models
 */
class Purchaseorder extends Model
{

    use ModelFilterTraits;

	protected $table = 'purchaseorders';

	protected $casts = [
		'supplier_id' => 'int',
		'department_id' => 'int',
		'purchase_id' => 'int',
		'total' => 'float',
		'status_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'completed_by' => 'int'
	];

	protected $dates = [
		//'date_created',
		//'date_completed',
		//'purchase_date'
	];

	protected $fillable = [
		'supplier_id',
		'date_created',
		'date_completed',
		'purchase_date',
		'department_id',
        'reference',
		'purchase_type',
		'purchase_id',
		'total',
		'status_id',
		'created_by',
		'updated_by',
		'completed_by'
	];


    public function purchase() : MorphTo
    {
        return $this->morphTo();
    }


	public function update_by()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

    public function create_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function complete_by()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

    public function purchasestatus()
    {
        return $this->belongsTo(Status::class,'status_id');
    }

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function purchaseorderitems()
	{
		return $this->hasMany(Purchaseorderitem::class);
	}
}

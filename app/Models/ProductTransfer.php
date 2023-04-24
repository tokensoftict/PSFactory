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
 * Class ProductTransfer
 *
 * @property int $id
 * @property Carbon|null $transfer_date
 * @property Carbon|null $transfer_time
 * @property float $quantity
 * @property float $pieces
 * @property float $approved_quantity
 * @property float $approved_pieces
 * @property string|null $transferable_type
 * @property int|null $transferable_id
 * @property int|null $transfer_by_id
 * @property int|null $resolve_by_id
 * @property int|null $status_id
 * @property int $stock_id
 * @property Carbon|null $resolve_date
 * @property Carbon|null $resolve_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Status|null $status
 * @property Stock $stock
 *
 * @package App\Models
 */
class ProductTransfer extends Model
{

    use ModelFilterTraits;

	protected $table = 'product_transfers';


	protected $casts = [
		'quantity' => 'float',
		'pieces' => 'float',
		'approved_quantity' => 'float',
		'approved_pieces' => 'float',
		'transferable_id' => 'int',
		'transfer_by_id' => 'int',
		'resolve_by_id' => 'int',
		'status_id' => 'int',
		'stock_id' => 'int'
	];

	protected $dates = [
		'transfer_date',
		'transfer_time',
		'resolve_date',
		'resolve_time'
	];

	protected $fillable = [
		'transfer_date',
		'transfer_time',
		'quantity',
		'pieces',
		'approved_quantity',
		'approved_pieces',
		'transferable_type',
		'transferable_id',
		'transfer_by_id',
		'resolve_by_id',
		'status_id',
		'stock_id',
		'resolve_date',
		'resolve_time'
	];

    public function transfer_by()
    {
        return $this->belongsTo(User::class, 'transfer_by_id');
    }

    public function resolve_by()
    {
        return $this->belongsTo(User::class, 'resolve_by_id');
    }

	public function status()
	{
		return $this->belongsTo(Status::class, 'status_id');
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class, 'stock_id');
	}

    public function transferstatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }


    public function transferable() : MorphTo
    {
        return $this->morphTo();
    }

}




<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stockopening
 *
 * @property int $id
 * @property int $stock_id
 * @property int $quantity
 * @property float|null $average_cost_price
 * @property Carbon $date_added
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Stock $stock
 *
 * @package App\Models
 */
class Stockopening extends Model
{

    use ModelFilterTraits;

	protected $table = 'stockopenings';

	protected $casts = [
		'stock_id' => 'int',
		'quantity' => 'int',
		'average_cost_price' => 'float'
	];

	protected $dates = [
		'date_added'
	];

	protected $fillable = [
		'stock_id',
		'quantity',
		'average_cost_price',
		'date_added'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}
}

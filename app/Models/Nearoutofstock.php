<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nearoutofstock
 *
 * @property int $id
 * @property int $stock_id
 * @property string $threshold_type
 * @property int $toBuy
 * @property float|null $threshold
 * @property float|null $quantity
 * @property float|null $sold
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Stock $stock
 *
 * @package App\Models
 */
class Nearoutofstock extends Model
{

    use ModelFilterTraits;

	protected $table = 'nearoutofstocks';

	protected $casts = [
		'stock_id' => 'int',
		'toBuy' => 'int',
		'threshold' => 'float',
		'quantity' => 'float',
		'sold' => 'float'
	];

	protected $fillable = [
		'stock_id',
		'threshold_type',
		'toBuy',
		'threshold',
		'quantity',
		'sold'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}
}

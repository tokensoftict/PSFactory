<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stockbincard
 *
 * @property int $id
 * @property int|null $stock_id
 * @property int|null $stockbatch_id
 * @property int|null $user_id
 * @property int $in
 * @property int $out
 * @property int $sold
 * @property int $return
 * @property int $total
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Stock|null $stock
 * @property Stockbatch|null $stockbatch
 * @property User|null $user
 *
 * @package App\Models
 */
class Stockbincard extends Model
{
    use ModelFilterTraits;

	protected $table = 'stockbincards';

	protected $casts = [
		'stock_id' => 'int',
		'stockbatch_id' => 'int',
		'user_id' => 'int',
		'in' => 'int',
		'out' => 'int',
		'sold' => 'int',
		'return' => 'int',
		'total' => 'int',
	];

	protected $fillable = [
		'stock_id',
		'stockbatch_id',
		'user_id',
		'in',
		'out',
        'date_added',
		'sold',
		'return',
		'total',
		'type'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function stockbatch()
	{
		return $this->belongsTo(Stockbatch::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

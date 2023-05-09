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
 * Class Stockbatch
 *
 * @property int $id
 * @property Carbon|null $received_date
 * @property Carbon|null $expiry_date
 * @property int $quantity
 * @property int|null $stock_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Stock|null $stock
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 * @property Collection|Stockbincard[] $stockbincards
 *
 * @package App\Models
 */
class Stockbatch extends Model
{
    use ModelFilterTraits;

	protected $table = 'stockbatches';

	protected $casts = [
		'quantity' => 'float',
		'stock_id' => 'int',
        'production_id' => 'int',
        'pieces' => 'float',
        'cost_price' => 'float',
	];

	protected $dates = [
		'received_date',
		'expiry_date'
	];

	protected $fillable = [
		'received_date',
		'expiry_date',
		'quantity',
		'stock_id',
        'pieces',
        'batch_number',
        'cost_price',
        'production_id',
	];

    public function production()
    {
        return $this->belongsTo(Production::class, 'production_id');
    }

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function invoiceitembatches()
	{
		return $this->hasMany(Invoiceitembatch::class);
	}

	public function stockbincards()
	{
		return $this->hasMany(Stockbincard::class);
	}
}

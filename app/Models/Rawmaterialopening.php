<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rawmaterialopening
 *
 * @property int $id
 * @property int $rawmaterial_id
 * @property float $measurement
 * @property float|null $average_cost_price
 * @property Carbon $date_added
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Rawmaterial $rawmaterial
 *
 * @package App\Models
 */
class Rawmaterialopening extends Model
{

    use ModelFilterTraits;

	protected $table = 'rawmaterialopenings';

	protected $casts = [
		'rawmaterial_id' => 'int',
		'measurement' => 'float',
		'average_cost_price' => 'float'
	];

	protected $dates = [
		'date_added'
	];

	protected $fillable = [
		'rawmaterial_id',
		'measurement',
		'average_cost_price',
		'date_added'
	];

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}
}

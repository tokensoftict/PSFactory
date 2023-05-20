<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nearoutofmaterial
 * 
 * @property int $id
 * @property int $rawmaterial_id
 * @property string $threshold_type
 * @property int $toBuy
 * @property float|null $threshold
 * @property float|null $quantity
 * @property float|null $used
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Rawmaterial $rawmaterial
 *
 * @package App\Models
 */
class Nearoutofmaterial extends Model
{
    use ModelFilterTraits;

	protected $table = 'nearoutofmaterials';

	protected $casts = [
		'rawmaterial_id' => 'int',
		'toBuy' => 'int',
		'threshold' => 'float',
		'quantity' => 'float',
		'used' => 'float'
	];

	protected $fillable = [
		'rawmaterial_id',
		'threshold_type',
		'toBuy',
		'threshold',
		'quantity',
		'used'
	];

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}
}

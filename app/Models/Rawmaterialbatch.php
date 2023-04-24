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
 * Class Rawmaterialbatch
 *
 * @property int $id
 * @property Carbon|null $received_date
 * @property Carbon|null $expiry_date
 * @property float $measurement
 * @property int|null $rawmaterial_id
 * @property int|null $supplier_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Rawmaterial|null $rawmaterial
 * @property Supplier|null $supplier
 * @property Collection|Rawmaterialbincard[] $rawmaterialbincards
 *
 * @package App\Models
 */
class Rawmaterialbatch extends Model
{
    use ModelFilterTraits;

	protected $table = 'rawmaterialbatches';

	protected $casts = [
		'measurement' => 'float',
		'rawmaterial_id' => 'int',
		'supplier_id' => 'int'
	];

	protected $dates = [
		'received_date',
		'expiry_date'
	];

	protected $fillable = [
		'received_date',
		'expiry_date',
		'measurement',
		'rawmaterial_id',
		'supplier_id'
	];

    protected $with = ['rawmaterial','supplier'];

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function rawmaterialbincards()
	{
		return $this->hasMany(Rawmaterialbincard::class);
	}
}

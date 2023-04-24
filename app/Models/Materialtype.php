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
 * Class Materialtype
 *
 * @property int $id
 * @property string $name
 * @property string|null $storage_measurement_unit
 * @property string|null $production_measurement_unit
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Rawmaterial[] $rawmaterials
 *
 * @package App\Models
 */
class Materialtype extends Model
{

    use ModelFilterTraits;

	protected $table = 'materialtypes';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'storage_measurement_unit',
		'production_measurement_unit',
		'status'
	];

	public function rawmaterials()
	{
		return $this->hasMany(Rawmaterial::class);
	}
}

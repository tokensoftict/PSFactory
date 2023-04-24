<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Productionline
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $capacity
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Productionline extends Model
{

    use ModelFilterTraits;

	protected $table = 'productionlines';

	protected $casts = [
		'capacity' => 'float',
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'capacity',
		'status'
	];
}

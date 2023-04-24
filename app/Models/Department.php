<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Department
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Purchaseorderitem[] $purchaseorderitems
 *
 * @package App\Models
 */
class Department extends Model
{
	use SoftDeletes, ModelFilterTraits;


	protected $table = 'departments';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'status'
	];

	public function purchaseorderitems()
	{
		return $this->hasMany(Purchaseorderitem::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Materialgroup
 * 
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Rawmaterial[] $rawmaterials
 *
 * @package App\Models
 */
class Materialgroup extends Model
{
	protected $table = 'materialgroups';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'status'
	];

	public function rawmaterials()
	{
		return $this->hasMany(Rawmaterial::class);
	}
}

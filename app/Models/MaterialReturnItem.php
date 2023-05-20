<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaterialReturnItem
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $returntype_type
 * @property int|null $returntype_id
 * @property int $material_return_id
 * @property int $rawmaterial_id
 * @property int|null $department_id
 * @property int $status_id
 * @property float $measurement
 * @property string|null $unit
 * @property float $convert_measurement
 * @property float $edited_measurement
 * @property string|null $convert_unit
 * @property int|null $resolve_by_id
 * @property Carbon|null $resolve_date
 * @property Carbon|null $resolve_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Department|null $department
 * @property MaterialReturn $material_return
 * @property Rawmaterial $rawmaterial
 * @property User|null $user
 * @property Status $status
 *
 * @package App\Models
 */
class MaterialReturnItem extends Model
{
	protected $table = 'material_return_items';

    use ModelFilterTraits;

	protected $casts = [
		'returntype_id' => 'int',
		'material_return_id' => 'int',
		'rawmaterial_id' => 'int',
		'department_id' => 'int',
		'status_id' => 'int',
		'measurement' => 'float',
		'convert_measurement' => 'float',
        'edited_measurement' => 'float',
		'resolve_by_id' => 'int',
	];

	protected $dates = [
		'resolve_date',
		'resolve_time'
	];

	protected $fillable = [
		'name',
		'returntype_type',
		'returntype_id',
		'material_return_id',
		'rawmaterial_id',
		'department_id',
		'status_id',
		'measurement',
        'edited_measurement',
		'unit',
		'convert_measurement',
		'convert_unit',
		'resolve_by_id',
		'resolve_date',
		'resolve_time',
        'extra'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function material_return()
	{
		return $this->belongsTo(MaterialReturn::class);
	}

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}

	public function resolve_by()
	{
		return $this->belongsTo(User::class, 'resolve_by_id');
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

    public function returntype()
    {
        return $this->morphTo();
    }
}

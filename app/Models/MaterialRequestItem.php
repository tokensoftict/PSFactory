<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MaterialRequestItem
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $requesttype_type
 * @property int|null $requesttype_id
 * @property int $material_request_id
 * @property int $rawmaterial_id
 * @property int|null $department_id
 * @property int $status_id
 * @property float $measurement
 * @property string|null $unit
 * @property float $convert_measurement
 * @property string|null $convert_unit
 * @property int|null $resolve_by_id
 * @property Carbon|null $resolve_date
 * @property Carbon|null $resolve_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Department|null $department
 * @property MaterialRequest $material_request
 * @property Rawmaterial $rawmaterial
 * @property User|null $user
 * @property Status $status
 *
 * @package App\Models
 */
class MaterialRequestItem extends Model
{

    use ModelFilterTraits;

	protected $table = 'material_request_items';

	protected $casts = [
		'requesttype_id' => 'int',
		'material_request_id' => 'int',
		'rawmaterial_id' => 'int',
		'department_id' => 'int',
		'status_id' => 'int',
		'measurement' => 'float',
		'convert_measurement' => 'float',
		'resolve_by_id' => 'int',
        'extra' => 'boolean'
	];

	protected $dates = [
		'resolve_date',
		'resolve_time'
	];

	protected $fillable = [
		'name',
		'requesttype_type',
		'requesttype_id',
		'material_request_id',
		'rawmaterial_id',
		'department_id',
		'status_id',
		'measurement',
		'unit',
		'convert_measurement',
		'convert_unit',
		'resolve_by_id',
		'resolve_date',
		'resolve_time',
        'extra'
	];


    protected $with = ['department', 'rawmaterial'];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function material_request()
	{
		return $this->belongsTo(MaterialRequest::class);
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

    public function requesttype()
    {
        return $this->morphTo();
    }
}

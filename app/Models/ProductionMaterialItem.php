<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionMaterialItem
 *
 * @property int $id
 * @property int $production_id
 * @property int|null $rawmaterial_id
 * @property int|null $production_template_id
 * @property int|null $department_id
 * @property int $status_id
 * @property bool $extra
 * @property string|null $name
 * @property float $measurement
 * @property string|null $unit
 * @property float $convert_measurement
 * @property string|null $convert_unit
 * @property float $returns
 * @property Carbon $production_date
 * @property Carbon|null $production_time
 * @property int|null $approved_by
 * @property Carbon|null $approved_date
 * @property Carbon|null $approved_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Department|null $department
 * @property Production $production
 * @property ProductionTemplate|null $production_template
 * @property Rawmaterial|null $rawmaterial
 * @property Status $status
 *
 * @package App\Models
 */
class ProductionMaterialItem extends Model
{
    use ModelFilterTraits;

	protected $table = 'production_material_items';

	protected $casts = [
		'production_id' => 'int',
		'rawmaterial_id' => 'int',
		'production_template_id' => 'int',
		'department_id' => 'int',
		'status_id' => 'int',
		'extra' => 'bool',
		'measurement' => 'float',
		'convert_measurement' => 'float',
		'returns' => 'float',
		'approved_by' => 'int',
        'rough' => 'int'
	];

	protected $dates = [
		'production_date',
		'production_time',
		'approved_date',
		'approved_time'
	];

	protected $fillable = [
		'production_id',
		'rawmaterial_id',
		'production_template_id',
		'department_id',
		'status_id',
		'extra',
		'name',
		'measurement',
		'unit',
		'convert_measurement',
		'convert_unit',
		'returns',
		'production_date',
		'production_time',
		'approved_by',
		'approved_date',
		'approved_time',
        'cost_price',
        'total_cost_price',
        'rough'
	];


    protected $with = ['department', 'rawmaterial'];

	public function approved()
	{
		return $this->belongsTo(User::class, 'approved_by');
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function production()
	{
		return $this->belongsTo(Production::class);
	}

	public function production_template()
	{
		return $this->belongsTo(ProductionTemplate::class);
	}

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

    public function scopefilterdepartment($query)
    {
        $department_id = auth()->user()->department_id;

        if($department_id == NULL) return $query;

        return $query->where($this->table.'.department_id', $department_id);
    }
}

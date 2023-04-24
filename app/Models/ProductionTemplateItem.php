<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionTemplateItem
 *
 * @property int $id
 * @property int $rawmaterial_id
 * @property int $production_template_id
 * @property string|null $unit
 * @property Carbon $date_created
 * @property float $measurement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ProductionTemplate $production_template
 * @property Rawmaterial $rawmaterial
 *
 * @package App\Models
 */
class ProductionTemplateItem extends Model
{

    use ModelFilterTraits;

	protected $table = 'production_template_items';

	protected $casts = [
		'rawmaterial_id' => 'int',
		'production_template_id' => 'int',
		'measurement' => 'float'
	];

	protected $dates = [
		'date_created'
	];

	protected $fillable = [
		'rawmaterial_id',
		'production_template_id',
		'unit',
		'date_created',
		'measurement'
	];

    protected $appends = ['name'];

    protected $with = ['rawmaterial'];

    public function getNameAttribute()
    {
        return $this->rawmaterial->name;
    }

	public function production_template()
	{
		return $this->belongsTo(ProductionTemplate::class);
	}

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}
}

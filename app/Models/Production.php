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
 * Class Production
 *
 * @property int $id
 * @property string $name
 * @property Carbon $production_date
 * @property Carbon|null $expiry_date
 * @property int $stock_id
 * @property float|null $cost_price
 * @property int|null $productionline_id
 * @property int $production_template_id
 * @property int|null $material_request_id
 * @property float $expected_quantity
 * @property float $rough_quantity
 * @property float $yield_quantity
 * @property string|null $batch_number
 * @property float $starting_unscrabler
 * @property float $starting_unibloc
 * @property float $starting_oriental
 * @property Carbon|null $production_time
 * @property int $status_id
 * @property string|null $remark
 * @property int $user_id
 * @property int|null $completed_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $starting_labelling
 * @property int|null $ending_unscrabler
 * @property int|null $ending_unibloc
 * @property int|null $ending_oriental
 * @property int|null $ending_labelling
 * @property int|null $department_id
 * @property array|null $packaging_reports
 * @property User $user
 * @property MaterialRequest|null $material_request
 * @property ProductionTemplate $production_template
 * @property Productionline|null $productionline
 * @property Status $status
 * @property Stock $stock
 * @property Collection|ProductionMaterialItem[] $production_material_items
 *
 * @package App\Models
 */
class Production extends Model
{

    use ModelFilterTraits;

	protected $table = 'productions';

	protected $casts = [
		'stock_id' => 'int',
		'cost_price' => 'float',
		'productionline_id' => 'int',
		'production_template_id' => 'int',
		'material_request_id' => 'int',
		'expected_quantity' => 'float',
		'rough_quantity' => 'float',
		'yield_quantity' => 'float',
		'starting_unscrabler' => 'float',
		'starting_unibloc' => 'float',
		'starting_oriental' => 'float',
		'status_id' => 'int',
		'user_id' => 'int',
		'completed_id' => 'int',
		'starting_labelling' => 'int',
		'ending_unscrabler' => 'int',
		'ending_unibloc' => 'int',
		'ending_oriental' => 'int',
		'ending_labelling' => 'int',
        'packaging_reports' => 'json'
	];

	protected $dates = [
		'production_date',
		'expiry_date',
		'production_time'
	];

	protected $fillable = [
		'name',
		'production_date',
		'expiry_date',
		'stock_id',
		'cost_price',
		'productionline_id',
		'production_template_id',
		'material_request_id',
		'expected_quantity',
		'rough_quantity',
		'yield_quantity',
		'batch_number',
		'starting_unscrabler',
		'starting_unibloc',
		'starting_oriental',
		'production_time',
		'status_id',
		'remark',
		'user_id',
		'completed_id',
		'starting_labelling',
		'ending_unscrabler',
		'ending_unibloc',
		'ending_oriental',
		'ending_labelling',
        'department_id',
        'packaging_reports'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function material_request()
	{
		return $this->belongsTo(MaterialRequest::class);
	}

	public function production_template()
	{
		return $this->belongsTo(ProductionTemplate::class);
	}

	public function productionline()
	{
		return $this->belongsTo(Productionline::class);
	}

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function production_material_items()
	{
		return $this->hasMany(ProductionMaterialItem::class);
	}

    public function scopefilterdepartment($query)
    {
        $department_id = auth()->user()->department_id;

        if($department_id === NULL) return $query;

        return $query->where($this->table.'.department_id', $department_id);
    }


    public function return()
    {
        return $this->morphOne(MaterialReturn::class,'return');
    }
}

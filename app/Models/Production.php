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
 * @property int|null $productionline_id
 * @property int $production_template_id
 * @property int|null $material_request_id
 * @property float $expected_quantity
 * @property float $rough_quantity
 * @property float $yield_quantity
 * @property string|null $batch_number
 * @property float $quantity_1
 * @property float $quantity_2
 * @property float $quantity_3
 * @property Carbon|null $production_time
 * @property int $status_id
 * @property string|null $remark
 * @property int $user_id
 * @property int|null $completed_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
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
	protected $table = 'productions';

    use ModelFilterTraits;

	protected $casts = [
		'stock_id' => 'int',
		'productionline_id' => 'int',
		'production_template_id' => 'int',
		'material_request_id' => 'int',
		'expected_quantity' => 'float',
		'rough_quantity' => 'float',
		'yield_quantity' => 'float',
		'quantity_1' => 'float',
		'quantity_2' => 'float',
		'quantity_3' => 'float',
		'status_id' => 'int',
		'user_id' => 'int',
		'completed_id' => 'int'
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
		'productionline_id',
		'production_template_id',
		'material_request_id',
		'expected_quantity',
		'rough_quantity',
		'yield_quantity',
		'batch_number',
		'quantity_1',
		'quantity_2',
		'quantity_3',
		'production_time',
		'status_id',
		'remark',
		'user_id',
		'completed_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function material_request()
	{
		return $this->belongsTo(MaterialRequest::class);
	}

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class);
    }

    public function items()
    {
        return $this->production_material_items();
    }

	public function production_template()
	{
		return $this->belongsTo(ProductionTemplate::class);
	}

	public function productionline()
	{
		return $this->belongsTo(Productionline::class);
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


}

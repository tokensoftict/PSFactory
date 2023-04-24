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
 * Class ProductionTemplate
 *
 * @property int $id
 * @property int $stock_id
 * @property string $name
 * @property Carbon $date_created
 * @property int|null $user_id
 * @property bool $status
 * @property int $expected_quantity
 * @property int|null $last_updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Stock $stock
 * @property Collection|ProductionTemplateItem[] $production_template_items
 *
 * @package App\Models
 */
class ProductionTemplate extends Model
{

    use ModelFilterTraits;

	protected $table = 'production_templates';

	protected $casts = [
		'stock_id' => 'int',
		'user_id' => 'int',
		'status' => 'bool',
		'expected_quantity' => 'int',
		'last_updated_by' => 'int'
	];



	protected $fillable = [
		'stock_id',
		'name',
		'date_created',
		'user_id',
		'status',
		'expected_quantity',
		'last_updated_by'
	];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function last_updated()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function production_template_items()
	{
		return $this->hasMany(ProductionTemplateItem::class);
	}
}

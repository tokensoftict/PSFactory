<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class MaterialReturn
 *
 * @property int $id
 * @property Carbon|null $return_date
 * @property Carbon|null $return_time
 * @property int|null $return_by_id
 * @property string|null $return_type
 * @property int|null $return_id
 * @property int|null $status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Status|null $status
 * @property Collection|MaterialReturnItem[] $material_return_items
 *
 * @package App\Models
 */
class MaterialReturn extends Model
{

    use ModelFilterTraits;

	protected $table = 'material_returns';

	protected $casts = [
		'return_by_id' => 'int',
		'return_id' => 'int',
		'status_id' => 'int'
	];

	protected $dates = [
		'return_date',
		'return_time'
	];

	protected $fillable = [
		'return_date',
		'return_time',
		'return_by_id',
		'return_type',
		'return_id',
		'status_id',
        'description'
	];

	public function return_by()
	{
		return $this->belongsTo(User::class, 'return_by_id');
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function material_return_items()
	{
		return $this->hasMany(MaterialReturnItem::class);
	}

    public function return() : MorphTo
    {
        return $this->morphTo();
    }

}

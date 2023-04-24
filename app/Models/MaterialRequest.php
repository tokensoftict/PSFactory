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
 * Class MaterialRequest
 *
 * @property int $id
 * @property Carbon|null $request_date
 * @property Carbon|null $request_time
 * @property string|null $request_type
 * @property int|null $request_id
 * @property int|null $request_by_id
 * @property int|null $resolve_by_id
 * @property int|null $status_id
 * @property Carbon|null $resolve_date
 * @property Carbon|null $resolve_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property MorphTo|null $request
 * @property User|null $user
 * @property Status|null $status
 * @property Collection|MaterialRequestItem[] $material_request_items
 * @property Collection|Production[] $productions
 *
 * @package App\Models
 */
class MaterialRequest extends Model
{
	protected $table = 'material_requests';

    use ModelFilterTraits;

	protected $casts = [
		'request_id' => 'int',
		'request_by_id' => 'int',
		'status_id' => 'int',
	];

	protected $dates = [
		'request_date',
		'request_time',
	];

	protected $fillable = [
		'request_date',
		'request_time',
		'request_type',
		'request_id',
		'request_by_id',
		'status_id',
        'description'
	];

    public function resolve_by()
    {
        return $this->belongsTo(User::class, 'resolve_by_id');
    }

    public function request_by()
    {
        return $this->belongsTo(User::class, 'request_by_id');
    }

    public function request() : MorphTo
    {
        return $this->morphTo();
    }

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function material_request_items()
	{
		return $this->hasMany(MaterialRequestItem::class);
	}

	public function productions()
	{
		return $this->hasMany(Production::class);
	}
}

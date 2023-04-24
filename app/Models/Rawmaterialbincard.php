<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rawmaterialbincard
 *
 * @property int $id
 * @property int|null $rawmaterialbatch_id
 * @property int|null $rawmaterial_id
 * @property int|null $user_id
 * @property int $in
 * @property int $out
 * @property int $return
 * @property int $total
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Rawmaterial|null $rawmaterial
 * @property Rawmaterialbatch|null $rawmaterialbatch
 * @property User|null $user
 *
 * @package App\Models
 */
class Rawmaterialbincard extends Model
{
    use ModelFilterTraits;

	protected $table = 'rawmaterialbincards';

	protected $casts = [
		'rawmaterialbatch_id' => 'int',
		'rawmaterial_id' => 'int',
		'user_id' => 'int',
		'in' => 'int',
		'out' => 'int',
		'return' => 'int',
		'total' => 'int'
	];

	protected $fillable = [
		'rawmaterialbatch_id',
		'rawmaterial_id',
		'user_id',
        'date_added',
		'in',
		'out',
		'return',
		'total',
		'type'
	];

	public function rawmaterial()
	{
		return $this->belongsTo(Rawmaterial::class);
	}

	public function rawmaterialbatch()
	{
		return $this->belongsTo(Rawmaterialbatch::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

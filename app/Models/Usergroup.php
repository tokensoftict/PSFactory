<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usergroup
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Usergroup extends Model
{
	protected $table = 'usergroups';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'status'
	];

    public static $rules = [
        'name' => 'required|string|unique:groups',
    ];

    public static $rules_update = [
        'name' => 'sometimes|required|string',
    ];

    protected $with = ['permissions'];

	public function permissions()
	{
		return $this->hasMany(Permission::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}


    public function tasks()
    {
        return $this->belongstoMany(Task::class, 'permissions');
    }

    public function group_tasks()
    {
        return $this->belongsToMany(Task::class, 'permissions')->withTimestamps();
    }
}

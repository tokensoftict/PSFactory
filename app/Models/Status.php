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
 * Class Status
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Invoiceitem[] $invoiceitems
 * @property Collection|Invoice[] $invoices
 * @property Collection|Purchaseorder[] $purchaseorders
 *
 * @package App\Models
 */
class Status extends Model
{
    use ModelFilterTraits;

	protected $table = 'statuses';

	protected $fillable = [
		'name',
		'label'
	];

	public function invoiceitems()
	{
		return $this->hasMany(Invoiceitem::class);
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function purchaseorders()
	{
		return $this->hasMany(Purchaseorder::class);
	}
}

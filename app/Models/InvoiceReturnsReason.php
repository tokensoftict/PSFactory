<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceReturnsReason
 *
 * @property int $id
 * @property string $title
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|InvoiceReturn[] $invoice_returns
 *
 * @package App\Models
 */
class InvoiceReturnsReason extends Model
{
	protected $table = 'invoice_returns_reasons';

    protected $casts = [
        'status' => 'bool'
    ];

	protected $fillable = [
		'title',
		'reason',
        'status'
	];

	public function invoice_returns()
	{
		return $this->hasMany(InvoiceReturn::class);
	}
}

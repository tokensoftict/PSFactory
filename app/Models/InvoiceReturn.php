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
 * Class InvoiceReturn
 *
 * @property int $id
 * @property int $invoice_returns_reason_id
 * @property string $return_number
 * @property int|null $customer_id
 * @property int $invoice_id
 * @property int $status_id
 * @property float $sub_total
 * @property int|null $created_by
 * @property int|null $approved_by
 * @property Carbon $return_date
 * @property Carbon $return_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Customer|null $customer
 * @property Invoice $invoice
 * @property Status $status
 * @property Collection|InvoiceReturnsItem[] $invoice_returns_items
 *
 * @package App\Models
 */
class InvoiceReturn extends Model
{

    use ModelFilterTraits;

	protected $table = 'invoice_returns';

	protected $casts = [
		'customer_id' => 'int',
		'invoice_id' => 'int',
		'status_id' => 'int',
		'sub_total' => 'float',
		'created_by' => 'int',
		'approved_by' => 'int',
        'invoice_returns_reason_id' => 'int'
	];

	protected $dates = [
		'return_date',
		'return_time'
	];

	protected $fillable = [
		'return_number',
		'customer_id',
		'invoice_id',
		'status_id',
		'sub_total',
		'created_by',
		'approved_by',
		'return_date',
		'return_time',
        'invoice_returns_reason_id'
	];

    protected $with = ['invoice_returns_items'];

    public function invoiceReturnsReason()
    {
        return $this->belongsTo(InvoiceReturnsReason::class, 'invoice_returns_reason_id');
    }

	public function create_by()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

    public function approve_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function invoice_returns_items()
	{
		return $this->hasMany(InvoiceReturnsItem::class);
	}
}

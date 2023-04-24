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
 * Class Payment
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string|null $invoice_number
 * @property string $invoice_type
 * @property int $invoice_id
 * @property float $subtotal
 * @property float $total_paid
 * @property Carbon|null $payment_time
 * @property Carbon|null $payment_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer|null $customer
 * @property User|null $user
 * @property Collection|Paymentmethoditem[] $paymentmethoditems
 *
 * @package App\Models
 */
class Payment extends Model
{
    use ModelFilterTraits;

	protected $table = 'payments';

	protected $casts = [
		'user_id' => 'int',
		'customer_id' => 'int',
		'invoice_id' => 'int',
		'subtotal' => 'float',
		'total_paid' => 'float'
	];

	protected $dates = [
		'payment_time',
		'payment_date'
	];

	protected $fillable = [
		'user_id',
		'customer_id',
		'invoice_number',
		'invoice_type',
		'invoice_id',
		'subtotal',
		'total_paid',
		'payment_time',
		'payment_date'
	];

    protected $with = ['customer','user','paymentmethoditems'];


    public function getInvoiceNumberAttribute()
    {
        if($this->invoice_type == Invoice::class) {
            return  $this->attributes['invoice_number'];
        }else{
            return $this->invoice->invoice_number;
        }

    }

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function invoice(){

        return $this->morphTo();
    }


	public function paymentmethoditems()
	{
		return $this->hasMany(Paymentmethoditem::class);
	}
}

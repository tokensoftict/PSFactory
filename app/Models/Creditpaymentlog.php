<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Creditpaymentlog
 *
 * @property int $id
 * @property int|null $payment_id
 * @property int|null $user_id
 * @property int|null $paymentmethod_id
 * @property int|null $customer_id
 * @property int|null $paymentmethoditem_id
 * @property string|null $invoicelog_type
 * @property int|null $invoicelog_id
 * @property float $amount
 * @property Carbon $payment_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $credit_number
 * @property Customer|null $customer
 * @property Payment|null $payment
 * @property Paymentmethod|null $paymentmethod
 * @property Paymentmethoditem|null $paymentmethoditem
 * @property User|null $user
 *
 * @package App\Models
 */
class Creditpaymentlog extends Model
{

    use ModelFilterTraits;

	protected $table = 'creditpaymentlogs';

	protected $casts = [
		'payment_id' => 'int',
		'user_id' => 'int',
		'paymentmethod_id' => 'int',
		'customer_id' => 'int',
		'paymentmethoditem_id' => 'int',
		'invoicelog_id' => 'int',
		'amount' => 'float'
	];

	protected $dates = [
		'payment_date'
	];

	protected $fillable = [
		'payment_id',
		'user_id',
		'paymentmethod_id',
		'customer_id',
		'paymentmethoditem_id',
		'invoicelog_type',
		'invoicelog_id',
		'amount',
		'payment_date',
        'credit_number'
	];

    protected $appends = ['sub_total', 'discount_amount', 'invoice_date', 'total_amount_paid', 'invoice_number'];


    protected $with = ['customer'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::created(function($credit){
            $credit->customer->updateCreditBalance();
        });

        self::deleted(function($credit){
            $credit->customer->updateCreditBalance();
        });

    }


    public function getSubTotalAttribute()
    {
        return $this->amount;
    }

    public function getInvoiceNumberAttribute()
    {
        return $this->credit_number;
    }

    public function getInvoiceDateAttribute()
    {
        return $this->payment_date;
    }

    public function getTotalAmountPaidAttribute()
    {
        return $this->amount;
    }

    public function getDiscountAmountAttribute() : int
    {
        return 0;
    }


	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function payment()
	{
		return $this->belongsTo(Payment::class);
	}

	public function paymentmethod()
	{
		return $this->belongsTo(Paymentmethod::class);
	}

	public function paymentmethoditem()
	{
		return $this->belongsTo(Paymentmethoditem::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function create_by()
	{
		return $this->user();
	}
}

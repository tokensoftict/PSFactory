<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Jobs\AddLogToProductBinCard;
use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Invoice
 *
 * @property int $id
 * @property string $invoice_number
 * @property int|null $customer_id
 * @property string|null $discount_type
 * @property float|null $discount_amount
 * @property float|null $discount_value
 * @property int $status_id
 * @property int|null $payment_id
 * @property float $sub_total
 * @property float $total_amount_paid
 * @property float $total_profit
 * @property float $total_cost
 * @property float $total_incentives
 * @property float $vat
 * @property float $vat_amount
 * @property int|null $created_by
 * @property int|null $last_updated_by
 * @property int|null $voided_by
 * @property Carbon $invoice_date
 * @property Carbon $sales_time
 * @property string|null $void_reason
 * @property Carbon|null $date_voided
 * @property Carbon|null $void_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $picked_by
 * @property int|null $checked_by
 * @property int|null $packed_by
 * @property int|null $dispatched_by
 * @property string|null $vehicle_number

 * @property string|null $driver_name
 * @property string|null $driver_phone_number
 * @property string|null $received_by
 * @property User|null $user
 * @property Customer|null $customer
 * @property Status $status
 * @property Collection|Invoiceactivitylog[] $invoiceactivitylogs
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 * @property Collection|Invoiceitem[] $invoiceitems
 *
 * @package App\Models
 */
class Invoice extends Model
{

    use ModelFilterTraits;

	protected $table = 'invoices';

	protected $casts = [
		'customer_id' => 'int',
		'discount_amount' => 'float',
        'discount_value' => 'float',
		'status_id' => 'int',
		'payment_id' => 'int',
		'sub_total' => 'float',
		'total_amount_paid' => 'float',
		'total_profit' => 'float',
		'total_cost' => 'float',
		'total_incentives' => 'float',
		'vat' => 'float',
		'vat_amount' => 'float',
		'created_by' => 'int',
		'last_updated_by' => 'int',
		'voided_by' => 'int',
		'picked_by' => 'int',
		'checked_by' => 'int',
		'packed_by' => 'int',
		'dispatched_by' => 'int'
	];

	protected $dates = [
		'invoice_date',
		'sales_time',
		'date_voided',
		'void_time'
	];

	protected $fillable = [
		'invoice_number',
		'customer_id',
		'discount_type',
		'discount_amount',
        'discount_value',
		'status_id',
		'payment_id',
		'sub_total',
		'total_amount_paid',
		'total_profit',
		'total_cost',
		'total_incentives',
		'vat',
		'vat_amount',
		'created_by',
		'last_updated_by',
		'voided_by',
		'invoice_date',
		'sales_time',
		'void_reason',
		'date_voided',
		'void_time',
		'picked_by',
		'checked_by',
		'packed_by',
		'dispatched_by',
        'department_id',
        'vehicle_number',
        'driver_name',
        'driver_phone_number',
        'received_by',
	];

    protected $with =['invoiceitems.stock'];

	public function create_by() : BelongsTo
	{
		return $this->belongsTo(User::class, 'created_by');
	}

    public function last_updated() : BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function picked() : BelongsTo
    {
        return $this->belongsTo(User::class, 'picked_by');
    }

    public function checked() : BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function packed() : BelongsTo
    {
        return $this->belongsTo(User::class, 'packed_by');
    }

    public function dispatched() : BelongsTo
    {
        return $this->belongsTo(User::class, 'dispatched_by');
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

    public function invoice_status() : BelongsTo
	{
		return $this->belongsTo(Status::class, 'status_id');
	}

	public function invoiceactivitylogs()
	{
		return $this->hasMany(Invoiceactivitylog::class);
	}

	public function invoiceitembatches()
	{
		return $this->hasMany(Invoiceitembatch::class);
	}

	public function invoiceitems()
	{
		return $this->hasMany(Invoiceitem::class);
	}



    public function wipePayment()
    {
        if($this->total_amount_paid > 0)
        {

            $this->payment()->delete();

            $this->paymentmethoditems()->delete();

            $this->total_amount_paid = 0;
            $this->status_id = status('Draft');
            $this->update();

            $bincards = [];
            //return back the stock initialy removed
            foreach ($this->invoiceitembatches as $invoiceitembatch)
            {
                $invoiceitembatch->stockbatch->quantity += $invoiceitembatch->quantity;
                $invoiceitembatch->stockbatch->update();
                $invoiceitembatch->stock->updateAvailableQuantity();
                $invoiceitembatch->delete();

                $bincards[] = [
                    'stock_id' => $invoiceitembatch->stock_id,
                    'stockbatch_id' =>  $invoiceitembatch->stockbatch->id,
                    'user_id' => auth()->id(),
                    'in' => 0,
                    'date_added'=>dailyDate(),
                    'out' => 0,
                    'sold' =>  0,
                    'return' => $invoiceitembatch->quantity,
                    'total' =>   $invoiceitembatch->stock->quantity,
                    'type' => 'RETURN'
                ];
            }

            dispatch(new AddLogToProductBinCard($bincards));

        }

    }

    public function payment()
    {
        return $this->morphOne(Payment::class,'invoice');
    }

    public function paymentmethoditems()
    {
        return $this->morphMany(Paymentmethoditem::class,'invoice');
    }


    public function scopefilterdepartment($query)
    {
        $department_id = auth()->user()->department_id;

        if($department_id == NULL) return $query;

        return $query->where($this->table.'.department_id', $department_id);
    }

}

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
 * Class Invoiceitem
 *
 * @property int $id
 * @property int $invoice_id
 * @property int|null $stock_id
 * @property int $quantity
 * @property int|null $customer_id
 * @property int $status_id
 * @property int $added_by
 * @property Carbon $invoice_date
 * @property Carbon $sales_time
 * @property float|null $cost_price
 * @property float|null $selling_price
 * @property float|null $profit
 * @property float|null $total_cost_price
 * @property float|null $total_selling_price
 * @property float|null $total_profit
 * @property float|null $total_incentives
 * @property float|null $discount_value
 * @property string|null $discount_type
 * @property float|null $discount_amount
 * @property int|null $discount_added_by
 * @property int|null $department_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer|null $customer
 * @property User|null $user
 * @property Invoice $invoice
 * @property Status $status
 * @property Stock|null $stock
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 *
 * @package App\Models
 */
class Invoiceitem extends Model
{
    use ModelFilterTraits;

	protected $table = 'invoiceitems';

	protected $casts = [
		'invoice_id' => 'int',
		'stock_id' => 'int',
		'quantity' => 'int',
		'customer_id' => 'int',
		'status_id' => 'int',
		'added_by' => 'int',
		'cost_price' => 'float',
		'selling_price' => 'float',
        'discount_value' => 'float',
		'profit' => 'float',
		'total_cost_price' => 'float',
		'total_selling_price' => 'float',
		'total_profit' => 'float',
		'total_incentives' => 'float',
		'discount_amount' => 'float',
		'discount_added_by' => 'int'
	];

	protected $dates = [
		'invoice_date',
		'sales_time'
	];

	protected $fillable = [
		'invoice_id',
		'stock_id',
		'quantity',
		'customer_id',
		'status_id',
		'added_by',
		'invoice_date',
		'sales_time',
		'cost_price',
		'selling_price',
		'profit',
		'total_cost_price',
		'total_selling_price',
        'discount_value',
		'total_profit',
		'total_incentives',
		'discount_type',
		'discount_amount',
		'discount_added_by',
        'department_id'
	];

    protected $appends = ['name','av_qty'];


    public function getNameAttribute()
    {
        return $this->stock->name;
    }

    public function getAvQtyAttribute()
    {
        return $this->stock->quantity;
    }

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

	public function user()
	{
		return $this->belongsTo(User::class, 'discount_added_by');
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function invoiceitembatches()
	{
		return $this->hasMany(Invoiceitembatch::class);
	}

    public function scopefilterdepartment($query)
    {
        $department_id = auth()->user()->department_id;

        if($department_id !== NULL) return $query;

        return $query->where($this->table.'.department_id', $department_id);
    }
}

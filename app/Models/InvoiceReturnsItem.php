<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceReturnsItem
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int $invoice_return_id
 * @property int|null $customer_id
 * @property int $status_id
 * @property int $quantity
 * @property int $pieces
 * @property int $added_by
 * @property float|null $cost_price
 * @property float|null $selling_price
 * @property float|null $total_cost_price
 * @property float|null $total_selling_price
 * @property float|null $total_profit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer|null $customer
 * @property Invoice|null $invoice
 * @property InvoiceReturn $invoice_return
 * @property Status $status
 * @property Stock $stock
 *
 * @package App\Models
 */
class InvoiceReturnsItem extends Model
{
    use ModelFilterTraits;

	protected $table = 'invoice_returns_items';

	protected $casts = [
		'invoice_id' => 'int',
		'invoice_return_id' => 'int',
		'customer_id' => 'int',
		'status_id' => 'int',
		'quantity' => 'int',
		'pieces' => 'int',
		'added_by' => 'int',
		'cost_price' => 'float',
		'selling_price' => 'float',
		'total_cost_price' => 'float',
		'total_selling_price' => 'float',
		'total_profit' => 'float',
        'stock_id' => 'int'
	];

	protected $fillable = [
		'invoice_id',
		'invoice_return_id',
		'customer_id',
		'status_id',
		'quantity',
		'pieces',
		'added_by',
		'cost_price',
		'selling_price',
		'total_cost_price',
		'total_selling_price',
		'total_profit',
        'stock_id',
        'department_id'
	];

    protected $with = ['stock'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function invoice_return()
	{
		return $this->belongsTo(InvoiceReturn::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

    public function scopefilterdepartment($query)
    {
        $department_id = auth()->user()->department_id;

        if($department_id !== NULL) return $query;

        return $query->where($this->table.'.department_id', $department_id);
    }
}

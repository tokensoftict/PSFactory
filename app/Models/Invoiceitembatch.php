<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoiceitembatch
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $invoiceitem_id
 * @property int|null $stock_id
 * @property int|null $stockbatch_id
 * @property int|null $customer_id
 * @property string|null $batchno
 * @property float $cost_price
 * @property float $selling_price
 * @property float $profit
 * @property float $incentives
 * @property int $quantity
 * @property Carbon $invoice_date
 * @property Carbon $sales_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer|null $customer
 * @property Invoice $invoice
 * @property Invoiceitem $invoiceitem
 * @property Stock|null $stock
 * @property Stockbatch|null $stockbatch
 *
 * @package App\Models
 */
class Invoiceitembatch extends Model
{

    use ModelFilterTraits;

	protected $table = 'invoiceitembatches';

	protected $casts = [
		'invoice_id' => 'int',
		'invoiceitem_id' => 'int',
		'stock_id' => 'int',
		'stockbatch_id' => 'int',
		'customer_id' => 'int',
		'cost_price' => 'float',
		'selling_price' => 'float',
		'profit' => 'float',
		'incentives' => 'float',
		'quantity' => 'int'
	];

	protected $dates = [
		'invoice_date',
		'sales_time'
	];

	protected $fillable = [
		'invoice_id',
		'invoiceitem_id',
		'stock_id',
		'stockbatch_id',
		'customer_id',
		'batchno',
		'cost_price',
		'selling_price',
		'profit',
		'incentives',
		'quantity',
		'invoice_date',
		'sales_time'
	];


    protected $with = ['stockbatch'];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function invoiceitem()
	{
		return $this->belongsTo(Invoiceitem::class);
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function stockbatch()
	{
		return $this->belongsTo(Stockbatch::class);
	}
}

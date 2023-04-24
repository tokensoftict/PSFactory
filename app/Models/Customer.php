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
 * Class Customer
 *
 * @property int $id
 * @property string $type
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $company_name
 * @property string|null $contact_user
 * @property string|null $email
 * @property bool|null $status
 * @property string|null $address
 * @property string|null $phone_number
 * @property Carbon|null $created_at
 * @property float $deposit_balance
 * @property float $credit_balance
 * @property Carbon|null $updated_at
 *
 * @property Collection|Creditpaymentlog[] $creditpaymentlogs
 * @property Collection|CustomerLedger[] $customer_ledgers
 * @property Collection|Customerdeposit[] $customerdeposits
 * @property Collection|InvoiceReturn[] $invoice_returns
 * @property Collection|InvoiceReturnsItem[] $invoice_returns_items
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 * @property Collection|Invoiceitem[] $invoiceitems
 * @property Collection|Invoice[] $invoices
 * @property Collection|Paymentmethoditem[] $paymentmethoditems
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Customer extends Model
{

    use ModelFilterTraits;

	protected $table = 'customers';

	protected $casts = [
		'status' => 'bool',
		'deposit_balance' => 'float',
		'credit_balance' => 'float'
	];

	protected $fillable = [
		'type',
		'firstname',
		'lastname',
		'company_name',
		'contact_user',
		'email',
		'status',
		'address',
		'phone_number',
		'deposit_balance',
		'credit_balance'
	];

    public function updateCreditBalance()
    {
       $this->credit_balance =  $this->creditpaymentlogs()->sum('amount');
       $this->update();
    }


    public function updateDepositBalance()
    {
        $this->deposit_balance = $this->customerdeposits()->sum('amount');
        $this->update();
    }

	public function creditpaymentlogs()
	{
		return $this->hasMany(Creditpaymentlog::class);
	}

	public function customer_ledgers()
	{
		return $this->hasMany(CustomerLedger::class);
	}

	public function customerdeposits()
	{
		return $this->hasMany(Customerdeposit::class);
	}

	public function invoice_returns()
	{
		return $this->hasMany(InvoiceReturn::class);
	}

	public function invoice_returns_items()
	{
		return $this->hasMany(InvoiceReturnsItem::class);
	}

	public function invoiceitembatches()
	{
		return $this->hasMany(Invoiceitembatch::class);
	}

	public function invoiceitems()
	{
		return $this->hasMany(Invoiceitem::class);
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function paymentmethoditems()
	{
		return $this->hasMany(Paymentmethoditem::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}
}

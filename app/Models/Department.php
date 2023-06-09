<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;


/**
 * Class Department
 *
 * @property int $id
 * @property string $name
 * @property string|null $quantity_column
 * @property string $department_type
 * @property bool $status
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|InvoiceReturn[] $invoice_returns
 * @property Collection|InvoiceReturnsItem[] $invoice_returns_items
 * @property Collection|Invoiceitembatch[] $invoiceitembatches
 * @property Collection|Invoiceitem[] $invoiceitems
 * @property Collection|Invoice[] $invoices
 * @property Collection|MaterialRequestItem[] $material_request_items
 * @property Collection|MaterialReturnItem[] $material_return_items
 * @property Collection|ProductionMaterialItem[] $production_material_items
 * @property Collection|Purchaseorderitem[] $purchaseorderitems
 * @property Collection|Purchaseorder[] $purchaseorders
 * @property Collection|Rawmaterial[] $rawmaterials
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Department extends Model
{
	use SoftDeletes, ModelFilterTraits;
	protected $table = 'departments';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'quantity_column',
		'department_type',
		'status'
	];

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

	public function material_request_items()
	{
		return $this->hasMany(MaterialRequestItem::class);
	}

	public function material_return_items()
	{
		return $this->hasMany(MaterialReturnItem::class);
	}

	public function production_material_items()
	{
		return $this->hasMany(ProductionMaterialItem::class);
	}

	public function purchaseorderitems()
	{
		return $this->hasMany(Purchaseorderitem::class);
	}

	public function purchaseorders()
	{
		return $this->hasMany(Purchaseorder::class);
	}

	public function rawmaterials()
	{
		return $this->hasMany(Rawmaterial::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}


    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::creating(function(Department $model){
            $value = generateRandom(5);

            Schema::table("stockbatches", function (Blueprint $table) use(& $value) {
                $table->decimal($value."pieces")->default(0)->after("pieces");
                $table->decimal($value."quantity")->default(0)->after("quantity");
            });

            Schema::table("stocks", function (Blueprint $table) use(& $value) {
                $table->decimal($value."pieces")->default(0)->after("pieces");
                $table->decimal($value."quantity")->default(0)->after("quantity");
            });

            Schema::table("stockopenings", function (Blueprint $table) use(& $value) {
                $table->decimal($value."pieces")->default(0)->after("pieces");
                $table->decimal($value."quantity")->default(0)->after("quantity");
            });

            $model->quantity_column = $value;
        });

        self::created(function(Department $model){
            Cache::forget('departments');
            departments();
        });
    }

}

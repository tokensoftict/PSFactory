<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ModelFilterTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $phone
 * @property int $usergroup_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $status
 * @property Carbon|null $last_login
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Usergroup $usergroup
 * @property Collection|Invoiceactivitylog[] $invoiceactivitylogs
 * @property Collection|Invoiceitem[] $invoiceitems
 * @property Collection|Invoice[] $invoices
 * @property Collection|Paymentmethoditem[] $paymentmethoditems
 * @property Collection|Payment[] $payments
 * @property Collection|Purchaseorderitem[] $purchaseorderitems
 * @property Collection|Purchaseorder[] $purchaseorders
 * @property Collection|Rawmaterialbincard[] $rawmaterialbincards
 * @property Collection|Stockbincard[] $stockbincards
 * @property Collection|Stock[] $stocks
 *
 * @package App\Models
 */

class User extends Authenticatable
{
    use ModelFilterTraits;
    use HasApiTokens, HasFactory, Notifiable;


    public static array $profile_fields = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $casts = [
        'usergroup_id' => 'int',
        'status' => 'bool'
    ];

    protected $dates = [
        'email_verified_at',
        'last_login'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'usergroup_id',
        'department_id',
        'email',
        'email_verified_at',
        'password',
        'status',
        'last_login',
        'remember_token'
    ];

    public function isSuperAmin()
    {
        return $this->usergroup_id === 1;
    }


    public function usergroup()
    {
        return $this->belongsTo(Usergroup::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function invoiceactivitylogs()
    {
        return $this->hasMany(Invoiceactivitylog::class);
    }

    public function invoiceitems()
    {
        return $this->hasMany(Invoiceitem::class, 'discount_added_by');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'voided_by');
    }

    public function paymentmethoditems()
    {
        return $this->hasMany(Paymentmethoditem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function purchaseorderitems()
    {
        return $this->hasMany(Purchaseorderitem::class, 'added_by');
    }

    public function purchaseorders()
    {
        return $this->hasMany(Purchaseorder::class, 'updated_by');
    }

    public function rawmaterialbincards()
    {
        return $this->hasMany(Rawmaterialbincard::class);
    }

    public function stockbincards()
    {
        return $this->hasMany(Stockbincard::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}

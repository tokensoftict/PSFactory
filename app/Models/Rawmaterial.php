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
 * Class Rawmaterial
 *
 * @property int $id
 * @property string $name
 * @property float $measurement
 * @property float $cost_price
 * @property string|null $description
 * @property int|null $materialtype_id
 * @property int|null $department_id
 * @property bool $expiry
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Department|null $department
 * @property Materialtype|null $materialtype
 * @property Collection|Rawmaterialbatch[] $rawmaterialbatches
 * @property Collection|Rawmaterialbincard[] $rawmaterialbincards
 * @property Collection|Rawmaterialopening[] $rawmaterialopenings
 *
 * @package App\Models
 */
class Rawmaterial extends Model
{
    use ModelFilterTraits;

    protected $table = 'rawmaterials';

    protected $casts = [
        'measurement' => 'float',
        'cost_price' => 'float',
        'materialtype_id' => 'int',
        'department_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'measurement',
        'cost_price',
        'description',
        'materialtype_id',
        'department_id',
        'expiry',
        'status',
        'cost_price'
    ];



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function materialtype()
    {
        return $this->belongsTo(Materialtype::class);
    }

    public function rawmaterialbatches()
    {
        return $this->hasMany(Rawmaterialbatch::class);
    }

    public function rawmaterialbincards()
    {
        return $this->hasMany(Rawmaterialbincard::class);
    }

    public function rawmaterialopenings()
    {
        return $this->hasMany(Rawmaterialopening::class);
    }

    public function getBatches($measurement)
    {
        $batch_ids = [];
        if(!$this->rawmaterialbatches()->exists()) return false;

        $batches = $this->rawmaterialbatches()->where("measurement", ">", "0")->orderBy("expiry_date", "ASC")->get();
        if ($batches->count() == 0) return false;

        foreach($batches as $batch) {
            if($batch->measurement - $measurement < 0){
                $quantity = $measurement - $batch->measurement;
                $b = $batch->toArray();
                $b['measurement'] = $batch->measurement;
                $b['from'] = 'measurement';
                $batch_ids[$batch->id] =$b;
            }else{
                $batch->measurement = $batch->measurement - $measurement;
                $b = $batch->toArray();
                $b['measurement'] = $measurement;
                $b['from'] = 'measurement';
                $batch_ids[$batch->id] = $b;
                $quantity = 0;
            }
            if($quantity === 0)  return $batch_ids;
        }

        if($quantity != 0) return false;

        if($quantity == 0) return $batch_ids;

        return false;
    }


    public function remove($batches){
        foreach ($batches as $key=>$batch){
            $rawbatch = Rawmaterialbatch::find($key);
            $rawbatch->{$batch['from']} =   $rawbatch->{$batch['from']} - $batch['measurement'];
            $rawbatch->update();
        }
        $this->updateAvailableQuantity();
    }

    public function add($measurement){
        $batch = $this->rawmaterialbatches()->orderBy("expiry_date", "DESC")->first();
        $batch->measurement =  $batch->measurement+$measurement;
        $batch->update();
        $this->updateAvailableQuantity();
    }


    public function updateAvailableQuantity()
    {
        $this->measurement = $this->rawmaterialbatches()->where('measurement',">",0)->sum('measurement');
        $this->update();
    }
}

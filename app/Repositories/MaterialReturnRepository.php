<?php

namespace App\Repositories;

use App\Models\MaterialReturn;
use App\Models\MaterialReturnItem;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use App\Models\Rawmaterial;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MaterialReturnRepository
{


    public function __construct()
    {

    }

    public static function materialReturn(MaterialReturn $materialReturn) : array{
        return [
            'return_date' =>  $materialReturn->return_date ? mysql_str_date($materialReturn->return_date) :  dailyDate(),
            'return_time' => $materialReturn->return_time ?? Carbon::now()->toDateTimeLocalString(),
            'return_by_id' => $materialReturn->return_by_id ?? auth()->id(),
            'return_type' =>  $materialReturn->return_type ?? "",
            'return_id' => $materialReturn->return_id ??  "",
            "status_id" =>  $materialReturn->status_id ?? status('Pending'),
            'description' => "",
            'material_return_items' => $materialReturn->material_return_items->count() > 0 ? json_encode($materialReturn->material_return_items->map(function($item){
                $item->extra = ($item->extra == "1" ?  "1" : "0");
                return Arr::only($item->toArray(), ['name','rawmaterial_id','department_id','measurement','unit','extra']);
            })->toArray()) : json_encode([])
        ];
    }



    public function createReturn($data) : MaterialReturn
    {
        $data['return_time'] =  Carbon::now()->toDateTimeLocalString();
        $data['return_type'] = !empty($data['return_id']) ? Production::class : "App\\Models\\Othereturns";
        $data['return_id'] = empty($data['return_id']) ? NULL : $data['return_id'];

        $material_items = $data['material_return_items'];

        unset($data['material_return_items']);

        $return = MaterialReturn::create($data);

        $items = [];

        foreach ($material_items as $material_item)
        {

            $material = Rawmaterial::find($material_item['rawmaterial_id']);

            $it =  array_merge(
                $material_item,
                [
                    'returntype_type' => $return->return_type == Production::class ? ProductionMaterialItem::class : $return->return_type,
                    'department_id' =>  $material->department_id,
                    'status_id' => status('Pending'),
                    'convert_measurement' =>  UnitConverterRepository::convert(
                        $material->materialtype->storage_measurement_unit,
                        $material->materialtype->production_measurement_unit,
                        $material_item['measurement']),
                    'unit' => $material->materialtype->storage_measurement_unit,
                    'convert_unit' => $material->materialtype->production_measurement_unit,

                ]);

            if(isset($material_item['returntype_id']) && is_numeric($material_item['returntype_id'])){
                $it['returntype_id'] = $material_item['returntype_id'];
            }else{
                $it['returntype_id'] = ($return->return_type == Production::class) ? $this->getProductionExtraMaterialRequest($return->return, $material_item['rawmaterial_id'], $material_item['extra']) : $return->return_id;
            }
            $items[] = new MaterialReturnItem($it);
        }

        $return->material_return_items()->saveMany( $items);

        return $return;
    }

    private function getProductionExtraMaterialRequest(Production $production, int $material_id, bool $extra) : int
    {
       return  $productionMaterial = $production->production_material_items()->where('rawmaterial_id', $material_id)
            ->where('extra', $extra)?->first()?->id;
    }

    public function updateReturn(MaterialReturn $return, $data) : MaterialReturn {

        $data['return_time'] =  Carbon::now()->toDateTimeLocalString();
        $data['return_type'] = !empty($data['return_id']) ? Production::class : "App\\Models\\Othereturns";
        $data['return_id'] = empty($data['return_id']) ? NULL : $data['return_id'];

        $material_items = $data['material_return_items'];

        unset($data['material_return_items']);

        $return->update($data);

        foreach ($return->material_return_items as $returnItem)
        {
            if($returnItem->returntype_type === ProductionMaterialItem::class){
                $returnItem->returntype->delete();
            }

        }

        $return->material_return_items()->delete();

        $items = [];

        foreach ($material_items as $material_item)
        {

            $material = Rawmaterial::find($material_item['rawmaterial_id']);

            $it =  array_merge(
                $material_item,
                [
                    'returntype_type' => $return->return_type == Production::class ? ProductionMaterialItem::class : $return->return_type,
                    'department_id' =>  $material->department_id,
                    'status_id' => status('Pending'),
                    'convert_measurement' =>  UnitConverterRepository::convert(
                        $material->materialtype->storage_measurement_unit,
                        $material->materialtype->production_measurement_unit,
                        $material_item['measurement']),
                    'unit' => $material->materialtype->storage_measurement_unit,
                    'convert_unit' => $material->materialtype->production_measurement_unit,

                ]);

            if(isset($material_item['returntype_id']) && is_numeric($material_item['returntype_id'])){
                $it['returntype_id'] = $material_item['returntype_id'];
            }else{
                $it['returntype_id'] = ($return->return_type == Production::class) ? $this->getProductionExtraMaterialRequest($return->return, $material_item['rawmaterial_id'], $material_item['extra']) : $return->return_id;
            }

            $items[] = new MaterialReturnItem($it);
        }

        $return->material_return_items()->saveMany( $items);

        return $return;
    }


    public function destroy($id)
    {
        MaterialReturn::find($id) -> delete();
    }


}

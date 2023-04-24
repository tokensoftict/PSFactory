<?php

namespace App\Repositories;

use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use App\Models\Rawmaterial;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MaterialRequestRepository
{

    private ProductionRepository $productionRepository;

    public function __construct()
    {
        $this->productionRepository = new ProductionRepository();
    }

    public static function materialRequest(MaterialRequest $materialRequest) : array{
        return [
            'request_date' =>  $materialRequest->request_date ? mysql_str_date($materialRequest->request_date) :  dailyDate(),
            'request_time' => $materialRequest->request_time ?? Carbon::now()->toDateTimeLocalString(),
            'request_by_id' => $materialRequest->request_by_id ?? auth()->id(),
            'request_type' =>  $materialRequest->request_type ?? "",
            'request_id' => $materialRequest->request_id ??  "",
            "status_id" =>  $materialRequest->status_id ?? status('Pending'),
            'description' => "",
            'material_request_items' => $materialRequest->material_request_items->count() > 0 ? json_encode($materialRequest->material_request_items->map(function($item){
                return Arr::only($item->toArray(), ['name','rawmaterial_id','department_id','measurement','unit']);
            })->toArray()) : json_encode([])
        ];
    }


    private function createProductionExtraMaterialRequest(array $item, MaterialRequest $request) : int
    {
        $item['production_template_id'] =  $request->request->production_template_id;
        unset($item['requesttype_type']);
        return $this->productionRepository->createProductionExtraMaterial(
            $request->request,
            $item
        );
    }

    public function createRequest($data) : MaterialRequest
    {
        $data['request_time'] =  Carbon::now()->toDateTimeLocalString();
        $data['request_type'] = !empty($data['request_id']) ? Production::class : "App\\Models\\Otherequests";
        $data['request_id'] = empty($data['request_id']) ? NULL : $data['request_id'];

        $material_items = $data['material_request_items'];

        unset($data['material_request_items']);

        $request = MaterialRequest::create($data);

        $items = [];

        foreach ($material_items as $material_item)
        {

            $material = Rawmaterial::find($material_item['rawmaterial_id']);

            $it =  array_merge(
                $material_item,
                [
                    'requesttype_type' => $request->request_type == Production::class ? ProductionMaterialItem::class : $request->request_type,
                    'department_id' =>  $material->department_id,
                    'status_id' => status('Pending'),
                    'convert_measurement' =>  UnitConverterRepository::convert(
                        $material->materialtype->production_measurement_unit,
                        $material->materialtype->storage_measurement_unit,
                        $material_item['measurement']),
                    'unit' => $material->materialtype->production_measurement_unit,
                    'convert_unit' => $material->materialtype->storage_measurement_unit,

                ]);

            if(isset($material_item['requesttype_id']) && is_numeric($material_item['requesttype_id'])){
                $it['requesttype_id'] =$material_item['requesttype_id'];
            }else{
                $it['requesttype_id'] = ($request->request_type == Production::class) ? $this->createProductionExtraMaterialRequest($it, $request) : $request->request_id;
            }

            $items[] = new MaterialRequestItem($it);
        }

        $request->material_request_items()->saveMany( $items);

        return $request;
    }


    public function updateRequest(MaterialRequest $request, $data) : MaterialRequest {

        $data['request_time'] =  Carbon::now()->toDateTimeLocalString();
        $data['request_type'] = !empty($data['request_id']) ? Production::class : "App\\Models\\Otherequests";
        $data['request_id'] = empty($data['request_id']) ? NULL : $data['request_id'];

        $material_items = $data['material_request_items'];

        unset($data['material_request_items']);

        $request->update($data);

        foreach ($request->material_request_items as $requestItem)
        {
            if($requestItem->requesttype_type === ProductionMaterialItem::class){
                $requestItem->requesttype->delete();
            }

        }

        $request->material_request_items()->delete();

        $items = [];

        foreach ($material_items as $material_item)
        {

            $material = Rawmaterial::find($material_item['rawmaterial_id']);

            $it =  array_merge(
                $material_item,
                [
                    'requesttype_type' => $request->request_type == Production::class ? ProductionMaterialItem::class : $request->request_type,
                    'department_id' =>  $material->department_id,
                    'status_id' => status('Pending'),
                    'convert_measurement' =>  UnitConverterRepository::convert(
                        $material->materialtype->production_measurement_unit,
                        $material->materialtype->storage_measurement_unit,
                        $material_item['measurement']),
                    'unit' => $material->materialtype->production_measurement_unit,
                    'convert_unit' => $material->materialtype->storage_measurement_unit,

                ]);

            if(isset($material_item['requesttype_id']) && is_numeric($material_item['requesttype_id'])){
                $it['requesttype_id'] =$material_item['requesttype_id'];
            }else{
                $it['requesttype_id'] = ($request->request_type == Production::class) ? $this->createProductionExtraMaterialRequest($it, $request) : $request->request_id;
            }

            $items[] = new MaterialRequestItem($it);
        }

        $request->material_request_items()->saveMany( $items);

        return $request;
    }


    public function destroy($id)
    {
        MaterialRequest::find($id) -> delete();
    }


}

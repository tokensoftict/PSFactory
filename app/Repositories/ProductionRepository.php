<?php

namespace App\Repositories;

use App\Classes\Settings;
use App\Events\MaterialRequestEvent;
use App\Models\Production;
use App\Models\ProductionMaterialItem;
use App\Models\Rawmaterial;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ProductionRepository
{

    public static array $fields = [
        'name' => "",
        'production_date' => "",
        'stock_id' => "",
        'production_template_id' => "",
        "productionline_id" => "",
        'rough_quantity'  => "0",
        'yield_quantity'  => "0",
        'batch_number'  => "",
        'quantity_1'  => "0",
        'quantity_2'  => "0",
        'quantity_3'  => "0",
        'production_time'  => "",
        'status_id'  => "5",
        'remark'  => "",
    ];


    public static array $productionMaterial = [
        'rawmaterial_id' => "",
        'production_template_id' => "",
        "department_id" => "",
        "name" => "",
        "measurement" => 0,
        "unit" => "",
        // "returns" => 0,
        // "production_date" => "",
        // "production_time" => ""
    ];

    public  static array $validation = [
        'data.name' => "required",
        'data.production_date' => "required",
        'data.stock_id' => "required",
        'data.production_template_id' => "required",
        'data.batch_number'  => "required",
        'data.production_time'  => "required",
        'data.status_id'  => "required",
        'data.productionline_id'  => "required",
    ];

    public  static array $messages = [
        'data.name.required' => "Name field is required",
        'data.production_date.required' => "Production date is required",
        'data.stock_id.required' => "Please select product",
        'data.production_template_id.required' => "Production template is required",
        'data.batch_number.required'  => "Batch Number is required",
        'data.production_time.required'  => "Production Time is required",
        'data.status_id.required'  => "Please select production status",
        'data.productionline_id.required'  => "Please select production line",
    ];


    public function __construct()
    {

    }


    public function create($data) : Production
    {
        $data['expected_quantity'] = 0;

        $production =  Production::create($data);

        $production->expected_quantity = $production->production_template->expected_quantity;

        $production->update();

        $production->materialRequest()->delete(); // already requested material

        $this->saveProductionMaterial($production);

        if($production->status_id === status('Waiting-Material'))
        {
            $this->requestMaterial($production);
        }

        return $production;
    }


    public function requestMaterial(Production $production)
    {


        $eventData = [
            'request_date' => dailyDate(),
            'request_time' => Carbon::now()->toDateTimeLocalString(),
            'request_type' => Production::class,
            'request_id' => $production->id,
            'request_by_id' => auth()->id(),
            'status_id' => status('Pending'),
        ];

        $eventData['material_request_items'] = [];

        foreach ($production->production_material_items as $item)
        {
            $eventData['material_request_items'][] = [
                'name' => $item->name,
                'requesttype_type' => get_class($item),
                'requesttype_id' => $item->id,
                'rawmaterial_id' => $item->rawmaterial_id,
                'department_id' => $item->department_id,
                'status_id' => status('Pending'),
                'measurement' => $item->measurement,
                'unit' => $item->unit,
                'convert_measurement' => $item->convert_measurement,
                'convert_unit' => $item->convert_unit,
            ];
        }

        //event(new MaterialRequestEvent($eventData)); // lets pause the event for now

        (new MaterialRequestRepository())->createRequest($eventData);
    }

    public function update(Production $production, $data) : Production
    {
        $production->update($data);

        $production->expected_quantity = $production->production_template->expected_quantity;

        $production->update();

        $production->materialRequest()->delete(); // already requested material

        $this->saveProductionMaterial($production);

        if($production->status_id === status('Waiting-Material'))
        {
            $this->requestMaterial($production);
        }

        return $production;
    }

    public function get($id)
    {
        return Production::find($id);
    }

    public function saveProductionMaterial(Production $production, $extra = false) : Production
    {

        $data_items = $production->production_template->production_template_items()->get()->map->only(...array_keys(self::$productionMaterial))->toArray();

        $data = [];
        foreach ($data_items as $item)
        {
            $data[] = new ProductionMaterialItem($this->prepareProductionItems($item, $production, $extra));
        }

        $production->production_material_items()->delete();

        $production->production_material_items()->saveMany($data);

        return $production;
    }


    public function createProductionExtraMaterial($production, array $item) : int
    {
        return $production->production_material_items()->insertGetId(
            $this->prepareProductionItems($item, $production, true)
        );
    }


    private function prepareProductionItems(array $item, Production $production, $extra = false) : array
    {
        $material = Rawmaterial::find($item['rawmaterial_id']);
        $item['production_date'] = $production->production_date;
        $item['production_time'] = $production->production_time;
        $item['department_id'] =   $material->department_id;
        $item['returns'] = 0;
        $item['extra'] = !$extra ? 0 : 1;
        $item['production_id'] = $production->id;
        $item['convert_measurement'] = UnitConverterRepository::convert(
            $material->materialtype->production_measurement_unit,
            $material->materialtype->storage_measurement_unit,
            $item['measurement']
        );
        $item['unit'] = $material->materialtype->production_measurement_unit;
        $item['convert_unit'] = $material->materialtype->storage_measurement_unit;
        $item['status_id'] = status('Pending');

        return $item;
    }


    public function destroy($id) : void
    {
        $this->get($id)->delete();
    }

}

<?php

namespace App\Repositories;

use App\Models\ProductionTemplate;
use App\Models\ProductionTemplateItem;

class ProductProductionTemplateRepository
{
    public function __construct()
    {
        //
    }

    public function create($data) : ProductionTemplate
    {

        return ProductionTemplate::create($data);
    }


    public function getTemplate($id) : ProductionTemplate
    {

        return ProductionTemplate::find($id);
    }


    public function update($id, $data) : ProductionTemplate
    {

        $template  = $this->getTemplate($id);

        $template->update($data);

        return $template;
    }

    public function destroy($id) : void
    {
        $this->getTemplate($id)->delete();
    }

    public function saveTemplateMaterialItems(ProductionTemplate $productionTemplate, array $items)
    {
        $materialItems = [];
        foreach ($items as $item)
        {
            $materialItems[] = new ProductionTemplateItem($item);
        }

        $productionTemplate->production_template_items()->saveMany($materialItems);

    }
}

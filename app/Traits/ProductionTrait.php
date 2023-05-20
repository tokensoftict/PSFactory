<?php
namespace App\Traits;

use App\Models\Production;

trait ProductionTrait
{

    public function rollbackProduction(Production $production)
    {
        if(!isset( $this->production))
        {
            $this->production = $production;
        }
        $this->production->status_id = status('In-Progress');
        $this->production->update();

        $this->alert(
            "success",
            "Production",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Production has been rollback successfully!.",
            ]
        );

        return redirect()->route('production.index');
    }


    public function deleteProduction(Production $production)
    {
        $this->production->delete();

        $this->alert(
            "success",
            "Production",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  "Production has been deleted successfully!.",
            ]
        );

        return redirect()->route('production.index');
    }

}

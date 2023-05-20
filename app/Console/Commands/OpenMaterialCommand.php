<?php

namespace App\Console\Commands;

use App\Classes\Settings;
use App\Models\Rawmaterial;
use App\Models\Rawmaterialopening;
use Illuminate\Console\Command;

class OpenMaterialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:material';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs every day by 1:00 ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Settings $settings)
    {
        if($settings->get('material_opening') == "backgroundprocess")
        {
            $this->info('Material Opening has already running to day');

            return Command::SUCCESS;
        }
        $settings->put('material_opening', 'backgroundprocess');

        $open = Rawmaterialopening::where('date_added',todaysDate())->get();

        if($open->count() === 0) {

            Rawmaterial::with(['rawmaterialbatches'])->where('status', 1)->chunk(1000, function ($materials) {

                foreach ($materials as $material) {

                    $batches = $material->rawmaterialbatches;

                    $average_cost = 0;
                    $total_qty = 0;

                    foreach ($batches as $batch) {
                        $total_qty += $batch->measurement;
                        $average_cost+= $total_qty *  $batch->cost_price;
                    }

                    $tt_average_cost = ($average_cost == 0 ? 0 : round($average_cost /  $total_qty));

                    $opening = [
                        'rawmaterial_id' => $material->id,
                        'average_cost_price' => $tt_average_cost,
                        'date_added' => todaysDate(),
                        'measurement' => $total_qty,
                    ];

                    Rawmaterialopening::create($opening);
                }
            });

        }

        $settings->put('material_opening', 'okay');
        return Command::SUCCESS;
    }
}

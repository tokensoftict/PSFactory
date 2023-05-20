<?php

namespace App\Console\Commands;

use App\Classes\Settings;
use App\Models\Stock;
use App\Models\Stockopening;
use Illuminate\Console\Command;

class OpenStockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs every day by 12:30 ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Settings $settings)
    {

        if($settings->get('stock_opening') == "backgroundprocess")
        {
            $this->info('Stock Opening has already running to day');

            return Command::SUCCESS;
        }

        $settings->put('stock_opening', 'backgroundprocess');

        $open = Stockopening::where('date_added',todaysDate())->get();

        if($open->count() === 0) {

            Stock::with(['stockbatches'])->where('status', 1)->chunk(1000, function ($stocks) {
                foreach ($stocks as $stock) {

                    $batches = $stock->stockbatches;

                    $average_cost = 0;
                    $total_qty = 0;
                    foreach ($batches as $batch) {
                        $salesDepartments = salesDepartments(true);
                        $total_carton = 0;
                        $total_pieces = 0;
                        $average_cost = 0;
                        foreach ($salesDepartments as $department){
                            // $dept->quantity_column.'pieces'
                            $total_carton += $batch->{$department->quantity_column.'quantity'};
                            $total_pieces += $batch->{$department->quantity_column.'pieces'};
                        }
                        $average_cost+= $total_carton *  $batch->cost_price;
                    }

                    $tt_average_cost = ($average_cost == 0 ? 0 : round($average_cost /  $total_carton));

                    $opening = [
                        'stock_id' => $stock->id,
                        'average_cost_price' => $tt_average_cost,
                        'date_added' => todaysDate()
                    ];

                    foreach ($salesDepartments as $department){
                        $opening[$department->quantity_column.'quantity'] = $stock->{$department->quantity_column.'quantity'};
                        $opening[$department->quantity_column.'pieces'] = $stock->{$department->quantity_column.'pieces'};
                    }

                    Stockopening::create($opening);

                }
            });

        }
        $settings->put('stock_opening', 'okay');
        return Command::SUCCESS;
    }
}

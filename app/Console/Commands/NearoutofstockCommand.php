<?php

namespace App\Console\Commands;

use App\Classes\Settings;
use App\Models\Invoiceitembatch;
use App\Models\Nearoutofstock;
use App\Models\Production;
use App\Models\Purchaseorderitem;
use App\Models\Stock;
use App\Models\Stockopening;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NearoutofstockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neartoutof:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Near Out Of Product';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Settings $settings)
    {
        $store = $settings->store();

        if($store->nearos_status === "backgroundprocess"){
            $this->info("Stock Os is already running");
            return Command::SUCCESS;
        }

        $settings->put('nearos_status', 'backgroundprocess');

        Nearoutofstock::truncate();


        $stocks = Stock::where('status',"1")->get();

        foreach($stocks as $stock) {

            $day = $store->threshold_days;
            $supply_days = $stock->lead_time; //lead time
            $threshold_day = $store->qty_to_buy_threshold;
            $from = date('Y-m-d', strtotime(' - ' . $day . ' days'));
            $to = todaysDate();

            $qty = 0;

            $_product =   Invoiceitembatch::select(
                'stock_id',
                DB::raw( 'SUM(quantity) as qty')
            )
                ->where('stock_id',$stock->id)
                ->whereHas('invoice',function($q) use(&$from,$to){
                    $q->whereBetween('invoice_date',[$from,$to]);
                })
                ->groupBy('stock_id')
                ->first();
            if($_product->count() > 0) {
                $p = $_product->toArray();
                $qty+=$p['qty'];
            }

            $thresholad_score = round(abs(($qty/$day) * $supply_days));

            $now_qty = $stock->totalBalance();

            $qty_to_buy = $qty * $threshold_day;

            if($thresholad_score > $now_qty){

                $insert = [
                    'stock_id' => $stock->id,
                    'threshold_type'=>"THRESHOLD",
                    'toBuy' =>  $qty_to_buy,
                    'threshold' => $thresholad_score,
                    'quantity' => $now_qty,
                    'sold' => $qty
                ];

            }else if($now_qty < 2){
                $insert = [
                    'stock_id' => $stock->id,
                    'threshold_type'=>"NORMAL",
                    'toBuy' =>  $qty_to_buy,
                    'threshold' => $thresholad_score,
                    'quantity' => $now_qty,
                    'sold' => $qty
                ];
            }

            if(isset($insert))
            {
                Stockopening::create($insert);
            }

        }

        $settings->put('nearos_status', 'okay');
        $settings->put('nearos_last_run', Carbon::now()->toDateTimeLocalString());
        $settings->put('p_run_nears', 'okay');

        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Classes\Settings;
use App\Models\MaterialRequestItem;
use App\Models\Nearoutofmaterial;
use App\Models\Rawmaterial;
use App\Models\Stockopening;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NearourofMaterialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neartoutof:material';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Near Out Of Material';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Settings $settings)
    {

        $store = $settings->store();
        if($store->material_nearos_status === "backgroundprocess"){
            $this->info("Material Os is already running");
            return Command::SUCCESS;
        }

        $settings->put('material_nearos_status', 'backgroundprocess');

        Nearoutofmaterial::truncate();

        $materials = Rawmaterial::where('status', 1)->get();

        foreach($materials as $material) {

            $day = $store->material_threshold_days;
            $supply_days = $material->lead_time; //lead time
            $threshold_day = $store->material_qty_to_buy_threshold;
            $from = date('Y-m-d', strtotime(' - ' . $day . ' days'));
            $to = todaysDate();

            $qty = 0;

            $_material = MaterialRequestItem::select(
                'rawmaterial_id',
                DB::raw( 'SUM(convert_measurement) as convert_measurement')
            )->where('rawmaterial_id',$material->id)
                ->whereHas('material_request', function ($q) use ($from, $to) {
                    $q->whereBetween('request_date',[$from,$to])->where('status_id', status('Approved'));
                })
                ->groupBy('rawmaterial_id')->first();

            if($_material) {
                $p = $_material->toArray();
                $qty+=$p['convert_measurement'];
            }

            $thresholad_score = round(abs(($qty/$day) * $supply_days));

            $now_qty = $material->measurement;
            $qty_to_buy = $qty * $threshold_day;
            if($thresholad_score > $now_qty){
                $insert = [
                    'rawmaterial_id' => $material->id,
                    'threshold_type'=>"THRESHOLD",
                    'toBuy' =>  $qty_to_buy,
                    'threshold' => $thresholad_score,
                    'quantity' => $now_qty,
                    'used' => $qty
                ];
            }else if($now_qty < 2){

                $insert = [
                    'rawmaterial_id' => $material->id,
                    'threshold_type'=>"NORMAL",
                    'toBuy' =>  $qty_to_buy,
                    'threshold' => $thresholad_score,
                    'quantity' => $now_qty,
                    'used' => $qty
                ];
            }

            if(isset($insert))
            {
                Nearoutofmaterial::create($insert);
                unset($insert);
            }

        }

        $settings->put('material_nearos_status', 'okay');
        $settings->put('material_nearos_status_last_run', Carbon::now()->toDateTimeLocalString());
        $settings->put('m_run_nears', 'okay');
        return Command::SUCCESS;
    }
}

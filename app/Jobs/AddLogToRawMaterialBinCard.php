<?php

namespace App\Jobs;

use App\Models\Rawmaterialbincard;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddLogToRawMaterialBinCard //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $rawbincards;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $rawbincards)
    {
        $this->rawbincards = $rawbincards;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->rawbincards =  collect($this->rawbincards)
            ->map(function($item){
                $item['created_at'] = Carbon::now()->toDateTimeLocalString();
                $item['updated_at'] = Carbon::now()->toDateTimeLocalString();
                return $item;
            })->toArray();  // ad created and updated filed to column

        Rawmaterialbincard::insert($this->rawbincards);
    }
}

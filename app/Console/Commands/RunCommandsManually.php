<?php

namespace App\Console\Commands;

use App\Classes\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunCommandsManually extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $settings = app(Settings::class);

        if($settings->get('p_run_nears') === "run"){
            $settings->put("p_run_nears", 'running');
            $settings->put("nearos_status", 'okay');
            $this->info("Product Near Os is now running");
            Artisan::call('neartoutof:product');

        }

        // this handle running of
        if($settings->get('m_run_nears') === "run"){
            $settings->put("m_run_nears", 'running');
            $settings->put("material_nearos_status", 'okay');

            $this->info("Material Near is now running");

            Artisan::call('neartoutof:material');
        }




        return Command::SUCCESS;
    }
}

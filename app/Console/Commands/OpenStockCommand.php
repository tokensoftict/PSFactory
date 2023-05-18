<?php

namespace App\Console\Commands;

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
    public function handle()
    {


        return Command::SUCCESS;
    }
}

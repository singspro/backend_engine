<?php

namespace App\Console\Commands;

use App\Http\Controllers\readinessDataLogger;
use Illuminate\Console\Command;

class readinessLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:readiness-logger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $exelog=new readinessDataLogger();
        $exelog->logDataReadiness();
    }
}

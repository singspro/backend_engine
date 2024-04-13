<?php

namespace App\Console\Commands;

use App\Http\Controllers\manpowerLoggerController;
use Illuminate\Console\Command;

class manpowerLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:manpower-logger';

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
        $logger=new manpowerLoggerController;
        $logger->log();
    }
}

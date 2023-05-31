<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ImportAllCommand extends Command
{
    protected $signature = 'import:all';

    protected $description = 'Command description';

    public function handle(): void
    {
        Artisan::call('app:import location');
        Artisan::call('app:import vacancy');
        Artisan::call('app:import application');
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\Imports\ImportJob;
use App\Models\Application;
use App\Models\Location;
use App\Models\Vacancy;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import {type : types of importing can be vacancy, application or location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for handling importing three types of models from kik api.';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        // $model = '\App\Models\\'.ucfirst($type);

        config('import.pattern')[$type]['job']::dispatch(
            config('services.wordpress.base_url') . config('import.pattern')[$type]['url'] . '?per_page=100',
            config('import.pattern')[$type]['pattern']
        );
    }
}

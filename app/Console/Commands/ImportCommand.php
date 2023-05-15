<?php

namespace App\Console\Commands;

use App\Jobs\Imports\ImportVacancy;
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
    public function handle(ImportVacancy $importjob)
    {
        //TODO choose creating three different jobs or one job for all
        $type = $this->choice(
            'What is your type?',
            ['vacancy', 'application', 'location'],
            'location'
        );

        if($type === 'vacancy')
            $importjob->dispatch();


    }
}

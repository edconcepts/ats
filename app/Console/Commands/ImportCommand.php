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

    //TODO maybe move this somewhere else
    protected $importData = [
        'vacancy' => [
            'model' => '\App\Models\Vacancy',
            'job' => '\App\Jobs\Imports\ImportVacancy',
            'pattern' => [
                'kik_id' => 'id',
                'slug' => 'slug',
                'title' => 'title.rendered',
                'kik_date' => 'date',
                'location_id' => 'vacancy-location.0',
            ],
            'url' => 'http://staging.werkenbijkik.nl/wp-json/wp/v2/vacatures',
        ],
        'application' => [
            'model' => '\App\Models\Application',
            'job' => '\App\Jobs\Imports\ImportApplication',
            'pattern' => [
                    'kik_id' => 'id',
                    'slug' => 'slug',
                    'title' => 'title.rendered',
                    'kik_date' => 'date',
                    'vacancy_id' => 'meta.vacature',
                    'name' => 'meta.naam',
                    'phone_number' => 'meta.telefoonnummer',
                    'email' => 'meta.email',
                    'kik_application_status' => 'meta.applicant-status'
            ],
            'url' => 'http://staging.werkenbijkik.nl/wp-json/wp/v2/solicitaties',
        ],
        'location' => [
            'model' => '\App\Models\Location',
            'job' => '\App\Jobs\Imports\ImportLocation',
            'pattern' => [
                'name' => 'name',
                'kik_id' => 'id',
                'description' => 'description',
                'slug' => 'slug',
            ],
            'url' => 'http://staging.werkenbijkik.nl/wp-json/wp/v2/vacancy-location',
        ],
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->choice(
            'What is your type?',
            ['vacancy', 'application', 'location'],
            'location'
        );
        // $model = '\App\Models\\'.ucfirst($type);

        $this->importData[$type]['job']::dispatch(
            $this->importData[$type]['url'],
            $this->importData[$type]['pattern']
        );
    }
}

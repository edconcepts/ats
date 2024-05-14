<?php

return [
    'pattern' => [
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
            'url' => 'vacatures',
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
                    'resume' => 'meta.cv',
                    'kik_application_status' => 'meta.applicant-status'
            ],
            'url' => 'solicitaties',
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
            'url' => 'vacancy-location',
        ],
    ]
];

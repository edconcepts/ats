<?php

namespace App\Jobs\Imports;

use App\Actions\ImportAction;
use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportVacancy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $pattern = [
        'kik_id' => 'id',
        'slug' => 'slug',
        'title' => 'title.rendered',
        'kik_date' => 'date',
        'location_id' => 'vacancy-location.0',
    ];
    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $url = 'http://staging.werkenbijkik.nl/wp-json/wp/v2/vacatures')
    {}

    /**
     * Execute the job.
     */
    public function handle(ImportAction $importAction): void
    {
        //TODO maybe turn it into a job where it gets the model to insert to
        $vacancies = $importAction->execute($this->url, $this->pattern);

        $oldVacanciesId = Vacancy::all()->pluck('kik_id');

        $newVacancies = $vacancies->whereNotIn('kik_id',$oldVacanciesId);

        Vacancy::insert($newVacancies->toArray());

    }
}

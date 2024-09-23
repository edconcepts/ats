<?php

namespace App\Http\Controllers\HumanResources;

use App\Actions\GetTaxonomiesListAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\UpdateVacancyRequest;
use App\Models\Location;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VacancyController extends Controller
{
    public function index()
    {
        $this->authorize('index', Vacancy::class);

        $wpUser = config('services.wordpress.user');
        $wpPassword = config('services.wordpress.pass');

        // No credentials, returning database data
        if (empty($wpUser) || empty($wpPassword)) {
            return Inertia::render('HR/Vacancies/Overview', [
                'locations' => Location::all(),
                'vacancies' => Vacancy::all(),
                'pages' => 1,
                'current_page' => request()->input('page', 1),
            ]);
        }

        $req = Http::withBasicAuth(
            $wpUser,
            $wpPassword
        )->get(
            config('services.wordpress.base_url') . 'vacatures?per_page=100&status=draft,publish,pending&page=' . request()->get('page', 1)
        );

        $vacancies = $req->json();
        $pages = $req->headers()['X-WP-TotalPages'][0];

        if ($pages > 1) {
            for ($i = 2; $i <= $pages; $i++) {
                $req = Http::withBasicAuth(
                    $wpUser,
                    $wpPassword
                )->get(
                    config('services.wordpress.base_url') . 'vacatures?per_page=100&status=draft,publish,pending&page=' . $i
                );

                $vacancies = array_merge($vacancies, $req->json());
            }
        }

        foreach ($vacancies as $index => $vacancy) {
            $location = Location::withCount('applications')
                ->where('kik_id', $vacancy['vacancy-location'][0] ?? null)
                ->first();

            $vacancies[$index]['location'] = $location->name ?? '-';
            $vacancies[$index]['location_id'] = $location->kik_id ?? null;

            $vacancies[$index]['applications_count'] = $location->applications_count ?? 0;
            if (empty($vacancy['end_date']))
                $vacancies[$index]['end_date'] = '-';
            elseif (is_numeric($vacancy['end_date']))
                $vacancies[$index]['end_date'] = Carbon::createFromTimestamp($vacancy['end_date'])->format('d-m-Y');
            else
                $vacancies[$index]['end_date'] = Carbon::parse($vacancy['end_date'])->format('d-m-Y');
        }


        return Inertia::render('HR/Vacancies/Overview', [
            'locations' => Location::all(),
            'vacancies' => $vacancies,
            'pages' => $pages,
            'current_page' => request()->input('page', 1),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Vacancy::class);

        $getTaxonomiesAction = new GetTaxonomiesListAction();
        $taxonomies = $getTaxonomiesAction->execute();

        return Inertia::render('HR/Vacancies/Create', [
            'taxonomies' => $taxonomies,
        ]);
    }

    public function store(UpdateVacancyRequest $request)
    {
        $this->authorize('store', Vacancy::class);

        try {
            $response = Http::withBasicAuth(
                config('services.wordpress.user'),
                config('services.wordpress.pass')
            )->post(config('services.wordpress.base_url') . 'vacatures', [
                'title' => $request->input('title'),
//                'video_url' => $request->input('video_url'),
                '_salary' => $request->input('_salary'),
                '_job-description' => $request->input('job_description'),
                '_requirements' => $request->input('_requirements'),
                'opleidingsniveau' => $request->input('opleidingsniveau'),
                '_responsibilities' => $request->input('_responsibilities'),
                'end_date' => $request->input('end_date'),
                'vacancy-location' => $request->input('vacancyLocation'),
                'categorieen' => $request->input('categorieen'),
                'job-boards' => $request->input('jobBoards'),
                'status' => $request->input('status'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($vacancy_id)
    {
        $this->authorize('edit', Vacancy::class);

        $wpUser = config('services.wordpress.user');
        $wpPassword = config('services.wordpress.pass');

        // No credentials, returning database data
        if (empty($wpUser) || empty($wpPassword)) {
            // Setting keys so page renders.
            $vacancy = Vacancy::findOrFail($vacancy_id);
            $vacancy->meta = [];
            $vacancy->categorieen = [];
            $vacancy->{'vacancy-location'} = [$vacancy->location->kik_id];

            return Inertia::render('HR/Vacancies/Edit', [
                'vacancy' => $vacancy,
                'taxonomies' => [
                    'job-boards' => [],
                    'opleidingsniveau' => [],
                ],
            ]);
        }

        $url = config('services.wordpress.base_url') . 'vacatures/' . $vacancy_id;

        $vacancy = Http::withBasicAuth(
            $wpUser,
            $wpPassword
        )->get($url)->json();

        $getTaxonomiesAction = new GetTaxonomiesListAction();
        $taxonomies = $getTaxonomiesAction->execute();

        return Inertia::render('HR/Vacancies/Edit', [
            'vacancy' => $vacancy,
            'taxonomies' => $taxonomies,
        ]);
    }

    public function update(UpdateVacancyRequest $request, $vacancy_id)
    {
        $this->authorize('update', Vacancy::class);

        try {
            $response = Http::withBasicAuth(
                config('services.wordpress.user'),
                config('services.wordpress.pass')
            )->post(config('services.wordpress.base_url') . 'vacatures/' . $vacancy_id, [
                'title' => $request->input('title'),
//                'video_url' => $request->input('video_url'),
                '_salary' => $request->input('_salary'),
                '_job-description' => $request->input('job_description'),
                '_requirements' => $request->input('_requirements'),
                'opleidingsniveau' => $request->input('opleidingsniveau'),
                '_responsibilities' => $request->input('_responsibilities'),
                'end_date' => $request->input('end_date'),
                'vacancy-location' => $request->input('vacancyLocation'),
                'categorieen' => $request->input('categorieen'),
                'job-boards' => $request->input('jobBoards'),
                'status' => $request->input('status'),
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function destroy($vacancy_id)
    {
        $this->authorize('delete', Vacancy::class);

        Vacancy::find($vacancy_id)?->delete();
        $this->changeStatus($vacancy_id, 'trash');

        return redirect()->route('vacancies.index');
    }

    public function changeStatus($vacancy_id, $status)
    {
        try {
            $response = Http::withBasicAuth(
                config('services.wordpress.user'),
                config('services.wordpress.pass')
            )->post(config('services.wordpress.base_url') . 'vacatures/' . $vacancy_id, [
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

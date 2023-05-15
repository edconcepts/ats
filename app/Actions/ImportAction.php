<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ImportAction
{
    // public function __construct(
    //     private string $url = 'http://staging.werkenbijkik.nl/wp-json/wp/v2/solicitaties',
    //     private array $pattern =  [
    //         'kik_id' => 'id',
    //         'slug' => 'slug',
    //         'title' => 'title.rendered',
    //         'date' => 'kik_id',
    //         'vacancy_id' => 'meta.vacature'
    //     ]
    // ){}

    public function execute(string $url, array $pattern)
    {
        $rawData = Http::get($url)->json();

        $extractedData = collect();

        foreach($rawData as $application)
        {
            $data = [];
            foreach($pattern as $key => $value)
            {
                $data[$key] = Arr::get($application, $value);
            }

            $extractedData->push($data);
        }
        return $extractedData;
    }
}

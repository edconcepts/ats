<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationService {

    public function __construct(private string $url = 'http://staging.werkenbijkik.nl/wp-json/wp/v2/vacancy-location')
    {}

    public function import()
    {
        $data = Http::get($this->url)->json();

        $locations = [];

        foreach($data as $location)
        {
            $locations [] = [
                'name' => $location['name'],
                'kik_id' => $location['id'],
                'description' => $location['description'],
                'slug' => $location['slug'],
            ];
        }

        return $locations;
    }

}

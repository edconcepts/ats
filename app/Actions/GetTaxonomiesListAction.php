<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GetTaxonomiesListAction
{
    protected array $topTaxonomies = [
        'job-boards',
        'categorieen',
        'vacancy-location',
        'opleidingsniveau',
    ];

    public function execute(): array
    {
        $extractedData = [];

        foreach($this->topTaxonomies as $topTaxonomy)
        {
            $rawTaxonomies = Http::get(config('services.wordpress.base_url'). $topTaxonomy . '?per_page=100')->json();

            foreach($rawTaxonomies as $taxonomy)
            {
                $extractedData[$topTaxonomy][] = [
                    'id' => $taxonomy['id'],
                    'name' => $taxonomy['name'],
                    'taxonomy' => $taxonomy['taxonomy'],
                ];
            }
        }
        return $extractedData;
    }

}

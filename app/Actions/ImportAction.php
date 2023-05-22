<?php

namespace App\Actions;

use App\Contracts\Importable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ImportAction
{
    // public function __construct(Importable $model)
    // {}

    public function execute($model, string $url, array $pattern)
    {
        $oldDataId = $model->all()->pluck('kik_id');

        $newData = $this->getImportingData($url, $pattern)->whereNotIn('kik_id',$oldDataId);

        $model->insert($newData->toArray());
    }

    private function getImportingData(string $url, array $pattern)
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

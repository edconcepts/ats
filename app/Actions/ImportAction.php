<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ImportAction
{
    // public function __construct(Importable $model)
    // {}
    //TODO refactor this its over srp

    public function execute($model, string $url, array $pattern)
    {
        $oldDataId = $model->all()->pluck('kik_id');

        $newData = $this->getImportingData($model, $url, $pattern)->whereNotIn('kik_id',$oldDataId);

        $model->insert($newData->toArray());
    }

    private function getImportingData($model, string $url, array $pattern)
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

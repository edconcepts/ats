<?php

namespace App\Actions;

use App\Contracts\Importable;
use App\Models\Application;
use App\Models\Status;
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

            //TODO refactor this
            if($model instanceof Application)
            {
                $data['status_id'] = Status::where('name', $data['kik_application_status'])->firstOrFail()->id;
            }

            $extractedData->push($data);
        }
        return $extractedData;
    }
}

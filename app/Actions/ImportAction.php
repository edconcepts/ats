<?php

namespace App\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportAction
{
    // public function __construct(Importable $model)
    // {}
    //TODO refactor this its over srp

    public function execute($model, string $url, array $pattern)
    {
        $newData = $this->getImportingData($model, $url, $pattern);

        foreach($newData as $data)
        {
            $model->updateOrCreate(
                [
                    'kik_id' => $data['kik_id']
                ],
                $data
            );
        }
    }

    private function getImportingData($model, string $url, array $pattern)
    {
        try {
            $response = Http::get($url);
            $totalPages = $response->header('X-WP-TotalPages');

            $extractedData = collect();
            for ($i=1; $i <= $totalPages; $i++) {

                $rawData = Http::get($url.'&page='.$i)->json();
                foreach($rawData as $application)
                {
                    $data = ['created_at' => now()];
                    foreach($pattern as $key => $value)
                    {

                        $data[$key] = Arr::get($application, $value);
                        
                    }
                    $extractedData->push($data);
                }
            }

            return $extractedData;
        }
        catch (\Exception $e) {
            Log::info($e->getMessage());

            return [];
        }
    }
}

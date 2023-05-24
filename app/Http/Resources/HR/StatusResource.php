<?php

namespace App\Http\Resources\HR;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $candiadates = [];

        foreach($this->applications as $application)
        {
            //TODO what's the job
            $candiadates[] = [
                'id' => $application->id,
                'name' => $application->name,
                'date' => $application->kik_date->format('Y-m-d H:i:s'),
                'job' => $application->vacancy?->title
            ];

        }
        return [
            'name' => $this->name,
            'id' => $this->id,
            'candidates' => $candiadates
        ];
    }
}

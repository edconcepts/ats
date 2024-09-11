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
        $candidates = [];

        foreach($this->applications as $application)
        {
            $candidates[] = [
                'id' => $application->id,
                'name' => $application->name,
                'date' => $application->kik_date->format('d-m-Y'),
                'job' => $application->vacancy?->title,
                'location_name' => $application->vacancy?->location->name,
                'interview_date' => $application->interview?->storeManagerTimeSlot->start,
                'interview_location' => $application->interview?->storeManagerTimeSlot->storeManager->location->name,
                'visible' => true,
            ];

        }
        return [
            'name' => $this->name,
            'id' => $this->id,
            'visible' => $this->visible,
            'candidates' => $candidates,
        ];
    }
}

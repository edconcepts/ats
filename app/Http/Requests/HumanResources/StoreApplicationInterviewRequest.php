<?php

namespace App\Http\Requests\HumanResources;

use App\Models\Location;
use App\Models\StoreManagerTimeSlot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'location' => ['required', 'exists:locations,id'],
            'timeSlot' => [
                'required',
                'exists:store_manager_time_slots,id',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $locationId = $this->input('location');
                    if (($location = Location::find($locationId)) instanceof Location) {
                        $currentTimeSlot = $this->route('application')->interview?->store_manager_time_slot_id;

                        $isAvailableForLocation = $location->manager?->availableTimeSlots()->find($value) instanceof StoreManagerTimeSlot;
                        $currentTimeslotIsFromLocation = $location->manager?->timeSlots()->find($currentTimeSlot) instanceof StoreManagerTimeSlot;

                        // If the given slot is not from this location, or is not available
                        // AND
                        // value is not the already set timeslot
                        // OR
                        // the current time slot is not for the given location
                        if (! $isAvailableForLocation && ($value !== $currentTimeSlot || ! $currentTimeslotIsFromLocation)) {
                            $fail('Opgegeven tijdslot behoort niet tot de opgegeven locatie (of is al bezet)!');
                        }
                    } else {
                        $fail('Locatie is verplicht!');
                    }
                },
            ]
        ];
    }
}

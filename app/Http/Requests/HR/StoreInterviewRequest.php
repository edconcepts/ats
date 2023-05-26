<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        //TODO timeSlot need a rule that it should attach to application vacancy location owner
        return [
            'application_id' => ['required', 'exists:applications,id'] ,
            'timeSlot' => ['required', 'exists:timeSlots,id']
        ];
    }
}

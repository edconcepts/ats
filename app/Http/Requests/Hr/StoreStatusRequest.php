<?php

namespace App\Http\Requests\Hr;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
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
        //TODO change the messages
        return [
            'name' => ['required', 'max:120'],
            'email.subject' => ['required_with:email.body', 'max:120'],
            'email.body' => ['required_with:email.subject', 'max:500'],
        ];
    }
}

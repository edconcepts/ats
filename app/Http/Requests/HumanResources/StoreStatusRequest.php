<?php

namespace App\Http\Requests\HumanResources;

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
            'hasEmail' => ['required', 'boolean'],
            'email.subject' => ['required_if:hasEmail,true', 'max:120'],
            'email.body' => ['required_if:hasEmail,true', 'max:500'],
        ];
    }
}

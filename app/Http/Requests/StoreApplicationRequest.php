<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'status_id' => 'required|exists:statuses,id',
            'vacancy_id' => 'required|exists:vacancies,kik_id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

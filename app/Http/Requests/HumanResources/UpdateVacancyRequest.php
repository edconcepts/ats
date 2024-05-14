<?php

namespace App\Http\Requests\HumanResources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVacancyRequest extends FormRequest
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
            'title' => [],
            'end_date' => [],
            'job_description' => [],
            'video_url' => [],
            '_requirements' => [],
            'opleidingsniveau' => [],
            '_responsibilities' => [],
            '_salary' => [],
            'vacancyLocation' => [],
            'categorieen' => [],
            'jobBoards' => [],

        ];
    }
}

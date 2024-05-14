<?php

namespace App\Http\Requests\Auth;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TwoFactorAuthenticationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'numeric',
                'digits:6',
                Rule::exists('users', 'two_factor_code')->where(function (Builder $query) {
                    return $query->where('id', $this->user()->id);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'code.exists' => 'Deze code is niet geldig.',
            'code.digits' => 'Deze code is niet geldig2.',
            'code.numeric' => 'Deze code is niet geldig3.',
            'code.required' => 'Deze code is niet geldig4.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

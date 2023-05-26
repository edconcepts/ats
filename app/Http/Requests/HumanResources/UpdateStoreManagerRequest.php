<?php

namespace App\Http\Requests\HumanResources;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreManagerRequest extends FormRequest
{
    public function rules(): array
    {
        $user = User::query()
            ->where('location_id', $this->route('location')->id)
            ->first();

        return [
            'name' => ['required', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user?->location_id ?? null, 'location_id'),
            ],
            'password' => ['nullable', 'min:8'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

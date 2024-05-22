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

//        dd($user);

        $passwordRequired = is_null($user) || is_null($user?->password);

        $passwordRules = $passwordRequired ? ['required', 'min:8'] : ['nullable'];

        return [
            'name' => ['required', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user?->location_id ?? null, 'location_id'),
            ],
            'phone' => ['required', 'max:255'],
            'password' => $passwordRules,
            'regio_manager_name' => ['nullable', 'max:255'],
            'regio_manager_email' => ['nullable', 'email', 'max:255'],
            'location_address' => ['nullable', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

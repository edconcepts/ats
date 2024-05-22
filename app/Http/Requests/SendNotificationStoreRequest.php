<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'recipients' => 'required|array',
            'message' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

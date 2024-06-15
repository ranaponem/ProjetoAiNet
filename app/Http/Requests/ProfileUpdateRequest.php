<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'lowercase', // Assuming 'lowercase' is a custom rule or filter
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'photo_filename' => 'nullable|image|max:10240', // Max 10MB image file
        ];
    }
}

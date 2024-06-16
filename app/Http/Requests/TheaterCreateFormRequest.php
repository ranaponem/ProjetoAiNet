<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterCreateFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'image_file' => 'sometimes|image|max:4096',
            'rows' => 'required|int',
            'cols' => 'required|int',
        ];
        return $rules;
    }
}

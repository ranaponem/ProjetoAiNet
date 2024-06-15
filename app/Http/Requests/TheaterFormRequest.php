<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterFormRequest extends FormRequest
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
            'image_file' => 'sometimes|image|mimes:png|max:4096', // maxsize = 4Mb
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'ECTS.required' => 'ECTS is required',
            'ECTS.integer' => 'ECTS must be an integer',
            'ECTS.min' => 'ECTS must be equal or greater that 1',
        ];
    }
}

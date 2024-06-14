<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CartConfirmationFormRequest extends FormRequest
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
        return [
            'student_number' => 'required|exists:students,number'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->user()) {
                    if ($this->user()->type == 'S') {
                        // When the user is a student, the student_number must be his number
                        $userStudentNumber = $this->user()?->student?->number;
                        if ($this->student_number != $userStudentNumber) {
                            $validator->errors()->add('student_number', "Your student number is $userStudentNumber");
                        }
                    }
                }
            }
        ];
    }
}

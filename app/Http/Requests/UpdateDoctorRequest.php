<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * Authorize request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],

            'mobile_no' => [
                'sometimes',
                'required',
                'digits:10',
                'unique:doctors,mobile_no,' . $this->doctor->id
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
                'required',
                'string',
                'max:255'
            ],


            'mobile_no' => [
                'required',
                'digits:10',
                'regex:/^[6-9]\d{9}$/',
                'unique:doctors,mobile_no'
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
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
    */
    public function rules(): array
    {
        return [
            
            'patient_name' => [
                'required',
                'string',
                'max:255'
            ],

            'patient_email' => [
                'required',
                'email'
            ],

            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'start_time' => [
                'required',
                'date_format:H:i'
            ]
        ];
    }
}

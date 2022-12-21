<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => [
                'required'
            ],

            'start_time' => [
                'required'
            ],

            'end_time' => [
                'required'
            ],

            'professional_id' => [
                'required',
                Rule::exists('users', 'id')
            ],

            'isNewPatient' => [
                'required'
            ],

            'patient.rfc' => [
                'required',
                Rule::when($this->isNewPatient === 2, [Rule::exists('patients', 'rfc')])
            ],

            'patient.name' => [
                Rule::when(
                    $this->isNewPatient === 1,
                    ['required']
                )
            ],

            'patient.email' => [
                Rule::when(
                    $this->isNewPatient === 1,
                    ['required']
                )
            ],

            'patient.phone' => [
                Rule::when(
                    $this->isNewPatient === 1,
                    ['required']
                )
            ],
        ];
    }
}

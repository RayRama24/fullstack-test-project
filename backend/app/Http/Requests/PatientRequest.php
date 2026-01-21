<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nik' => 'required|digits:16',
            'email' => 'required|email',
            'name' => 'required',
            // 'birth_date' => 'required|date'
            'address' => 'required|string'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'medical_record_no' => 'required|exists:patients,medical_record_no'
        ];
    }
}

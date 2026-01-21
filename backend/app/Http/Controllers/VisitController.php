<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Patient;
use App\Http\Requests\VisitRequest;

class VisitController extends Controller
{
    public function store(VisitRequest $request)
    {
        $patient = Patient::where('medical_record_no', $request->medical_record_no)
            ->firstOrFail();

        Visit::create([
            'patient_id' => $patient->id
        ]);

        return response()->json([
            'message' => 'Visit created',
            'patient' => [
                'medical_record_no' => $patient->medical_record_no,
                'name' => $patient->name,
                'total_visits' => $patient->visits()->count()
            ]
        ]);
    }
}

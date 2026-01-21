<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Crypt;

class PatientController extends Controller
{
    private function generateMedicalRecord()
    {
        $last = Patient::orderBy('id', 'desc')->first();
        $number = $last ? intval(substr($last->medical_record_no, 2)) + 1 : 1;

        return 'RM' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function store(PatientRequest $request)
    {
        $patient = Patient::create([
            'medical_record_no' => $this->generateMedicalRecord(),
            'nik' => Crypt::encryptString($request->nik),
            'nik_hash' => hash('sha256', $request->nik),
            'email' => Crypt::encryptString($request->email),
            'name' => $request->name,
            // 'birth_date' => $request->birth_date
            'address' => $request->address
        ]);

        return response()->json([
            'message' => 'Patient registered',
            'data' => $patient
        ]);
    }

    public function showByRm($rm)
{
    $patient = Patient::where('medical_record_no', $rm)->first();

    if (!$patient) {
        return response()->json([
            'message' => 'Patient not found'
        ], 404);
    }

    return response()->json([
        'data' => [
            'medical_record_no' => $patient->medical_record_no,
            'name' => $patient->name,
            // 'birth_date' => $patient->birth_date,
            'nik' => Crypt::decryptString($patient->nik),
            'address' => $patient->address,
            'email' => Crypt::decryptString($patient->email)
        ]
    ]);
}

    public function index()
    {
        $patients = Patient::orderBy('id', 'desc')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'no_rm' => $p->medical_record_no,
                'nama' => $p->name,
                'nik' => Crypt::decryptString($p->nik),
                'email' => Crypt::decryptString($p->email),
                // 'birth_date' => $p->birth_date,
                'address' => $p->address,
                'jumlah_kunjungan' => $p->visits()->count() ?? 0
            ];
        });

        return response()->json($patients, 200);
    }

}

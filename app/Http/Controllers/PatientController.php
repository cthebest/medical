<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $rfc = $request->query('rfc');
        if ($request->wantsJson()) {
            $patient = Patient::rfc($rfc)->get();
            return response()->json($patient);
        }
    }
}

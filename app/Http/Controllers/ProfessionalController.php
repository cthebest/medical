<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{


    public function getProfessionals()
    {
        return response()->json(User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Profesional');
            }
        )->get());
    }
}

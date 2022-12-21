<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Weekday;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeHourController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->query('resource_user'));
        if (!$user) {
            return response()->json(['message' => ['error' => 'El usuario no existe']], 404);
        }
        return response()->json($user->getOfficeHours());
    }

    public function store(Request $request)
    {
        $user = User::findOrFail($request->resource_user);
        $user->addOfficeHours($request->officeHours);

        $request->session()->flash('message', 'Se ha creado un horario laboral');

        return redirect()->route('agenda.index', [
            'dialog' => 'show-office-hours',
            'resource_user' => $user->id
        ]);
    }

    public function edit(Request $request)
    {
        $user = User::findOrFail($request->query('resource_user'));
        $weekday = Weekday::findOrFail($request->query('resource_weekday_id'));
        $officeHour = $user->weekdays()->where('weekday_id', $weekday->id)->first();
        return response()->json($officeHour);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->query('resource_user'));
        $user->weekdays()->updateExistingPivot($request->id, ['values' => json_encode($request->intervals)]);

        $request->session()->flash('message', 'Horario laboral actualizado');
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->query('resource_user'));
        $weekday = Weekday::findOrFail($request->query('weekday_id'));

        $user->weekdays()->detach([$weekday->id]);

        return redirect()->route('agenda.index', [
            'dialog' => 'show-office-hours',
            'resource_user' => $user->id
        ]);
    }
}

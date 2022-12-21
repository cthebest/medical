<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Weekday;
use App\Services\AvailableTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AgendaController extends DialogAbstractController
{
    public function getAvailableTimes(Request $request)
    {
        if (!$request->query('resource_user')) {
            abort(404);
        }
        $availableTime = new AvailableTime();
        return response()->json($availableTime->build($request));
    }


    public function getAppointmentConfiguration(Request $request)
    {
        $this->setUser($request);
        return response()->json($this->user->appointment_configuration);
    }

    public function saveAppointmentConfiguration(Request $request)
    {
        $this->setUser($request);
        $this->user->addAppointmentConfiguration($request->only('duration'));
        $request->session()->flash('message', 'La nueva configuración se guardó con éxito');

        return redirect()->route('agenda.index', $request->except('duration'));
    }

    public function getAppointmentsCount(Request $request): JsonResponse
    {
        $this->setUser($request);

        $appointmentsCount = Appointment::selectRaw('count(date) as count, date, user_id')
            ->groupBy(['date', 'user_id'])
            ->where('user_id', $this->user->id)
            ->get();
        return response()->json($appointmentsCount);
    }

    public function getWeekdays(Request $request)
    {
        $this->setUser($request);
        $user = $this->user;
        $weekdays = Weekday::whereDoesntHave('users', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return response()->json($weekdays);
    }

    protected function getIndexResponse(): Response
    {
        return Inertia('Agenda/Index', [
            'professional' => $this->user, // Compartir a la vista props usuario consultado arriba
        ]);
    }
}

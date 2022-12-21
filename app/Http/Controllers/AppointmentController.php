<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Mail\CreatedAppointment;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Services\Appointment\Status\Confirmed;
use App\Services\Appointment\Status\Registered;
use App\Services\Appointment\Status\Unpaid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::parse($request->query('date'));
        $appointments = Appointment::with('patient')->whereHas('user', function ($q) use ($request) {
            $q->where('id', $request->query('resource_user'));
        })->whereYear('date', $date->year)->whereMonth('date', $date->month)->get();

        return response()->json($appointments);
    }

    public function store(StoreAppointmentRequest $request)
    {
        // Obtenemos al paciente
        $patient = Patient::whereRfc($request->patient['rfc'])->first();
        $user = User::findOrFail($request->professional_id);

        // TODO verificar que el usario sea un profesional, con esto
        // se protege que un paciente no pueda crear una cita
        // a un usuario que no tenga rol de profesional. 
        if (!$patient) {
            $patient = Patient::create([
                'name' => $request->patient['name'],
                'email' => $request->patient['email'],
                'phone' => $request->patient['phone'],
                'rfc' => $request->patient['rfc'],
            ]);
        }

        $user->appointments()->attach($patient->id, [
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'appointments_status' => Registered::class,
            'payment_status' => Unpaid::class
        ]);


        $request->session()->flash('message', 'Cita creada con éxito');

        // Buscamos la cita registrada para enviarle un correo al usuario y
        // especificarle que debe confirmar la cita
        $appointment = Appointment::where(['patient_id' => $patient->id, 'date' => $request->date])->first();
        Mail::to($patient->email)->send(new CreatedAppointment($patient, $appointment->id));

        return redirect()->route('agenda.index', [
            'resource_user' => $user->id,
            'view' => $request->query('view'),
            'dialog' => $request->query('dialog')
        ]);
    }

    public function confirmation(string $id, Request $request)
    {
        $appointment = Appointment::find($id);
        $status = $appointment->appointments_status;
        $status = new $status($appointment);
        $confirmed = $status->confirm();

        if ($request->wantsJson()) {
            return response()->json($confirmed);
        }

        return Inertia(component: 'Appointments/ConfirmedAppointment', props: ['La cita fue confirmada con éxito']);
    }
}

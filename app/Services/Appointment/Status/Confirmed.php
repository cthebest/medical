<?php

namespace App\Services\Appointment\Status;

use App\Mail\CanceledAppointment;
use App\Services\Appointment\AppointmentStatusConcrete;
use Illuminate\Support\Facades\Mail;
use JsonSerializable;

class Confirmed extends AppointmentStatusConcrete implements JsonSerializable
{
    public function cancel()
    {
        $this->appointment->appointments_status = Limbo::class;
        $this->appointment->update();
        Mail::to($this->appointment->patient->email)->send(new CanceledAppointment($this->appointment));
        return response()->json(['Estado actualizado correctamente', $this->appointment]);
    }

    public function complete()
    {
        $this->appointment->appointment_status = Completed::class;
        $this->appointment->update();
        return response()->json(['Estado actualizado correctamente', $this->appointment]);
    }

    public function getColor(): string
    {
        return "confirmed";
    }

    public function getName(): string
    {
        return 'Confirmado';
    }

    public function getTransition(): array
    {
        return [
            ['name' => 'Completado', 'route' => 'appointments-status.complete', 'color' => 'completed'],
            ['name' => 'Cancelado', 'route' => 'appointments-status.cancel', 'color' => 'canceled']
        ];
    }
}

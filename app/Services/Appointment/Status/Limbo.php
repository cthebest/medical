<?php

namespace App\Services\Appointment\Status;

use App\Services\Appointment\AppointmentStatusConcrete;
use JsonSerializable;

class Limbo extends AppointmentStatusConcrete implements JsonSerializable
{
    public function confirm()
    {
        $this->appointment->appointments_status = Confirmed::class;
        $this->appointment->update();
        return response()->json(['Estado actualizado correctamente', $this->appointment]);
    }

    public function getColor(): string
    {
        return 'canceled';
    }

    public function getName(): string
    {
        return 'Por asignar';
    }

    public function getTransition(): array
    {
        return [
            ['name' => 'Confirmado', 'route' => 'appointments-status.confirm', 'color' => 'confirmed']
        ];
    }
}

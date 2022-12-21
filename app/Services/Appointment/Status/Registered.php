<?php

namespace App\Services\Appointment\Status;

use App\Services\Appointment\AppointmentStatusConcrete;
use JsonSerializable;

class Registered extends AppointmentStatusConcrete implements JsonSerializable
{
    public function confirm()
    {
        $this->appointment->appointments_status = Confirmed::class;
        $this->appointment->update();
        return ['Estado actualizado correctamente', $this->appointment];
    }

    public function getName(): string
    {
        return 'Registrado';
    }

    public function getColor(): string
    {
        return 'registered';
    }

    public function getTransition(): array
    {
        return [
            ['name' => 'Confirmado', 'route' => 'appointments-status.confirm', 'color' => 'confirmed']
        ];
    }
}

<?php

namespace App\Services\Appointment\Status;

use App\Services\Appointment\AppointmentStatusConcrete;
use JsonSerializable;

class Completed extends AppointmentStatusConcrete implements JsonSerializable
{
    public function getColor(): string
    {
        return 'completed';
    }

    public function getName(): string
    {
        return 'Completado';
    }
}

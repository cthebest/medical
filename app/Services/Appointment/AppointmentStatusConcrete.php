<?php

namespace App\Services\Appointment;

use App\Exceptions\UnsoportedActionException;
use App\Services\Appointment\Interfaces\AppointmentStatusInterface;

abstract class AppointmentStatusConcrete implements AppointmentStatusInterface
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function register()
    {
        return throw new UnsoportedActionException('La acción registrar no es soportada por el estado actual');
    }

    public function confirm()
    {
        return throw new UnsoportedActionException('La acción confirmar no es soportada por el estado actual');
    }
    public function cancel()
    {
        return throw new UnsoportedActionException('La acción cancelar no es soportada por el estado actual');
    }

    public function complete()
    {
        return throw new UnsoportedActionException('La acción completar no es soportada por el estado actual');
    }
    public function getColor(): string
    {
        return '';
    }
    public function getName(): string
    {
        return '';
    }
    public function getTransition(): array
    {
        return [];
    }

    public function jsonSerialize(): mixed
    {
        return [
            'color' => $this->getColor(),
            'name' => $this->getName(),
            'transitions' => $this->getTransition()
        ];
    }
}

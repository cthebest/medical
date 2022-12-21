<?php

namespace App\Services\Appointment;

use App\Exceptions\UnsoportedActionException;
use App\Services\Appointment\Interfaces\PaymentStatusInterface;

abstract class PaymentStatusConcrete implements PaymentStatusInterface
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function paid()
    {
        return throw new UnsoportedActionException('La acción pagar no es soportada por el estado actual');
    }

    public function unpaid()
    {
        return throw new UnsoportedActionException('La acción no pagado no es soportada por el estado actual');
    }
    public function canceled()
    {
        return throw new UnsoportedActionException('La acción cancelado no es soportada por el estado actual');
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

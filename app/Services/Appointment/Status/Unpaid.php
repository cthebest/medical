<?php

namespace App\Services\Appointment\Status;

use App\Services\Appointment\PaymentStatusConcrete;
use JsonSerializable;
use App\Services\Status\Paid;

class Unpaid extends PaymentStatusConcrete implements JsonSerializable
{
    public function paid()
    {
        $this->appointment->payment_status = Paid::class;
        $this->appointment->update();
        return response()->json(['Estado actualizado correctamente', $this->appointment]);
    }

    public function getColor(): string
    {
        return "registered";
    }

    public function getName(): string
    {
        return 'No pagado';
    }

    public function getTransition(): array
    {
        return [
            ['name' => 'Pagado', 'route' => 'payment-status.paid', 'color' => 'completed'],
        ];
    }
}

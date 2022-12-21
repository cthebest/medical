<?php

namespace App\Services\Appointment\Interfaces;

interface PaymentStatusInterface
{
    public function unpaid();
    public function paid();
    public function canceled();
    public function getColor(): string;
    public function getName(): string;
    public function getTransition(): array;
}

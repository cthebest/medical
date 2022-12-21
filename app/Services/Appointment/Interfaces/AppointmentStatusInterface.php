<?php

namespace App\Services\Appointment\Interfaces;

interface AppointmentStatusInterface
{
    public function register();
    public function confirm();
    public function cancel();
    public function complete();
    public function getColor(): string;
    public function getName(): string;
    public function getTransition(): array;
}

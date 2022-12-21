<?php

namespace App\Services\Dialog\Concretes;

use App\Services\Dialog\Abstacts\DialogAbstract;

class CreateAppointmentConfigurationConcrete extends DialogAbstract
{
    /**
     * Obtiene la habilidad de una vista concreta
     */
    protected function getAbility(): string
    {
        return 'show_appointmens_time';
    }
}
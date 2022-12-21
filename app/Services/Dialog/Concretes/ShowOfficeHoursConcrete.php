<?php

namespace App\Services\Dialog\Concretes;

use App\Services\Dialog\Abstacts\DialogAbstract;

class ShowOfficeHoursConcrete extends DialogAbstract
{
    /**
     * Obtiene la habilidad de una vista concreta
     */
    protected function getAbility(): string
    {
        return 'show_office_hours';
    }
}
<?php

namespace App\Services\Dialog\Concretes;

use App\Services\Dialog\Abstacts\DialogAbstract;

class EditOfficeHoursConcrete extends DialogAbstract
{
    /**
     * Obtiene la habilidad de una vista concreta
     */
    protected function getAbility(): string
    {
        return 'update_office_hours';
    }
}
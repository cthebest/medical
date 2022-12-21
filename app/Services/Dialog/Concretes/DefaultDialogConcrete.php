<?php

namespace App\Services\Dialog\Concretes;

use App\Services\Dialog\Abstacts\DialogAbstract;

class DefaultDialogConcrete extends DialogAbstract
{
    /**
     * Obtiene la habilidad de una vista concreta
     */
    protected function getAbility(): string|null
    {
        return null;
    }
}
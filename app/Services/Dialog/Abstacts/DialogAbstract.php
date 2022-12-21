<?php

namespace App\Services\Dialog\Abstacts;

use App\Models\User;
use App\Services\Dialog\Interfaces\DialogInterface;

abstract class DialogAbstract implements DialogInterface
{

    public function __construct(private readonly User $user)
    {
    }

    /**
     * ------------------------------------------------
     * Validamos que una vista pueda ser mostrada
     * para un usuario autenticado
     * ------------------------------------------------
     **/
    public function validate(): bool
    {
        // Si la habilidad no es nula, entonces la comprobamos
        // de lo contrario, significa que el usuario no
        // requiere de una ventana dialog
        if ($this->getAbility()) {
            return $this->user->can($this->getAbility());
        }

        return true;
    }

    /**
     * Obtiene la habilidad de una vista concreta
     */
    protected abstract function getAbility(): string|null;
}
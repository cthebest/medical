<?php

namespace App\Services\Dialog\Interfaces;

interface DialogInterface
{
    /**
     * ---------------------------------------------------
     * Valida si la vista(dialog) puede ser vista por un
     * usuario autenticado
     * ---------------------------------------------------
     **/
    public function validate(): bool;
}
<?php

namespace App\Services\Dialog;

use App\Models\User;
use App\Services\Dialog\Concretes\CreateAppointmentConcrete;
use App\Services\Dialog\Concretes\CreateAppointmentConfigurationConcrete;
use App\Services\Dialog\Concretes\CreateOfficeHoursConcrete;
use App\Services\Dialog\Concretes\DefaultDialogConcrete;
use App\Services\Dialog\Concretes\EditOfficeHoursConcrete;
use App\Services\Dialog\Concretes\ShowOfficeHoursConcrete;
use App\Services\Dialog\Interfaces\DialogInterface;

class DialogFactory
{
    /**
     * Permite obtener el validador DialogInterface que nos permita establecer
     * si el usuario autenticado puede ver dicha vista.
     *
     * @param User $user El usuario autenticado
     * @param string $typeDialogView El tipo de vista dialogo que se requiere validar
     */
    public function getValidator(User $user, string $typeDialogView): DialogInterface
    {
        return match ($typeDialogView) {
            'create-office-hours' => new CreateOfficeHoursConcrete($user),
            'show-office-hours' => new ShowOfficeHoursConcrete($user),
            'appointment' => new CreateAppointmentConcrete($user),
            'appointment-configuration' => new CreateAppointmentConfigurationConcrete($user),
            'edit-office-hours' => new EditOfficeHoursConcrete($user),
            'default' => new DefaultDialogConcrete($user),
        };
    }
}
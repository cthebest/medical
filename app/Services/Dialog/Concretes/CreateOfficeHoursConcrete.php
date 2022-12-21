<?php

namespace App\Services\Dialog\Concretes;

use App\Services\Dialog\Abstacts\DialogAbstract;

class CreateOfficeHoursConcrete extends DialogAbstract
{
    protected function getAbility(): string
    {
        return 'create_office_hours';
    }
}
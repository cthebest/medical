<?php

namespace App\Traits\Agenda;

use App\Models\Event;

trait HasEvents
{
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}

<?php

namespace App\Traits\Agenda;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasAppointment
{
    /**
     * The roles that belong to the HasAppointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'appointments')
            ->withPivot(['date', 'start_time', 'end_time', 'id'])
            ->using(Appointment::class);
    }
}

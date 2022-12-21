<?php

namespace App\Traits\Agenda;

use App\Models\AppointmentConfiguration;
use App\Models\ConfigType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAppointmentConfiguration
{
    /**
     * The roles that belong to the HasConfiguration
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment_configuration(): BelongsTo
    {
        return $this->belongsTo(AppointmentConfiguration::class);
    }

    public function addAppointmentConfiguration($duration)
    {

        $appointmentConfiguration = AppointmentConfiguration::whereDuration($duration['duration'])->first();

        if (!$appointmentConfiguration) {
            $appointmentConfiguration = AppointmentConfiguration::create($duration);
        }

        $this->appointment_configuration()->associate($appointmentConfiguration);
        $this->save();
    }
}

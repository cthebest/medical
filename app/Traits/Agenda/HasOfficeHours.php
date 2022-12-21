<?php

namespace App\Traits\Agenda;

use App\Models\Weekday;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasOfficeHours
{
    public function weekdays(): BelongsToMany
    {
        return $this->belongsToMany(Weekday::class, 'office_hours')->withPivot('values');
    }

    public function getOfficeHours(): Collection
    {
        return $this->weekdays()->get();
    }

    public function addOfficeHours(array $officeHours)
    {
        $workingTimes = [];
        // Eliminamos todos los elementos que se encuentren dentro de nuestro arreglo
        foreach ($officeHours as $officeHour) {
            $workingTimes[$officeHour['id']]['values'] = json_encode($officeHour['values']);
        }
        $this->weekdays()->sync($workingTimes, false);
    }
}

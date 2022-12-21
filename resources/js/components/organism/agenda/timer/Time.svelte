<script>
    import {onMount} from 'svelte';
    import moment from 'moment';

    export let time; // Permite hacer conexión con la vista que requiere el valor
    export let unavailableHours = []; // El rango de horas que no se encuentran disponibles
    export let startTimeChose = undefined; // La hora inicial escogida
    export let index;
    let hours = []; // EL arreglo de horas disponibles

    function buildOptions() {
        hours = getAvailableHours(startTimeChose);
    }

    /**
     * Función que permite establecer el conjunto de horas que el usuario
     * tiene disponible para escoger.
     * @param start hora inicial
     * @param end hora final
     * @returns {*[]} EL conjunto de horas disponibles
     */
    function getAvailableHours(start = '12:00 AM', end = '11:59 PM') {
        let startTime;
        let endTime = moment(end, 'h:mm: A');
        startTime = moment(start, 'h:mm: A');

        if (startTimeChose) {
            console.log("holi");
            startTime.add(1, 'hours');
        }

        let timeStops = [];
        let auxUnavailableHours = [];

        if (index) {
            auxUnavailableHours = unavailableHours.filter((value, i) => i !== index);
        }
        while (startTime <= endTime) {
            const unavailableHour = auxUnavailableHours.find(unavailableHour => {
                // EL objeto de las horas no disponibles
                const auxStartTime = moment(unavailableHour.start_time, 'h:mm: A');
                if (unavailableHour.end_time) {
                    const auxEndTime = moment(unavailableHour.end_time, 'h:mm: A');
                    return startTime.isBetween(auxStartTime, auxEndTime, undefined, '[]');
                }
                return false;
            });
            // Si una hora no disponible fue encontrada, significa que no puede
            // continuar. Ha encontrado el limite superior
            if (unavailableHour && startTimeChose) {
                break;
            }

            if (!unavailableHour) {
                timeStops.push(new moment(startTime).format('h:mm: A'));
            }

            startTime.add(30, 'minutes');
        }

        return timeStops;
    }
</script>

<div>
    <select name="hour" id="hour" class="px-2 py-1 border border-gray-500 rounded-full bg-gray-100"
            bind:value={time} on:click={buildOptions}>
        {#each hours as hour}
            <option value={hour}>{hour}</option>
        {/each}
    </select>
</div>

<script>
    import Day from "./Day.svelte";
    import { onMount } from "svelte";
    import moment from "moment/moment";
    import { buildDays } from "../../../repository/calendar";

    let days = [];

    export let action = null;
    export let label = null;
    export let professional;
    let calendar;
    let appointments = [];
    // La fecha que se irá moviendo cuando el usuario
    // de clic en atrás o siguiente
    let currentDate;
    // La fecha actual
    let todayDate = null;
    export let dayView = "h-28";

    let weekdays = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];

    $: if (action === "nextDate") {
        nextMonth();
    } else if (action === "prevDate") {
        prevMonth();
    }

    function nextMonth() {
        currentDate.add(1, "months");
        getCalendar();
        action = null;
    }

    function prevMonth() {
        currentDate.subtract(1, "months");
        getCalendar();
        action = null;
    }

    onMount(() => {
        // La fecha de hoy, este objeto no deberá modificarse
        todayDate = moment();
        // La fecha que será modificada cada vez que se de en el botón
        // siguiente o atrás
        currentDate = todayDate.clone();
        getCalendar();
    });

    function getCalendar() {
        // Obtenemos el calendario que se construye a partir de la fecha
        // que se modificará y la fecha de hoy
        calendar = buildDays(currentDate, todayDate);

        // Nombre del mes
        label = calendar.month_name;
        getAppointments();
    }

    function getAppointments() {
        days = [];
        if (professional) {
            // Buscamos las citas
            axios
                .get(
                    route("appointments.index", {
                        resource_user: professional.id,
                        date: currentDate.format("YYYY-MM-DD"),
                    })
                )
                .then((response) => {
                    appointments = response.data;
                    // Se obtienen todos los días
                    days = calendar.days;
                });
        } else {
            days = calendar.days;
        }
    }
</script>

<div
    class="grid grid-cols-7 bg-gray-200 gap-[1px] border border-gray-200 font-light"
>
    {#each weekdays as weekday}
        <span class="bg-white py-2 flex justify-center">{weekday}</span>
    {/each}

    <Day {days} on:click class={dayView} {appointments} />
</div>

<script>
    import { createEventDispatcher } from "svelte";
    import Appointments from "./Appointments.svelte";

    const dispatch = createEventDispatcher();

    export let days = [];
    export let appointments = [];
    let className = "";

    export { className as class };

    function selected_day(day) {
        if (day.isValid) {
            dispatch("click", day);
        }
    }
    function getAppointments(date) {
        return appointments.filter((appointment) => appointment.date === date);
    }
</script>

{#if days.length > 0}
    {#each days as day}
        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <div
            class=" bg-white {className}"
            class:today={day.isToday}
            class:text-purple-600={!day.isValid}
            class:text-gray-400={!day.isInCurrentMonth}
            class:cursor-not-allowed={!day.isValid}
            class:cursor-pointer={day.isValid}
            on:click={() => selected_day(day)}
        >
            <div class="flex justify-end">
                <span
                    type="button"
                    class="block"
                    class:text-red-800={day.isToday}
                    class:font-bold={day.isToday}
                >
                    {day.number}
                </span>
            </div>
            {#if appointments && appointments.length > 0}
                <Appointments appointments={getAppointments(day.date)} />
            {/if}
        </div>
    {/each}
{:else}
    <span class="bg-white col-span-full">Buscando...</span>
{/if}

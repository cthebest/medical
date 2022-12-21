<script>
    export let appointments;
    let count = appointments.length - 3 > 0 ? appointments.length - 3 : 0;

    let appointmentsFilter = appointments.slice(0, 3);
</script>

{#if appointments && appointments.length > 0}
    <!-- svelte-ignore a11y-click-events-have-key-events -->
    <div
        class=" z-50 px-2 space-y-1"
        on:click={() => console.log("hola mundo")}
    >
        {#each appointmentsFilter as appointment}
            <div class="flex items-center relative">
                <div class="h-2 w-2 bg-blue-700 rounded-full absolute" />
                <p class="ml-2 font-bold text-xs truncate">
                    {appointment.patient.name}
                </p>
            </div>
        {/each}
        {#if count > 0}
            <span class="text-xs">+{count} más</span>
        {/if}
    </div>
{/if}

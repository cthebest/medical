<script>
    import "moment/locale/es";
    import Fa from "svelte-fa/src/fa.svelte";
    import { faAngleDown, faAngleUp } from "@fortawesome/free-solid-svg-icons";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();
    // Esta variable nos permite determinar la vista
    // que se debe mostrar en la página de agenda
    export let isMonthSelected = true;
    // El nombre del mes seleccionado
    export let label;
</script>

<div class="flex  items-center justify-between">
    <div class="flex items-center space-x-2">
        {#if label}
            <h1 class="uppercase">
                {label}
            </h1>
        {/if}
        <div class="flex flex-col">
            <button
                class="border bg-blue-600 text-white self-center rounded-full"
                on:click={() => dispatch("prevDate")}
            >
                <Fa icon={faAngleUp} />
            </button>
            <button
                class="border  bg-blue-600 text-white self-center rounded-full"
                on:click={() => dispatch("nextDate")}
            >
                <Fa icon={faAngleDown} />
            </button>
        </div>
    </div>

    <div>
        <button class="bg-[#006699] p-2 text-gray-200 rounded-lg">Hoy</button>
        <button
            class="bg-[#006699] p-2 text-gray-200 rounded-lg"
            class:selected={isMonthSelected}
        >
            Mes
        </button>
    </div>
</div>

<style>
    .selected {
        @apply bg-[#99cc33];
    }
</style>

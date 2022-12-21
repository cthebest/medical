<script>
    import Calendar from "../../organism/agenda/calendar/Calendar.svelte";
    import ClickOutside from "svelte-click-outside";
    import Hour from "./Hour.svelte";

    let openCalendar = false;
    let value = "";
    let triggerEl;

    export let time = {
        date: null,
        hour: "",
    };
    function selectedDay(event) {
        value = event.detail.date;
        time.date = value;
    }
</script>

<div class="flex space-x-1">
    <div class="relative">
        <label for="" class="block">Fecha</label>
        <input
            type="text"
            class="border p-2 rounded-md text-gray-500"
            placeholder="aaaa-mm-dd"
            readonly
            value={time.date}
            bind:this={triggerEl}
            on:click={() => (openCalendar = !openCalendar)}
        />
        {#if openCalendar}
            <ClickOutside
                on:clickoutside={() => (openCalendar = false)}
                exclude={[triggerEl]}
            >
                <Calendar on:click={selectedDay} />
            </ClickOutside>
        {/if}
    </div>

    <Hour date={value} bind:hour={time.hour} />
</div>

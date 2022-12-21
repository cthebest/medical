<script>
    import { Inertia } from "@inertiajs/inertia";
    import { onMount } from "svelte";

    export let date = null;
    export let hour = "";
    let times = [];

    $: if (date) {
        getAvailableTimes();
    }

    function getAvailableTimes() {
        // How to get a param with URL in javascript?
        const urlParams = new URL(window.location).searchParams;
        times = [];
        axios
            .get(
                route("available-times", {
                    resource_user: urlParams.get("resource_user"),
                    date: date,
                })
            )
            .then((response) => {
                times = response.data.availables;
                date = null;
            });
    }
</script>

<div class="w-full">
    <label for="" class="block">Hora</label>
    <select
        class="border p-2.5 rounded-md text-gray-500 w-full"
        bind:value={hour}
    >
        <option value="">Seleccione una hora</option>
        {#each times as time}
            <option value={time}>{time.interval}</option>
        {/each}
    </select>
</div>

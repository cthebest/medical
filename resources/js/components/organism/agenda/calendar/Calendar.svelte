<script>
    import Fa from "svelte-fa/src/fa.svelte";
    import {
        faAngleLeft,
        faAngleRight,
    } from "@fortawesome/free-solid-svg-icons";
    import MonthView from "./MonthView.svelte";
    import { fade } from "svelte/transition";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    let action = null;
    let label;
</script>

<div class="absolute  w-full mt-2 bg-white text-xs z-10" out:fade>
    <div
        class="flex items-center justify-center p-1 border-t border-l border-r"
    >
        <button type="button" on:click={() => (action = "prevDate")}
            ><Fa icon={faAngleLeft} /></button
        >
        <span>{label}</span>
        <button type="button" on:click={() => (action = "nextDate")}
            ><Fa icon={faAngleRight} /></button
        >
    </div>

    <MonthView bind:label dayView={"p-0"} on:click  bind:action/>
</div>

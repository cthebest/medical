<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let type = "button";
</script>

<button
    {type}
    class="bg-red-500 text-white px-2 py-1"
    on:click={() => dispatch("click")}
>
    <slot />
</button>

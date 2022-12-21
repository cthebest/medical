<script>
    import AgendaHeader from "./AgendaHeader.svelte";
    import {
        view_component,
        view_request,
    } from "../../../repository/request-stores";

    export let view, professional;
    let action = null;
    let label = null;
    $: if (view) {
        $view_request.component = view;
    } else {
        $view_request.component = null;
    }
</script>

<div class="mt-5">
    <!--Obtengo los días del mes-->
    <AgendaHeader
        on:nextDate={() => (action = "nextDate")}
        on:prevDate={() => (action = "prevDate")}
        {label}
    />
    {#if $view_component}
        <svelte:component
            this={$view_component}
            bind:action
            bind:label
            {professional}
        />
    {/if}
</div>

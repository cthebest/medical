<script>
    import Panel from "../../atoms/panel/Panel.svelte";
    import { fade } from "svelte/transition";
</script>

<div
    class="fixed bg-gray-500 top-0 left-0 right-0 bottom-0 flex justify-center items-center bg-opacity-40 z-50"
    transition:fade
>
    <Panel class="panel-md">
        <slot />
    </Panel>
</div>

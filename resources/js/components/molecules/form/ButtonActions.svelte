<script>
    import ButtonDanger from "../../atoms/buttons/ButtonDanger.svelte";
    import ButtonPrimary from "../../atoms/buttons/ButtonPrimary.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import { createEventDispatcher } from "svelte";
    import { page } from "@inertiajs/inertia-svelte";

    const dispatch = createEventDispatcher();

    export let permission;
</script>

<FormGroup>
    {#if $page.props && $page.props.auth?.permissions.find((permission_) => permission_ === permission)}
        <ButtonPrimary on:click={() => dispatch("save")}>Guardar</ButtonPrimary>
    {/if}
    <ButtonDanger on:click={() => dispatch("close")}>Cancelar</ButtonDanger>
</FormGroup>

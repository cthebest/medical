<script>
    import { Inertia } from "@inertiajs/inertia";
    import { page } from "@inertiajs/inertia-svelte";

    let professionals = [];
    let professional_id = "";
    export let professional;

    $: if (!$page.props.auth.roles.find((role) => role === "Profesional")) {
        getProfessionals();
    }

    $: if (!professional.roles.find((role) => role.name === "Profesional")) {
        professional_id = "";
    } else {
        professional_id = professional.id;
    }

    function getProfessionals() {
        axios
            .get(route("professionals"))
            .then((response) => (professionals = response.data));
    }

    function changeProfessional() {
        const url = new URL(window.location).searchParams;
        if (!professional_id) {
            professional_id = $page.props.auth.user_id;
        }
        Inertia.get(
            route("agenda.index", {
                resource_user: professional_id,
                view: url.get("view"),
            })
        );
    }
</script>

{#if professionals.length > 0}
    <select
        name=""
        id=""
        class="p-2 mb-4"
        bind:value={professional_id}
        on:change={changeProfessional}
    >
        <option value="">Seleccione un profesional</option>
        {#each professionals as professional}
            <option value={professional.id}>{professional.name}</option>
        {/each}
    </select>
{/if}

<script>
    import { onMount } from "svelte";
    import Modal from "../../molecules/modal/Modal.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import ButtonPrimary from "../../atoms/buttons/ButtonPrimary.svelte";
    import ButtonDanger from "../../atoms/buttons/ButtonDanger.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    let officeHours = [];
    onMount(() => getOfficeHour());

    function getOfficeHour() {


        axios
            .get(route("office-hours.index", {
                resource_user: $page.props.query.resource_user
            }))
            .then((response) => (officeHours = response.data));
    }

    function getValues(officeHour) {
        return JSON.parse(officeHour.pivot.values);
    }

    function create() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user, // TODO este es el id del usuario autenticado
                dialog: "create-office-hours",
                view: $page.props.query.view,
            })
        );
    }

    function destroy(id) {
        Inertia.delete(
            route("office-hours.destroy", {
                resource_user: $page.props.query.resource_user,
                weekday_id: id,
            }),
            {
                onSuccess: () => getOfficeHour(),
            }
        );
    }

    function edit(weekday_id) {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                resource_weekday_id: weekday_id, // TODO este es el id del usuario autenticado
                dialog: "edit-office-hours",
                view: $page.props.query.view,
            })
        );
    }
</script>

<Modal>
    <div class="flex items-center justify-between">
        <h1>Horario laboral</h1>
        {#if $page.props.auth.permissions.find((permission) => permission === "create_office_hours")}
            <ButtonPrimary on:click={create}>Nuevo horario</ButtonPrimary>
        {/if}
    </div>
    <div class="space-y-4">
        <ul class="max-h-56 overflow-y-auto">
            {#each officeHours as officeHour}
                <li>
                    <div class="flex items-center">
                        <span class="font-bold">{officeHour.name}</span>
                        <!-- svelte-ignore a11y-click-events-have-key-events -->
                        <span
                            class="border px-1  rounded-full bg-green-500 text-white text-sm cursor-pointer"
                            on:click={() => edit(officeHour.id)}
                        >
                            Editar
                        </span>
                        <!-- svelte-ignore a11y-click-events-have-key-events -->
                        <span
                            class="border px-1  rounded-full bg-red-500 text-white text-sm cursor-pointer"
                            on:click={() => destroy(officeHour.id)}
                        >
                            Eliminar
                        </span>
                    </div>
                    <ul>
                        {#each getValues(officeHour) as value}
                            <li>De {value.start_time} - {value.end_time}</li>
                        {/each}
                    </ul>
                </li>
            {/each}
        </ul>
        <ButtonDanger
            on:click={() =>
                Inertia.get(
                    route("agenda.index", {
                        resource_user: $page.props.query.resource_user,
                        view: $page.props.query.view,
                    })
                )}
        >
            Cerrar
        </ButtonDanger>
    </div>
</Modal>

<script>
    import {
        component,
        request,
    } from "../../components/repository/request-stores";

    import Agenda from "../../components/organism/agenda/calendar/Agenda.svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import Panel from "../../components/atoms/panel/Panel.svelte";
    import ButtonPrimary from "../../components/atoms/buttons/ButtonPrimary.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Configuration from "../../components/organism/agenda/configuration/Configuration.svelte";
    import SwitchProfessional from "../../components/organism/agenda/professional/SwitchProfessional.svelte";
    import {page} from "@inertiajs/inertia-svelte";

    export let professional;

    let view = $page.props.query.view;
    // Función que permite abrir una nueva vista modal
    // para crear citas
    function createAppointment() {

        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                view,
                dialog: "appointment",
            })
        );
    }
</script>

<AdminLayout>
    <Panel class="panel-full">
        <!--Selector para cambair de profesional-->
        <SwitchProfessional {professional} />
        {#if professional.roles.find((role) => role.name === "Profesional")}
            <div class="flex justify-between">
                <ButtonPrimary on:click={createAppointment}>
                    Nueva cita
                </ButtonPrimary>
                <Configuration />
            </div>
            <Agenda {view} {professional} />
        {/if}
    </Panel>
    <!--Esta directiva nos permitirá mostrar las vistas modales del módulo agenda-->
    {#if $component}
        <svelte:component this={$component} />
    {/if}
</AdminLayout>

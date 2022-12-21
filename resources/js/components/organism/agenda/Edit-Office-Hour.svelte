<script>
    import { onMount } from "svelte";
    import Modal from "../../molecules/modal/Modal.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Intervals from "./timer/Intervals.svelte";
    import Form from "../../atoms/form/Form.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import {page} from "@inertiajs/inertia-svelte";

    let processing = false;
    let weekday = {};
    let officeHour = { id: null, intervals: [] };

    function store() {
        Inertia.put(
            route("office-hours.update", {
                resource_user: $page.props.query.resource_user, // TODO este es el id del usuario autenticado
            }),
            officeHour
        );
    }

    function close() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                dialog: "show-office-hours",
                view: "month",
            })
        );
    }

    onMount(() => getOfficeHour());

    function getOfficeHour() {
        // Obtenemos las direcciones para obtener sus identificadores
        const url = new URL(window.location).searchParams;
        const resource_weekday_id = url.get("resource_weekday_id");
        axios
            .get(
                route("office-hours.edit", {
                    resource_user: $page.props.query.resource_user,
                    resource_weekday_id: resource_weekday_id,
                })
            )
            .then((response) => {
                weekday = response.data;
                if (weekday) {
                    officeHour.id = weekday.id;
                    officeHour.intervals = getIntervals();
                }
            });
    }

    function getIntervals() {
        return JSON.parse(weekday?.pivot.values);
    }

    function removeEntry(index) {
        officeHour.intervals = officeHour.intervals.filter(
            (e, i) => i !== index
        );
    }

    function addEntry() {
        if (
            !officeHour.intervals[officeHour.intervals.length - 1].start_time ||
            !officeHour.intervals[officeHour.intervals.length - 1].end_time
        ) {
            alert("Por favor, ingrese datos en horario inicial y final");
            return;
        }
        officeHour.intervals.push({});
        officeHour.intervals = officeHour.intervals;
    }
</script>

<Modal>
    {#if officeHour.id}
        <h1>Horario laboral ({weekday.name})</h1>
        <Form>
            {#each officeHour?.intervals as interval, index}
                <Intervals
                    on:add={addEntry}
                    on:delete={() => removeEntry(index)}
                    bind:interval
                    {index}
                    bind:intervals={officeHour.intervals}
                />
            {/each}
        </Form>
        <ButtonActions on:save={store} on:close={close} permission="update_office_hours"/>
    {:else}
        ¡Vaya!, dicho horario no se encuentra en nuestra base de datos
    {/if}
</Modal>

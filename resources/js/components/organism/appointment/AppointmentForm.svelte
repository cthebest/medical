<script>
    import { Inertia } from "@inertiajs/inertia";
    import Form from "../../atoms/form/Form.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import Date from "../../molecules/date/Date.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import SearchInput from "../patient/SearchInput.svelte";
    import {page} from "@inertiajs/inertia-svelte";

    let appointment = {
        time: {
            date: null,
            hour: "",
        },
        isNewPatient: 1,
        patient: {
            name: null,
            rfc: null,
            phone: null,
            email: null,
        },
        reason: null,
    };

    let processing = false;

    function store() {

        Inertia.post(
            route("appointments.store", {
                view: $page.props.query.view,
                dialog: $page.props.query.dialog,
            }),
            {
                patient: appointment.patient,
                reason: appointment.reason,
                professional_id: $page.props.query.resource_user,
                isNewPatient: appointment.isNewPatient,
                date: appointment.time.date,
                start_time: appointment.time.hour.start_time,
                end_time: appointment.time.hour.end_time,
            },
            {
                onStart: () => (processing = true),
                onSuccess: () => {
                    appointment = {
                        time: {
                            date: null,
                            hour: "",
                        },
                        isNewPatient: 1,
                        patient: {
                            name: null,
                            rfc: null,
                            phone: null,
                            email: null,
                        },
                        reason: null,
                    };
                },
                onFinish: () => (processing = false),
            }
        );
    }

    function close() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                view: $page.props.query.view,
            })
        );
    }
</script>

<Form {processing}>
    <h1>Información de la cita</h1>
    <FormGroup class="group space-y-3">
        <Date bind:time={appointment.time} />
        <SearchInput
            isNewPatient={appointment.isNewPatient}
            bind:rfc={appointment.patient.rfc}
        />
        <FormGroup>
            <label for="">¿Es paciente nuevo?</label>
            <label>
                Sí
                <input
                    type="radio"
                    id="html"
                    value={1}
                    bind:group={appointment.isNewPatient}
                />
            </label>
            <label>
                No
                <input
                    type="radio"
                    id="html"
                    value={2}
                    bind:group={appointment.isNewPatient}
                />
            </label>
        </FormGroup>
        {#if appointment.isNewPatient === 1}
            <InputLabel
                name="patient"
                title="¿Para quién es la cita?"
                id="patient"
                bind:value={appointment.patient.name}
            />

            <InputLabel
                name="phone"
                title="Número de teléfono"
                id="phone"
                bind:value={appointment.patient.phone}
            />
            <InputLabel
                name="email"
                title="Correo electrónico"
                id="email"
                bind:value={appointment.patient.email}
            />
        {/if}
        <InputLabel
            name="reason"
            title="Motivo de la cita"
            id="reason"
            bind:value={appointment.reason}
        />
    </FormGroup>
    <ButtonActions
        on:close={close}
        on:save={store}
        permission="create_appointments"
    />
</Form>

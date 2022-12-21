<script>
    import Modal from "../../molecules/modal/Modal.svelte";
    import { onMount } from "svelte";
    import Form from "../../atoms/form/Form.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import { Inertia } from "@inertiajs/inertia";

    let minutes = [];
    let duration;

    function buildMinuts() {
        for (let i = 0; i <= 60; i += 5) {
            minutes.push({ value: i });
            minutes = minutes;
        }
    }

    onMount(() => getAppointmentConfiguration());

    function getAppointmentConfiguration() {
        const url = new URL(window.location).searchParams;
        const resource_user = url.get("resource_user");
        buildMinuts();
        axios
            .get(
                route("appointment-configurations.get", {
                    resource_user: resource_user,
                })
            )
            .then((response) => (duration = response.data.duration));
    }

    function store() {
        const url = new URL(window.location).searchParams;
        const resource_user = url.get("resource_user");
        const view = url.get("view");
        const dialog = "appointment-configuration";

        Inertia.post(
            route("appointment-configurations", {
                resource_user: resource_user,
                view: view,
                dialog: dialog,
            }),
            {
                duration: duration,
            }
        );
    }

    function close() {
        const url = new URL(window.location).searchParams;
        const resource_user = url.get("resource_user");
        const view = url.get("view");

        Inertia.get(
            route("agenda.index", {
                resource_user: resource_user,
                view: view,
            })
        );
    }
</script>

<Modal>
    <Form>
        <div>
            <label for="" class="block">Duración de la cita</label>
            <select bind:value={duration} class="p-2">
                <option value="">--</option>
                {#each minutes as minute}
                    <option value={"" + minute.value}>
                        {minute.value}
                    </option>
                {/each}
            </select>
        </div>
        <ButtonActions
            on:save={store}
            on:close={close}
            permission="create_appointmens_time"
        />
    </Form>
</Modal>

<script>
    import Modal from "../../molecules/modal/Modal.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { onMount } from "svelte";
    import UserForm from "./Partials/UserForm.svelte";

    let processing = false;

    let user = {
        role: "professional",
    };

    function create() {
        Inertia.put(route("users.update", { user: user.id }), user, {
            onStart: () => {
                processing = true;
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function close() {
        Inertia.get(route("users.index"));
    }

    onMount(() => getUser());

    function getUser() {
        const url = new URL(window.location).searchParams;
        axios
            .get(route("users.edit", { user: url.get("resource_user") }))
            .then((response) => {
                response.data.role = response.data.roles[0].name;
                user = response.data;
            });
    }
</script>

<Modal>
    <h1>Actualizar usuario</h1>
    <UserForm {processing} on:save={create} on:close={close} bind:user />
</Modal>

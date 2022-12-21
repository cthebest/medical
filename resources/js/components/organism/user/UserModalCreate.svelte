<script>
    import Modal from "../../molecules/modal/Modal.svelte";
    import ToolbarTitle from "../../molecules/toolbar/ToolbarTitle.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import UserForm from "./Partials/UserForm.svelte";

    let processing = false;

    let user = {
        role: "professional",
    };

    function create() {
        Inertia.post(route("users.store"), user, {
            onStart: () => {
                processing = true;
            },
            onSuccess: () => {
                user = { role: "professional" };
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function close() {
        Inertia.get(route("users.index"));
    }
</script>

<Modal>
    <h1>Nuevo usuario</h1>
    <UserForm {processing} on:save={create} on:close={close} bind:user />
</Modal>

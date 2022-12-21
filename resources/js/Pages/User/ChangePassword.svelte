<script>
    import Panel from "../../components/atoms/panel/Panel.svelte";
    import PasswordInput from "../../components/atoms/inputs/PasswordInput.svelte";
    import ButtonActions from "../../components/molecules/form/ButtonActions.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import ButtonPrimary from "../../components/atoms/buttons/ButtonPrimary.svelte";
    import ButtonDanger from "../../components/atoms/buttons/ButtonDanger.svelte";
    import FormGroup from "../../components/atoms/group/FormGroup.svelte";

    let roles = [];
    export let token;
    export let email;
    let credentials = {
        password: null,
        password_confirmation: null,
        email: email,
        token: token,
    };

    function update() {
        Inertia.patch(route("users.updatePassword", { token }), credentials);
    }

    function close() {
        Inertia.get(route("login"));
    }
</script>

<div class="w-full border flex justify-center items-center h-screen">
    <Panel variation="panel-md">
        <fieldset class="border p-2 space-y-3">
            <legend>Actualizar contraseña</legend>
            <PasswordInput
                label="Contraseña *"
                id="password"
                variation="inline"
                bind:value={credentials.password}
                type="password"
            />
            <PasswordInput
                label="Confirmar contraseña *"
                id="password_confirmation"
                variation="inline"
                bind:value={credentials.password_confirmation}
                type="password"
            />
            <FormGroup>
                <ButtonPrimary on:click={update}>Guardar</ButtonPrimary>
                <ButtonDanger on:click{close}>Cerrar</ButtonDanger>
            </FormGroup>
        </fieldset>
    </Panel>
</div>

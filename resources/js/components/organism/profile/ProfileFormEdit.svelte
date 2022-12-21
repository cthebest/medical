<script>
    import ToolbarTitle from "../../molecules/toolbar/ToolbarTitle.svelte";
    import Form from "../../atoms/form/Form.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { page } from "@inertiajs/inertia-svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import ButtonPrimary from "../../atoms/buttons/ButtonPrimary.svelte";

    let processing = false;

    export let user = {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
    };

    //profile.password_update

    function update_profile() {
        Inertia.put(route("profile.update", { user: user.id }), user, {
            onStart: () => {
                processing = true;
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function update_password() {
        Inertia.put(route("profile.password_update", { user: user.id }), user, {
            onStart: () => {
                processing = true;
            },
            onFinish: () => {
                processing = false;
            },
        });
    }
</script>

<ToolbarTitle title="Perfil" />
<Form>
    <FormGroup class="grid-group-2">
        <Panel class="panel-full">
            <h2 class="font-bold text-xl mb-6">Información del perfil</h2>
            <div class="space-y-4">
                <FormGroup class="group">
                    <InputLabel
                        type="text"
                        name="Nombre"
                        title="Nombre de usuario *"
                        errorType={$page.props.errors?.name}
                        bind:value={user.name}
                    />
                </FormGroup>
                <FormGroup class="group">
                    <InputLabel
                        type="email"
                        name="email"
                        title="Correo electrónico *"
                        errorType={$page.props.errors?.email}
                        bind:value={user.email}
                    />
                </FormGroup>
                <ButtonPrimary on:click={update_profile}>Guardar</ButtonPrimary>
            </div>
        </Panel>
        <Panel class="panel-full">
            <h2 class="font-bold text-xl mb-6">Seguridad</h2>
            <div class="space-y-4">
                <InputLabel
                    type="password"
                    name="Nombre"
                    title="Contraseña *"
                    errorType={$page.props.errors?.password}
                    bind:value={user.password}
                />
                <InputLabel
                    type="password"
                    name="email"
                    title="Confirme su contraseña *"
                    errorType={$page.props.errors?.password_confirmation}
                    bind:value={user.password_confirmation}
                />

                <ButtonPrimary
                    title="Guardar"
                    {processing}
                    on:click={update_password}>Guardar</ButtonPrimary
                >
            </div>
        </Panel>
    </FormGroup>
</Form>

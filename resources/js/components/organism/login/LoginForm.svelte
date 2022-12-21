<script>
    import { Inertia } from "@inertiajs/inertia";
    import Panel from "../../atoms/panel/Panel.svelte";
    import Form from "../../atoms/form/Form.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import ButtonPrimary from "../../atoms/buttons/ButtonPrimary.svelte";

    let processing = false;
    let values = {
        email: null,
        password: null,
    };

    let errors;

    function login() {
        Inertia.post("/admin/login", values, {
            onStart: (visit) => {
                processing = true;
            },
            onFinish: () => {
                processing = false;
            },
        });
    }
</script>

<Panel class="panel-md">
    <Form bind:errors {processing}>
        <h1>Iniciar Sesión</h1>
        <InputLabel
            title="Email *"
            type="email"
            name="email"
            errorType={errors?.email}
            bind:value={values.email}
        />
        <InputLabel
            title="Password *"
            type="password"
            name="password"
            errorType={errors?.password}
            bind:value={values.password}
        />
        <ButtonPrimary on:click={login}>Iniciar Sesión</ButtonPrimary>
    </Form>
</Panel>

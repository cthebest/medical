<script>
    import { onMount } from "svelte";
    import Form from "../../../atoms/form/Form.svelte";
    import InputLabel from "../../../molecules/form/InputLabel.svelte";
    import SelectLabel from "../../../molecules/form/SelectLabel.svelte";
    import ButtonActions from "../../../molecules/form/ButtonActions.svelte";
    // Roles que se encuentran en la base de datos
    let roles = [];
    let errors;

    // Objeto usuario para guardar en la base de datos
    export let user = {
        name: null,
        email: null,
        role: "professional",
    };
    export let processing;

    onMount(() => getRoles());

    function getRoles() {
        axios
            .get(route("admin.roles"))
            .then((response) => (roles = response.data));
    }
</script>

<Form bind:errors {processing}>
    <InputLabel
        type="text"
        name="Nombre"
        title="Nombre de usuario *"
        errorType={errors?.name}
        bind:value={user.name}
    />
    <InputLabel
        type="email"
        name="email"
        title="Correo electrónico *"
        errorType={errors?.email}
        bind:value={user.email}
    />
    <SelectLabel
        text="Rol"
        bind:value={user.role}
        data={roles}
        field="name"
        name="roles"
    />

    <ButtonActions on:save on:close permission="create_users" />
</Form>

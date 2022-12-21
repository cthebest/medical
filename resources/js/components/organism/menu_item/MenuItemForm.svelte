<script>
    import Form from "../../atoms/form/Form.svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import { onMount } from "svelte";
    import SelectLabel from "../../molecules/form/SelectLabel.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import { Inertia } from "@inertiajs/inertia";

    export let processing = false;
    let errors;
    let components = [];
    let resources = [];
    export let menuItem = {
        title: null,
        icon: "",
        component_type: "",
        resource: "0",
    };

    $: if (menuItem.component_type && components && components.length) {
        const component = components.find(
            (component) => component.name === menuItem.component_type
        );

        if (component && component.has_table) {
            getResources(component.name);
        }
    }

    onMount(() => getComponents());

    function getComponents() {
        axios
            .get(route("components"))
            .then((response) => (components = response.data));
    }

    function getResources(component) {
        axios
            .get(route(`${component}.get-all`))
            .then((response) => (resources = response.data));
    }

    function resetResource() {
        resources = [];
        menuItem.resource = "" + 0;
        console.log(menuItem);
    }
</script>

<Panel class="panel-full">
    <Form {processing} bind:errors>
        <InputLabel
            title="Título"
            name="title"
            id="title"
            errorType={errors?.title}
            bind:value={menuItem.title}
        />

        <InputLabel
            title="Ícono"
            name="icon"
            id="icon"
            errorType={errors?.icon}
            bind:value={menuItem.icon}
        />

        <FormGroup class="group">
            <label for="">Componentes</label>
            <select
                name="resource"
                id="resource"
                class="p-3 rounded-md"
                bind:value={menuItem.component_type}
                on:change={resetResource}
            >
                <option value="">Seleccione un componente</option>
                {#each components as resource}
                    <option value={resource.name}>{resource.label}</option>
                {/each}
            </select>
        </FormGroup>

        {#if resources.length > 0}
            <FormGroup class="group">
                <label for="">Recurso</label>
                <select
                    name="resource"
                    id="resource"
                    class="p-3 rounded-md"
                    bind:value={menuItem.resource}
                >
                    <option value="0">Seleccione un recurso</option>
                    {#each resources as resource}
                        <option value={"" + resource.id}
                            >{resource.title}</option
                        >
                    {/each}
                </select>
            </FormGroup>
        {/if}

        <ButtonActions on:save on:close />
    </Form>
</Panel>

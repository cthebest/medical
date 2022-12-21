<script>
    import Select from "../../atoms/inputs/Select.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";

    export let text, name, value, data, field;
</script>

<FormGroup class="group">
    <label for={name} class="block font-bold">
        {text ?? "Por favor, agregar nombre"}
    </label>
    <Select {name} bind:value {data} {field} />
</FormGroup>

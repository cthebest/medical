<script>
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import EmailInput from "../../atoms/inputs/EmailInput.svelte";
    import PasswordInput from "../../atoms/inputs/PasswordInput.svelte";
    import TextInput from "../../atoms/inputs/TextInput.svelte";
    export let title, type, errorType, name, id, value;

    const options = {
        text: TextInput,
        password: PasswordInput,
        email: EmailInput,
    };
</script>

<FormGroup class="group">
    <label for="">{title}</label>
    <div>
        <svelte:component
            this={options[type] ?? options.text}
            {name}
            {id}
            bind:value
        />
        {#if errorType}
            <span class="text-red-600">{errorType}</span>
        {/if}
    </div>
</FormGroup>

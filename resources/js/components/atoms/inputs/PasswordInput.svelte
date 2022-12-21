<script>
    export let name, id, value;
</script>

<input
    type="password"
    class="p-2 border  w-full rounded-md"
    {name}
    {id}
    bind:value
/>

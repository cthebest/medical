<script>
    export let name, id, value;
</script>

<input
    type="text"
    class="p-2 border  w-full rounded-md"
    {name}
    {id}
    bind:value
/>

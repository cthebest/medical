<script>
    export let name,
        data = [],
        field,
        value;
</script>

<select {name} id="" bind:value class="p-3 rounded-md">
    {#each data as dato}
        <option value={dato[field]}>{dato[field]}</option>
    {/each}
</select>

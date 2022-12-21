<script>
    import InputLabel from "../../molecules/form/InputLabel.svelte";

    export let isNewPatient;
    export let rfc = "";
    let patients = [];
    let chose = false;
    const config = {
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    };
    $: if (rfc && isNewPatient === 2 && rfc.length > 2 && !chose) {
        axios
            .get(
                route("patient", {
                    rfc: rfc,
                }),
                config
            )
            .then((response) => (patients = response.data));
    } else {
        patients = [];
        chose = false;
    }

    function choseRFC(patient_rfc) {
        rfc = patient_rfc;
        chose = true;
    }
</script>

<div class="relative">
    <InputLabel name="rfc" title="RFC" bind:value={rfc} />
    {#if patients.length > 0}
        <ul class="mt-2 border absolute bg-white w-full shadow-md">
            {#each patients as patient}
                <!-- svelte-ignore missing-declaration -->
                <!-- svelte-ignore a11y-click-events-have-key-events -->
                <li
                    class="hover:bg-gray-200"
                    on:click={() => choseRFC(patient.rfc)}
                >
                    {patient.name}
                </li>
            {/each}
        </ul>
    {/if}
</div>

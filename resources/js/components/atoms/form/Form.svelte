<script>
    import { page } from "@inertiajs/inertia-svelte";
    import { Circle3 } from "svelte-loading-spinners";

    export let errors, processing;

    $: if ($page.props.errors) {
        errors = $page.props.errors;
    }
</script>

<form class="space-y-4 relative">
    {#if $page.props.flash.message}
        <div
            class="border border-green-200 text-green-700 bg-green-200 p-2 rounded-md"
        >
            <span>{$page.props.flash.message}</span>
        </div>
    {/if}

    {#if $page.props.errors.message}
        <div
            class="border border-red-200 text-red-700 bg-red-200 p-2 rounded-md"
        >
            <span>{$page.props.errors.message}</span>
        </div>
    {/if}
    <slot />
    {#if processing}
        <div id="processing" class="absolute top-0 left-0 right-0 bottom-0">
            <div class="flex justify-center items-center h-full">
                <Circle3 size="60" color="#FF3E00" unit="px" duration="1s" />
            </div>
        </div>
    {/if}
</form>

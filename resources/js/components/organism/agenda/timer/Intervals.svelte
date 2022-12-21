<script>
    import Time from "./Time.svelte";
    import {createEventDispatcher} from "svelte";
    import Fa from "svelte-fa/src/fa.svelte";
    import {faTrash, faPlus} from "@fortawesome/free-solid-svg-icons";

    const dispatch = createEventDispatcher();

    let isHidden = true;

    export let interval = {
        start_time: null,
        end_time: undefined
    };
    export let intervals = [];
    export let index;
</script>

<!-- svelte-ignore a11y-mouse-events-have-key-events -->
<div
    class="p-2 hover:bg-gray-100 rounded-md my-1"
    on:mouseover={() => (isHidden = false)}
    on:mouseout={() => (isHidden = true)}>
    <div class="flex items-center">
        <span class="pr-2">de</span>
        <!--Intervalo mínimo-->
        <Time bind:time={interval.start_time} unavailableHours={intervals} {index}/>
        <span class="px-2">a</span>
        <!--Intervalo máximo-->
        <Time bind:time={interval.end_time} startTimeChose="{interval.start_time}"
              unavailableHours={intervals} {index}/>
        <div class="px-2 flex space-x-4">
            {#if intervals.length - 1 === index}
                <button
                    type="button"
                    class:hidden={isHidden}
                    class="block text-gray-500 rounded-full hover:bg-gray-600 hover:text-gray-200 h-6 w-6 flex items-center justify-center"
                    on:click={()=>dispatch("add")}>
                    <Fa icon={faPlus}/>
                </button>
            {/if}
            <button
                type="button"
                class:hidden={isHidden}
                class="block text-gray-500 rounded-full hover:bg-gray-600 hover:text-gray-200 h-6 w-6 flex items-center justify-center"
                on:click={()=>dispatch("delete")}>
                <Fa icon={faTrash}/>
            </button>
        </div>
    </div>
</div>

<script>
    import { onMount } from "svelte";
    import prueba from "images/fondoheader.png";
    // Hola mundo

    let menuItems = [];

    onMount(() => getElements());

    function getElements() {
        axios.all([axios.get(route("menu-items.get-all"))]).then(
            axios.spread((menuItemsResponse) => {
                // output of req.
                menuItems = menuItemsResponse.data;
                console.log(menuItems);
            })
        );
    }
</script>

<svelte:head>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    />
</svelte:head>
<div class="bg-[#99cc33] mx-40">
    <header>
        <div id="slider">
            <img
                src={prueba}
                id="image"
                alt=""
                class="w-full h-96 object-fill"
            />
        </div>
        <nav class="bg-[#99cc33] px-5 py-2">
            <ul class="text-white flex space-x-3">
                {#each menuItems as menuItem}
                    <li class="flex flex-col">
                        <div
                            class="bg-[#006699] h-8 w-8 rounded-full flex justify-center items-center"
                        >
                            <i class={menuItem.icon} />
                        </div>
                        <a href={menuItem.path}>{menuItem.title}</a>
                    </li>
                {/each}
            </ul>
        </nav>
    </header>
</div>

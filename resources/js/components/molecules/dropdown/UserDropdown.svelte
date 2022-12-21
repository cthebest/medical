<script>
    // library for creating dropdown menu appear on click
    import { createPopper } from "@popperjs/core";
    import { page } from "@inertiajs/inertia-svelte";
    let dropdownPopoverShow = false;

    let btnDropdownRef;
    let popoverDropdownRef;

    const toggleDropdown = (event) => {
        event.preventDefault();
        if (dropdownPopoverShow) {
            dropdownPopoverShow = false;
        } else {
            dropdownPopoverShow = true;
            createPopper(btnDropdownRef, popoverDropdownRef, {
                placement: "bottom-start",
            });
        }
    };

    function getInitials(name) {
        // Separamos el nombre en un array de palabras
        const words = name.split(" ");
        // Aquí almacenaremos las iniciales
        let initials = "";
        // Itera sobre las palabras del array
        for (let i = 0; i < words.length; i++) {
            // Agrega la primera letra de cada palabra a la variable de iniciales
            initials += words[i][0];
        }
        // Devuelve las iniciales
        return initials;
    }
</script>

<div>
    <a
        class="block"
        href="#pablo"
        bind:this={btnDropdownRef}
        on:click={toggleDropdown}
    >
        <div class="items-center flex">
            <span
                class="p-2 text-sm inline-flex bg-blue-600 text-white items-center justify-center rounded-md"
            >
                {getInitials($page.props.auth.username)}
            </span>
        </div>
    </a>
    <div
        bind:this={popoverDropdownRef}
        class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg 
        min-w-48 {dropdownPopoverShow ? 'block' : 'hidden'}"
    >
        <a
            href={route("profile.edit", {
                user: $page.props.auth.user_id,
            })}
            class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent 
            hover:text-gray-600"
        >
            Perfil
        </a>

        <div class="h-0 my-2 border border-solid border-blueGray-100" />
        <a
            href={route("logout")}
            class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent
            hover:text-gray-600"
        >
            Cerrar sesión
        </a>
    </div>
</div>

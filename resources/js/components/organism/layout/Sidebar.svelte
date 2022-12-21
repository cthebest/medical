<script>
    import SidebarItem from "../../molecules/listas/SidebarItem.svelte";
    import {
        faGauge,
        faCalendar,
        faCalendarCheck,
        faUsers,
        faNewspaper,
        faBurger,
    } from "@fortawesome/free-solid-svg-icons";
    import { page } from "@inertiajs/inertia-svelte";

    let collapseShow = "hidden";
    $: console.log($page.props);
    function toggleCollapseShow(classes) {
        collapseShow = classes;
    }
</script>

<nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto 
    md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-[#006699] flex 
    flex-wrap items-center justify-between relative md:w-64 z-20 py-4 
    text-white px-6"
>
    <div
        class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 
        flex flex-wrap items-center justify-between w-full mx-auto"
    >
        <!-- Toggler -->
        <button
            class="cursor-pointer opacity-50 md:hidden px-3 py-1 
            text-xl leading-none bg-transparent rounded border border-solid 
            border-transparent"
            type="button"
            on:click={() => toggleCollapseShow("m-2 py-3 px-6")}
        >
            Icon
        </button>
        <!-- Brand -->
        <a
            class="md:block text-left md:pb-2 mr-0 inline-block 
            whitespace-nowrap text-sm uppercase font-bold p-4 
            px-0 text-[#99cc33]"
            href="/"
        >
            Medical
        </a>
        <!-- User -->
        <ul class="md:hidden items-center flex flex-wrap list-none">
            <li class="inline-block relative">
                <!--
                <NotificationDropdown />
                -->
            </li>
            <li class="inline-block relative">
                <!--<UserDropdown />-->
            </li>
        </ul>
        <!-- Collapse -->
        <div
            class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative 
            md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 
            overflow-y-auto overflow-x-hidden h-auto items-center flex-1 bg-[#006699]
            rounded {collapseShow}"
        >
            <!-- Collapse header -->
            <div
                class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid 
                border-gray-200"
            >
                <div class="flex flex-wrap">
                    <div class="w-6/12">
                        <a
                            class="md:block text-left md:pb-2 text-blueGray-600 mr-0 
                            inline-block whitespace-nowrap text-sm uppercase 
                            font-bold p-4 px-0 text-[#99cc33]"
                            href="/"
                        >
                            Medical
                        </a>
                    </div>
                    <div class="w-6/12 flex justify-end">
                        <button
                            type="button"
                            class="cursor-pointer opacity-50 md:hidden px-3 
                            py-1 text-xl leading-none bg-transparent rounded border 
                            border-solid border-transparent"
                            on:click={() => toggleCollapseShow("hidden")}
                        >
                            Close icon
                        </button>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="my-4 md:min-w-full" />
            <!-- Heading -->
            <h6
                class="md:min-w-full text-xs uppercase font-bold block pt-1 
                pb-4 no-underline text-[#99cc33]"
            >
                Inicio
            </h6>
            <!-- Navigation 006699 blue 99cc33 green-->

            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <SidebarItem
                    title={"dashboard"}
                    icon={faGauge}
                    href="users.index"
                />
            </ul>
            <!-- Divider -->
            {#if $page.props.auth.roles.find((role) => role === "Profesional" || role === "Secretaria")}
                <hr class="my-4 md:min-w-full" />
                <h6
                    class="md:min-w-full text-xs uppercase font-bold block pt-1 
            pb-4 no-underline text-[#99cc33]"
                >
                    Calendario
                </h6>
                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <SidebarItem
                        title={"Agenda"}
                        icon={faCalendarCheck}
                        href="agenda.index"
                        params={{
                            resource_user: $page.props.auth.user_id,
                            view: "month",
                        }}
                    />
                </ul>
            {/if}
            {#if $page.props.auth.roles.find((role) => role === "Editor" || role === "Administrador")}
                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <h6
                    class="md:min-w-full text-xs uppercase font-bold block pt-1 
                pb-4 no-underline text-[#99cc33]"
                >
                    Recursos
                </h6>
                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    {#if $page.props.auth.roles.find((role) => role === "Administrador")}
                        <SidebarItem
                            title={"Usuarios"}
                            icon={faUsers}
                            href="users.index"
                        />
                    {/if}
                    {#if $page.props.auth.permissions.find((permission) => permission === "list_articles")}
                        <SidebarItem
                            title={"Artículos"}
                            icon={faNewspaper}
                            href="articles.index"
                        />
                    {/if}
                    <SidebarItem
                        title={"Menú"}
                        icon={faBurger}
                        href="menu-items.index"
                    />
                </ul>
            {/if}
        </div>
    </div>
</nav>

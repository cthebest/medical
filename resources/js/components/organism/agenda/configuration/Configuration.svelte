<script>
    import Fa from "svelte-fa/src/fa.svelte";
    import { faCog } from "@fortawesome/free-solid-svg-icons";
    import { Inertia } from "@inertiajs/inertia";
    import { createPopper } from "@popperjs/core";
    import ClickOutside from "svelte-click-outside";
    import {page} from "@inertiajs/inertia-svelte";
    let btnDropdownRef, popoverDropdownRef;
    let open = false;

    function toggleDropdown() {
        open = !open;

        if (open) {
            createPopper(btnDropdownRef, popoverDropdownRef, {
                placement: "left",
                modifiers: [
                    {
                        name: "offset",
                        options: {
                            offset: [0, 10],
                        },
                    },
                ],
            });
        }
    }

    function getOfficeHourURL() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                view: $page.props.query.view,
                dialog: "show-office-hours",
            })
        );
    }

    function appointmentConfiguration() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                view: $page.props.query.view,
                dialog: "appointment-configuration",
            })
        );
    }
</script>

<div>
    <button
        class="p-2 bg-[#99cc33] flex items-center text-white"
        bind:this={btnDropdownRef}
        on:click={toggleDropdown}
    >
        <Fa icon={faCog} />
        Configuración
    </button>
    <ClickOutside
        on:clickoutside={() => (open = false)}
        exclude={[btnDropdownRef]}
    >
        <ul bind:this={popoverDropdownRef} class="border" class:hidden={!open}>
            <li class="hover:bg-red-200 p-2">
                <a href={"#"} on:click={getOfficeHourURL}>Horario laboral</a>
            </li>
            <li class="hover:bg-red-200 p-2">
                <a href={"#"} on:click={appointmentConfiguration}>
                    Tiempo de la cita
                </a>
            </li>
        </ul>
    </ClickOutside>
</div>

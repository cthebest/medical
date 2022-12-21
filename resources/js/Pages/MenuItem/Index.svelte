<script>
    import Table from "../../components/atoms/table/Table.svelte";
    import Thead from "../../components/atoms/table/Thead.svelte";
    import TBody from "../../components/atoms/table/TBody.svelte";
    import TDataCell from "../../components/atoms/table/TDataCell.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FormGroup from "../../components/atoms/group/FormGroup.svelte";
    import {
        component,
        request,
    } from "../../components/repository/request-stores";
    import ButtonPrimary from "../../components/atoms/buttons/ButtonPrimary.svelte";
    import ButtonDanger from "../../components/atoms/buttons/ButtonDanger.svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import Panel from "../../components/atoms/panel/Panel.svelte";
    import { paginate, LightPaginationNav } from "svelte-paginate";

    export let menuItems; // Son todos los usuarios que se encuentran en la base de datos
    let currentPage = menuItems.current_page;

    export let dialog; // Es el modal que será mostrado al usuario

    $: if (dialog) {
        $request.component = dialog;
    } else {
        $request.component = null;
    }

    function create() {
        Inertia.get(route("menu-items.create"));
    }

    function edit(menuItem) {
        Inertia.get(
            route("menu-items.edit", {
                menu_item: menuItem,
            })
        );
    }
</script>

<AdminLayout>
    <Panel class="panel-full">
        <div class="py-2">
            <ButtonPrimary on:click={create}>Nuevo item de menú</ButtonPrimary>
        </div>
        <Table>
            <tr>
                <Thead>Título</Thead>
                <Thead>Ruta</Thead>
                <Thead>Link interno</Thead>
                <Thead>Fecha de creación</Thead>
                <Thead>Fecha de actualización</Thead>
                <Thead>Acciones</Thead>
            </tr>
            <TBody>
                {#each menuItems.data as menuItem}
                    <tr>
                        <TDataCell>{menuItem.title}</TDataCell>
                        <TDataCell>{menuItem.path}</TDataCell>
                        <TDataCell>{menuItem.link}</TDataCell>
                        <TDataCell>{menuItem.created_at}</TDataCell>
                        <TDataCell>{menuItem.updated_at}</TDataCell>
                        <TDataCell>
                            <FormGroup>
                                <ButtonPrimary on:click={() => edit(menuItem)}
                                    >Editar</ButtonPrimary
                                >
                                <ButtonDanger
                                    on:click={() =>
                                        Inertia.delete(
                                            route("menu-items.destroy", {
                                                menu_item: menuItem.id,
                                            })
                                        )}>Eliminar</ButtonDanger
                                >
                            </FormGroup>
                        </TDataCell>
                    </tr>
                {/each}
            </TBody>
        </Table>
        <div class="mt-4">
            <LightPaginationNav
                totalItems={menuItems.total}
                pageSize={menuItems.per_page}
                {currentPage}
                limit={1}
                showStepOptions={true}
                on:setPage={(e) => {
                    Inertia.get(
                        route("menu-items.index", { page: e.detail.page })
                    );
                    currentPage = e.detail.page;
                }}
            />
        </div>
        {#if component}
            <svelte:component this={$component} />
        {/if}
    </Panel>
</AdminLayout>

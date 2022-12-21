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

    export let users; // Son todos los usuarios que se encuentran en la base de datos
    let currentPage = users.current_page;


    // Permite enviar al servidor el tipo de modal que deseo y un recurso si necesito actualizarlo
    function openModalForm(dialogType = "create-user", resource_user) {
        Inertia.get("users", {
            dialog: dialogType,
            resource_user: resource_user,
        });
    }
</script>

<AdminLayout>
    <Panel class="panel-full">
        <div class="py-2">
            <ButtonPrimary
                title="Nuevo usuario"
                on:click={() => openModalForm("create-user")}
            >
                Nuevo usuario
            </ButtonPrimary>
        </div>
        <Table>
            <tr>
                <Thead>Nombre</Thead>
                <Thead>Email</Thead>
                <Thead>Rol</Thead>
                <Thead>Fecha de creación</Thead>
                <Thead>Fecha de actualización</Thead>
                <Thead>Acciones</Thead>
            </tr>
            <TBody>
                {#each users.data as user}
                    <tr>
                        <TDataCell>{user.name}</TDataCell>
                        <TDataCell>{user.email}</TDataCell>
                        <TDataCell>
                            {#each user.roles as role}
                                {role.name}
                            {/each}
                        </TDataCell>
                        <TDataCell>{user.created_at}</TDataCell>
                        <TDataCell>{user.updated_at}</TDataCell>
                        <TDataCell>
                            <FormGroup>
                                <ButtonPrimary
                                    on:click={() =>
                                        openModalForm("edit-user", user.id)}
                                    >Editar</ButtonPrimary
                                >
                                <ButtonDanger
                                    on:click={() =>
                                        Inertia.delete(
                                            route("users.destroy", {
                                                user: user.id,
                                            })
                                        )}
                                >
                                    Eliminar
                                </ButtonDanger>
                            </FormGroup>
                        </TDataCell>
                    </tr>
                {/each}
            </TBody>
        </Table>
        <div class="mt-4">
            <LightPaginationNav
                totalItems={users.total}
                pageSize={users.per_page}
                {currentPage}
                limit={1}
                showStepOptions={true}
                on:setPage={(e) => {
                    Inertia.get(route("users.index", { page: e.detail.page }));
                    currentPage = e.detail.page;
                }}
            />
        </div>
        {#if component}
            <svelte:component this={$component} />
        {/if}
    </Panel>
</AdminLayout>

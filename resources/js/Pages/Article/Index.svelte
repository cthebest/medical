<script>
    import Table from "../../components/atoms/table/Table.svelte";
    import Thead from "../../components/atoms/table/Thead.svelte";
    import TBody from "../../components/atoms/table/TBody.svelte";
    import TDataCell from "../../components/atoms/table/TDataCell.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FormGroup from "../../components/atoms/group/FormGroup.svelte";
    import ButtonPrimary from "../../components/atoms/buttons/ButtonPrimary.svelte";
    import ButtonDanger from "../../components/atoms/buttons/ButtonDanger.svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import Panel from "../../components/atoms/panel/Panel.svelte";
    import { paginate, LightPaginationNav } from "svelte-paginate";

    export let articles; // Son todos los artículos que se encuentran en la base de datos
    let currentPage = articles.current_page;

    function create() {
        Inertia.get(route("articles.create"));
    }

    function edit(article_id) {
        Inertia.get(route("articles.edit", { article: article_id }));
    }
</script>

<AdminLayout>
    <Panel class="panel-full">
        <div class="py-2">
            <ButtonPrimary on:click={create}>Nuevo artículo</ButtonPrimary>
        </div>
        <Table>
            <tr>
                <Thead>Título</Thead>
                <Thead>Alias</Thead>
                <Thead>Autor</Thead>
                <Thead>Fecha de creación</Thead>
                <Thead>Fecha de actualización</Thead>
                <Thead>Acciones</Thead>
            </tr>
            <TBody>
                {#each articles.data as article}
                    <tr>
                        <TDataCell>{article.title}</TDataCell>
                        <TDataCell>{article.alias}</TDataCell>
                        <TDataCell>
                            {article.user.name}
                        </TDataCell>
                        <TDataCell>{article.created_at}</TDataCell>
                        <TDataCell>{article.updated_at}</TDataCell>
                        <TDataCell>
                            <FormGroup>
                                <ButtonPrimary on:click={() => edit(article.id)}
                                    >Editar</ButtonPrimary
                                >
                                <ButtonDanger
                                    on:click={() =>
                                        Inertia.delete(
                                            route("articles.destroy", {
                                                article: article.id,
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
                totalItems={articles.total}
                pageSize={articles.per_page}
                {currentPage}
                limit={1}
                showStepOptions={true}
                on:setPage={(e) => {
                    Inertia.get(
                        route("articles.index", { page: e.detail.page })
                    );
                    currentPage = e.detail.page;
                }}
            />
        </div>
    </Panel>
</AdminLayout>

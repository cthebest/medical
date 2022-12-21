<script>
    import { Inertia } from "@inertiajs/inertia";
    import ArticleForm from "../../components/organism/article/ArticleForm.svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import MenuItemForm from "../../components/organism/menu_item/MenuItemForm.svelte";

    let processing;
    export let menuItem;

    function store() {
        Inertia.put(
            route("menu-items.update", { menu_item: menuItem.id }),
            menuItem,
            {
                preserveState: false,
                onStart: () => (processing = true),
                onFinish: () => (processing = false),
            }
        );
    }

    function close() {
        Inertia.get(route("menu-items.index"));
    }
</script>

<AdminLayout>
    <MenuItemForm {processing} on:save={store} on:close={close} bind:menuItem />
</AdminLayout>

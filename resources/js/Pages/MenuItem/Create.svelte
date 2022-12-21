<script>
    import { Inertia } from "@inertiajs/inertia";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import ArticleForm from "../../components/organism/article/ArticleForm.svelte";
    import MenuItemForm from "../../components/organism/menu_item/MenuItemForm.svelte";

    let menuItem = {
        title: null,
        component_type: "",
        resource: 0,
    };

    let processing = false;

    function store() {
        Inertia.post(route("menu-items.store"), menuItem, {
            onStart: () => {
                processing = true;
            },
            onSuccess: () => {
                menuItem = {
                    title: null,
                    component_type: "",
                    resource: 0,
                };
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function close() {
        Inertia.get(route("menu-items.index"));
    }
</script>

<AdminLayout>
    <MenuItemForm {processing} on:save={store} on:close={close} bind:menuItem />
</AdminLayout>

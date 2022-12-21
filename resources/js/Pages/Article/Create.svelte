<script>
    import { Inertia } from "@inertiajs/inertia";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import ArticleForm from "../../components/organism/article/ArticleForm.svelte";

    let article = {
        title: null,
        file: null,
        body: "",
    };

    let processing = false;

    function store() {
        Inertia.post(route("articles.store"), article, {
            onStart: () => {
                processing = true;
            },
            onSuccess: () => {
                article = {
                    title: null,
                    url_photo: null,
                    body: "",
                };
            },
            onFinish: () => {
                processing = false;
            },
        });
    }

    function close() {
        Inertia.get(route("articles.index"));
    }
</script>

<AdminLayout>
    <ArticleForm {processing} on:save={store} on:close={close} bind:article />
</AdminLayout>

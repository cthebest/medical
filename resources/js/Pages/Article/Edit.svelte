<script>
    import { Inertia } from "@inertiajs/inertia";
    import ArticleForm from "../../components/organism/article/ArticleForm.svelte";
    import { onMount } from "svelte";
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";

    let processing;
    let article;
    export let id;
    function store() {
        Inertia.put(
            route("articles.update", { article: article.id }),
            article,
            {
                onStart: () => (processing = true),
                onFinish: () => (processing = false),
            }
        );
    }

    function close() {
        Inertia.get(route("articles.index"));
    }

    onMount(() => getArticle());

    function getArticle() {
        axios
            .get(route("articles.get-article", { article: id }))
            .then((response) => {
                article = response.data;
                if (response.data.body) {
                    article = response.data;
                } else {
                    response.data.body = "";
                    article = response.data;
                }
            });
    }
</script>

<AdminLayout>
    {#if article}
        <ArticleForm
            {processing}
            on:save={store}
            on:close={close}
            bind:article
        />
    {/if}
</AdminLayout>

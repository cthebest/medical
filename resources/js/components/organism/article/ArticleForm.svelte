<script>
    import Editor from "@tinymce/tinymce-svelte";
    import Form from "../../atoms/form/Form.svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";

    export let processing = false;
    let errors;
    export let article = {
        title: null,
        file: null,
        body: "",
    };

    const onFileSelected = (e) => {
        article.file = e.target.files[0];
    };
</script>

<Panel class="panel-full">
    <Form {processing} bind:errors>
        <InputLabel
            title="Título"
            name="title"
            id="title"
            errorType={errors?.title}
            bind:value={article.title}
        />
        <div>
            <label for="avatar" class="block">Foto de portada</label>
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/png, image/jpeg"
                on:change={(e) => onFileSelected(e)}
            />
        </div>
        <Editor
            apiKey="2b1c61f1wtvokeiudot95vc7iu0bdr8pm9rzyj8lmgdc5n1o"
            bind:value={article.body}
        />

        <ButtonActions on:save on:close />
    </Form>
</Panel>

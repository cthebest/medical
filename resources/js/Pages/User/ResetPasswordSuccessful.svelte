<script>
    import Panel from "@/components/atoms/panel/Panel.svelte";

    export let redirect;
</script>
<Panel variation="md">
    Su contraseña fue actualizada exitosamente, ahora puedes iniciar sesión <a href="{redirect}">Iniciar sesión</a>
</Panel>

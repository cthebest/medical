<script>
    let className = 'inline-group';
    export {className as class}
</script>
<div class="{className}">
    <slot></slot>
</div>

<style>
    .inline-group {
        @apply flex space-x-3 items-center w-full;
    }

    .group {
        @apply flex flex-col;
    }

    .grid-group-2 {
        @apply grid grid-cols-2 gap-2;
    }
</style>

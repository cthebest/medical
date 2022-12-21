<script>
    let className = "panel-md";
    export { className as class };
</script>

<div class="panel {className}">
    <slot />
</div>

<style>
    .panel {
        @apply bg-white shadow-lg p-4  border border-gray-300 rounded-lg;
    }
    .panel-full {
        @apply min-w-full;
    }
    .panel.panel-xl {
        @apply max-w-xl;
    }

    .panel.panel-lg {
        @apply max-w-lg min-w-[36rem];
    }

    .panel.panel-md {
        @apply max-w-md min-w-[32rem] overflow-y-auto max-h-[32rem];
    }

    .panel.panel-sm {
        @apply max-w-sm min-w-[28rem];
    }
</style>

<script>
    import Fa from "svelte-fa/src/fa.svelte";
    export let title, icon, href, params;
</script>

<li class="hover:bg-[#99cc33] px-2  rounded-full">
    <a
        href={route(href, params)}
        class="text-xs uppercase py-2 font-bold flex items-center space-x-2"
    >
        <Fa {icon} />
        <span>{title}</span>
    </a>
</li>

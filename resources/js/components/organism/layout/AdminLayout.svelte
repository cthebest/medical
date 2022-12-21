<script>
    import FooterAdmin from "./FooterAdmin.svelte";
    import Navbar from "./Navbar.svelte";

    import Sidebar from "./Sidebar.svelte";
</script>

<div>
    <Sidebar />
    <div class="relative md:ml-64 bg-gray-100 h-screen">
        <Navbar />
        <div class="px-2 md:px-4 mx-auto w-full pt-20 h-full">
            <slot />
            <FooterAdmin />
        </div>
    </div>
</div>

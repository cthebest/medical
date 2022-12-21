<script>
    import UserDropdown from "../../molecules/dropdown/UserDropdown.svelte";

    // core components
</script>

<!-- Navbar -->
<nav
    class="absolute top-0 left-0 w-full z-10 bg-white md:flex-row md:flex-nowrap 
    md:justify-start flex items-center p-4"
>
    <div
        class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap 
        md:px-10 px-4"
    >
        Administración

        <!-- User -->
        <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
            <UserDropdown />
        </ul>
    </div>
</nav>
<!-- End Navbar -->

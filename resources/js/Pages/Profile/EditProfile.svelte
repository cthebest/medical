<script>
    import AdminLayout from "../../components/organism/layout/AdminLayout.svelte";
    import ProfileFormEdit from "../../components/organism/profile/ProfileFormEdit.svelte";

    export let user;
</script>

<AdminLayout>
    <ProfileFormEdit {user} />
</AdminLayout>

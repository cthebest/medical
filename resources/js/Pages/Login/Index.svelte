<script>
    import LoginForm from "../../components/organism/login/LoginForm.svelte";



    export let errors;
</script>

<div class="w-full border flex justify-center items-center h-screen">
    <LoginForm {errors}></LoginForm>
</div>

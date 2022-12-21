import './bootstrap';
import '../css/app.css'
import {createInertiaApp} from "@inertiajs/inertia-svelte"
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {Inertia} from "@inertiajs/inertia";

/*
Inertia.on('success', event => {
    const baseUrl = new URL(window.location);
    if (!baseUrl.searchParams.get('dialog')) {
        event.stopImmediatePropagation();
        window.location.href = window.localStorage.getItem('baseUrl');
    }
    window.localStorage.setItem('baseUrl', baseUrl.pathname);
});

window.addEventListener('popstate', (event) => {
    event.stopImmediatePropagation();

    window.location.href = window.localStorage.getItem('baseUrl');
});*/
createInertiaApp({
    resolve: name => resolvePageComponent(`./Pages/${name}.svelte`,
        import.meta.glob("./Pages/**/*.svelte")), setup({el, App, props}) {
        new App({target: el, props})
    },
})


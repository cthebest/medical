import {writable, derived} from 'svelte/store';
import {modalComponents} from "./modal-components";
import {page} from "@inertiajs/inertia-svelte";

export const request = writable({
    component: null
});

export const view_request = writable({
    component: null
});

export const view_component = derived(view_request, $view_request => {
    if ($view_request.component) {
        return modalComponents.find(component => component.name === $view_request.component).component;
    }
})
// Obtenemos la vista modal
export const component = derived(page, $page => {
    const dialog = $page.props.query.dialog;
    if (dialog) {
        return modalComponents.find(component => component.name === dialog).component;
    }
    return null;
})




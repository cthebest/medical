import UserFormCreate from "../organism/user/UserModalCreate.svelte";
import UserFormEdit from "../organism/user/UserModalEdit.svelte";
import ShowOfficeHour from "../organism/agenda/Show-Office-Hour.svelte";
import CreateOfficeHour from "../organism/agenda/Create-Office-Hour.svelte";
import EditOfficeHour from "../organism/agenda/Edit-Office-Hour.svelte";
import AppointmentModal from "../organism/appointment/AppointmentModal.svelte";
import MonthView from "../organism/agenda/calendar/MonthView.svelte";
import AppointmentConfigurationModal from "../organism/appointment/AppointmentConfigurationModal.svelte";

export const modalComponents = [
    {
        name: 'create-user',
        component: UserFormCreate
    },

    {
        name: 'edit-user',
        component: UserFormEdit
    },
    {
        name: 'show-office-hours',
        component: ShowOfficeHour
    },

    {
        name: 'create-office-hours',
        component: CreateOfficeHour
    },
    {
        name: 'edit-office-hours',
        component: EditOfficeHour
    },

    {
        name: 'appointment',
        component: AppointmentModal
    },

    {
        name: 'month',
        'component': MonthView
    },

    {
        name: 'appointment-configuration',
        'component': AppointmentConfigurationModal
    }
]

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AppointmentConfiguration;
use App\Models\Component;
use App\Models\User;
use App\Models\Weekday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Weekday::insert([
            [
                'name' => 'Lunes',
                'day_number' => 1
            ],
            [
                'name' => 'Martes',
                'day_number' => 2
            ],
            [
                'name' => 'Miércoles',
                'day_number' => 3
            ],
            [
                'name' => 'Jueves',
                'day_number' => 4
            ],
            [
                'name' => 'Viernes',
                'day_number' => 5
            ],
            [
                'name' => 'Sábado',
                'day_number' => 6
            ],
            [
                'name' => 'Domingo',
                'day_number' => 7
            ]
        ]);
        // ROLES DISPONIBLES
        $admin = Role::create([
            'name' => 'Administrador'
        ]);
        $professional = Role::create([
            'name' => 'Profesional'
        ]);
        $secretary = Role::create([
            'name' => 'Secretaria'
        ]);

        $editor = Role::create([
            'name' => 'Editor'
        ]);

        $appointmentConfigurationDefault = AppointmentConfiguration::create(['duration' => 0]);

        // USUARIO POR DEFECTO
        $user = $appointmentConfigurationDefault->users()->create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678'),
        ]);

        $editor_user = $appointmentConfigurationDefault->users()->create([
            'name' => 'Editor',
            'email' => 'editor@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $user->assignRole($admin);
        $editor_user->assignRole($editor);

        // PERMISOS ADMINISTRADOR
        $create_user = Permission::create(['name' => 'create_users']);
        $update_user = Permission::create(['name' => 'update_users']);
        $delete_user = Permission::create(['name' => 'delete_users']);
        $list_users = Permission::create(['name' => 'list_users']);
        $create_menu_item = Permission::create(['name' => 'create_menu_items']);
        $update_menu_item = Permission::create(['name' => 'update_menu_items']);
        $delete_menu_item = Permission::create(['name' => 'delete_menu_items']);
        $list_menu_item = Permission::create(['name' => 'list_menu_items']);


        //PERMISOS PROFESIONAL
        $create_appointments = Permission::create(['name' => 'create_appointments']);
        $delete_appointments = Permission::create(['name' => 'delete_appointments']);
        $update_appointments = Permission::create(['name' => 'update_appointments']);
        $list_appointments = Permission::create(['name' => 'list_appointments']);

        $show_agenda = Permission::create(['name' => 'show_agenda']);
        $create_appointmens_time = Permission::create(['name' => 'create_appointmens_time']);
        $show_appointmens_time = Permission::create(['name' => 'show_appointmens_time']);


        $show_office_hours = Permission::create(['name' => 'show_office_hours']);
        $create_office_hours = Permission::create(['name' => 'create_office_hours']);
        $update_office_hours = Permission::create(['name' => 'update_office_hours']);
        $delete_office_hours = Permission::create(['name' => 'delete_office_hours']);

        $show_event = Permission::create(['name' => 'show_event']);
        $update_event = Permission::create(['name' => 'update_event']);
        $delete_event = Permission::create(['name' => 'delete_event']);
        $create_event = Permission::create(['name' => 'create_event']);

        $secretary->syncPermissions([
            $create_appointments,
            $delete_appointments, $update_appointments,
            $list_appointments, $show_agenda, $show_office_hours,
            $show_event, $show_appointmens_time
        ]);

        $professional->syncPermissions([
            $create_appointments, $delete_appointments,
            $update_appointments, $list_appointments,
            $show_agenda, $create_appointmens_time, $show_appointmens_time,
            $create_office_hours, $show_office_hours, $update_office_hours,
            $delete_office_hours, $show_event, $update_event,
            $delete_event, $create_event
        ]);

        //PERMISOS EDITOR
        $create_article = Permission::create(['name' => 'create_articles']);
        $update_articles = Permission::create(['name' => 'update_articles']);
        $delete_articles = Permission::create(['name' => 'delete_articles']);
        $list_articles = Permission::create(['name' => 'list_articles']);

        $editor->syncPermissions([
            $create_article, $update_articles,
            $delete_articles, $list_articles, $create_menu_item, $update_menu_item, $delete_menu_item, $list_menu_item
        ]);

        $admin->syncPermissions([
            $create_user, $update_user, $delete_user, $list_users, $create_menu_item,
            $update_menu_item, $delete_menu_item, $list_menu_item, $list_articles
        ]);

        //AGREGAR LOS COMPONENTES PARA LOS ITEMS DE MENÚ
        Component::insert(
            [
                [
                    'name' => 'articles',
                    'label' => 'Artículos',
                    'has_table' => true
                ],
                [
                    'name' => 'contacts',
                    'label' => 'Contáctenos',
                    'has_table' => false
                ],
                [
                    'name' => 'appointments',
                    'label' => 'Citas',
                    'has_table' => false,
                ],
                [
                    'name' => 'invoices',
                    'label' => 'Facturación',
                    'has_table' => false,
                ],
                [
                    'name' => 'photos',
                    'label' => 'Fotos',
                    'has_table' => true,
                ]
            ]
        );
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

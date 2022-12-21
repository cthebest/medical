<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OfficeHourController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas para el usuario autenticado
Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/', function () {
        return Inertia('Welcome');
    });
    Route::get('components', [ComponentController::class, 'index'])->name('components');

    Route::get('articles/get-all', [ArticleController::class, 'all'])->name('articles.get-all');

    Route::get('logout', [LoginController::class, 'logout'])
        ->name('logout');
    Route::get('roles', RoleController::class)->name('admin.roles');
    // Rutas para el perfil

    Route::get('profile/{user}/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('profile/{user}/password-update', [ProfileController::class, 'password_update'])
        ->name('profile.password_update');
    Route::put('profile/{user}', [ProfileController::class, 'profile_update'])
        ->name('profile.update');

    Route::get('patient', [PatientController::class, 'index'])->name('patient');

    // Rutas para la agenda-----
    Route::prefix('agenda')->group(function () {

        Route::get('/', [AgendaController::class, 'index'])
            ->name('agenda.index')->middleware('can:show_agenda');

        // Mostrar las citas de cada profesional
        Route::get('appointments-count', [AgendaController::class, 'getAppointmentsCount'])
            ->name('agenda.get-appointments-count');
        Route::get('weekdays', [AgendaController::class, 'getWeekdays'])
            ->name('agenda.getWeekdays');

        Route::get('appointment-configurations', [AgendaController::class, 'getAppointmentConfiguration'])
            ->name('appointment-configurations.get');
        Route::post('appointment-configurations', [AgendaController::class, 'saveAppointmentConfiguration'])
            ->name('appointment-configurations');

        // Rutas para el horario de oficina
        Route::get('office-hours/edit', [OfficeHourController::class, 'edit'])
            ->name('office-hours.edit')->middleware('can:update_office_hours');

        Route::put('office-hours', [OfficeHourController::class, 'update'])
            ->name('office-hours.update')->middleware('can:update_office_hours');

        Route::delete('office-hours', [OfficeHourController::class, 'destroy'])
            ->name('office-hours.destroy')->middleware('can:delete_office_hours');

        Route::resource('office-hours', OfficeHourController::class)
            ->except('destroy', 'edit', 'update');
    });
    Route::get('professionals', [
        ProfessionalController::class,
        'getProfessionals'
    ])->name('professionals');

    Route::get('articles/{article}/get-article', [ArticleController::class, 'getArticle'])->name('articles.get-article');

    // Resources-----
    Route::resources([
        'users' => UserController::class,
        'articles' => ArticleController::class,
        'menu-items' => MenuItemController::class,
        'appointments' => AppointmentController::class,

    ]);
});

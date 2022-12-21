<?php
// Rutas para el usuario invitado

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserPublicController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // La ruta para establecer si la cita fue confirmada
    Route::get('appointment/{id}/confirmation', [AppointmentController::class, 'confirmation'])
        ->name(name: 'confirmation.appointment');

    Route::get('admin/login', [LoginController::class, 'index'])
        ->name('login');
    Route::post('admin/login', [LoginController::class, 'login']);

    Route::get('admin/users/{token}/reset-password/{email}', [UserPublicController::class, 'resetPassword'])
        ->name('users.resetPassword');
    Route::patch('admin/users/update-password', [UserPublicController::class, 'updatePassword'])
        ->name('users.updatePassword');
    Route::get('admin/users/reset-password-successful', [UserPublicController::class, 'reset_password_successful'])
        ->name('users.reset_password_successful');
    
});

<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PublicController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Inertia('Public/Index');
});

Route::get('contacts', function () {
    return "Hola contactos";
});

Route::prefix('articles')->group(function () {
    Route::get('/', function () {
        return "Hola artículos";
    });

    Route::get('{article}', function (Article $article) {
        return "Hola artículo:" . $article->body;
    });
});


Route::get('menu-items/get-all', [PublicController::class, 'getMenuItems'])
    ->name('menu-items.get-all');

Route::get('available-times', [AgendaController::class, 'getAvailableTimes'])
    ->name('available-times');

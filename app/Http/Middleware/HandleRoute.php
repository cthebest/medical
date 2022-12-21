<?php

namespace App\Http\Middleware;

use App\Models\MenuItem;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HandleRoute
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*
         * Nos permitirá obtener la ruta específica al controlador
         * tabla: Menu
         *      -id
         *      -name
         *      -url /contactenos->se genera automáticamente -> lo que ve el usuario
         *      -resource ->si escoge un recurso
         *      -link /article?tag=recurso->se genera automáticamente -> lo que ve la máquina
            $request = Request::create('/algo/mio', 'GET', [], [], [], $_SERVER);
            return Route::dispatch($request);
        */
        $menuItem = MenuItem::wherePath($request->getUri())->first();
        if (!$menuItem) {
            return $next($request);
        }

        $request = Request::create($menuItem->link, 'GET', [], [], [], $_SERVER);
        return Route::dispatch($request);
    }
}

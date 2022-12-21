<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class LoginController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return Inertia('Login/Index');
    }

    /**
     * Comprueba las credenciales de un usuario e inicia su sesión
     *
     * @param LoginRequest $request (email, password)
     *
     */
    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();
            // Si las credenciales del usuario son correctas, el sistema lo llevará al
            // dashboard; de lo contrario, lo llevará a la ruta que quiso consultar
            return redirect()->intended('admin');
        }
        // Si las credenciales no son correctas, enviaremos un mensaje de error
        return back()->withErrors(['message' => 'Las credenciales no coinciden con nuestros registros']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

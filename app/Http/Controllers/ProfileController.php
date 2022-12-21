<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:view,user', 'can:update,user']);
    }
    public function edit(User $user): Response|ResponseFactory
    {
        $user = $user->load('roles');
        return Inertia('Profile/EditProfile', compact('user'));
    }

    public function password_update(User $user, Request $request)
    {

        $credentials = $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);
        $credentials['password'] = Hash::make($credentials['password']);

        $request->session()->flash('message', 'La contraseña fue actualizada correctamente');
        $user->update($credentials);
    }

    public function profile_update(User $user, Request $request)
    {
        $profile = $request->validate([
            'name' => [
                'required',
                Rule::unique('users')->ignore($user)
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($user)
            ]
        ]);
        $request->session()->flash('message', 'El perfil fue actualizado correctamente');
        $user->update($profile);
    }
}

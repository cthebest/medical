<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Mail\UserRegistered;
use App\Models\AppointmentConfiguration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrador']);
    }

    public function index(Request $request): Response|ResponseFactory
    {

        $users = User::with('roles')->whereNot(function ($query) {
            $query->where('id', auth()->id());
        })->paginate(12);

        return Inertia('User/Index', compact('users'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $duration = AppointmentConfiguration::where('duration', 0)->first();

        // Creamos un nuevo usuario
        $user = (new User)->fill(array_merge(
            $request->except('role'),
            ['password' => Hash::make(Str::random(8))]
        ));

        $user->appointment_configuration()->associate($duration);
        $user->assignRole($request->only('role'));
        $user->save();

        //Generación de token y almacenado en la tabla password_resets
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Enviamos el correo electrónico al usuario creado
        Mail::to($user->email)->send(new UserRegistered($user, $token));

        $request->session()->flash('message', 'El usuario fue creado');


        return redirect()->route('users.index', ['dialog' => 'create-user']);
    }

    public function edit(User $user)
    {
        return response()->json($user->load('roles'));
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $user->update($request->except('role'));
        $user->syncRoles($request->only('role'));

        $request->session()->flash('message', 'El usuario fue actualizado');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id !== auth()->id()) {
            $user->delete();
        }
        return redirect()->route('users.index');
    }

    
}

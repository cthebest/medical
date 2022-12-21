<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_puede_ver_todos_los_usuarios()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'Bob Patiño',
            'email' => 'patiño@mail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Registro básico
        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertInertia(function ($page) {
            $page->where('users.data', function ($value) {
                return is_object($value->where('name', 'Bob Patiño'));
            });
        });
        $response->assertDontSee('Edgar Andrey Vega Paredes');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_puede_crear_un_nuevo_usuario()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'Bob Patiño',
            'email' => 'patiño@mail.com',
            'role' => 'professional'
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('professional'));
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_no_puede_crear_un_nuevo_usuario_sin_email()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'Bob Patiño',
            'role' => 'professional'
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_no_puede_crear_un_nuevo_usuario_sin_nombre()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'email' => 'patiño@mail.com',
            'role' => 'professional'
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_no_puede_crear_un_nuevo_usuario_con_un_email_registrado()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'Patiño',
            'email' => 'edgvega@mail.com',
            'role' => 'professional'
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_no_puede_crear_un_nuevo_usuario_con_un_nombre_registrado()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'patiño@mail.com',
            'role' => 'professional'
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_no_puede_crear_un_nuevo_usuario_sin_role()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->post('/admin/users', [
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'patiño@mail.com',
        ]);

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }


    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usario_administrador_puede_eliminar_un_usuario()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $user2 = User::create([
            'name' => 'Bob patiño',
            'email' => 'patiño@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->delete(route('users.destroy', [
            'user' => 2
        ]));

        $user = User::whereEmail('patiño@mail.com')->first();
        $this->assertNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function un_usuario_no_puede_eliminar_su_propia_cuenta()
    {
        Role::create([
            'name' => 'professional'
        ]);
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Registro básico
        $response = $this->actingAs($user)->delete(route('users.destroy', [
            'user' => 1
        ]));

        $user = User::whereEmail('edgvega@mail.com')->first();
        $this->assertNotNull($user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuario_administrador_puede_actualizar_otro_usuario()
    {
        $role = Role::create([
            'name' => 'professional'
        ]);

        Role::create([
            'name' => 'admin'
        ]);

        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $user->assignRole($role);

        // Registro básico
        $response = $this->actingAs($user)->put(route('users.update', [
            'user' => 1
        ]), [
            'name' => 'Edgitar',
            'email' => 'edg@mail.com',
            'role' => 'admin'
        ]);

        $user = User::select('name', 'email')->whereEmail('edg@mail.com')->first();
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => 'Edgitar',
                'email' => 'edg@mail.com',
            ]), $user);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuario_normal_puede_actualizar_otro_usuario()
    {
        $role = Role::create([
            'name' => 'professional'
        ]);

        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'Bob patiño',
            'email' => 'patiño@mail.com',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole($role);
        // Registro básico
        $response = $this->actingAs($user)->put(route('users.update', [
            'user' => 2
        ]), [
            'name' => 'Pati',
            'email' => 'patiño@mail.com',
            'role' => 'professional'
        ]);

        $user = User::select('name', 'email')->whereEmail('patiño@mail.com')->first();
        $this->assertJsonStringNotEqualsJsonString(
            json_encode([
                'name' => 'Pati',
                'email' => 'patiño@mail.com',
            ]), $user->toJson());
    }
}

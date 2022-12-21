<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuarios_no_autenticados_pueden_ver_el_login(): void
    {
        $response = $this->get('/admin/login');
        $response->assertOk();
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuarios_autenticados_no_pueden_ver_el_login(): void
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->actingAs($user)->get('/admin/login');
        $response->assertRedirect('/admin/');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuarios_registrados_pueden_iniciar_sesion(): void
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertRedirect('/admin/');
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuarios_no_registrados_pueden_ingresar_a_la_administracion(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'casimiro@mail.com',
            'password' => '12345678'
        ]);
        $this->assertNotEquals('/admin', $response->headers->get('location'));
    }
}

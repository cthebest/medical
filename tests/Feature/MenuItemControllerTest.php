<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class MenuItemControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuario_puede_crear_un_item_de_menu_con_un_articulo()
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Creamos un artículo
        $article = (new Article)->fill([
            'title' => 'Quienes somos',
            'body' => 'Mi primer post',
            'url_photo' => 'miurl',
            'alias' => Str::slug('Quienes somos')
        ]);
        $article->user()->associate($user);
        $article->save();

        // Si no se envía un recurso, entonces se mostrará todo el contenido del componente
        $response = $this->actingAs($user)->post(route('menu-items.store'), [
            'title' => 'Quienes somos',
            'component_type' => 'articles',
            'resource' => 'quienes-somos',
            'field' => 'alias'
        ]);
        //http://localhost/articles/quienes-somos
        $menuItems = MenuItem::all();
        $this->assertCount(1, $menuItems);

        $this->assertEquals('http://localhost/articles/quienes-somos', $menuItems[0]->link);
    }
}

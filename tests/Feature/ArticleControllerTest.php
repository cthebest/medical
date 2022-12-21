<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function usuario_puede_crear_un_articulo()
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'mi primer post',
            'body' => 'Mi primer post',
            'url_photo' => 'miurl',
        ]);

        $article = Article::with('user')->get();

        // Como solo tenemos un artículo, entonces verificamos si existe solo 1
        $this->assertCount(1, $article);
        $this->assertEquals($user->name, $article[0]->user->name);
    }

    /**
     * @test
     * @return void
     */
    public function usuario_puede_crear_un_articulo_sin_titulo()
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        $response = $this->actingAs($user)->post(route('articles.store'), [
            'body' => 'Mi primer post',
            'url_photo' => 'miurl',
        ]);

        $article = Article::with('user')->get();

        // Como no se puede crear un artículo sin título, la cantidad
        // de registros disponibles es cero
        $this->assertCount(0, $article);
    }

    /**
     * @test
     * @return void
     */
    public function usuario_puede_actualizar_articulos()
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Creamos un artículo
        $article = (new Article)->fill([
            'title' => 'mi primer post',
            'body' => 'Mi primer post',
            'url_photo' => 'miurl',
            'slug' => Str::slug('mi primer post')
        ]);
        $article->user()->associate($user);
        $article->save();

        $response = $this->actingAs($user)->put(route('articles.update', [
            'article' => $article->id
        ]), [
            'title' => 'mi primer post actualizado',
            'body' => 'Mi primer post actualizado',
            'url_photo' => 'miurl',
        ]);

        $article = Article::with('user')->get();

        // Como solo tenemos un artículo, entonces verificamos si existe solo 1
        $this->assertEquals('mi primer post actualizado', $article[0]->title);
        $this->assertEquals('Mi primer post actualizado', $article[0]->body);
    }


    /**
     * @test
     * @return void
     */
    public function usuario_puede_eliminar_articulos()
    {
        $user = User::create([
            'name' => 'Edgar Andrey Vega Paredes',
            'email' => 'edgvega@mail.com',
            'password' => Hash::make('12345678')
        ]);

        // Creamos un artículo
        $article = (new Article)->fill([
            'title' => 'mi primer post',
            'body' => 'Mi primer post',
            'url_photo' => 'miurl',
            'slug' => Str::slug('mi primer post')
        ]);
        $article->user()->associate($user);
        $article->save();

        $response = $this->actingAs($user)->delete(route('articles.destroy', [
            'article' => $article->id
        ]));

        $article = Article::with('user')->get();

        // Como solo existe un solo artículo, cuando lo eliminamos, nos deberá dar 0 
        // artículos creados
        $this->assertCount(0, $article);
    }
}

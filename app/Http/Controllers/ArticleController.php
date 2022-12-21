<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ArticleController extends Controller
{


    public function __construct()
    {
        $this->middleware(['role_or_permission:Editor|list_articles']);
    }

    /**
     * Obtener todos los artículos para mostrarlos en la tabla 
     * de la página Index.svelte.
     * 
     * La páginación será de doce elementos por cada página
     */

    public function index()
    {
        $articles = Article::with('user')->paginate(12);

        return Inertia('Article/Index', compact('articles'));
    }


    public function all()
    {
        return response()->json(Article::all('alias', 'id', 'title'));
    }

    public function create()
    {
        if (!auth()->user()->can('create_articles')) {
            abort(403);
        }
        return Inertia('Article/Create');
    }


    /**
     * Cuando se vaya a realizar el guardado de un artículo,
     * el sistema generará automáticamente el slug que le
     * corresponde a cada artículo, necesario para su
     * búsqueda
     */
    public function store(StoreArticleRequest $request)
    {
        if (!auth()->user()->can('create_articles')) {
            abort(403);
        }

        $path = null;

        if ($request->has('file') && $request->file('file')) {
            $path = Storage::putFileAs(
                'article/images',
                $request->file('file'),
                $request->file('file')->hashName()
            );
        }

        $attributes = $request->merge(['url_photo' => $path, 'alias' => Str::slug($request->title)]);

        $article = (new Article)->fill($attributes->except('file'));
        $article->user()->associate(auth()->user());
        $article->save();

        $request->session()->flash('message', 'Artículo creado con éxito');

        return redirect()->route('articles.create');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        $this->authorize('view', $article);
        return Inertia('Article/Edit', compact('id'));
    }

    public function getArticle(Article $article)
    {
        return response()->json($article);
    }

    public function update(Article $article, StoreArticleRequest $request)
    {
        $this->authorize('update', $article);

        $path = null;
        if ($request->has('file')) {
            $path = Storage::putFileAs(
                'article/images',
                $request->file('file'),
                $request->file('file')->hashName()
            );
        }

        $attributes = $request->merge(['url_photo' => $path, 'alias' => Str::slug($request->title)]);
        $article->update($attributes->except('file'));
        $request->session()->flash('message', 'Artículo actualizado con éxito');
    }

    /**
     * Método que permite eliminar un solo artículo
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        session()->flash('message', 'Artículo eliminado con éxito');
        return redirect()->route('articles.index');
    }
}

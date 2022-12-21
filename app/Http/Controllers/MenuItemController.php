<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Administrador|Editor']);
    }

    public function index()
    {
        $menuItems = MenuItem::paginate(1);
        return Inertia('MenuItem/Index', compact('menuItems'));
    }

    public function create()
    {
        return Inertia('MenuItem/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('menu_items', 'title')
            ]
        ]);


        MenuItem::create($this->getAttributes($request));

        session()->flash('message', 'Ítem de menú creado con éxito');
    }

    public function edit(MenuItem $menuItem)
    {
        $url_parts = explode('/', $menuItem->link);

        $menuItemCollection = new Collection();

        if (count($url_parts) - 1 > 2) {
            $menuItemCollection->put('component_type', $url_parts[3]);
        } else {
            $menuItemCollection->put('component_type', '');
        }

        if (count($url_parts) - 1 > 3) {
            $menuItemCollection->put('resource', $url_parts[4]);
        } else {
            $menuItemCollection->put('resource', 0);
        }

        $menuItemCollection->put('title', $menuItem->title);
        $menuItemCollection->put('id', $menuItem->id);
        $menuItem = $menuItemCollection;

        return Inertia('MenuItem/Edit', compact('menuItem'));
    }

    public function update(MenuItem $menuItem, Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('menu_items', 'title')->ignore($menuItem)
            ]
        ]);

        $menuItem->update($this->getAttributes($request));
        session()->flash('message', 'Ítem de menú actualizado con éxito');

        return redirect()->route('menu-items.edit', $menuItem);
    }

    private function getAttributes(Request $request)
    {
        $resource = '';
        $alias = '';
        if ($request->get('resource') && $request->get('resource') > 0) {
            $resource = $request->resource;
        }
        if ($request->component_type) {
            $alias = Str::slug($request->title);
        }
        // Lo que verá el usuario en la url de su navegador
        $path = url($alias);
        // Lo que entenderá el sistema una vez se busque el item de menú
        $link = url($request->component_type ?? '', $resource);
        return array_merge($request->only('title', 'icon'), ['path' => $path, 'link' => $link]);
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        session()->flash('message', 'Ítem de menú eliminado con éxito');
        return redirect()->route('menu-items.index');
    }
}

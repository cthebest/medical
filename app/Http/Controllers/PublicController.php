<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class PublicController extends Controller
{
    public function getMenuItems()
    {
        return response()->json(MenuItem::all());
    }
}

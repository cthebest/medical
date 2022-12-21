<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

class RoleController
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Role::all());
    }
}

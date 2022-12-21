<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Dialog\DialogFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;


abstract class DialogAbstractController extends Controller
{
    protected $user;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        /**@var User $authUserModel el usuario autenticado */
        $authUserModel = auth()->user();

        $dialogFactory = new DialogFactory();

        $dialogInterface = $dialogFactory->getValidator($authUserModel, $request->query('dialog', 'default'));

        if (!$dialogInterface->validate()) {
            throw new AuthorizationException();
        }

        $this->setUser($request);
        return $this->getIndexResponse();
    }

    /**
     * Obtiene un usuario a partir de una variable resource_user
     * que envía el usuario desde la url del navegador
     *
     * @param $request
     */
    protected function setUser($request): void
    {
        if ($request->has('resource_user')) {
            $this->user = User::with('roles')->findOrFail(\request()->query('resource_user'));
        }
    }


    protected abstract function getIndexResponse(): mixed;
}
<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Article $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Article $article)
    {
        // Comprueba si el usuario, que ha iniciado sesión, puede actualizar las credenciales de
        // otro usuario. En este caso solo un usuario administrador puede actualizar las
        // credenciales de otro usuario, en cambio un usuario sin dicho rol no puede
        // hacerlo
        return $user->id === $article->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_articles');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Article $user_model)
    {
        // Comprueba si el usuario, que ha iniciado sesión, puede actualizar las credenciales de
        // otro usuario. En este caso solo un usuario administrador puede actualizar las
        // credenciales de otro usuario, en cambio un usuario sin dicho rol no puede
        // hacerlo
        return $user->id === $user_model->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Article $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Article $model)
    {
        return $user->id === $model->user->id;
    }

}

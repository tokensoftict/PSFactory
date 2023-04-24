<?php

namespace App\Policies;

use App\Models\Production;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Production $production)
    {
        if(!userCanView("production.show")) return false;

        return  true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return userCanView("production.create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Production $production)
    {
        if(!userCanView('production.edit')) return false;

        if(!($production->status_id === status('Pending')
            || $production->status_id === status('Draft')
        )) return false;

        return  true;

    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user, Production $production)
    {
        return $this->update($user, $production);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Production $production)
    {
        if(!userCanView("production.destroy")) return  false;

        if(!($production->status_id === status('Pending') || $production->status_id === status('Draft'))) return false;
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function transfer(User $user, Production $production){

        if(!userCanView("production.transfer")) return  false;

        if($production->status_id !== status('Ready')) return false;

        return true;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function complete(User $user, Production $production){

        if(!userCanView("production.complete")) return  false;

        if($production->status_id !== status('In-Progress')) return false;

        return true;
    }

}

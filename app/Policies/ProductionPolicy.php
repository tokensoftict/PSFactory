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
    public function view(User $user, Production $production): bool
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
    public function create(User $user): bool
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
    public function update(User $user, Production $production): bool
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
    public function edit(User $user, Production $production): bool
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
    public function delete(User $user, Production $production): bool
    {
        if(!userCanView("production.destroy")) return  false;

        if(($production->status_id === status('Pending') || $production->status_id === status('Draft'))) return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function transfer(User $user, Production $production): bool
    {

        if(!userCanView("production.transfer")) return  false;

        if(($production->yield_quantity - $production->total_transferred)  > 0) return true;

        return false;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function complete(User $user, Production $production): bool
    {

        if(!userCanView("production.complete")) return  false;

        if($production->status_id !== status('In-Progress')) return false;

        return true;
    }


    /**
     * @param User $user
     * @param Production $production
     * @return bool
     */
    public function edit_production_item(User $user, Production $production) : bool
    {
        if(!userCanView("production.edit_production_item")) return false;

        if($production->status_id === status('Declined')) return true;

        return false;

    }

    /**
     * @param User $user
     * @param Production $production
     * @return bool
     */
    public function rollback(User $user, Production $production) : bool
    {
        if(!userCanView("production.rollback")) return  false;

        if(isset($production->return) && $production->return->status_id == status('Approved')) return false; // Material Return has already bee approved

        if($production->status_id !== status('Ready')) return false;

        return true;
    }


    public function enter_yield(User $user, Production $production) : bool
    {
        if(!userCanView("production.enter_yield")) return  false;

        if(
            $production->status_id === status('Complete')
            ||
            $production->status_id === status('Declined')
            ||
            $production->status_id === status('Pending')
            ||
            $production->status_id === status('Waiting-Material')
            ||
            $production->status_id === status('Material-Approval-In-Progress')

        ) return false;

        return true;
    }

}

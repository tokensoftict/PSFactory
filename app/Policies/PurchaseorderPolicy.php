<?php

namespace App\Policies;

use App\Models\Purchaseorder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseorderPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Purchaseorder  $purchaseorder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Purchaseorder $purchaseorder)
    {
        return userCanView("purchaseorders.show");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return userCanView(" purchaseorders.create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Purchaseorder  $purchaseorder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Purchaseorder $purchaseorder)
    {
        if(!userCanView("purchaseorders.edit")) return false;

        if($purchaseorder->status_id === status('Complete') ) return false;

        return true;

    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Purchaseorder  $purchaseorder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user, Purchaseorder $purchaseorder)
    {
        return $this->update($user, $purchaseorder);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Purchaseorder  $purchaseorder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Purchaseorder $purchaseorder)
    {
        if(!userCanView("purchaseorders.destroy")) return false;

        if($purchaseorder->status_id === status('Complete') ) return false;

        return true;

    }


    public function complete(User $user, Purchaseorder $purchaseorder)
    {
        if(!userCanView("purchaseorders.markAsComplete")) return false;

        if($purchaseorder->status_id === status('Complete') ) return false;

        return true;

    }


}

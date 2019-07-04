<?php

namespace App\Policies;

use App\Http\Models\User;
use App\Http\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function own(User $user, Order $order)
    {
        return $order->user_id == $user->id;
    }
}
